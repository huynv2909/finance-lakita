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

         $this->load->model('Voucher_model');
         $input = array(
            'order' => array('date', 'desc')
         );
         $this->data['vouchers'] = $this->Voucher_model->get_list($input);

         $this->load->view('layout', $this->data);
      }

      public function show_info() {
         if ($this->input->post()) {
            $id = $this->input->post('id');
            $this->data['info'] = $this->AccountingEntry_model->get_info($id);

            $this->load->model('Distribution_model');
            $input = array(
               'where' => array(
                  'entry_id' => $id
               )
            );
            $this->data['distribute_list'] = $this->Distribution_model->get_list($input);

            $input = array(
               'where' => array(
                  'active' => 1
               ),
               'order' => array('code', 'desc')
            );
            $this->load->model('DetailDimension_model');

            $response = array(
               'act' => $this->load->view('load_by_ajax/act_box', $this->data, true),
               'distributes' => $this->data['distribute_list'],
               'tot' => $this->data['info']->TOT,
               'toa' => $this->data['info']->TOA,
               'dimensionals' => $this->DetailDimension_model->get_list($input)
            );

            die(json_encode($response));
         }

      }

      public function load_form() {
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
               'type' => 'input',
               'properties' => array(
                  'id' => 'debit_acc',
                  'type' => 'number',
                  'style' => 'width:100%;'
               ),
               'options' => ''
            ),
            array(
               'type' => 'input',
               'properties' => array(
                  'id' => 'credit_acc',
                  'type' => 'number',
                  'style' => 'width:100%;'
               ),
               'options' => ''
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
   }

 ?>
