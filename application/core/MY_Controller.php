<?php
	if (!defined('BASEPATH')) die('Bad request!');

	class MY_Controller extends CI_Controller
	{
		var $data = array();

		function __construct()
		{
			parent::__construct();

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
