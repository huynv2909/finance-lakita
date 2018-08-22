<?php
	/**
	 * User
	 */
	class User extends MY_Controller
	{
      function __construct()
      {
         parent::__construct();
         $this->load->model('User_model');
      }

		public function index()
		{
			$this->data['title'] = "Thông tin cá nhân";
			$this->data['template'] = 'user/index';
			$this->data['active'] = 'user';

			$this->load->view('layout', $this->data);
		}

      public function permission() {
         $this->data['title'] = "Vai trò và quyền hạn";
			$this->data['template'] = 'user/permission';
			$this->data['active'] = 'user';
         $this->data['js_files'] = array('user_permission');

         $this->load->model('Operation_model');
			$this->load->model('Permission_model');
			$input = array(
				'where' => array('is_default' => 0)
			);
         $operation_list = $this->Operation_model->get_list($input);

			if ($this->input->post()) {
				$str_changed = $this->input->post('have_changed');

				if (trim($str_changed) != '') {
					$list_changed = explode(',', trim($str_changed));

					foreach ($list_changed as $id) {
						// Some default permission
						$list_permisstion = '';
						foreach ($operation_list as $ope) {
							if (null !== $this->input->post($ope->name . '_' . $id)) {
								if ($list_permisstion != '') {
									$list_permisstion = $list_permisstion . ',';
								}

								$list_permisstion = $list_permisstion . $this->input->post($ope->name . '_' . $id);
							}
						}

						$data_update = array(
							'permission_list' => $list_permisstion
						);

						if (!$this->Permission_model->update($id, $data_update)) {
							$this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
							redirect($this->routes['user_permission']);
						}

					}

					$this->session->set_flashdata('message_success', 'Cập nhật thành công!');
					redirect($this->routes['user_permission']);
				}
			}

			$ope_arr = array();
			foreach ($operation_list as $operation) {
				$temp_arr = array(
					'name' => $operation->name,
					'description' => $operation->description
				);

				if (isset($ope_arr[$operation->entity]) && is_array($ope_arr[$operation->entity])) {
					array_push($ope_arr[$operation->entity], $temp_arr);
				} else {
					$ope_arr[$operation->entity] = array($temp_arr);
				}
			}
			$this->data['operations'] = $ope_arr;

			$roles = $this->Permission_model->get_list();
			foreach ($roles as $role) {
				$permission_arr = explode(',', $role->permission_list);
				$arr_temp = array();
				foreach ($permission_arr as $operation) {
					array_push($arr_temp, $operation);
				}
				$role->{"permission"} = $arr_temp;
			}
			$this->data['roles'] = $roles;

			$this->load->view('layout', $this->data);
      }

      public function manager() {

      }


	}
 ?>
