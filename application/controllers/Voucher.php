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

					if ($this->input->post('auto_distribution') != 0) {
						$this->data['all_dimen'] = $this->DetailDimension_model->get_list();

						if ($this->input->post('income') == 1) {
							$total_row_sub = $this->input->post('count_sub');
							// If have tax
							$weight_tax = 0;

							if ($this->input->post('vat_check')) {
								$weight_tax = $this->input->post('tax_value') / 100;
							}

							for ($i=1; $i <= $total_row_sub; $i++) {
								$used = $this->input->post('confirm_' . $i);
								if ($used == 1) {
									$value_entered = str_replace(".","",$this->input->post('value_' . $i));
									$value_tax = $value_entered*$weight_tax;
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
									if (!$this->createAccountingAndDistribution($data_acc, $course_dis, true)) {
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
										// 316: Chi phí phi nhân sự Sale
										if (!$this->createAccountingAndDistribution($data_acc, 316, false, ' (VAT) ')) {
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
					redirect($this->routes['voucher_create']);
				}
				else {
					$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra khi nhập dữ liệu!');
					redirect($this->routes['voucher_create']);
				}
			}

			$filter = array();

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

				if ($this->input->get('income') == '0' || $this->input->get('income') == '1') {
					$filter['where']['income'] = $this->input->get('income');
				}

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

			// Payment Method
			$this->load->model('Method_model');
			$this->data['methods']= $this->Method_model->get_list();

			// Provider
			$this->load->model('Provider_model');
			$this->data['providers']= $this->Provider_model->get_list();

			$this->data['latest_voucher_id'] = $this->session->flashdata('latest_id');

			$this->load->view('layout', $this->data);
		}

		public function showInfo() {
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

		public function viewMore() {
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
			$voucher_list = $this->Voucher_model->get_list();
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

            if ($this->Voucher_model->delete($id)) {
               $response['success'] = true;
               $response['message'] = "Đã xóa!";
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

				 $this->fileToSystem($targetFile);
			}
		}

		private function fileToSystem($path) {
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

			for ($i=1; $i < $total; $i++) {

				$code = 'NONE';
				foreach ($all_types as $type) {
					if ($type->id == $data[$i][1]) {
						$code = $this->GenerateCode($type->code);
						break;
					}
				}

				$info = array(
					'code' => $code,
					'code_real' => $data[$i][0],
					'type_id' => $data[$i][1],
					'content' => $data[$i][2],
					'income' => $data[$i][3],
					'TOT' => $data[$i][4],
					'TOA' => $data[$i][5],
					'executor' => $data[$i][6],
					'value' => $data[$i][7],
					'owner' => $this->user->id,
					'note' => $data[$i][8],
					'method' => $data[$i][9],
					'provider' => $data[$i][10]
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
