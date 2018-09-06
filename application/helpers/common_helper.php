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
		$begin = (new DateTime( $from ))->modify('first day of this month');
		$end = (new DateTime( $to ))->modify('first day of this month');
		$end->setTime(0,0,1);
		$time_arr = array();

		if ($type == 1) {

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


 ?>
