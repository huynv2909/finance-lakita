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
		}

		public function create()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->data['title'] = "Thêm chứng từ";
			$this->data['template'] = 'voucher/create';
			$this->data['active'] = 'voucher';
			$this->data['js_files'] = array('voucher_create');

			$voucher_list = $this->Voucher_model->get_list();
			foreach ($voucher_list as $voucher) {
				$voucher->{"completed"} = $this->checkIssetAccoutingEntry($voucher->id, $voucher->value);
			}

			$this->data['vouchers'] = $voucher_list;
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

			// Courses list
			$this->load->model('DetailDimension_model');
			$input = array(
				'where' => array(
					'dimen_id' => 120,
					'active' => 1
				),
				'order' => 'name asc'
			);
         $courses = $this->DetailDimension_model->get_list($input);
			$this->data['courses'] = $courses;

			// Dimen list
			$input = array(
				'where' => array('dimen_id !=' => 120),
				'order' => 'name asc'
			);
         $dimens = $this->DetailDimension_model->get_list($input);
			$this->data['dimens'] = $dimens;

			// Get system acc
			$this->load->model('AccountingSystem');
         $list_account = $this->AccountingSystem->get_list();
			$this->data['system_acc'] = $list_account;

			// default debit acc & credit acc , update by ajax later

			$this->data['latest_voucher_id'] = $this->session->flashdata('latest_id');

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

					if (!$this->Voucher_model->create($data)) {
						$this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
						redirect(base_url('voucher/create'));
					}

					$voucher_id = $this->Voucher_model->get_insert_id();
					// to pop up go to accounting entry create
					// $this->session->set_flashdata('latest_id', $voucher_id);
					$this->data['all_dimen'] = $this->DetailDimension_model->get_list();

					if ($this->input->post('income') == 1) {
						$total_row_sub = $this->input->post('count_sub');
						for ($i=1; $i <= $total_row_sub; $i++) {
							$used = $this->input->post('confirm_' . $i);
							if ($used == 1) {
								$data_acc = array(
									'voucher_id' => $voucher_id,
									'TOT' => $this->input->post('tot'),
									'TOA' => $this->input->post('toa_' . $i),
									'value' => str_replace(".","",$this->input->post('value_' . $i)),
									'debit_acc' => $this->input->post('debit_' . $i),
									'credit_acc' => $this->input->post('credit_' . $i)
								);

								$course_dis = $this->input->post('course_' . $i);
								if (!$this->createAccountingAndDistribution($data_acc, $course_dis, true)) {
									$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
									redirect(base_url('voucher/create'));
								}
							}

						}

					} else {
						$total_row_sub = $this->input->post('count_sub_out');
						for ($i=1; $i <= $total_row_sub; $i++) {
							$used = $this->input->post('confirm_out_' . $i);
							if ($used == 1) {
								$data_acc = array(
									'voucher_id' => $voucher_id,
									'TOT' => $this->input->post('tot'),
									'TOA' => $this->input->post('toa_out_' . $i),
									'value' => str_replace(".","",$this->input->post('value_out_' . $i)),
									'debit_acc' => $this->input->post('debit_out_' . $i),
									'credit_acc' => $this->input->post('credit_out_' . $i)
								);

								$dimen_selected = $this->input->post('dimen_out_' . $i);
								if (!$this->createAccountingAndDistribution($data_acc, $dimen_selected, false)) {
									$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
									redirect(base_url('voucher/create'));
								}
							}

						}

					}

					$this->session->set_flashdata('message_success', 'Thêm dữ liệu thành công!');
					redirect(base_url('voucher/create'));
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
					'TOT' => $this->data['info']->TOT,
					'value' => $this->data['info']->value
				);

				die(json_encode($response));
			}
		}

		public function view_more() {
			if ($this->input->post()) {
				$voucher_id = $this->input->post('id');

				$voucher = $this->Voucher_model->get_info($voucher_id);
				$this->data['voucher'] = $voucher;

				$this->load->model('VoucherType_model');
				$input = array(
					'where' => array(
						'active' => 1
					)
				);
				$this->data['voucher_types'] = $this->VoucherType_model->get_list($input);

				$this->load->model('User_model');
				$this->data['users'] = $this->User_model->get_list();

				$this->load->model('AccountingEntry_model');
				$input = array(
					'where' => array('voucher_id' => $voucher->id)
				);

				$list_act = $this->AccountingEntry_model->get_list($input);
				foreach ($list_act as $act) {
					$act->{"completed"} = $this->checkIssetDistribution($act->id);
				}

				$this->data['accounting_entries'] = $list_act;

				$this->load->view('voucher/more/voucher', $this->data);
				$this->load->view('voucher/more/act-entry', $this->data);

			}
		}

		public function get_default_sys() {
			if ($this->input->post()) {
				$voucher_type = $this->input->post('voucher_type_id');
				$this->load->model('VoucherType_model');

				$type = $this->VoucherType_model->get_info($voucher_type);

				die(json_encode($type));
			}
		}

		private function checkInput() {
			$value_str = $this->input->post('value');
			$value_total = str_replace(".","",$value_str);

			if (!is_numeric($value_total)) {
				return false;
			}

			if ($this->input->post('income') == 1) {
				$total_sub = $this->input->post('count_sub');
				$total = 0;
				for ($i=1; $i <= $total_sub; $i++) {
					$used = $this->input->post('confirm_' . $i);
					if ($used == 1) {
						$value_temp = $this->input->post('value_' . $i);
						$value_temp = str_replace(".","",$value_temp);
						if (!is_numeric($value_temp)) {
							return false;
						}
						$total += $value_temp;
						$this->form_validation->set_rules('course_' . $i,'Course', 'required|greater_than[0]');
					}
				}
				if ($total != $value_total) {
					return false;
				}
			}

			$this->form_validation->set_rules('voucher_type', 'Voucher type', 'required|greater_than[0]');
			$this->form_validation->set_rules('tot', 'TOT', 'required');
			$this->form_validation->set_rules('executor', 'Executor', 'required|greater_than[0]');

			return $this->form_validation->run();
		}

		private function GenerateCode($receipt_code) {
			$date = new DateTime();
			$string = $date->getTimestamp();
			return $receipt_code . $string;
		}


		private function checkIssetAccoutingEntry($id_voucher, $value_voucher) {
			$input = array(
				'where' => array(
					'voucher_id' => $id_voucher
				)
			);

			$this->load->model('AccountingEntry_model');

			if (count($acc_list = $this->AccountingEntry_model->get_list($input)) > 0) {
				$total_acc = 0;
				foreach ($acc_list as $acc) {
					$total_acc += $acc->value;
				}

				if ($total_acc == $value_voucher) {
					return true;
				}

				return false;
			} else {
				return false;
			}
		}

		private function checkIssetDistribution($id_act) {
			$input = array(
				'where' => array(
					'entry_id' => $id_act
				)
			);

			$this->load->model('Distribution_model');

			if (count($this->Distribution_model->get_list($input)) > 0) {
				return true;
			} else {
				return false;
			}
		}

		private function createAccountingAndDistribution($info_acc, $detail_dimen_id, $is_revenue = false) {
			$parent_id = NULL;
			foreach ($this->data['all_dimen'] as $dimen) {
				if ($dimen->id == $detail_dimen_id) {
					$info_acc['content'] = $dimen->name;
					$parent_id = $dimen->parent_id;
					break;
				}
			}

			//  But toan.
			$this->load->model('AccountingEntry_model');
			if (!$this->AccountingEntry_model->create($info_acc)) {
				return false;
			}

			$acc_id = $this->AccountingEntry_model->get_insert_id();
			$this->load->model('DetailDimension_model');
			$this->load->model('Distribution_model');

			// Doanh thu: id = 210
			if ($is_revenue) {
				$data_rev = array(
					'entry_id' => $acc_id,
					'dimensional_id' => 210,
					'TOT' => $info_acc['TOT'],
					'TOA' => $info_acc['TOA'],
					'value' => $info_acc['value'],
					'content' => 'Doanh thu'
				);

				if (!$this->Distribution_model->create($data_rev)) {
					return false;
				}
			}

			// Cac chieu` san pham
			$dimen_id = $detail_dimen_id;
			$content_dis = $info_acc['content'];

			do {
				$data_dis = array(
					'entry_id' => $acc_id,
					'dimensional_id' => $dimen_id,
					'TOT' => $info_acc['TOT'],
					'TOA' => $info_acc['TOA'],
					'value' => $info_acc['value'],
					'content' => $content_dis
				);
				if (!$this->Distribution_model->create($data_dis)) {
					return false;
				}
				$dimen_id = $parent_id;
				if ($dimen_id != NULL) {
					$new_dimen = $this->DetailDimension_model->get_info($dimen_id);
					$content_dis = $new_dimen->name;
					$parent_id = $new_dimen->parent_id;
				}

			} while ($dimen_id != NULL);

			return true;
		}


	}
 ?>
