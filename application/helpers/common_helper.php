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
 ?>
