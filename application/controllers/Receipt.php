<?php 
	/**
	 * Receipt
	 */
	class Receipt extends MY_Controller
	{
		public function create()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');

			$this->data['title'] = "Thêm chứng từ";
			$this->data['templete'] = 'receipt/create';
			$this->data['active'] = 'receipt';

			// Get type receipt
			$this->load->model('ReceiptType_model');
			$this->data['receipt_type'] = $this->ReceiptType_model->get_list();
			// Get employee
			$this->load->model('User_model');
			$this->data['employees'] = $this->User_model->get_list();

			// Get notify
			$message = $this->session->flashdata('message');
			$this->data['message'] = $message;

			// When submit form
			if ($this->input->post()) {
				if ($this->checkInput()) {
					$code = trim($this->input->post('receipt_code'));
					if (empty($code)) {
						$type = NULL;
						foreach ($this->data['receipt_type'] as $item) {
							if ($item->id == $this->input->post('receipt_type')) {
								$type = $item->code;
								break;
							}
						}
						$code = $this->GenerateCode($type);
					}

					$data = array(
						'code' => $code,
						'type_id' => $this->input->post('receipt_type'),
						'content' => $this->input->post('content'),
						'tot' => $this->input->post('tot'),
						'toa' => $this->input->post('toa'),
						'executor' => $this->input->post('executor'),
						'value' => $this->input->post('value'),
						'owner' => 1,
						'date' => $this->input->post('date'),
						'note' => $this->input->post('note')
						);

					$this->load->model('Receipt_model');
					if ($this->Receipt_model->create($data)) {
						$this->session->set_flashdata('message', 'Thêm dữ liệu thành công!');
					}
					else {
						$this->session->set_flashdata('message', 'Đã có lỗi xảy ra!');
					}
					redirect(base_url('receipt/create'));
				}
			}

			$this->load->view('layout', $this->data);
		}


		private function checkInput() {
			$this->form_validation->set_rules('receipt_type', 'Receip type', 'required');
			$this->form_validation->set_rules('value', 'Money', 'required');
			$this->form_validation->set_rules('tot', 'Receip type', 'required');
			$this->form_validation->set_rules('toa', 'Receip type', 'required');
			$this->form_validation->set_rules('executor', 'Executor', 'required');
			$this->form_validation->set_rules('date', 'Date', 'required');

			return $this->form_validation->run();
		}

		private function GenerateCode($receipt_code) {
			$date = new DateTime();
			$string = $date->getTimestamp();
			return $receipt_code . $string;
		}
	}
 ?>