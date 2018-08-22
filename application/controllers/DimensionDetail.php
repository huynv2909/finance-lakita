<?php
   /**
    * DimensionDetail
    */
   class DimensionDetail extends MY_Controller
   {

      function __construct()
      {
         parent::__construct();
         $this->load->model('DetailDimension_model');
      }

      public function index() {
         $this->data['title'] = "Chi tiết chiều quản trị";
         $this->data['active'] = "DimensionDetail";
         $this->data['template'] = "dimension_detail/index";
         $this->data['js_files'] = array('dimension-detail_create');

         $this->load->model('Dimension_model');

         $input = array(
            'order' => 'active desc'
         );

         $this->data['dimensions'] = $this->Dimension_model->get_list();

         $input = array(
            'where' => array('active' => 1)
         );

         $this->data['details'] = $this->DetailDimension_model->get_list($input);

         $this->load->view('layout', $this->data);
      }

      public function changeStatus() {
         if ($this->input->post()) {
            $id = $this->input->post('id');
            $active = $this->input->post('active');

            $new_update = array(
               'active' => 1 - $active
            );

            if ($this->DetailDimension_model->update($id, $new_update)) {
               echo "Changed";
            } else {
               echo "Errors";
            }

         }
      }

      // Load all detail row have specified parent id.
      public function listAll() {
         if ($this->input->post()) {
            $dimen_id = $this->input->post('id');

            $input = array(
               'where' => array('dimen_id' => $dimen_id)
            );

            die(json_encode($this->DetailDimension_model->get_list($input)));
         }
      }

      public function delete() {
         if ($this->input->post()) {
            $id = $this->input->post('id');

            $response = array();

            if ($this->DetailDimension_model->delete($id)) {
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
