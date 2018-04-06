<?php 
	/**
	 * Receipt
	 */
	class Receipt extends MY_Controller
	{
		public function create()
		{
			$this->data['title'] = "Thêm chứng từ";
			$this->data['templete'] = 'receipt/create';
			$this->data['active'] = 'receipt';

			// Get type receipt
			$this->load->model('ReceiptType_model');
			$this->data['receipt_type'] = $this->ReceiptType_model->get_list();
			// Get employee
			$this->load->model('User_model');
			$this->data['employees'] = $this->User_model->get_list();

			// When submit form
			if ($this->input->post()) {
				if ($this->checkInput()) {
					pre($this->input->post());
				}
			}

			$this->load->view('layout', $this->data);
		}


		private function checkInput() {
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('receipt_type', 'Receip type', 'required');
			$this->form_validation->set_rules('value', 'Money', 'required');
			$this->form_validation->set_rules('tot', 'Receip type', 'required');
			$this->form_validation->set_rules('toa', 'Receip type', 'required');
			$this->form_validation->set_rules('executor', 'Executor', 'required');
			$this->form_validation->set_rules('date', 'Date', 'required');

			return $this->form_validation->run();
		}
	}
 ?>