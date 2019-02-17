<?php
	/**
	 * Log
	 */
	class Log extends MY_Controller
	{
		public function __construct() {
			parent::__construct();
			$this->load->model('Log_model');
		}

		public function index()
		{
			$this->data['title'] = "Lịch sử hoạt động";
			$this->data['template'] = 'log/index';
			$this->data['active'] = 'log';
			$this->data['js_files'] = array('config_index');

			

			$this->load->view('layout', $this->data);
		}
	}
 ?>
