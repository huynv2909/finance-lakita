<?php
	/**
	 * Dashboard
	 */
	class Dashboard extends MY_Controller
	{
		function __construct()
      {
         parent::__construct();
         $this->load->model('Distribution_model');
         $this->load->model('Voucher_model');
         $this->load->model('DetailDimension_model');
         $this->load->model('AccountingEntry_model');
      }

		public function index()
		{
			$this->data['title'] = "Dashboard";
			$this->data['template'] = 'dashboard/index';
			$this->data['active'] = 'dashboard';
			$this->data['js_files'] = array('dashboard_index');

			// month kpi
			$kpi_default = 300000000;
			// 210 is 'Doanh thu'
			$id_revenue_dimension = 210;
			// 1: current month, 2: month before, 3: current year
			$date_range_default = 1;
			$min_date = date('Y-m-01');
			$max_date = date('Y-m-d');

			if ($this->input->get('date_range')) {
				$date_range_default = $this->input->get('date_range');
				$this->transformRangeToDate($min_date, $max_date, $date_range_default);
			}

			if ($this->input->get('from')) {
				$min_date = $this->input->get('from');
				$date_range_default = 0;
			}

			if ($this->input->get('to')) {
				$max_date = $this->input->get('to');
				$date_range_default = 0;
			}

			$this->data['min_date'] = $min_date;
			$this->data['max_date'] = $max_date;
			$this->data['date_range'] = $date_range_default;

			$input = array(
				'select' => array('SUM(accounting_entries.value) AS revenue'),
				'join' => array('vouchers', 'vouchers.id = accounting_entries.voucher_id'),
				'where' => array(
					'vouchers.income' => 1,
					'accounting_entries.TOA >=' => $min_date,
					'accounting_entries.TOA <=' => $max_date
				),
				'order' => 'accounting_entries.TOA ASC'
			);
			$revenue = $this->AccountingEntry_model->get_list($input)[0]->revenue;

			$this->data['kpi'] = $kpi_default;
			$this->data['revenue'] = $revenue;

			// New records;
			$input = array(
				'where' => array(
					'date >=' => $min_date . ' 00:00:00',
					'date <=' => $max_date . ' 23:59:59'
				)
			);
			$new_records = $this->Voucher_model->get_total($input);
			$this->data['new_records'] = $new_records;

			// cost
			$input = array(
				'select' => array('SUM(accounting_entries.value) AS cost'),
				'join' => array('vouchers', 'vouchers.id = accounting_entries.voucher_id'),
				'where' => array(
					'vouchers.income' => 0,
					'accounting_entries.TOA >=' => $min_date,
					'accounting_entries.TOA <=' => $max_date
				),
				'order' => 'accounting_entries.TOA ASC'
			);

			$cost = $this->AccountingEntry_model->get_list($input)[0]->cost;
			$this->data['profit'] = $revenue - $cost;

			// trend revenue
			$input = array(
				'where' => array('dimensional_id' => $id_revenue_dimension),
				'order' => 'TOA asc'
			);
			$revenue_dis = $this->Distribution_model->get_list($input);
			$from_date = $revenue_dis[0]->TOA;
			$to_date = date('Y-m-d');
			$date_range = split_date($from_date, $to_date, 2);

			$revenue_by_month = array();
			foreach ($date_range as $month => $value) {
				$ele = explode('-', $month);
				$value['month'] = $ele[0];
				$value['year'] = $ele[1];

				$input = array(
					'select' => array('SUM(value) AS revenue'),
					'where' => array(
						'dimensional_id' => $id_revenue_dimension,
						'TOA >=' => $value['from'],
						'TOA <=' => $value['to']
					)
				);
				$value['revenue'] = $this->Distribution_model->get_list($input)[0]->revenue;
				array_push($revenue_by_month, $value);
			}

			$this->data['revenue_by_month'] = $revenue_by_month;

			// distribution in layer 1
			$input = array(
				'where' => array(
					'dimen_code' => 'HD1',
					'id !=' => 210
				)
			);
			$dimens = $this->DetailDimension_model->get_list($input);
			$ratio_in_layer_1 = array();
			foreach ($dimens as $dimen) {
				$temp_arr = array(
					'id' => $dimen->id,
					'name' => $dimen->name
				);
				$input = array(
					'select' => array('SUM(value) AS revenue'),
					'where' => array(
						'dimensional_id' => $dimen->id,
						'TOA >=' => $min_date,
						'TOA <=' => $max_date
					)
				);
				$temp_arr['revenue'] = intval($this->Distribution_model->get_list($input)[0]->revenue);
				array_push($ratio_in_layer_1, $temp_arr);
			}
			$this->data['revenue_in_1'] = $ratio_in_layer_1;

			// Tree map
			$input = array(
				'where_in' => array('dimen_code', array('SP', 'NSP1', 'NSP2'))
			);
			$all_product = $this->DetailDimension_model->get_list($input);

			$trees = array();

			foreach ($all_product as $product) {
				$input = array(
					'select' => array('SUM(value) AS revenue'),
					'where' => array(
						'dimensional_id' => $product->id,
						'TOA >=' => $min_date,
						'TOA <=' => $max_date
					)
				);
				$value = $this->Distribution_model->get_list($input)[0]->revenue;
				if ($value > 0) {
					if ($product->parent_id != null) {
						$parent = $this->DetailDimension_model->get_info($product->parent_id);
						$temp = array(
							'parent_name' => $parent->name,
							'value' => $value
						);
					} else {
						$temp = array(
							'parent_name' => 'Product',
							'value' => $value
						);
					}

					$trees[$product->name] = $temp;
				}
			}
			$this->data['trees'] = $trees;

			$this->load->view('layout', $this->data);
		}

		private function transformRangeToDate(&$min_date, &$max_date, $range_type) {
			// Current month
			if ($range_type == 1) {
				$min_date = date('Y-m-01');
				$max_date = date('Y-m-d');
			}

			// before month
			if ($range_type == 2) {
				$before_month = date('m') - 1;
				$min_date = date('Y-' . $before_month . '-01');
				$before_time = new DateTime( $min_date );
				$before_time->modify('last day of this month');
				$max_date = $before_time->format('Y-m-d');
			}

			// current year
			if ($range_type == 3) {
				$min_date = date('Y-01-01');
				$max_date = date('Y-m-d');
			}
		}


	}
 ?>
