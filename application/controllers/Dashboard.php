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
			$this->data['active'] = 'dashboard';
			if ($this->user->permission == 3) {
				$this->accountant();
			} else {
				$this->manager();
			}

		}

		private function accountant() {
			$this->data['template'] = 'dashboard/accountant';
			$this->data['js_files'] = array('dashboard_index');

			// 1: current month, 2: month before, 3: current year, 4: today
			$min_date = date('Y-m-d');
			$max_date = date('Y-m-d');
			$date_range = 4;

			if ($this->input->get('date_range') && $this->input->get('date_range') == '1') {
				$min_date = date('Y-m-1');
				$min_date = date('Y-m-d');
				$date_range = 1;
			}

			if ($this->input->get('from')) {
				$min_date = $this->input->get('from');
				$date_range = 0;
			}

			if ($this->input->get('to')) {
				$max_date = $this->input->get('to');
				$date_range = 0;
			}

			$this->data['min_date'] = $min_date;
			$this->data['max_date'] = $max_date;
			$this->data['date_range'] = $date_range;

			$input = array(
				'select' => array('COUNT(`id`) AS quantity'),
				'where' => array('approved' => 0,
					'deleted' => 0
				)
			);
			$this->data['unapproved'] = $this->Voucher_model->get_list($input)[0]->quantity;

			$this->load->view('layout', $this->data);
		}

		private function manager() {
			$this->data['template'] = 'dashboard/index';
			$this->data['js_files'] = array('dashboard_index');
			// month kpi
			$cfg = json_decode($this->data['configs']);

			$kpi_default = $cfg->REVENUE_KPI;
			// 210 is 'Doanh thu'
			$id_revenue_dimension = 210;
			// 1: current month, 2: month before, 3: current year
			$date_range_default = 1;
			$min_date = date('Y-m-01');
			$max_date = date('Y-m-d');

			if ($this->input->get('date_range')) {
				$date_range_default = $this->input->get('date_range');
				transformRangeToDate($min_date, $max_date, $date_range_default);
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
				'select' => array('SUM(value) AS revenue'),
				'where' => array(
					'dimensional_id' => 210,
					'deleted' => 0,
					'TOA >=' => $min_date,
					'TOA <=' => $max_date
				)
			);

			$revenue = $this->Distribution_model->get_list($input)[0]->revenue;

			$this->data['kpi'] = $kpi_default;
			$this->data['revenue'] = $revenue;

			// New records;
			$input = array(
				'where' => array(
					'deleted' => 0,
					'date >=' => $min_date . ' 00:00:00',
					'date <=' => $max_date . ' 23:59:59'
				)
			);
			$new_records = $this->Voucher_model->get_total($input);
			$this->data['new_records'] = $new_records;
			$this->data['total_records'] = $this->Voucher_model->get_total();

			// cost
			$input = array(
				'select' => array('SUM(value) AS cost'),
				'where' => array(
					'deleted' => 0,
					'TOA >=' => $min_date,
					'TOA <=' => $max_date
				),
				'where_in' => array('dimensional_id', array(310,320,330,340,250,350) )
			);

			$cost = $this->Distribution_model->get_list($input)[0]->cost;
			$this->data['profit'] = $revenue - $cost;

			// trend revenue
			$input = array(
				'where' => array('dimensional_id' => $id_revenue_dimension, 'deleted' => 0),
				'order' => 'TOA asc'
			);
			$revenue_dis = $this->Distribution_model->get_list($input);
			$from_date = date('Y-m-d');
			if (count($revenue_dis) > 1) {
				$from_date = $revenue_dis[0]->TOA;
			}

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
						'deleted' => 0,
						'TOA >=' => $value['from'],
						'TOA <=' => $value['to']
					)
				);
				$revenue_month = $this->Distribution_model->get_list($input)[0];

				if ($revenue_month->revenue) {
					$value['revenue'] = $revenue_month->revenue;
				} else {
					$value['revenue'] = 0;
				}
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
						'deleted' => 0,
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
				'where_in' => array('dimen_code', array('SP', 'NSP1', 'NSP2')),
				'where_not_in' => array('id', array(1517,1518))
			);
			$all_product = $this->DetailDimension_model->get_list($input);

			$trees = array();

			foreach ($all_product as $product) {
				$input = array(
					'select' => array('SUM(value) AS revenue'),
					'where' => array(
						'dimensional_id' => $product->id,
						'deleted' => 0,
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

			// Get logs
			$this->load->model('Log_model');
			$input = array(
            'select' => array($this->Log_model->table . '.*', $this->Operation_model->table . '.description'),
            'join' => array($this->Operation_model->table => $this->Operation_model->table . '.name = ' . $this->Log_model->table . '.action'),
            'order' => 'time desc',
            'limit' => array(5, 0)
         );

			$logs = $this->Log_model->get_list($input);

			$this->data['logs'] = $logs;

			$this->load->model('User_model');
			$this->data['users'] = $this->User_model->get_list();

			$this->load->view('layout', $this->data);
		}


	}
 ?>
