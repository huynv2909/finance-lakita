<?php
	/**
	 * Redirect
	 */
	class Redirect extends MY_Controller
	{

		function accessDenied()
		{
			$this->load->view('errors/access_denied');
		}
	}
 ?>
