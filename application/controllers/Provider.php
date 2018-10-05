<?php
	/**
	 * Provider
	 */
	class Provider extends MY_Controller
	{
      public function __construct() {
         parent::__construct();
         $this->load->model('Provider_model');
      }

		public function listByMethodId()
		{
			if ($this->input->post('id')) {
            $method_id = $this->input->post('id');
            $input = array(
               'where' => array('in_id' => $method_id)
            );

            die(json_encode($this->Provider_model->get_list($input)));
         }
		}
	}
 ?>
