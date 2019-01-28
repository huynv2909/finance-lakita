<?php
	/**
	 * Report
	 */
	class Report extends MY_Controller
	{
      var $trace_temp = array();

		public function __construct() {
         parent::__construct();
         $this->load->model('Distribution_model');
			$this->load->model('DetailDimension_model');
      }

		public function financeActivity()
		{
			$this->data['title'] = "BÁO CÁO HOẠT ĐỘNG TÀI CHÍNH";
         $this->data['active'] = "Report";
         $this->data['template'] = "report/activity.php";
         $this->data['js_files'] = array('report_activity');

         // default dimension
         $dimension_id = array(200,210,220); // HD1,HD2,HD3

         $input = array(
            'where' => array('active' => 1),
            'where_in' => array('dimen_id', $dimension_id),
            'order' => 'layer asc'
         );

         $detail_objects = $this->DetailDimension_model->get_list($input);

         $list_detail = array();
         $trace_temp = array(); // temporory array to sort $list_detail
         $this->sort($list_detail, $detail_objects, $trace_temp);


			$distribution = NULL;

			if ($this->input->get('from') && validateDate($this->input->get('from'))) {
				$min_date = $this->input->get('from');

				$distribution = $this->Distribution_model->get_list();
			} else {
				// Default get all
				$input = array(
					'order' => 'TOA asc'
				);
				// default date
				$distribution = $this->Distribution_model->get_list($input);
				$toa_min_date = date("Y-m-d");
				if (count($distribution) > 0) {
					$toa_min_date = reset($distribution)->TOA;
				}

				$input = array(
					'order' => 'TOT asc'
				);
				$distribution = $this->Distribution_model->get_list($input);
				$tot_min_date = date("Y-m-d");
				if (count($distribution) > 0) {
					$tot_min_date = reset($distribution)->TOT;
				}
				// Merge time
				$min_date = ($toa_min_date < $tot_min_date)?$toa_min_date:$tot_min_date;
			}

			if ($this->input->get('to') && validateDate($this->input->get('to'))) {
				$max_date = $this->input->get('to');
			} else {
				$max_date = date("Y-m-d");
			}

			$this->data['from'] = $min_date;
			$this->data['to'] = $max_date;

			$by = 2;
			if ($this->input->get('by') && in_array($this->input->get('by'), array('1','2','3'))) {
				$by = $this->input->get('by');
			}
			// default: month = 2
			$date_range = array_reverse(split_date($min_date, $max_date, $by), true);
			$this->data['date_range'] = $date_range;

			$data_compilation = array();
			$list_layer = array();
			$index_mark = array(
				'A100' => 0, // Doanh thu
				'B110' => 0, // Chi phi ban hang
				'B120' => 0, // Chi phi van hanh
				'B130' => 0, // Chi phi quan ly
				'D100' => 0  // Chi phi dau tu
			);
			// $list_detail is list detail dimension
			foreach ($list_detail as $detail) {
				$array_dimen = array(
					'id' => $detail->id,
					'name' => $detail->name,
					'layer' => $detail->layer,
					'data' => array(),
					'total_tot' => 0,
					'total_toa' => 0
				);

				foreach ($date_range as $point => $range) {
					$condition = array(
						'select' => array('SUM(value) AS total'),
						'where' => array(
							'dimensional_id' => $detail->id,
							'TOA  >=' => $range['from'],
							'TOA  <=' => $range['to']
						)
					);
					$range['toa_value'] = $this->Distribution_model->get_list($condition)[0]->total;
					$array_dimen['total_toa'] += $range['toa_value'];

					$condition = array(
						'select' => array('SUM(value) AS total'),
						'where' => array(
							'dimensional_id' => $detail->id,
							'TOT  >=' => $range['from'],
							'TOT  <=' => $range['to']
						)
					);
					$range['tot_value'] = $this->Distribution_model->get_list($condition)[0]->total;
					$array_dimen['total_tot'] += $range['tot_value'];

					$array_dimen['data'][$point] = $range;
				}
				array_push($data_compilation, $array_dimen);

				// Mark revenue
				if ($detail->id == '210') {
					$index_mark['A100'] = count($data_compilation) - 1;
				}

				// Mark sale
				if ($detail->id == '310') {
					$index_mark['B110'] = count($data_compilation) - 1;
				}

				// Mark operation
				if ($detail->id == '320') {
					$index_mark['B120'] = count($data_compilation) - 1;
				}

				// Mark management
				if ($detail->id == '330') {
					$index_mark['B130'] = count($data_compilation) - 1;
				}

				// Mark investment
				if ($detail->id == '340') {
					$index_mark['D100'] = count($data_compilation) - 1;
				}

				// Mark tax
				if ($detail->id == '350') {
					$index_mark['C100'] = count($data_compilation) - 1;
				}

				// process list array
				if (!in_array($detail->layer, $list_layer)) {
					array_push($list_layer, $detail->layer);
				}
			}

			$this->data['number_layer'] = count($list_layer);

			$PL1A = array(
				'id' => 'PL1A',
				'name' => 'Lợi nhuận sau bán hàng (PL1A)',
				'layer' => 1,
				'data' => array(),
				'total_tot' => 0,
				'total_toa' => 0
			);
			$PL1B = array(
				'id' => 'PL1B',
				'name' => 'Lợi nhuận sau vận hành (PL1B)',
				'layer' => 1,
				'data' => array(),
				'total_tot' => 0,
				'total_toa' => 0
			);
			$PL2 = array(
				'id' => 'PL2',
				'name' => 'Lợi nhuận sau bán hàng và vận hành (PL2)',
				'layer' => 1,
				'data' => array(),
				'total_tot' => 0,
				'total_toa' => 0
			);
			$PL6 = array(
				'id' => 'PL6',
				'name' => 'Lợi nhuận sau thuế (PL6)',
				'layer' => 1,
				'data' => array(),
				'total_tot' => 0,
				'total_toa' => 0
			);
			$PL7 = array(
				'id' => 'PL7',
				'name' => 'Cash flow (PL7)',
				'layer' => 1,
				'data' => array(),
				'total_tot' => 0,
				'total_toa' => 0
			);
			foreach ($date_range as $point => $range) {
				if ($data_compilation[$index_mark['A100']]['data'][$point]['toa_value']) {
					$A100a = $data_compilation[$index_mark['A100']]['data'][$point]['toa_value'];
				} else {
					$A100a = 0;
				}

				if ($data_compilation[$index_mark['A100']]['data'][$point]['tot_value']) {
					$A100t = $data_compilation[$index_mark['A100']]['data'][$point]['tot_value'];
				} else {
					$A100t = 0;
				}

				if ($data_compilation[$index_mark['B110']]['data'][$point]['toa_value']) {
					$B110a = $data_compilation[$index_mark['B110']]['data'][$point]['toa_value'];
				} else {
					$B110a = 0;
				}

				if ($data_compilation[$index_mark['B110']]['data'][$point]['tot_value']) {
					$B110t = $data_compilation[$index_mark['B110']]['data'][$point]['tot_value'];
				} else {
					$B110t = 0;
				}

				if ($data_compilation[$index_mark['B120']]['data'][$point]['toa_value']) {
					$B120a = $data_compilation[$index_mark['B120']]['data'][$point]['toa_value'];
				} else {
					$B120a = 0;
				}

				if ($data_compilation[$index_mark['B120']]['data'][$point]['tot_value']) {
					$B120t = $data_compilation[$index_mark['B120']]['data'][$point]['tot_value'];
				} else {
					$B120t = 0;
				}

				if ($data_compilation[$index_mark['B130']]['data'][$point]['toa_value']) {
					$B130a = $data_compilation[$index_mark['B130']]['data'][$point]['toa_value'];
				} else {
					$B130a = 0;
				}

				if ($data_compilation[$index_mark['B130']]['data'][$point]['tot_value']) {
					$B130t = $data_compilation[$index_mark['B130']]['data'][$point]['tot_value'];
				} else {
					$B130t = 0;
				}

				if ($data_compilation[$index_mark['C100']]['data'][$point]['toa_value']) {
					$C100a = $data_compilation[$index_mark['C100']]['data'][$point]['toa_value'];
				} else {
					$C100a = 0;
				}

				if ($data_compilation[$index_mark['C100']]['data'][$point]['tot_value']) {
					$C100t = $data_compilation[$index_mark['C100']]['data'][$point]['tot_value'];
				} else {
					$C100t = 0;
				}

				if ($data_compilation[$index_mark['D100']]['data'][$point]['toa_value']) {
					$D100a = $data_compilation[$index_mark['D100']]['data'][$point]['toa_value'];
				} else {
					$D100a = 0;
				}

				if ($data_compilation[$index_mark['D100']]['data'][$point]['tot_value']) {
					$D100t = $data_compilation[$index_mark['D100']]['data'][$point]['tot_value'];
				} else {
					$D100t = 0;
				}

				// PL1A
				$range['toa_value'] = $A100a - $B110a;
				$PL1A['total_toa'] += $range['toa_value'];

				$range['tot_value'] = $A100t - $B110t;
				$PL1A['total_tot'] += $range['tot_value'];

				$PL1A['data'][$point] = $range;

				// PL1B
				$range['toa_value'] = $A100a - $B120a;
				$PL1B['total_toa'] += $range['toa_value'];

				$range['tot_value'] = $A100t - $B120t;
				$PL1B['total_tot'] += $range['tot_value'];

				$PL1B['data'][$point] = $range;

				// PL2
				$range['toa_value'] = $A100a - $B110a - $B120a;
				$PL2['total_toa'] += $range['toa_value'];

				$range['tot_value'] = $A100t - $B110t - $B120t;
				$PL2['total_tot'] += $range['tot_value'];

				$PL2['data'][$point] = $range;

				// PL6
				$range['toa_value'] = $A100a - $C100a;
				$PL6['total_toa'] += $range['toa_value'];

				$range['tot_value'] = $A100t - $C100t;
				$PL6['total_tot'] += $range['tot_value'];

				$PL6['data'][$point] = $range;

				// PL7
				$range['toa_value'] = $A100a - $B110a - $B120a - $B130a - $C100a - $D100a;
				$PL7['total_toa'] += $range['toa_value'];

				$range['tot_value'] = $A100t - $B110t - $B120t - $B130t - $C100t - $D100t;
				$PL7['total_tot'] += $range['tot_value'];

				$PL7['data'][$point] = $range;
			}
			$data_compilation[] = $PL1A;
			$data_compilation[] = $PL1B;
			$data_compilation[] = $PL2;
			$data_compilation[] = $PL6;
			$data_compilation[] = $PL7;

			$this->data['data_compilation'] = $data_compilation;
			// pre($data_compilation);
			$this->load->view('layout', $this->data);
		}

		public function coursesReport() {
			$this->data['title'] = "BÁO CÁO DOANH THU KHÓA HỌC";
         $this->data['active'] = "Report";
         $this->data['template'] = "report/courses";
         $this->data['js_files'] = array('report_activity');

			// default dimension
         $dimension_id = array(100,110,120); // NSP1, NSP2, SP

         $input = array(
            'where' => array('active' => 1),
            'where_in' => array('dimen_id', $dimension_id),
				'or_where_in' => array('id', array(1515,1516)),
            'order' => 'layer asc'
         );

         $detail_objects = $this->DetailDimension_model->get_list($input);
			//pre($this->db->last_query());

         $list_detail = array();
         $trace_temp = array(); // temporory array to sort $list_detail
         $this->sort($list_detail, $detail_objects, $trace_temp);

			$distribution = NULL;

			if ($this->input->get('from') && validateDate($this->input->get('from'))) {
				$min_date = $this->input->get('from');

				$distribution = $this->Distribution_model->get_list();
			} else {
				// Default get all
				$input = array(
					'order' => 'TOA asc'
				);
				// default date
				$distribution = $this->Distribution_model->get_list($input);
				$toa_min_date = date("Y-m-d");
				if (count($distribution) > 0) {
					$toa_min_date = reset($distribution)->TOA;
				}

				$input = array(
					'order' => 'TOT asc'
				);
				$distribution = $this->Distribution_model->get_list($input);
				$tot_min_date = date("Y-m-d");
				if (count($distribution) > 0) {
					$tot_min_date = reset($distribution)->TOT;
				}
				// Merge time
				$min_date = ($toa_min_date < $tot_min_date)?$toa_min_date:$tot_min_date;
			}

			if ($this->input->get('to') && validateDate($this->input->get('to'))) {
				$max_date = $this->input->get('to');
			} else {
				$max_date = date("Y-m-d");
			}

			$this->data['from'] = $min_date;
			$this->data['to'] = $max_date;

			$by = 2;
			if ($this->input->get('by') && in_array($this->input->get('by'), array('1','2','3'))) {
				$by = $this->input->get('by');
			}
			// default: month = 2
			$date_range = array_reverse(split_date($min_date, $max_date, $by), true);
			$this->data['date_range'] = $date_range;

			$data_compilation = array();
			$list_layer = array();

			// $list_detail is list detail dimension
			foreach ($list_detail as $detail) {
				$array_dimen = array(
					'id' => $detail->id,
					'name' => $detail->name,
					'layer' => $detail->layer,
					'data' => array(),
					'total_tot' => 0,
					'total_toa' => 0
				);

				foreach ($date_range as $point => $range) {
					$condition = array(
						'select' => array('SUM(value) AS total'),
						'where' => array(
							'dimensional_id' => $detail->id,
							'TOA  >=' => $range['from'],
							'TOA  <=' => $range['to']
						)
					);
					$range['toa_value'] = $this->Distribution_model->get_list($condition)[0]->total;
					$array_dimen['total_toa'] += $range['toa_value'];

					$condition = array(
						'select' => array('SUM(value) AS total'),
						'where' => array(
							'dimensional_id' => $detail->id,
							'TOT  >=' => $range['from'],
							'TOT  <=' => $range['to']
						)
					);
					$range['tot_value'] = $this->Distribution_model->get_list($condition)[0]->total;
					$array_dimen['total_tot'] += $range['tot_value'];

					$array_dimen['data'][$point] = $range;
				}
				array_push($data_compilation, $array_dimen);

				// process list array
				if (!in_array($detail->layer, $list_layer)) {
					array_push($list_layer, $detail->layer);
				}
			}


			$this->data['number_layer'] = count($list_layer);
			$this->data['data_compilation'] = $data_compilation;

			$this->load->view('layout', $this->data);
		}

		public function viewData() {
			if ($this->input->post()) {
				$type = $this->input->post('type');
				$from = $this->input->post('from');
				$to = $this->input->post('to');
				$id = $this->input->post('id');

				$this->load->model('Voucher_model');
				$this->load->model('AccountingEntry_model');
				$this->load->model('Distribution_model');

				$input = array(
					'select' => array(
						$this->Voucher_model->table . '.code AS code',
						$this->Voucher_model->table . '.date AS date',
						$this->Voucher_model->table . '.content AS content_v',
						$this->Voucher_model->table . '.value AS value_v',
						$this->AccountingEntry_model->table . '.TOT AS tot',
						$this->AccountingEntry_model->table . '.TOA AS toa',
						$this->AccountingEntry_model->table . '.content AS content_a',
						$this->AccountingEntry_model->table . '.value AS value_a',
						$this->Distribution_model->table . '.content AS content_d',
						$this->Distribution_model->table . '.value AS value_d',
					),
					'join' => array(
						$this->Voucher_model->table => $this->Voucher_model->table . '.id = ' . $this->AccountingEntry_model->table . '.voucher_id',
						$this->Distribution_model->table => $this->Distribution_model->table . '.entry_id = ' . $this->AccountingEntry_model->table . '.id'
					),
					'where' => array(
						$this->Distribution_model->table . '.dimensional_id' => $id,
						$this->Distribution_model->table . '.' . $type . ' >=' => $from,
						$this->Distribution_model->table . '.' . $type . ' <=' => $to
					),
					'order' => 'date DESC'
				);

				$this->data['data_compilation'] = $this->AccountingEntry_model->get_list($input);

				$this->load->view('report/data', $this->data);
			}
		}

      private function sort(&$new_arr, $origin, $trace_temp) {
         if (count($origin) == 0) {
            return $new_arr;
         } else {
            if (count($new_arr) == 0) {
               array_push($new_arr, reset($origin));
               array_push($trace_temp, reset($origin));
               unset($origin[key($origin)]);
            } else {
               $last_element = end($trace_temp);
               $have_child = false;
               foreach ($origin as $key_2 => $detail) {
                  if ($last_element->id == $detail->parent_id) {
                     $have_child = true;
                     array_push($new_arr, $detail);
                     array_push($trace_temp, $detail);
                     unset($origin[$key_2]);
                     break;
                  }
               }

               if (!$have_child) {
                  end($trace_temp);
                  unset($trace_temp[key($trace_temp)]);
                  reset($trace_temp);
                  if (count($trace_temp) == 0) {
                     array_push($new_arr, reset($origin));
                     array_push($trace_temp, reset($origin));
                     unset($origin[key($origin)]);
                  }
               }

            }
         }

         $this->sort($new_arr, $origin, $trace_temp);
      }

   }
 ?>
