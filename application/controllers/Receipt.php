<?php
	/**
	 * Receipt
	 */
	class Receipt extends MY_Controller
	{
		public function index() {
			$this->data['title'] = "Sổ kế toán";
			$this->data['template'] = "receipt/index";
			$this->data['active'] = 'receipt';

			$this->load->model('Receipt_model');
			$this->data['receipts'] = $this->Receipt_model->get_list();

			$this->load->model('ReceiptType_model');
			$input = array(
				'where' => array(
					'active' => 1
				)
			);
			$this->data['receipt_types'] = $this->ReceiptType_model->get_list($input);

			$this->load->model('User_model');
			$this->data['users'] = $this->User_model->get_list();

			$this->load->view('layout', $this->data);
		}

		public function create()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->data['title'] = "Thêm chứng từ";
			$this->data['template'] = 'receipt/create';
			$this->data['active'] = 'receipt';

			// Get type receipt
			$this->load->model('ReceiptType_model');
			$input = array(
				'where' => array(
					'active' => 1
				)
			);
			$this->data['receipt_type'] = $this->ReceiptType_model->get_list($input);
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

					$code = trim($this->input->post('receipt_code'));
					$type = NULL;
					foreach ($this->data['receipt_type'] as $item) {
						if ($item->id == $this->input->post('receipt_type')) {
							$type = $item->code;
							break;
						}
					}
					$code = $this->GenerateCode($type);

					$data = array(
						'code' => $code,
						'code_real' => $this->input->post('code_real'),
						'type_id' => $this->input->post('receipt_type'),
						'content' => $this->input->post('content'),
						'TOT' => $this->input->post('tot'),
						'TOA' => $this->input->post('toa'),
						'executor' => $this->input->post('executor'),
						'value' => str_replace(".","",$this->input->post('value')),
						'owner' => 1,
						'date' => $this->input->post('date'),
						'note' => $this->input->post('note'),
						'income' => $this->input->post('income')
						);

					$this->load->model('Receipt_model');
					if ($this->Receipt_model->create($data)) {
						$receipt_id = $this->Receipt_model->get_insert_id();

						$index_max = $this->input->post('index_max');

						$this->load->model('AccountingEntry_model');
						for ($i=1; $i <= $index_max; $i++) {
							if ($this->input->post('hide-' . $i) == 'true') {
								$trans = array(
									'receipt_id' => $receipt_id,
									'TOT' => $this->input->post('tot-' . $i),
									'TOA' => $this->input->post('toa-' . $i),
									'value' => str_replace(".","",$this->input->post('value-' . $i)),
									'note' => $this->input->post('note-' . $i),
									'income' => $this->input->post('income-' . $i)
								);

								$this->AccountingEntry_model->create($trans);
							}
						}
						$this->session->set_flashdata('message_success', 'Thêm dữ liệu thành công!');
						redirect(base_url('receipt/create'));
					}
				}
				else {
					$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra khi nhập dữ liệu!');
					redirect(base_url('receipt/create'));
				}
			}

			$this->load->view('layout', $this->data);
		}

		public function type() {
			$this->data['title'] = "Loại chứng từ";
			$this->data['template'] = "receipt/type";
			$this->data['active'] = 'receipt';

			$input = array(
				'order' => array('active', 'desc')
			);
			$this->load->model('ReceiptType_model');
			$this->data['receipt_types'] = $this->ReceiptType_model->get_list($input);

			$this->load->view('layout', $this->data);
		}

		public function view_more() {
			if ($this->input->post()) {
				$receipt_id = $this->input->post('id');
				$input = array(
					'where' => array('id' => $receipt_id)
				);

				$this->load->model('Receipt_model');
				$receipt = $this->Receipt_model->get_list($input)[0];
				$this->data['receipt'] = $receipt;

				$this->load->model('ReceiptType_model');
				$input = array(
					'where' => array(
						'active' => 1
					)
				);
				$this->data['receipt_types'] = $this->ReceiptType_model->get_list($input);

				$this->load->model('User_model');
				$this->data['users'] = $this->User_model->get_list();

				$this->load->model('AccountingEntry_model');
				$input = array(
					'where' => array('receipt_id' => $receipt->id)
				);
				$this->data['accounting_entries'] = $this->AccountingEntry_model->get_list($input);

				$this->load->view('receipt/more/receipt', $this->data);
				$this->load->view('receipt/more/act-entry', $this->data);

			}
		}

		// Load accounting entry form
		public function load_form()
		{
			if ($this->input->post()) {
				$id = $this->input->post('id');

				$this->load->model('ReceiptType_model');
				$input = array(
					'select' => array('act_type_list_id'),
					'where' => array('id' => $id)
				);
				if ($response = $this->ReceiptType_model->get_list($input)) {
					$list = $response[0]->act_type_list_id;
					$files = explode(',', $list);
					$data['count'] = count($files);
					$this->load->view('receipt/act_form/info-and-custom', $data);

					$this->load->model('ActEntryType_model');
					$sequence = 1;
					foreach ($files as $item ) {
						$input = array(
							'where' => array('id' => $item),
							'active' => 1
						);

						$data['info_tr'] = $this->ActEntryType_model->get_list($input)[0];
						$data['sequence'] = $sequence;
						$sequence++;
						$this->load->view('receipt/act_form/main', $data);
					}
					$this->load->view('receipt/act_form/submit');
				}
				else {
					echo "Errors: Empty information!";
				}

			}
		}

		public function add_act_entry()
		{
			if ($this->input->post()) {
				$count = $this->input->post('count');
				$tot = $this->input->post('tot');
				$toa = $this->input->post('toa');
				$data['sequence'] = $count + 1;
				$data['tot'] = $tot;
				$data['toa'] = $toa;
				$this->load->view('receipt/act_form/act-added', $data);
			}
		}

		private function checkInput() {
			$value_str = $this->input->post('value');
			$value_total = str_replace(".","",$value_str);

			if (!is_numeric($value_total)) {
				return false;
			}
			$this->form_validation->set_rules('receipt_type', 'Receip type', 'required');
			$this->form_validation->set_rules('tot', 'TOT', 'required');
			$this->form_validation->set_rules('toa', 'TOA', 'required');
			$this->form_validation->set_rules('executor', 'Executor', 'required');
			$this->form_validation->set_rules('date', 'Date', 'required');

			$value_act = 0;

			$index_max = $this->input->post('index_max');
			for ($i=1; $i <= $index_max; $i++) {
				if ($this->input->post('hide-' . $i) == 'true') {
					$value_str = $this->input->post('value-' . $i);
					$value = str_replace(".","",$value_str);

					if (!is_numeric($value)) {
						return false;
					}
					$value_act += $value;

					$this->form_validation->set_rules('tot-' . $i, 'TOT', 'required');
					$this->form_validation->set_rules('toa-' . $i, 'TOA', 'required');
				}
			}

			if ($this->input->post('income') == 1) {
				if ($value_total != $value_act) {
					return false;
				}
			}

			return $this->form_validation->run();
		}

		private function GenerateCode($receipt_code) {
			$date = new DateTime();
			$string = $date->getTimestamp();
			return $receipt_code . $string;
		}
	}
 ?>
