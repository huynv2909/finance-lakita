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

			// Get type receipt
			$this->load->model('VoucherType_model');
			$input = array(
				'where' => array(
					'active' => 1
				)
			);
			$this->data['voucher_type'] = $this->VoucherType_model->get_list($input);

			$this->load->model('DetailDimension_model');

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
						'owner' => $this->user->id,
						'note' => $this->input->post('note'),
						'method' => $this->input->post('method'),
						'provider' => $this->input->post('provider'),
						'income' => $this->input->post('income')
						);

					if (!$this->Voucher_model->create($data)) {
						$this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
						redirect($this->routes['voucher_create']);
					}

					$voucher_id = $this->Voucher_model->get_insert_id();
					// to pop up go to accounting entry create
					$this->session->set_flashdata('latest_id', $voucher_id);

					$this->data['log_info']['row_id'] = $voucher_id;
					$this->data['log_info']['info'] = $this->input->post('content') . ' : ' . str_replace(".","",$this->input->post('value')) . ' d';

					if ($this->input->post('auto_distribution') != 0) {
						$this->data['log_info']['info'] .= ' [AUTO phân bổ]';
						$this->data['all_dimen'] = $this->DetailDimension_model->get_list();

						if ($this->input->post('income') == 1) {
							$total_row_sub = $this->input->post('count_sub');
							// If have tax
							$weight_tax = 0;

							if ($this->input->post('vat_check')) {
								$weight_tax = $this->input->post('tax_value') / ( 100 + $this->input->post('tax_value') );
							}

							for ($i=1; $i <= $total_row_sub; $i++) {
								$used = $this->input->post('confirm_' . $i);
								if ($used == 1) {
									$value_entered = str_replace(".","",$this->input->post('value_' . $i));
									$value_tax = ceil($value_entered*$weight_tax);
									$value_revenue = $value_entered - $value_tax;

									$data_acc = array(
										'voucher_id' => $voucher_id,
										'TOT' => $this->input->post('tot'),
										'TOA' => $this->input->post('toa_' . $i),
										'value' => $value_revenue,
										'debit_acc' => $this->input->post('debit_' . $i),
										'credit_acc' => $this->input->post('credit_' . $i)
									);

									$course_dis = $this->input->post('course_' . $i);

									$is_revenue = true;

									// 22: Thu khac. 23: Dau tu
									if ($this->input->post('voucher_type') == 22 || $this->input->post('voucher_type') == 23) {
										$is_revenue = false;
									}

									if (!$this->createAccountingAndDistribution($data_acc, $course_dis, $is_revenue)) {
										$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
										redirect($this->routes['voucher_create']);
									}

									if ($value_tax > 0) {
										$data_acc = array(
											'voucher_id' => $voucher_id,
											'TOT' => $this->input->post('tot'),
											'TOA' => $this->input->post('toa_' . $i),
											'value' => $value_tax,
											'debit_acc' => $this->input->post('debit_tax'),
											'credit_acc' => $this->input->post('credit_tax')
										);
										// 350: Chi phí thue
										if (!$this->createAccountingAndDistribution($data_acc, 350, false, ' (VAT) ')) {
											$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
											redirect($this->routes['voucher_create']);
										}
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
										redirect($this->routes['voucher_create']);
									}
								}

							}

						}
					}

					$this->session->set_flashdata('message_success', 'Thêm dữ liệu thành công!');
					$this->Log_model->create($this->data['log_info']);

					redirect($this->routes['voucher_create']);
				}
				else {
					$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra khi nhập dữ liệu!');
					redirect($this->routes['voucher_create']);
				}
			}

			$filter = array(
				'where' => array('approved' => 1, 'deleted' => 0)
			);

			if ($this->input->get()) {
				if ($this->input->get('from')) {
					$filter['where']['TOT >='] = $this->input->get('from');
				}

				if ($this->input->get('to')) {
					$filter['where']['TOT <='] = $this->input->get('to');
				}

				if ($this->input->get('method')) {
					$filter['where']['method'] = $this->input->get('method');
				}

				if ($this->input->get('provider')) {
					$filter['where']['provider'] = $this->input->get('provider');
				}

				if ($this->input->get('voucher_type')) {
					$filter['where']['type_id'] = $this->input->get('voucher_type');
				}

				if ($this->input->get('executor')) {
					$filter['where']['executor'] = $this->input->get('executor');
				}

				if ($this->input->get('auto')) {
					$auto = $this->input->get('auto');

					if ($auto == '1') {
						$filter['like'] = array('content', '[AUTO-FROM-CRM]');
					}

					if ($auto == '2') {
						$filter['not_like'] = array('content', '[AUTO-FROM-CRM]');
					}
				}

				if ($this->input->get('income') == '0' || $this->input->get('income') == '1') {
					$filter['where']['income'] = $this->input->get('income');
				}

			} else {
				$this->data['limit_loading'] = json_decode($this->data['configs'])->NUMBER_LOADING;
				$filter['limit'] = array($this->data['limit_loading'],0);
			}

			$voucher_list = $this->Voucher_model->get_list($filter);
			$count_uncompleted = 0;
			foreach ($voucher_list as $voucher) {
				$done = $this->checkCompletedAccountingEntry($voucher->id, $voucher->value);
				$voucher->{"completed"} = $done;
				if (!$done) {
					$count_uncompleted++;
				}
			}
			$this->data['amount_uncompleted'] = $count_uncompleted;

			$this->data['get_uncompleted'] = 1;
			if ($this->input->get('uncompleted')) {
				$this->data['get_uncompleted'] = 0;
			}

			$this->data['vouchers'] = $voucher_list;

			// Get employee
			$this->load->model('User_model');
			$this->data['employees'] = $this->User_model->get_list();

			// Courses list
			$input = array(
				'where' => array(
					'dimen_id' => 120,
					'active' => 1,
					'deleted' => 0
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

			// Payment Method
			$this->load->model('Method_model');
			$this->data['methods']= $this->Method_model->get_list();

			// Provider
			$this->load->model('Provider_model');
			$this->data['providers']= $this->Provider_model->get_list();

			$this->data['latest_voucher_id'] = $this->session->flashdata('latest_id');

			$this->load->view('layout', $this->data);
		}

		public function approve()
		{
			$this->data['title'] = "Duyệt chứng từ thu tự động thêm từ CRM";
			$this->data['template'] = 'voucher/approve';
			$this->data['active'] = 'voucher';
			$this->data['js_files'] = array('voucher_approve');

			$filter = array(
				'where' => array('approved' => 0, 'income' => 1, 'deleted' => 0)
			);

			if ($this->input->get()) {
				if ($this->input->get('method')) {
					$filter['where']['method'] = $this->input->get('method');
				}

				if ($this->input->get('provider')) {
					$filter['where']['provider'] = $this->input->get('provider');
				}

				if ($this->input->get('voucher_type')) {
					$filter['where']['type_id'] = $this->input->get('voucher_type');
				}

			}

			$vc_news = $this->Voucher_model->get_list($filter);
			$this->data['vc_news'] = array();

			if (count($vc_news) > 0) {
				$this->load->model('Crm_model');
				foreach ($vc_news as $vc) {
					$parts = explode('-', $vc->content);

					if (count($parts) > 5) {
						$id_contact = $parts[3];
						$vc->{"course_code"} = $parts[5];

						$input = array(
							'where' => array('id_contact' => $id_contact)
						);

						$contact_info = $this->Crm_model->get_list($input);
						if (count($contact_info) > 0) {
							$vc->{"crm_note"} = $contact_info[0]->note;
						} else {
							$vc->{"crm_note"} = '';
						}
					} else {
						$vc->{"course_code"} = '';
						$vc->{"crm_note"} = '';
					}



				}
				$this->data['vc_news'] = $vc_news;

				$this->load->model('VoucherType_model');
				$input = array(
					'where' => array('active' => 1),
					'order' => 'income DESC'
				);
				$this->data['types'] = $this->VoucherType_model->get_list($input);

				$this->load->model('DetailDimension_model');
				$input = array(
					'where' => array('active' => 1, 'dimen_code' => 'SP'),
					'order' => 'name ASC'
				);
				$this->data['courses'] = $this->DetailDimension_model->get_list($input);

				$this->load->model('User_model');
				$this->data['users'] = $this->User_model->get_list();

				$this->load->model('Provider_model');
				$input = array('order' => 'name ASC');
				$this->data['providers'] = $this->Provider_model->get_list($input);

				$this->load->model('Method_model');
				$this->data['methods'] = $this->Method_model->get_list();
			}

			$this->load->view('layout', $this->data);
		}

		public function approve2()
		{
			$this->data['title'] = "Duyệt chứng từ chi";
			$this->data['template'] = 'voucher/approve2';
			$this->data['active'] = 'voucher';
			$this->data['js_files'] = array('voucher_approve');

			$filter = array(
				'where' => array('approved' => 0, 'income' => 0, 'deleted' => 0)
			);

			if ($this->input->get()) {
				if ($this->input->get('method')) {
					$filter['where']['method'] = $this->input->get('method');
				}

				if ($this->input->get('provider')) {
					$filter['where']['provider'] = $this->input->get('provider');
				}

				if ($this->input->get('voucher_type')) {
					$filter['where']['type_id'] = $this->input->get('voucher_type');
				}

			}

			$vc_news = $this->Voucher_model->get_list($filter);
			$this->data['vc_news'] = array();

			if (count($vc_news) > 0) {
				$this->data['vc_news'] = $vc_news;

				$this->load->model('VoucherType_model');
				$input = array(
					'where' => array('active' => 1),
					'order' => 'income DESC'
				);
				$this->data['types'] = $this->VoucherType_model->get_list($input);

				$this->load->model('User_model');
				$this->data['users'] = $this->User_model->get_list();

				$this->load->model('Provider_model');
				$input = array('order' => 'name ASC');
				$this->data['providers'] = $this->Provider_model->get_list($input);

				$this->load->model('Method_model');
				$this->data['methods'] = $this->Method_model->get_list();

			}

			$this->load->view('layout', $this->data);
		}

		public function approveOne() {
			if ($this->input->post()) {
				$value = str_replace(".","",$this->input->post('value'));
				$id = $this->input->post('id');
				$tot = $this->input->post('tot');

				$data = array(
					'type_id' => $this->input->post('type_id'),
					'content' => $this->input->post('content'),
					'TOT' => $tot,
					'TOA' => $tot,
					'executor' => $this->input->post('executor'),
					'value' => $value,
					'owner' => $this->user->id,
					'method' => $this->input->post('method'),
					'provider' => $this->input->post('provider'),
					'approved' => 1
				);

				if (!$this->Voucher_model->update($id, $data)) {
					$this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
					redirect($this->routes['voucher_approve']);
				}

				$this->data['log_info']['row_id'] = $id;
				$this->data['log_info']['info'] = $data['content'] . ' : ' . $data['value'] . ' d';

				if ($this->input->post('auto') == 1) {
					$this->data['log_info']['info'] .= ' [AUTO phân bổ]';

					$this->load->model('DetailDimension_model');
					$this->data['all_dimen'] = $this->DetailDimension_model->get_list();

					if ($this->input->post('vat') == 1) {
						$vat_value = $this->input->post('vat_value');

						$data_acc = array(
							'voucher_id' => $id,
							'TOT' => $tot,
							'TOA' => $tot,
							'value' => $vat_value,
							'debit_acc' => 111,
							'credit_acc' => 3331
						);

						$dimen_selected = 350;
						if (!$this->createAccountingAndDistribution($data_acc, $dimen_selected, false)) {
							$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra trong quá trình phân bổ 3!');
							redirect($this->routes['voucher_approve']);
						}
						$value -= $vat_value;
					}

					if ($this->input->post('cod') == 1) {
						$cod_value = $this->input->post('cod_value');
						$value = $value - $cod_value;

						$data_acc = array(
							'voucher_id' => $id,
							'TOT' => $tot,
							'TOA' => $tot,
							'value' => $value,
							'debit_acc' => 111,
							'credit_acc' => 511
						);

						$dimen_selected = $this->input->post('course');
						if (!$this->createAccountingAndDistribution($data_acc, $dimen_selected, true)) {
							$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra trong quá trình phân bổ 1!');
							redirect($this->routes['voucher_approve']);
						}

						$data_acc = array(
							'voucher_id' => $id,
							'TOT' => $tot,
							'TOA' => $tot,
							'value' => $cod_value,
							'debit_acc' => 111,
							'credit_acc' => 511
						);

						$dimen_selected = 318;
						if (!$this->createAccountingAndDistribution($data_acc, $dimen_selected, false)) {
							$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra trong quá trình phân bổ 2!');
							redirect($this->routes['voucher_approve']);
						}

					} else {
						$data_acc = array(
							'voucher_id' => $id,
							'TOT' => $tot,
							'TOA' => $tot,
							'value' => $value,
							'debit_acc' => 111,
							'credit_acc' => 511
						);

						$dimen_selected = $this->input->post('course');
						if (!$this->createAccountingAndDistribution($data_acc, $dimen_selected, true)) {
							$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra trong quá trình phân bổ!');
							redirect($this->routes['voucher_approve']);
						}
					}
				}

				$this->Log_model->create($this->data['log_info']);

				die('Thao tác thành công!');
			}
		}

		public function approveOne2() {
			if ($this->input->post()) {
				$value = str_replace(".","",$this->input->post('value'));
				$id = $this->input->post('id');
				$tot = $this->input->post('tot');

				$data = array(
					'type_id' => $this->input->post('type_id'),
					'content' => $this->input->post('content'),
					'TOT' => $tot,
					'TOA' => $tot,
					'executor' => $this->input->post('executor'),
					'value' => $value,
					'owner' => $this->user->id,
					'method' => $this->input->post('method'),
					'provider' => $this->input->post('provider'),
					'approved' => 1
				);

				if (!$this->Voucher_model->update($id, $data)) {
					$this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
					redirect($this->routes['voucher_approve']);
				}

				$this->data['log_info']['row_id'] = $id;
				$this->data['log_info']['info'] = $data['content'] . ' : ' . $data['value'] . ' d';

				if ($this->input->post('auto') == 1) {
					$this->data['log_info']['info'] .= ' [AUTO phân bổ]';
					$this->load->model('DetailDimension_model');
					$this->data['all_dimen'] = $this->DetailDimension_model->get_list();

					$this->load->model('VoucherType_model');
					$type_info = $this->VoucherType_model->get_info($data['type_id']);

					if ($dimen_selected = $type_info->first_dimen != 0) {
						$data_acc = array(
							'voucher_id' => $id,
							'TOT' => $tot,
							'TOA' => $tot,
							'value' => $value,
							'debit_acc' => $type_info->debit_def,
							'credit_acc' => $type_info->credit_def
						);

						if (!$this->createAccountingAndDistribution($data_acc, $dimen_selected, false)) {
							$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra trong quá trình phân bổ!');
							redirect($this->routes['voucher_approve']);
						}
					} else {
						$this->session->set_flashdata('message_errors', 'Hãy cập nhật phân bổ mặc định cho loại chứng từ để dùng được tính năng tự động phân bổ!');
						redirect($this->routes['voucher_approve']);
					}


				}

				$this->Log_model->create($this->data['log_info']);

				die('Thao tác thành công!');
			}
		}

		public function denyOne() {
			if ($this->input->post()) {
				$id = $this->input->post('id');

				if (!$this->Voucher_model->update($id, array('deleted' => 1))) {
					$this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
					redirect($this->routes['voucher_approve']);
				}

				$info = $this->Voucher_model->get_info($id);
				$this->data['log_info']['row_id'] = $id;
				$this->data['log_info']['info'] = $info->content . ' : ' . $info->value . ' d [APPROVING]';
				$this->Log_model->create($this->data['log_info']);

				die('Thao tác thành công!');
			}
		}

		public function showInfo() {
			if ($this->input->post()) {
				$id = $this->input->post('id');

				$this->data['info'] = $this->Voucher_model->get_info($id);

				$this->load->model('User_model');
				$this->data['employees'] = $this->User_model->get_list();

				$this->load->model('VoucherType_model');
				$this->data['types'] = $this->VoucherType_model->get_list();

				$input = array(
					'where' => array(
						'voucher_id' => $id,
						'deleted' => 0
					)
				);
				$this->load->model('AccountingEntry_model');
				$this->data['act_list'] = $this->AccountingEntry_model->get_list($input);

				$this->load->model('Method_model');
				$this->data['methods'] = $this->Method_model->get_list();

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

		public function viewMore() {
			if ($this->input->post()) {
				$voucher_id = $this->input->post('id');

				$voucher = $this->Voucher_model->get_info($voucher_id);

				$voucher->{"completed"} = $this->checkCompletedAccountingEntry($voucher->id, $voucher->value);

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

				$this->load->model('Method_model');
				$this->data['methods'] = $this->Method_model->get_list();

				$this->load->model('Provider_model');
				$this->data['providers'] = $this->Provider_model->get_list();

				$list_act = $this->AccountingEntry_model->get_list($input);
				foreach ($list_act as $act) {
					$act->{"completed"} = $this->checkIssetDistribution($act->id);
				}

				$this->data['accounting_entries'] = $list_act;

				$this->load->view('voucher/more/voucher', $this->data);
				$this->load->view('voucher/more/act-entry', $this->data);

			}
		}

		public function getDefaultSys() {
			if ($this->input->post()) {
				$voucher_type = $this->input->post('voucher_type_id');
				$this->load->model('VoucherType_model');

				$type = $this->VoucherType_model->get_info($voucher_type);

				die(json_encode($type));
			}
		}

		public function distributionOneTime() {
			$input = array(
				'where' => array('approved' => 1, 'deleted' => 0)
			);
			$voucher_list = $this->Voucher_model->get_list($input);
			$this->load->model('VoucherType_model');
			$this->load->model('AccountingEntry_model');
			$this->load->model('Distribution_model');
			$this->load->model('DetailDimension_model');

			$this->data['all_dimen'] = $this->DetailDimension_model->get_list();

			foreach ($voucher_list as $voucher) {
				$input = array(
					'where' => array(
						'voucher_id' => $voucher->id
					)
				);

				$type = $this->VoucherType_model->get_info($voucher->type_id);

				if (count($acc_list = $this->AccountingEntry_model->get_list($input)) > 0) {
					$total_acc = 0;
					foreach ($acc_list as $acc) {
						$total_acc += $acc->value;
					}

					if ($total_acc < $voucher->value) {
						$add_value = $voucher->value - $total_acc;


						if ($type->income == 1) {
							// Add 1 accouting entry;
							$data = array(
								'voucher_id' => $voucher->id,
								'TOT' => $voucher->TOT,
								'TOA' => $voucher->TOT,
								'value' => $add_value,
								'debit_acc' => $type->debit_def,
								'credit_acc' => $type->credit_def,
								'content' => 'Tự động khớp bút toán'
							);
							if (!$this->AccountingEntry_model->create($data)) {
								$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra 1!');
								redirect($this->routes['voucher_create']);
							}
							$acc_id = $this->AccountingEntry_model->get_insert_id();

							$data = array(
								'entry_id' => $acc_id,
								'dimensional_id' => 210, // Doanh thu
								'TOT' => $voucher->TOT,
								'TOA' => $voucher->TOT,
								'value' => $add_value,
								'content' => 'Doanh thu (Tự động phân bổ)'
							);

							if (!$this->Distribution_model->create($data)) {
								$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra 2!');
								redirect($this->routes['voucher_create']);
							}
						} else {
							// Not income voucher
							$data_acc = array(
								'voucher_id' => $voucher->id,
								'TOT' => $voucher->TOT,
								'TOA' => $voucher->TOT,
								'value' => $add_value,
								'debit_acc' => $type->debit_def,
								'credit_acc' => $type->credit_def
							);

							if (!$this->createAccountingAndDistribution($data_acc, $type->first_dimen, false)) {
								$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra 3!');
								redirect($this->routes['voucher_create']);
							}
						}
					}
				} else {
					// new
					if ($type->income == 1) {
						// Add 1 accouting entry;
						$data = array(
							'voucher_id' => $voucher->id,
							'TOT' => $voucher->TOT,
							'TOA' => $voucher->TOT,
							'value' => $voucher->value,
							'debit_acc' => $type->debit_def,
							'credit_acc' => $type->credit_def,
							'content' => 'Tự động khớp bút toán'
						);

						if (!$this->AccountingEntry_model->create($data)) {
							$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra 4!');
							redirect($this->routes['voucher_create']);
						}
						$acc_id = $this->AccountingEntry_model->get_insert_id();

						$data = array(
							'entry_id' => $acc_id,
							'dimensional_id' => 210, // Doanh thu
							'TOT' => $voucher->TOT,
							'TOA' => $voucher->TOT,
							'value' => $voucher->value,
							'content' => 'Doanh thu (Tự động phân bổ)'
						);

						if (!$this->Distribution_model->create($data)) {
							$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra 5!');
							redirect($this->routes['voucher_create']);
						}

						$this->data['log_info']['row_id'] = $voucher->id;
   					$this->data['log_info']['info'] = $voucher->content . ' : ' . $voucher->value . ' d';
                  $this->Log_model->create($this->data['log_info']);


					} else {
						// Not income voucher
						$data_acc = array(
							'voucher_id' => $voucher->id,
							'TOT' => $voucher->TOT,
							'TOA' => $voucher->TOT,
							'value' => $voucher->value,
							'debit_acc' => $type->debit_def,
							'credit_acc' => $type->credit_def
						);

						if (!$this->createAccountingAndDistribution($data_acc, $type->first_dimen, false)) {
							$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra 6!');
							redirect($this->routes['voucher_create']);
						}

						$this->data['log_info']['row_id'] = $voucher->id;
   					$this->data['log_info']['info'] = $voucher->content . ' : ' . $voucher->value . ' d';
                  $this->Log_model->create($this->data['log_info']);
					}
				}
			}


			$this->session->set_flashdata('message_success', 'Thao tác thành công!');
			redirect($this->routes['voucher_create']);
		}

		public function delete() {
         if ($this->input->post()) {
            $id = $this->input->post('id');

            $response = array();

            if ($this->Voucher_model->update($id, array('deleted' => 1))) {
               $response['success'] = true;
               $response['message'] = "Đã xóa!";

					$info = $this->Voucher_model->get_info($id);
					$this->data['log_info']['row_id'] = $id;
					$this->data['log_info']['info'] = $info->content . ' : ' . $info->value . ' d';

					$this->Log_model->create($this->data['log_info']);
            } else {
               $response['success'] = false;
               $response['message'] = "Không thể xóa!";
            }

            die(json_encode($response));
         }
      }

		public function createByFiles() {
			if (!empty($_FILES)) {
				 $tempFile = $_FILES['files']['tmp_name'];
	          $fileName = $_FILES['files']['name'];
	          $okExtensions = array('xls', 'xlsx', 'csv');
	          $fileParts = explode('.', $fileName);
	          if (!in_array(strtolower(end($fileParts)), $okExtensions)) {
					 $this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
					 redirect($this->routes['voucher_create']);
	          }
	          $targetFile = FCPATH . 'public/upload/vouchers/' . date('Y-m-d-H-i-s') . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
	          if (!move_uploaded_file($tempFile, $targetFile)) {
					 $this->session->set_flashdata('message_errors', 'Thao tác thất bại :(');
					 redirect($this->routes['voucher_create']);
	          }

				 $this->fileToSystem($targetFile, $this->input->post('type'));
			}
		}

		private function fileToSystem($path, $type) {
			$this->load->library('PHPExcel');

			$objPHPExcel = PHPExcel_IOFactory::load($path);
	      $sheet = $objPHPExcel->getActiveSheet();
	      $data = $sheet->toArray();
	      $total = count($data);

			$input = array(
				'where' => array(
					'active' => 1
				)
			);

			$this->load->model('VoucherType_model');
			$this->load->model('Voucher_model');
			$all_types = $this->VoucherType_model->get_list($input);

			// Thu
			if ($type == '1') {
				for ($i=1; $i < $total; $i++) {

					$code = $this->GenerateCode('PCF');

					$info = array(
						'code' => $code . 'f' . $i,
						'code_real' => '',
						'type_id' => 23,
						'content' => $data[$i][2],
						'income' => 1,
						'TOT' => $data[$i][0],
						'TOA' => $data[$i][1],
						'executor' => 6,
						'value' => $data[$i][3],
						'owner' => $this->user->id,
						'note' => 'input from files',
						'method' => 0,
						'provider' => 0,
						'approved' => 0
					);

					if (!$this->Voucher_model->create($info)) {
						if ($i > 1) {
							$this->session->set_flashdata('message_errors', 'Đã thêm ' . ($i - 1) . ', có lỗi tại dòng ' . $i . ' :(');
							redirect($this->routes['voucher_create']);
						} else {
							$this->session->set_flashdata('message_errors', 'Có lỗi xảy ra, quá trình thất bại! :(');
							redirect($this->routes['voucher_create']);
						}
					}

					$this->data['log_info']['row_id'] = $this->Voucher_model->get_insert_id();
					$this->data['log_info']['info'] = $info['content'] . ' : ' . $info['value'] . ' d [FROM FILE]';
               $this->Log_model->create($this->data['log_info']);

				}

			} else { // Chi
				for ($i=1; $i < $total; $i++) {

					$code = $this->GenerateCode('PCF');

					$info = array(
						'code' => $code . 'f' . $i,
						'code_real' => '',
						'type_id' => 10,
						'content' => $data[$i][2],
						'income' => 0,
						'TOT' => $data[$i][0],
						'TOA' => $data[$i][1],
						'executor' => 6,
						'value' => $data[$i][3],
						'owner' => $this->user->id,
						'note' => 'input from files',
						'method' => 0,
						'provider' => 0,
						'approved' => 0
					);

					if (!$this->Voucher_model->create($info)) {
						if ($i > 1) {
							$this->session->set_flashdata('message_errors', 'Đã thêm ' . ($i - 1) . ', có lỗi tại dòng ' . $i . ' :(');
							redirect($this->routes['voucher_create']);
						} else {
							$this->session->set_flashdata('message_errors', 'Có lỗi xảy ra, quá trình thất bại! :(');
							redirect($this->routes['voucher_create']);
						}
					}

					$this->data['log_info']['row_id'] = $this->Voucher_model->get_insert_id();
					$this->data['log_info']['info'] = $info['content'] . ' : ' . $info['value'] . ' d [FROM FILE]';
               $this->Log_model->create($this->data['log_info']);

				}


			}


			$this->session->set_flashdata('message_success', 'Thêm thành công ' . ($total - 1) . ' chứng từ mới!');
			redirect($this->routes['voucher_create']);

		}

		private function checkInput() {
			$value_str = $this->input->post('value');
			$value_total = str_replace(".","",$value_str);

			if (!is_numeric($value_total)) {
				return false;
			}

			if ($this->input->post('auto_distribution') != 0) {
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
							$this->form_validation->set_rules('course_' . $i, 'Course', 'required|greater_than[0]');
						}
					}

					if ($total != $value_total) {
						return false;
					}
				}
			}

			$this->form_validation->set_rules('voucher_type', 'Voucher type', 'required|greater_than[0]');
			$this->form_validation->set_rules('tot', 'TOT', 'required');
			$this->form_validation->set_rules('method', 'Method', 'required');
			$this->form_validation->set_rules('provider', 'Provider', 'required');
			$this->form_validation->set_rules('executor', 'Executor', 'required|greater_than[0]');

			return $this->form_validation->run();
		}

		private function GenerateCode($receipt_code) {
			$date = new DateTime();
			$string = $date->getTimestamp();
			return $receipt_code . $string;
		}

		private function checkCompletedAccountingEntry($id_voucher, $value_voucher) {
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

		private function createAccountingAndDistribution($info_acc, $detail_dimen_id, $is_revenue = false, $text_add = '') {
			$parent_id = NULL;
			foreach ($this->data['all_dimen'] as $dimen) {
				if ($dimen->id == $detail_dimen_id) {
					$info_acc['content'] = $dimen->name . $text_add;
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
					'content' => $content_dis . $text_add
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
