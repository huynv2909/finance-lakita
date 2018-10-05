<?php
	/**
	 * Method
	 */
	class Method extends MY_Controller
	{
      public function __construct() {
         parent::__construct();
         $this->load->model('Method_model');
      }
	}
 ?>
