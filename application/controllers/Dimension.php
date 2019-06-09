<?php
   /**
    * Dimension
    */
   class Dimension extends MY_Controller
   {

      function __construct()
      {
         parent::__construct();
         $this->load->model('Dimension_model');
      }

      public function index()
      {
         $this->data['title'] = "Chiều quản trị";
         $this->data['active'] = "Dimension";
         $this->data['template'] = "dimension/index";
         $this->data['js_files'] = array('dimension_create');

         $this->data['dimensions'] = $this->Dimension_model->get_list();

         $this->load->view('layout', $this->data);
      }

      public function create() {
         if ($this->input->post()) {
            $this->form_validation->set_rules('code', 'Code', 'required');
            $this->form_validation->set_rules('name', 'Node', 'required');
            $this->form_validation->set_rules('sequence', 'Sequence', 'required');
   			$this->form_validation->set_rules('layer', 'Layer', 'required|greater_than[0]');

            if ($this->form_validation->run() && $this->checkCode(trim($this->input->post('code'))) ) {

               $data = array(
                  'code' => trim($this->input->post('code')),
                  'name' => $this->input->post('name'),
                  'parent_id' => $this->input->post('parent_id'),
                  'note' => $this->input->post('note'),
                  'sequence' => $this->input->post('sequence'),
                  'layer' => $this->input->post('layer')
               );

               if ($this->Dimension_model->create($data)) {
                  $this->session->set_flashdata('message_success', 'Thêm dữ liệu thành công!');

                  $this->data['log_info']['row_id'] = $this->Dimension_model->get_insert_id();
   					$this->data['log_info']['info'] = $data['name'];
                  $this->Log_model->create($this->data['log_info']);

						redirect($this->routes['dimension_index']);
               } else {
                  $this->session->set_flashdata('message_errors', 'Có lỗi xảy ra!');
   					redirect($this->routes['dimension_index']);
               }
            } else {
               $this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra khi nhập dữ liệu!');
					redirect($this->routes['dimension_index']);
            }
         }
      }

      public function getDetail() {
         if ($this->input->post()) {
            $id = $this->input->post('id');

            $input = array(
               'where' => array('dimen_id' => $id, 'deleted' => 0)
            );

            $this->load->model('DetailDimension_model');
            $list_detail = $this->DetailDimension_model->get_list($input);

            $all_detail = $this->DetailDimension_model->get_list();

            foreach ($list_detail as $detail) {
               if ($detail->parent_id != NULL) {
                  foreach ($all_detail as $parent) {
                     if ($detail->parent_id == $parent->id) {
                        $detail->{"parent_name"} = $parent->name;
                        break;
                     }
                  }
               } else {
                  $detail->{"parent_name"} = "";
               }

               if (in_array('dimensiondetail_changestatus', explode(',', $this->role->permission_list))) {
                 if ($detail->active) {
                    $detail->{"exchange"} = '<i class="fa fa-fw fa-2x vertical-middle active-color exchange-btn" data-url="' . $this->routes['dimensiondetail_changestatus'] . '" data-id="' . $detail->id . '" data-active="1" aria-hidden="true" title="Click to change!"></i>';
                 } else {
                    $detail->{"exchange"} = '<i class="fa fa-fw fa-2x vertical-middle exchange-btn" data-url="' . $this->routes['dimensiondetail_changestatus'] . '" data-id="' . $detail->id . '" data-active="0" aria-hidden="true" title="Click to change!"></i>';
                 }
               } else {
                 $detail->{"exchange"} = '';
               }

               if (in_array('dimensiondetail_delete', explode(',', $this->role->permission_list))) {
                 $detail->{"delete"} = '<button type="button" class="btn btn-circle del-btn" data-url="' . $this->routes['dimensiondetail_delete'] . '" data-id="' . $detail->id . '"><i class="fa fa-times"></i></button>';
               } else {
                 $detail->{"delete"} = '';
               }

            }

            $this->load->model('Dimension_model');
            $info_dimen = $this->Dimension_model->get_info($id);

            $list_parent = array();
            if (is_numeric($info_dimen->parent_id)) {
               $input = array(
                  'where' => array('dimen_id' => $info_dimen->parent_id)
               );
               $list_parent = $this->DetailDimension_model->get_list($input);
            }

            $response = array(
               'details' => $list_detail,
               'info_dimen' => $info_dimen,
               'list_parent' => $list_parent
            );

            die(json_encode($response));
         }
      }

      private function checkCode($new_code) {
         $list_code = $this->Dimension_model->get_list();

         foreach ($list_code as $item) {
            if ($item->code == $new_code) {
               return false;
            }
         }

         return true;
      }
   }

 ?>
