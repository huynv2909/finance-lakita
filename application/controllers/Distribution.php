<?php
   /**
    * Distribution
    */
   class Distribution extends MY_Controller
   {
      function __construct()
      {
         parent::__construct();
      }

      public function create() {
         $this->data['title'] = "Phân bổ bút toán";
			$this->data['template'] = 'distribution/create';
			$this->data['active'] = 'receipt';
         $this->load->view('layout', $this->data);
      }
   }

 ?>
