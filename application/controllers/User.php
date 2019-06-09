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

					$this->data['log_info']['row_id'] = $list_changed[0];
					$this->data['log_info']['info'] = 'Thay đổi quyền';
					$this->Log_model->create($this->data['log_info']);

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
			$this->data['title'] = "Quản trị người dùng";
			$this->data['template'] = 'user/manager';
			$this->data['active'] = 'user';
         $this->data['js_files'] = array('user_manager');

			$this->data['users'] = $this->User_model->get_list(array('where' => array('deleted' => 0, 'id !=' => 0)));

			if ($this->input->post()) {
				$data = array(
					'name' => $this->input->post('name'),
					'permission' => $this->input->post('permission'),
					'username' => $this->input->post('username'),
					'password' => md5($this->input->post('password'))
				);

				if (!$this->User_model->create($data)) {
					$this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
					redirect($this->routes['user_manager']);
				}

				$this->data['log_info']['row_id'] = $this->User_model->get_insert_id();
				$this->data['log_info']['info'] = $data['name'];

				$this->Log_model->create($this->data['log_info']);

				$this->session->set_flashdata('message_success', 'Thao tác thành công!');
				redirect($this->routes['user_manager']);
			}

			$this->load->view('layout', $this->data);
      }

		public function edit() {
			if ($this->input->post()) {
				$id = $this->input->post('id');

				$this->data['info'] = $this->User_model->get_info($id);

				$this->load->view('user/edit', $this->data);
			}
		}

		public function delete() {
			if ($this->input->post()) {
            $id = $this->input->post('id');

            $response = array();

            if ($this->User_model->update($id, array('deleted' => 1))) {
               $response['success'] = true;
               $response['message'] = "Đã xóa!";

               $info = $this->User_model->get_info($id);
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

		public function profile() {
			$this->data['title'] = "Thông tin cá nhân";
			$this->data['template'] = 'user/profile';
			$this->data['active'] = 'user';

			$this->data['info'] = $this->User_model->get_info($this->user->id);

			if ($this->input->post()) {
				if ($this->data['info']->password != md5($this->input->post('password'))) {
					$this->session->set_flashdata('message_errors', 'Mật khẩu không chính xác, thao tác thất bại :(');
					redirect($this->routes['user_profile']);
				}

				if (!$this->User_model->update($this->user->id, array('password' => md5($this->input->post('new_password'))))) {
					$this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
					redirect($this->routes['user_profile']);
				}

				$this->data['log_info']['row_id'] = $this->user->id;
				$this->data['log_info']['info'] = $this->data['info']->name . ' : tự đổi mật khẩu';

				$this->Log_model->create($this->data['log_info']);

				$this->session->set_flashdata('message_success', 'Thao tác thành công!');
				redirect($this->routes['user_profile']);
			}

			$this->load->view('layout', $this->data);
		}

		public function editSubmit() {
			if ($this->input->post()) {
				$id = $this->input->post('id');

				$data = array(
					'name' => $this->input->post('name'),
					'permission' => $this->input->post('permission')
				);

				if ($this->input->post('change') == 1) {
					$data['password'] = $this->input->post('password');
				}

				if (!$this->User_model->update($id, $data)) {
					$this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
					redirect($this->routes['user_manager']);
				}

				$this->data['log_info']['row_id'] = $id;
				$this->data['log_info']['info'] = $data['name'];

				$this->Log_model->create($this->data['log_info']);

				$this->session->set_flashdata('message_success', 'Thao tác thành công!');

				redirect($this->routes['user_manager']);
			}
		}

	}
 ?>
