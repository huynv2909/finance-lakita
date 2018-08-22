<?php
	/**
	 * Logout
	 */
	class Logout extends MY_Controller
	{

		function index()
		{
			$this->session->unset_userdata('username');
			redirect($this->routes['login_index']);
		}
	}
 ?>
