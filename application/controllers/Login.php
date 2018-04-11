<?php 
	/**
	 * Login
	 */
	class Login extends MY_Controller
	{
		
		function index()
		{
			$this->load->library('form_validation');
			$this->load->helper('form');
			$this->load->helper('security');

			$this->data['title'] = "Đăng nhập vào hệ thống";

			if ($this->input->post()) {
				
				if ($this->Authentication()) {
					redirect(base_url());
				}

				$this->data['message'] = 'Invalid Username or Password';
			}

			$this->load->view('login/index', $this->data);
		}

		private function Authentication()
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			if ($this->form_validation->run()) {
				$user_info = array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password')
					);

				$this->load->model('User_model');

				if ($this->User_model->check_exist($user_info)) {
					$this->session->set_userdata('username', $this->input->post('username'));
					return true;
				};
			}

			return false;
		}

		private function Remember()
		{
			// Update later
		}
	}
 ?>