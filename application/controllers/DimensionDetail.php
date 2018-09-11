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

      public function coursesManager() {
         $this->data['title'] = "Quản trị khóa học";
         $this->data['template'] = "dimension_detail/courses_manager";
         $this->data['js_files'] = array('voucher-type_create');

         $input = array(
            'where' => array('dimen_code' => 'SP'),
            'order' => 'active desc'
         );

         $courses = $this->DetailDimension_model->get_list($input);
         $this->data['courses'] = $courses;

         $input = array(
            'where' => array('dimen_code' => 'NSP2')
         );
         $groups = $this->DetailDimension_model->get_list($input);
         $this->data['groups'] = $groups;

         if ($this->input->post()) {
            $code = trim($this->input->post('code'));
            $name = $this->input->post('name');
            $income = $this->input->post('income');

            $flag = true;
            foreach ($courses as $type) {
               if ($code == $type->name) {
                  $flag = false;
                  break;
               }
            }

            if ($name == '') {
               $flag = false;
            }

            if (!flag) {
               $this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra khi nhập dữ liệu!');
					redirect($this->routes['dimensiondetail_coursesmanager']);
            }

            $data = array(
               'dimen_id' => 120,
               'dimen_code' => 'SP',
               'name' => $code,
               'note' => $name,
               'parent_id' => $income,
               'layer' => 2
            );

            if ($this->DetailDimension_model->create($data)) {
               $this->session->set_flashdata('message_success', 'Thêm dữ liệu thành công!');
               redirect($this->routes['dimensiondetail_coursesmanager']);
            } else {
               $this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
					redirect($this->routes['dimensiondetail_coursesmanager']);
            }

         }

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
