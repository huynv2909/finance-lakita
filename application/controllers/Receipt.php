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
			$message_errors = $this->session->flashdata('message_errors');
			$message_success = $this->session->flashdata('message_success');
			$this->data['message_errors'] = $message_errors;
			$this->data['message_success'] = $message_success;

			// When submit form
			if ($this->input->post()) {
				if ($this->checkInput()) {
					// Check value is number
					$value_str = $this->input->post('value');
					$value = str_replace(".","",$value_str);

					if (!is_numeric($value)) {
						$this->session->set_flashdata('message_errors', 'Hãy nhập tiền là định dạng số!');
						redirect(base_url('receipt/create'));
					}

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
						'value' => $value,
						'owner' => 1,
						'date' => $this->input->post('date'),
						'note' => $this->input->post('note')
						);

					$this->load->model('Receipt_model');
					if ($this->Receipt_model->create($data)) {
						$this->session->set_flashdata('message_success', 'Thêm dữ liệu thành công!');
					}
					else {
						$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
					}
					redirect(base_url('receipt/create'));
				}
			}

			$this->load->view('layout', $this->data);
		}

		public function load_form()
		{
			if ($this->input->post()) {
				$id = $this->input->post('id');

				$this->load->model('ReceiptType_model');
				$input = array(
					'select' => array('transaction_type_list_id'),
					'where' => array('id' => $id)
				);
				if ($response = $this->ReceiptType_model->get_list($input)) {
					$list = $response[0]->transaction_type_list_id;
					$files = explode(',', $list);
					$data['count'] = count($files);
					$this->load->view('receipt/transaction_form/info-and-custom', $data);

					$this->load->model('TransactionType_model');
					$sequence = 1;
					foreach ($files as $item ) {
						$input = array(
							'where' => array('id' => $item)
						);

						$data['info_tr'] = $this->TransactionType_model->get_list($input)[0];
						$data['sequence'] = $sequence;
						$sequence++;
						$this->load->view('receipt/transaction_form/' . $item, $data);
					}
					$this->load->view('receipt/transaction_form/submit');
				}
				else {
					echo "Errors: Empty information!";
				}

			}
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
