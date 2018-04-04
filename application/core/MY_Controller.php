<?php 
	if (!defined('BASEPATH')) die('Bad request!');

	class MY_Controller extends CI_Controller
	{
		var $data = array();

		function __construct()
		{
			parent::__construct();

			$controller = $this->uri->segment(1);
			$controller = strtolower($controller);

			switch ($controller) {
				// Admin
				case 'admin':
					$this->load->library('session');
					$this->load->helper('admin');

					$this->check();
					break;
				// Blog
				default:
					// Load file libraries, helper,...
					# code...
					break;
			}
		}

		private function check()
		{
			$controller = $this->uri->rsegment('1');

			$loged_in = $this->session->userdata('user');

			if ($loged_in && $controller == 'login') {
				redirect(admin_url('home'));
			}

			if (!$loged_in && $controller != 'login') {
				redirect(admin_url('login'));
			}
		}
	}
 ?>