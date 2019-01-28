<?php
   /**
    *
    */
   class AccountingEntry extends MY_Controller
   {
      public function __construct() {
         parent::__construct();
         $this->load->model('AccountingEntry_model');
      }

      function index()
      {
         $this->data['title'] = "Bút toán";
			$this->data['template'] = 'accounting/index';
			$this->data['active'] = 'receipt';
         $this->data['js_files'] = array('accountingentry_index');

         $this->load->model('Voucher_model');
         $this->data['limit_loading'] = json_decode($this->data['configs'])->NUMBER_LOADING;

         $input = array(
            'select' => array($this->AccountingEntry_model->table . '.*', $this->Voucher_model->table . '.code'),
            'join' => array($this->Voucher_model->table => $this->Voucher_model->table . '.id = ' . $this->AccountingEntry_model->table . '.voucher_id'),
            'order' => 'TOA desc',
            'limit' => array($this->data['limit_loading'], 0)
         );

         if ($this->input->get('code')) {
            $input['where'] = array($this->Voucher_model->table . '.code' => $this->input->get('code'));
         }

         $this->data['entries'] = $this->AccountingEntry_model->get_list($input);

         $this->load->view('layout', $this->data);
      }

      public function edit() {
         if ($this->input->post()) {
            $this->load->model('AccountingEntry_model');
            $this->load->model('Voucher_model');

            $this->load->model('User_model');
				$this->data['employees'] = $this->User_model->get_list();

            $this->load->model('Method_model');
				$this->data['methods'] = $this->Method_model->get_list();

            $this->load->model('VoucherType_model');
				$this->data['types'] = $this->VoucherType_model->get_list();

            $this->load->model('AccountingSystem');
            $this->data['act_system'] = $this->AccountingSystem->get_list();

            $id_acc = $this->input->post('id');

            $this->data['act_detail'] = $this->AccountingEntry_model->get_info($id_acc);

            $id_vou = $this->data['act_detail']->voucher_id;

            $this->data['info'] = $this->Voucher_model->get_info($id_vou);

            $input = array(
               'select' => 'SUM(value) AS sum_old',
               'where' => array(
                  'voucher_id' => $id_vou,
                  'id !=' => $id_acc
               )
            );
            $query = $this->AccountingEntry_model->get_list($input);

            $sum_old = $query[0]->sum_old;
            $total_val = $this->data['info']->value;

            $remaining_val = $total_val - $sum_old;

            $responses = array(
               'voucher_detail' => $this->load->view('load_by_ajax/voucher_box', $this->data, true),
               'form' => $this->load->view('accounting/edit', $this->data, true),
               'remaining' => $remaining_val
            );

            die(json_encode($responses));
         }
      }

      public function editSubmit() {
         if ($this->input->post()) {
            $id = $this->input->post('id');

            $data_update = array(
               'TOA' => $this->input->post('toa'),
               'value' => str_replace(".","",$this->input->post('value')),
               'debit_acc' => $this->input->post('debit_acc'),
               'credit_acc' => $this->input->post('credit_acc'),
               'content' => $this->input->post('content')
            );
            $this->load->model('AccountingEntry_model');

            if ($this->AccountingEntry_model->update($id, $data_update)) {
               $update_dis = array(
                  'TOA' => $this->input->post('toa')
               );
               $this->load->model('Distribution_model');

               if ($this->Distribution_model->update_rule(array('entry_id' => $id), $update_dis)) {
                  $this->session->set_flashdata('message_success', 'Cập nhật dữ liệu thành công!');
		             redirect($this->routes['accountingentry_index']);
               } else {
                  $this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra 2!');
                  redirect($this->routes['accountingentry_index']);
               }
            } else {
               $this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
               redirect($this->routes['accountingentry_index']);
            }
         }
      }

      public function create() {
         $this->data['title'] = "Nhập bút toán";
			$this->data['template'] = 'accounting/create';
			$this->data['active'] = 'receipt';
         $this->data['js_files'] = array('accounting-entry_create');

         if ($this->input->get('voucher_id')) {
				$this->data['set_voucher'] = $this->input->get('voucher_id');
			}

         // When ajax request to create to database
         if ($this->input->post()) {
            $data = array(
               'voucher_id' => $this->input->post('voucher_id'),
               'TOT' => $this->input->post('TOT'),
               'TOA' => $this->input->post('TOA'),
               'value' => $this->input->post('value'),
               'debit_acc' => $this->input->post('debit_acc'),
               'credit_acc' => $this->input->post('credit_acc'),
               'content' => $this->input->post('content')
            );
            $data['value'] = str_replace(".","",$data['value']);

   			if (!is_numeric($data['value']) || !is_numeric($data['voucher_id']) || !trim($data['TOA']) || !trim($data['TOT']) || !is_numeric($data['debit_acc']) || !is_numeric($data['debit_acc'])) {
               $response = array(
                  'success' => false,
                  'message' => 'Thao tác thất bại, hãy nhập đầy đủ thông tin!'
               );
   			} else {
               if ($this->AccountingEntry_model->create($data)) {
                  $response = array(
                     'success' => true,
                     'message' => 'Cập nhật thành công!'
                  );
               } else {
                  $response = array(
                     'success' => false,
                     'message' => 'Có lỗi xảy ra!'
                  );
               }
            }

            die(json_encode($response));
         }

         $this->data['vouchers'] = $this->getUncompletedVoucher();

         $this->load->view('layout', $this->data);
      }

      public function showInfo() {
         if ($this->input->post()) {
            $id = $this->input->post('id');
            $this->data['info'] = $this->AccountingEntry_model->get_info($id);

            // Get distributed
            $this->load->model('Distribution_model');
            $input = array(
               'where' => array(
                  'entry_id' => $id
               )
            );
            $this->data['distribute_list'] = $this->Distribution_model->get_list($input);

            // Get Dimension manager list
            $this->load->model('Dimension_model');
            $list_mng = $this->Dimension_model->get_list();

            // Get detail
            $this->load->model('DetailDimension_model');
            $input = array(
               'where' => array(
                  'active' => 1
               )
            );
            $list_dimension = $this->DetailDimension_model->get_list($input);

            foreach ($this->data['distribute_list'] as $item ) {
               foreach ($list_dimension as $dimen) {
                  if ($item->dimensional_id == $dimen->id) {
                     $item->dimensional_id = $dimen->name;
                     if ($dimen->note != '') {
                        $item->dimensional_id .= " : " . $dimen->note;
                     }
                     foreach ($list_mng as $mng) {
                        if ($mng->id == $dimen->dimen_id) {
                           $item->{"mng"} = $mng->name;
                           break;
                        }
                     }
                     break;
                  }
               }
            }

            $input = array(
               'where' => array(
                  'active' => 1
               ),
               'order' => 'dimen_code desc'
            );
            $this->load->model('DetailDimension_model');
            $list_details = $this->DetailDimension_model->get_list($input);

            $response = array(
               'act' => $this->load->view('load_by_ajax/act_box', $this->data, true),
               'distributes' => $this->data['distribute_list'],
               'tot' => $this->data['info']->TOT,
               'toa' => $this->data['info']->TOA,
               'mngs' => $list_mng,
               'dimensionals' => $list_details
            );

            die(json_encode($response));
         }

      }

      public function delete() {
         if ($this->input->post()) {
            $id = $this->input->post('id');

            $response = array();

            if ($this->AccountingEntry_model->delete($id)) {
               $response['success'] = true;
               $response['message'] = "Đã xóa!";
            } else {
               $response['success'] = false;
               $response['message'] = "Không thể xóa!";
            }

            die(json_encode($response));
         }
      }

      public function loadForm() {
         $voucher_id = $this->input->get('voucher_id');
         $this->load->model('Voucher_model');
         $type_id = $this->Voucher_model->get_info($voucher_id)->type_id;
         $this->load->model('VoucherType_model');
         $type_info = $this->VoucherType_model->get_info($type_id);
         $debit_def = $type_info->debit_def;
         $credit_def = $type_info->credit_def;

         $this->load->model('AccountingSystem');

         $list_account = $this->AccountingSystem->get_list();

         $options_deb = array(
            array(
               'innerHTML' => '(Lựa chọn tài khoản)',
               'value' => 0,
               'class' => 'hidden'
            )
         );

         foreach ($list_account as $item) {
            $temp = array(
               'innerHTML' => $item->number . " : " . $item->description,
               'value' => $item->number
            );
            if ($item->number == $debit_def) {
               $temp['selected'] = "true";
            }

            array_push($options_deb, $temp);
         }

         $options_cre = array(
            array(
               'innerHTML' => '(Lựa chọn tài khoản)',
               'value' => 0,
               'class' => 'hidden'
            )
         );

         foreach ($list_account as $item) {
            $temp = array(
               'innerHTML' => $item->number . " : " . $item->description,
               'value' => $item->number
            );
            if ($item->number == $credit_def) {
               $temp['selected'] = "true";
            }

            array_push($options_cre, $temp);
         }

         $form = array(
            array(
               'type' => 'input',
               'properties' => array(
                  'id' => 'TOA',
                  'type' => 'date',
                  'style' => 'width:100%; line-height: normal;'
               ),
               'options' => ''
            ),
            array(
               'type' => 'textarea',
               'properties' => array(
                  'id' => 'content',
                  'rows' => '2',
                  'style' => 'width:100%;'
               ),
               'options' => ''
            ),
            array(
               'type' => 'input',
               'properties' => array(
                  'id' => 'value',
                  'onkeyup' => 'oneDot(this)',
                  'type' => 'text',
                  'style' => 'width:100%;'
               ),
               'options' => ''
            ),
            array(
               'type' => 'select',
               'properties' => array(
                  'id' => 'debit_acc',
                  'style' => 'width:100%; height: 26px;'
               ),
               'options' => $options_deb
            ),
            array(
               'type' => 'select',
               'properties' => array(
                  'id' => 'credit_acc',
                  'style' => 'width:100%; height: 26px;'
               ),
               'options' => $options_cre
            )
         );

         $response = array();
   		foreach ($form as $item) {
   			$this->data['properties'] = $item['properties'];
   			$this->data['options'] = $item['options'];

   			array_push($response, $this->load->view('form/' . $item['type'], $this->data, true));
   		}
   		die(json_encode($response));
      }

      // view distributed
      public function viewMore() {
         if ($this->input->post('id')) {
            $id = $this->input->post('id');

            $this->data['entry_info'] = $this->AccountingEntry_model->get_info($id);

            $this->load->model('Dimension_model');
            $this->load->model('DetailDimension_model');
            $this->load->model('Distribution_model');
            $dimensions = $this->Dimension_model->get_list();

            $input = array(
               'select' => array($this->Distribution_model->table . '.*', $this->DetailDimension_model->table . '.dimen_id', $this->DetailDimension_model->table . '.dimen_code', $this->DetailDimension_model->table . '.name'),
               'join' => array($this->DetailDimension_model->table => $this->DetailDimension_model->table . '.id = ' . $this->Distribution_model->table . '.dimensional_id'),
               'where' => array('entry_id' => $id)
            );

            $distributions = $this->Distribution_model->get_list($input);

            $group_dis = array();
            foreach ($distributions as $record) {
               $temp = array(
                  'detail_id' => $record->dimensional_id,
                  'detail' => $record->name,
                  'value' => $record->value
               );
               if (array_key_exists($record->dimen_code, $group_dis)) {
                  array_push($group_dis[$record->dimen_code], $temp);
               } else {
                  $group_dis[$record->dimen_code] = array($temp);
               }
            }
            $this->data['group_dis'] = $group_dis;
            $this->load->view('accounting/view_more', $this->data);
         }
      }

      // Require by ajax, return result and voucher id to client site
      public function getVoucher() {
         if ($this->input->post()) {
            $id = $this->input->post('id');

            $response = array();

            if ($info = $this->AccountingEntry_model->get_info($id)) {
               $response['success'] = true;
               $response['voucher_id'] = $info->voucher_id;
            } else {
               $response['success'] = false;
            }

            die(json_encode($response));
         }
      }

      // return list voucher uncomplete: no accounting entry OR Total accounting entry value not equal voucher value
      private function getUncompletedVoucher() {
         $this->load->model('Voucher_model');
         $input = array(
            'where' => array('approved' => 1),
            'order' => 'date desc'
         );

         $all_vouchers = $this->Voucher_model->get_list($input);

         $return_list = array();
         foreach ($all_vouchers as $voucher) {
            $input = array(
               'where' => array(
                  'voucher_id' => $voucher->id
               )
            );
            $list_act = $this->AccountingEntry_model->get_list($input);

            if (count($list_act) > 0) {
               $total_act = 0;
               foreach ($list_act as $act) {
                  $total_act += $act->value;
               }
               if ($total_act < $voucher->value) {
                  array_push($return_list, $voucher);
               }
            } else {
               array_push($return_list, $voucher);
            }
         }

         return $return_list;
      }

   }

 ?>
