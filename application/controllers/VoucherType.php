<?php
   /**
    * VoucherType
    */
   class VoucherType extends MY_Controller
   {
      function __construct()
      {
         parent::__construct();
         $this->load->model('VoucherType_model');
      }

      public function index() {
         $this->data['title'] = "Loại chứng từ";
		      $this->data['template'] = "voucher_type/index";
          $this->data['active'] = 'voucher';
         $this->data['js_files'] = array('voucher-type_create');

         $input = array(
            'order' => 'active desc, id desc'
         );

         $types = $this->VoucherType_model->get_list($input);


         if ($this->input->post()) {
            $code = trim($this->input->post('code'));
            $name = $this->input->post('name');
            $income = $this->input->post('income');

            $flag = true;
            foreach ($types as $type) {
               if ($code == $type->code) {
                  $flag = false;
                  break;
               }
            }

            if ($name == '') {
               $flag = false;
            }

            if (!flag) {
               $this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra khi nhập dữ liệu!');
			         redirect($this->routes['vouchertype_index']);
            }

            $data = array(
               'code' => $code,
               'name' => $name,
               'income' => $income
            );

            if ($this->VoucherType_model->create($data)) {
               $this->session->set_flashdata('message_success', 'Thêm dữ liệu thành công!');

               $this->data['log_info']['row_id'] = $this->VoucherType_model->get_insert_id();
		           $this->data['log_info']['info'] = $name;
               $this->Log_model->create($this->data['log_info']);

               redirect($this->routes['vouchertype_index']);
            } else {
               $this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
			          redirect($this->routes['vouchertype_index']);
            }

         }

         $this->data['list_types'] = $types;

         $this->load->view('layout', $this->data);
      }

      public function changeStatus() {
         if ($this->input->post()) {
            $id = $this->input->post('id');
            $active = $this->input->post('active');

            $new_update = array(
               'active' => 1 - $active
            );

            if ($this->VoucherType_model->update($id, $new_update)) {

               $this->data['log_info']['row_id'] = $id;
               if ($new_update['active'] == 1) {
                  $this->data['log_info']['info'] = 'change to Active' ;
               } else {
                  $this->data['log_info']['info'] = 'change to Deactive' ;
               }

               $this->Log_model->create($this->data['log_info']);
               echo "Changed";
            } else {
               echo "Errors";
            }

         }
      }

      public function delete() {
         if ($this->input->post()) {
            $id = $this->input->post('id');

            $response = array();

            if ($this->VoucherType_model->update($id, array('deleted' => 1))) {
               $response['success'] = true;
               $response['message'] = "Đã xóa!";

               $info = $this->VoucherType_model->get_info($id);
					$this->data['log_info']['row_id'] = $id;
					$this->data['log_info']['info'] = $info->name;

               $this->Log_model->create($this->data['log_info']);
            } else {
               $response['success'] = false;
               $response['message'] = "Không thể xóa!";
            }

            die(json_encode($response));
         }
      }

      public function setDefault() {
         $this->data['title'] = "Thông tin mặc định cho các phiếu chi";
         $this->data['active'] = 'voucher_type';
         $this->data['template'] = 'voucher_type/set_default';
         $this->data['js_files'] = array('voucher-type_set-default');

         $input = array(
            'where' => array('income' => 0, 'deleted' => 0)
         );
         $this->data['types'] = $this->VoucherType_model->get_list($input);
         $input = array(
            'where' => array('income' => 1, 'deleted' => 0)
         );
         $this->data['in_types'] = $this->VoucherType_model->get_list($input);

         $input = array(
            'where_in' => array(
               'dimen_code',
               array('HD1','HD2','HD3')
            )
         );
         $this->load->model('DetailDimension_model');

         // Build tree
         $dimen = $this->DetailDimension_model->get_list($input);
         $tree_dimen = array();
         // HD1
         foreach ($dimen as $item) {
            if ($item->dimen_code == 'HD1') {
               array_push($tree_dimen, array('id' => $item->id, 'text' => $item->name));
            }
         }
         // HD2
         foreach ($dimen as $item) {
            if ($item->dimen_code == 'HD2') {
               foreach ($dimen as $parent) {
                  if ($item->parent_id == $parent->id) {
                     $str = '[' . $item->name . ']->[' . $parent->name . ']';
                     $temp = array('id' => $item->id, 'text' => $str);
                     array_push($tree_dimen, $temp);
                     break;
                  }
               }
            }
         }
         // HD3
         foreach ($dimen as $item) {
            if ($item->dimen_code == 'HD3') {
               foreach ($tree_dimen as $tree) {
                  if ($item->parent_id == $tree['id']) {
                     $str = '[' . $item->name . ']->[' . $tree['text'] . ']';
                     $temp = array('id' => $item->id, 'text' => $str);
                     array_push($tree_dimen, $temp);
                     break;
                  }
               }
            }
         }

         $tree_dimen = array_reverse($tree_dimen);

         $this->data['trees'] = $tree_dimen;

         // Get system acc
			$this->load->model('AccountingSystem');
         $list_account = $this->AccountingSystem->get_list();
			$this->data['system_acc'] = $list_account;

         if ($this->input->post()) {
            $list_changed = $this->input->post('list_changed');
            $array_changed = explode(',', $list_changed);
            // var_dump($array_changed);
            // die;
            foreach ($array_changed as $type_id) {
               $data_update = array(
                  'debit_def' => $this->input->post('debit_def_' . $type_id),
                  'credit_def' => $this->input->post('credit_def_' . $type_id),
                  'first_dimen' => $this->input->post('first_dimen_' . $type_id)
               );

               if (!$this->VoucherType_model->update($type_id, $data_update)) {
                  $this->session->set_flashdata('message_errors', 'Thao tác thất bại!');
   					redirect($this->routes['vouchertype_setdefault']);
               }

               $this->data['log_info']['row_id'] = $type_id;
               $this->data['log_info']['info'] = 'Thay đổi';
               $this->Log_model->create($this->data['log_info']);

            }

            $this->session->set_flashdata('message_success', 'Cập nhật thành công!');
            redirect($this->routes['vouchertype_setdefault']);
         }

         $this->load->view('layout', $this->data);
      }
   }

 ?>
