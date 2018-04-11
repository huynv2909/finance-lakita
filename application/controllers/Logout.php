<?php 
	/**
	 * Logout
	 */
	class Logout extends MY_Controller
	{
		
		function index()
		{
			$this->session->unset_userdata('username');
			redirect(base_url('login'));
		}
	}
 ?>