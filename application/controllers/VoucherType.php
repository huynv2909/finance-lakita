<?php
   /**
    * VoucherType
    */
   class VoucherType extends MY_Controller
   {
      function __construct()
      {
         parent::__construct();
         $this->load->model('VoucherType_model');
      }

      public function index() {
         $this->data['title'] = "Loại chứng từ";
			$this->data['template'] = "voucher_type/index";
			$this->data['active'] = 'voucher';

         $this->data['list_types'] = $this->VoucherType_model->get_list();

         $this->load->view('layout', $this->data);
      }
   }

 ?>
