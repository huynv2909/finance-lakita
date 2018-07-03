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
			$this->data['active'] = 'voucher';

         $this->load->model('Voucher_model');
         $input = array(
            'order' => array('date', 'desc')
         );
         $this->data['vouchers'] = $this->Voucher_model->get_list($input);

         $this->load->view('layout', $this->data);
      }
   }

 ?>
