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

         // Get notify
			$message_errors = $this->session->flashdata('message_errors');
			$message_success = $this->session->flashdata('message_success');
			$this->data['message_errors'] = $message_errors;
			$this->data['message_success'] = $message_success;

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
						redirect(base_url('Dimension'));
               } else {
                  $this->session->set_flashdata('message_errors', 'Có lỗi xảy ra!');
   					redirect(base_url('Dimension'));
               }
            } else {
               $this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra khi nhập dữ liệu!');
					redirect(base_url('Dimension'));
            }
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
