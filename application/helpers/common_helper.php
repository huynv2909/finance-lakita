<?php
	function public_url($url = '')
	{
		return base_url('public/' . $url);
	}

	function pre($data, $exit = true)
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';

		if ($exit)
		{
			die;
		}
	}

	function format_default_value($value_ori) {
		$value = trim($value_ori, " ");
		if (empty($value)) {
			return "(Còn lại)";
		} else {
			$frac = explode('/', $value);
			if ($frac[1] == '100') {
				return $frac[0] . '%';
			}
			else {
				$num = str_replace(array("m", "k"), array(M, k), $frac[1]);
				return number_format($frac[0], 0, ",", ".") . '/' . number_format($num, 0, ",", ".");
			}
		}
	}

	// $type
	// 1 : year
	// 2 : month
	// 3 : day
	function split_date($from, $to, $type) {
		$begin = (new DateTime( $from ));

		$end = (new DateTime( $to ));
		$end->setTime(0,0,1);
		$time_arr = array();

		if ($type == 1) {
			$begin = (new DateTime(explode("-",$from)[0] . '-01-01'));

			$interval = new DateInterval('P1Y');
			$daterange = new DatePeriod($begin, $interval ,$end);

			foreach($daterange as $date){
				$time_arr[$date->format("Y")] = array(
					'from' => $date->format("Y-01-01"),
					'to' => $date->format("Y-12-31")
				);
			}

		}

		if ($type == 2) {
			$begin->modify('first day of this month');
			$interval = new DateInterval('P1M');
			$daterange = new DatePeriod($begin, $interval ,$end);

			foreach($daterange as $date){
				$time_arr[$date->format("m-Y")] = array(
					'from' => $date->format("Y-m-01"),
					'to' => $date->format("Y-m-t")
				);
			}
		}

		if ($type == 3) {
			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);

			foreach($daterange as $date){
				$time_arr[$date->format("d-m-Y")] = array(
					'from' => $date->format("Y-m-d"),
					'to' => $date->format("Y-m-d")
				);
			}
		}

		reset($time_arr);
		$time_arr[key($time_arr)]['from'] = $from;
		end($time_arr);
		$time_arr[key($time_arr)]['to'] = $to;

		return $time_arr;
	}

	function validateDate($date, $format = 'Y-m-d')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}

	function transformRangeToDate(&$min_date, &$max_date, $range_type) {
		// Current month
		if ($range_type == 1) {
			$min_date = date('Y-m-01');
			$max_date = date('Y-m-d');
		}

		// before month
		if ($range_type == 2) {
			$before_month = date('m') - 1;
			$min_date = date('Y-' . $before_month . '-01');
			if ($before_month == 0) {
				$before_month = 12;
				$before_year = date('Y') - 1;
				$min_date = date($before_year . '-' . $before_month . '-01');
			};

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

	function valueInPointTime($name_obj, $arr) {
		foreach ($arr as $obj) {
			if ($obj->name == $name_obj) {
				return $obj->amount;
			}
		}
		return 0;
	}

 ?>
