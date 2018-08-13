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

      public function show_info() {
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

      public function load_form() {
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

      // Require by ajax, return result and voucher id to client site
      public function get_voucher() {
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
