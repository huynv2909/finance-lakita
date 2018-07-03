<?php
	/**
	 * Voucher
	 */
	class Voucher extends MY_Controller
	{
		public function __construct() {
			parent::__construct();
			$this->load->model('Voucher_model');
		}

		public function index() {
			$this->data['title'] = "Sổ kế toán";
			$this->data['template'] = "voucher/index";
			$this->data['active'] = 'receipt';
			$this->data['receipts'] = $this->Voucher_model->get_list();

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
			$this->data['template'] = 'voucher/create';
			$this->data['active'] = 'voucher';

			$this->load->model('Voucher_model');
			$this->data['vouchers'] = $this->Voucher_model->get_list();
			// Get type receipt
			$this->load->model('VoucherType_model');
			$input = array(
				'where' => array(
					'active' => 1
				)
			);
			$this->data['voucher_type'] = $this->VoucherType_model->get_list($input);
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
					$type = NULL;
					foreach ($this->data['voucher_type'] as $item) {
						if ($item->id == $this->input->post('voucher_type')) {
							$type = $item->code;
							break;
						}
					}
					$code = $this->GenerateCode($type);

					$data = array(
						'code' => $code,
						'code_real' => $this->input->post('code_real'),
						'type_id' => $this->input->post('voucher_type'),
						'content' => $this->input->post('content'),
						'TOT' => $this->input->post('tot'),
						'TOA' => $this->input->post('toa'),
						'executor' => $this->input->post('executor'),
						'value' => str_replace(".","",$this->input->post('value')),
						'owner' => 1,
						'note' => $this->input->post('note'),
						'income' => $this->input->post('income')
						);

					$this->load->model('Voucher_model');
					if ($this->Voucher_model->create($data)) {
						$this->session->set_flashdata('message_success', 'Thêm dữ liệu thành công!');
						redirect(base_url('voucher/create'));
					}
				}
				else {
					$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra khi nhập dữ liệu!');
					redirect(base_url('voucher/create'));
				}
			}

			$this->load->view('layout', $this->data);
		}

		public function show_info() {
			if ($this->input->post()) {
				$id = $this->input->post('id');

				$this->data['info'] = $this->Voucher_model->get_info($id);

				$this->load->model('User_model');
				$this->data['employees'] = $this->User_model->get_list();

				$this->load->model('VoucherType_model');
				$input = array(
					'where' => array(
						'active' => 1
					)
				);
				$this->data['types'] = $this->VoucherType_model->get_list($input);

				$input = array(
					'where' => array(
						'voucher_id' => $id
					)
				);
				$this->load->model('AccountingEntry_model');
				$this->data['act_list'] = $this->AccountingEntry_model->get_list($input);

				$response = array(
					'voucher' => $this->load->view('load_by_ajax/voucher_box', $this->data, true),
					'act' => $this->data['act_list'],
					'voucher_id' => $this->data['info']->id,
					'TOT' => $this->data['info']->TOT
				);

				die(json_encode($response));
			}
		}

		// public function type() {
		// 	$this->data['title'] = "Loại chứng từ";
		// 	$this->data['template'] = "receipt/type";
		// 	$this->data['active'] = 'receipt';
		//
		// 	$input = array(
		// 		'order' => array('active', 'desc')
		// 	);
		// 	$this->load->model('VoucherType_model');
		// 	$this->data['receipt_types'] = $this->ReceiptType_model->get_list($input);
		// 	$input = array(
		// 		'where' => array(
		// 			'active' => 1
		// 		)
		// 	);
		// 	$this->load->model('ActEntryType_model');
		// 	$this->data['act_entry_types'] = $this->ActEntryType_model->get_list($input);
		//
		// 	$this->load->view('layout', $this->data);
		// }


		// Create new type receipt by ajax
		// public function create_type_receipt() {
		// 	if ($this->input->post()) {
		// 		$this->load->model('ReceiptType_model');
		// 		$input = array(
		// 			'select' => array('code')
		// 		);
		//
		// 		$this->data['list_code'] = $this->ReceiptType_model->get_list($input);
		// 		$this->load->view('receipt/load/create_type_form', $this->data);
		// 	}
		// }

		// Delete a type receipt by Ajax
		// public function delete_type() {
		// 	if ($this->input->post()) {
		// 		$id = $this->input->post('id');
		// 		$this->load->model('ReceiptType_model');
		//
		// 		if ($this->ReceiptType_model->delete($id)) {
		// 			$response = array(
		// 				'success' => true,
		// 				'message' => "Đã xóa!"
		// 			);
		// 		} else {
		// 			$response = array(
		// 				'success' => false,
		// 				'message' => "Đã có lỗi xảy ra!"
		// 			);
		// 		}
		// 		die(json_encode($response));
		// 	}
		// }

		// Update name receipt type
		// public function update_name() {
		// 	if ($this->input->post()) {
		// 		$id = $this->input->post('id');
		// 		$name = $this->input->post('name');
		//
		// 		$data = array(
		// 			'name' => $name
		// 			);
		// 		$this->load->model('ReceiptType_model');
		//
		// 		if ($this->ReceiptType_model->update($id, $data)) {
		// 			echo 'success';
		// 		} else {
		// 			echo 'failed';
		// 		}
		// 	}
		// }

		// Update status of receitpt_type by ajax
		// public function change_status() {
		// 	if ($this->input->post()) {
		// 		$list_change = json_decode($this->input->post('list_change'));
		// 		$this->load->model('ReceiptType_model');
		//
		// 		foreach ($list_change as $key => $value) {
		// 			$input = array(
		// 				'active' => $value
		// 			);
		// 			$this->ReceiptType_model->update($key, $input);
		// 		}
		// 	}
		// }

		// when updated status of receipt type, we reload list receipt type by ajax
		// public function load_new_status() {
		// 	if ($this->input->post()) {
		// 		$input = array(
		// 			'order' => array('active', 'desc')
		// 		);
		// 		$this->load->model('ReceiptType_model');
		// 		$this->data['receipt_types'] = $this->ReceiptType_model->get_list($input);
		//
		// 		$this->load->view('receipt/load/receipt_list', $this->data);
		//
		// 	}
		// }

		// Update list accounting entry type of receipt type
		// public function update_list_act() {
		// 	if ($this->input->post()) {
		// 		$id_type = $this->input->post('id');
		// 		$new_list = $this->input->post('list');
		//
		// 		$this->load->model('ReceiptType_model');
		// 		$data = array(
		// 			'act_type_list_id' => $new_list
		// 		);
		// 		if ($this->ReceiptType_model->update($id_type, $data)) {
		// 			echo 'success';
		// 		}
		// 		else {
		// 			echo 'failed';
		// 		}
		// 	}
		// }

		// public function view_more() {
		// 	if ($this->input->post()) {
		// 		$receipt_id = $this->input->post('id');
		// 		$input = array(
		// 			'where' => array('id' => $receipt_id)
		// 		);
		//
		// 		$this->load->model('Receipt_model');
		// 		$receipt = $this->Receipt_model->get_list($input)[0];
		// 		$this->data['receipt'] = $receipt;
		//
		// 		$this->load->model('ReceiptType_model');
		// 		$input = array(
		// 			'where' => array(
		// 				'active' => 1
		// 			)
		// 		);
		// 		$this->data['receipt_types'] = $this->ReceiptType_model->get_list($input);
		//
		// 		$this->load->model('User_model');
		// 		$this->data['users'] = $this->User_model->get_list();
		//
		// 		$this->load->model('AccountingEntry_model');
		// 		$input = array(
		// 			'where' => array('receipt_id' => $receipt->id)
		// 		);
		// 		$this->data['accounting_entries'] = $this->AccountingEntry_model->get_list($input);
		//
		// 		$this->load->view('receipt/more/receipt', $this->data);
		// 		$this->load->view('receipt/more/act-entry', $this->data);
		//
		// 	}
		// }

		// Load accounting entry types when click receipt.
		// public function load_act_type() {
		// 	if ($this->input->post()) {
		// 		$id = $this->input->post('id');
		//
		// 		$this->load->model('ReceiptType_model');
		// 		$input = array(
		// 			'select' => array('act_type_list_id'),
		// 			'where' => array('id' => $id)
		// 		);
		//
		// 		if ($response = $this->ReceiptType_model->get_list($input)) {
		// 			$list = $response[0]->act_type_list_id;
		// 			echo '<input type="hidden" name="list-act-ori" id="list-act-ori" value="' . $list . '">';
		// 			echo '<input type="hidden" name="list-new" id="list-new" value="' . $list . '">';
		// 			$id_list = explode(',', $list);
		// 			foreach ($id_list as $item) {
		// 				$this->load_a_act_type_and_show($item);
		// 			}
		// 		}
		// 	}
		// }

		// Load act type info to edit receipt type
		// public function load_act_type_info() {
		// 	if ($this->input->post()) {
		// 		$id = $this->input->post('id');
		// 		$this->load_a_act_type_and_show($id);
		// 	}
		// }

		// Load accounting entry form
		// public function load_form()
		// {
		// 	if ($this->input->post()) {
		// 		$id = $this->input->post('id');
		//
		// 		$this->load->model('ReceiptType_model');
		// 		$input = array(
		// 			'select' => array('act_type_list_id'),
		// 			'where' => array('id' => $id)
		// 		);
		// 		if ($response = $this->ReceiptType_model->get_list($input)) {
		// 			$list = $response[0]->act_type_list_id;
		// 			$files = explode(',', $list);
		// 			$data['count'] = count($files);
		// 			if (trim($list, " ") == '') {
		// 				$data['count'] = 0;
		// 			}
		// 			$this->load->view('receipt/act_form/info-and-custom', $data);
		//
		// 			if ($data['count'] > 0) {
		// 				$this->load->model('ActEntryType_model');
		// 				$sequence = 1;
		// 				foreach ($files as $item ) {
		// 					$input = array(
		// 						'where' => array('id' => $item),
		// 						'active' => 1
		// 					);
		//
		// 					$data['info_tr'] = $this->ActEntryType_model->get_list($input)[0];
		// 					$data['sequence'] = $sequence;
		// 					$sequence++;
		// 					$this->load->view('receipt/act_form/main', $data);
		// 				}
		// 			}
		// 			$this->load->view('receipt/act_form/submit');
		// 		}
		// 		else {
		// 			echo "Errors: Empty information!";
		// 		}
		//
		// 	}
		// }

		// public function add_act_entry()
		// {
		// 	if ($this->input->post()) {
		// 		$count = $this->input->post('count');
		// 		$tot = $this->input->post('tot');
		// 		$toa = $this->input->post('toa');
		// 		$data['sequence'] = $count + 1;
		// 		$data['tot'] = $tot;
		// 		$data['toa'] = $toa;
		// 		$this->load->view('receipt/act_form/main', $data);
		// 	}
		// }

		// private function load_a_act_type_and_show($id) {
		// 	$this->load->model('ActEntryType_model');
		// 	$data['act_type'] = $this->ActEntryType_model->get_info($id);
		// 	$this->load->view('receipt/load/act_list', $data);
		// }

		private function checkInput() {
			$value_str = $this->input->post('value');
			$value_total = str_replace(".","",$value_str);

			if (!is_numeric($value_total)) {
				return false;
			}
			$this->form_validation->set_rules('voucher_type', 'Voucher type', 'required');
			$this->form_validation->set_rules('tot', 'TOT', 'required');
			$this->form_validation->set_rules('executor', 'Executor', 'required');

			return $this->form_validation->run();
		}

		private function GenerateCode($receipt_code) {
			$date = new DateTime();
			$string = $date->getTimestamp();
			return $receipt_code . $string;
		}
	}
 ?>
