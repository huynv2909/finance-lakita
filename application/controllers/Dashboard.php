<?php 
	/**
	 * Dashboard
	 */
	class Dashboard extends MY_Controller
	{
		public function index()
		{
			$this->data['title'] = "Dashboard";
			$this->data['templete'] = 'dashboard/index';
			$this->data['active'] = 'dashboard';

			$this->load->view('layout', $this->data);
		}
	}
 ?>