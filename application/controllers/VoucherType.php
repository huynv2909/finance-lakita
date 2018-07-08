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

         // Get notify
         $message_errors = $this->session->flashdata('message_errors');
         $message_success = $this->session->flashdata('message_success');
         $this->data['message_errors'] = $message_errors;
         $this->data['message_success'] = $message_success;

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
					redirect(base_url('VoucherType/index'));
            }

            $data = array(
               'code' => $code,
               'name' => $name,
               'income' => $income
            );

            if ($this->VoucherType_model->create($data)) {
               $this->session->set_flashdata('message_success', 'Thêm dữ liệu thành công!');
               redirect(base_url('VoucherType/index'));
            } else {
               $this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
					redirect(base_url('VoucherType/index'));
            }

         }

         $this->data['list_types'] = $types;

         $this->load->view('layout', $this->data);
      }

      public function change_status() {
         if ($this->input->post()) {
            $id = $this->input->post('id');
            $active = $this->input->post('active');

            $new_update = array(
               'active' => 1 - $active
            );

            if ($this->VoucherType_model->update($id, $new_update)) {
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

            if ($this->VoucherType_model->delete($id)) {
               $response['success'] = true;
               $response['message'] = "Đã xóa!";
            } else {
               $response['success'] = false;
               $response['message'] = "Không thể xóa!";
            }

            die(json_encode($response));
         }
      }

   }

 ?>
