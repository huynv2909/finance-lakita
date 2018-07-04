<?php
   /**
    * Distribution
    */
   class Distribution extends MY_Controller
   {
      function __construct()
      {
         parent::__construct();
         $this->load->model('Distribution_model');
      }

      public function create() {
         $this->data['title'] = "Phân bổ bút toán";
			$this->data['template'] = 'distribution/create';
			$this->data['active'] = 'voucher';

         if ($this->input->post()) {
            $data = array(
               'entry_id' => $this->input->post('entry_id'),
               'dimensional_id' => $this->input->post('dimen_id'),
               'TOT' => $this->input->post('TOT'),
               'TOA' => $this->input->post('TOA'),
               'value' => $this->input->post('value'),
               'content' => $this->input->post('content')
            );
            $data['value'] = str_replace(".","",$data['value']);

   			if (!is_numeric($data['value']) || !is_numeric($data['entry_id']) || !is_numeric($data['dimensional_id']) || !trim($data['TOA']) || !trim($data['TOT']) ) {
               $response = array(
                  'success' => false,
                  'message' => 'Thao tác thất bại, hãy nhập đầy đủ thông tin!'
               );
   			} else {
               if ($this->Distribution_model->create($data)) {
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

      public function load_form() {
         $this->load->model('DetailDimension_model');
         $input = array(
            'where' => array(
               'active' => 1
            ),
            'order' => array('code', 'asc')
         );
         $listDimen = $this->DetailDimension_model->get_list($input);

         $options = array(
            array(
               'innerHTML' => '(Lựa chọn chiều quản trị)',
               'value' => '0'
            )
         );

         foreach ($listDimen as $item) {
            $temp = array(
               'innerHTML' => $item->code . " : " . $item->name,
               'value' => $item->id
            );
            array_push($options, $temp);
         }

         $form = array(
            array(
               'type' => 'select',
               'properties' => array(
                  'id' => 'dimension',
                  'style' => 'width:100%; min-height: 28px; background-color: #fff;'
               ),
               'options' => $options
            ),
            array(
               'type' => 'input',
               'properties' => array(
                  'id' => 'value',
                  'onkeyup' => 'oneDot(this)',
                  'type' => 'text',
                  'style' => 'width:100%;',
                  'placeholder' => 'Số tiền'
               ),
               'options' => ''
            ),
            array(
               'type' => 'textarea',
               'properties' => array(
                  'id' => 'content',
                  'rows' => '2',
                  'style' => 'width:100%;',
                  'placeholder' => 'Nội dung'
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
