<?php
	/**
	 * Redirect
	 */
	class Redirect extends MY_Controller
	{

		function accessDenied()
		{
			$this->data['title'] = 'Access Denied!';
			$this->data['template'] = 'errors/access_denied';
			$this->load->view('layout', $this->data);
		}
	}
 ?>
