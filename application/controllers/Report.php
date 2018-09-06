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
      }

		public function financeActivity()
		{
			$this->data['title'] = "BÁO CÁO HOẠT ĐỘNG TÀI CHÍNH";
         $this->data['active'] = "Report";
         $this->data['template'] = "report/activity.php";
         $this->data['js_files'] = array('report_activity', 'floating-scroll/dist/jquery.floatingscroll.es6.min');
			$this->data['css_files'] = array('js/floating-scroll/dist/jquery.floatingscroll');

         // default dimension
         $dimension_id = array(200,210,220); // HD1,HD2,HD3
         $this->load->model('DetailDimension_model');

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
				$toa_min_date = reset($distribution)->TOA;

				$input = array(
					'order' => 'TOT asc'
				);
				$distribution = $this->Distribution_model->get_list($input);
				$tot_min_date = reset($distribution)->TOT;

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
