<?php
   /**
    *
    */
   class AccountingEntry extends MY_Controller
   {
      function index()
      {

      }

      public function create() {
         $this->data['title'] = "Nhập bút toán";
			$this->data['template'] = 'accounting/create';
			$this->data['active'] = 'receipt';
         $this->load->view('layout', $this->data);
      }
   }

 ?>
