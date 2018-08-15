<?php
	if (!defined('BASEPATH')) die('Bad request!');

	class MY_Controller extends CI_Controller
	{
		var $data = array();

		function __construct()
		{
			parent::__construct();

			// Get notify
         $message_errors = $this->session->flashdata('message_errors');
         $message_success = $this->session->flashdata('message_success');
         $this->data['message_errors'] = $message_errors;
         $this->data['message_success'] = $message_success;

			$configs = $this->input->cookie('configs_json');
			$this->data['check'] = 'no cookie';
			// Get config
			if ($configs == NULL) {
				$this->data['check'] = 'cookie';
				$this->load->model('Config_model');
				$config_db = $this->Config_model->get_list();
				$config_arr = array();
				foreach ($config_db as $row) {
					$config_arr[$row->name] = $row->value;
				}
				$configs = json_encode($config_arr);
				$cookie= array(
	           'name'   => 'configs_json',
	           'value'  => $configs,
	           'expire' => '604800'	 // a week
	       	);
				$this->input->set_cookie($cookie);
			}
			$this->data['configs'] = $configs;

			$this->check();
		}

		// Check user loged_in
		private function check()
		{
			$controller = strtolower($this->uri->rsegment('1'));

			$loged_in = $this->session->userdata('username');

			if ($loged_in) {
				$this->load->model('User_model');
				$input = array(
					'where' => array('username' => $loged_in)
				);
				$this->data['user'] = $this->User_model->get_list($input)[0];
			}

			if ($loged_in && $controller == 'login') {
				redirect(base_url('dashboard'));
			}

			if (!$loged_in && $controller != 'login') {
				redirect(base_url('login'));
			}
		}
	}
 ?>
