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
 ?>