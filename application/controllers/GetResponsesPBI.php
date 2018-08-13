<?php
	/**
	 * GetResponsesPBI
	 */
	class GetResponsesPBI extends CI_Controller
	{
		public function index()
		{
			if ($this->input->get()) {
            $data = $this->input->get();
            $res = '';
            foreach ($data as $key => $value) {
               $res .= $key . ' : ' . $value . "\n";
            }
            file_put_contents('public/response.txt', $res);
            die('get');
         }

         if ($this->input->post()) {
            $data = $this->input->post();
            $res = '';
            foreach ($data as $key => $value) {
               $res .= $key . ' : ' . $value . "\n";
            }
            file_put_contents('public/response.txt', $res);
            die('post');
         }

         die('none');
		}

      public function getAccessTokenByJs() {
         $this->load->view('powerbi_get_token');
      }

		public function showReport() {
			$this->load->view('report/index');
		}

		public function usingPostRequest() {
			$url = 'https://login.microsoftonline.com/common/oauth2/token';
			$data = array(
				 'grant_type' => 'password',
			    'scope' => 'openid',
			    'resource' => 'https://analysis.windows.net/powerbi/api',
			    'client_id' => 'a050392b-5b82-4dae-a75f-5b7a52dacbf7',
			    'username' => 'hocketoanonline@lakita.vn',
			    'password' => 'lakita@2018'
			);

			// use key 'http' even if you send the request to https://...
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => http_build_query($data)
			    )
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			if ($result === FALSE) {
				echo 'fail';
			}

			$result = json_decode($result);
			// echo '<pre>';
			// var_dump($result);
			//
			// echo date('m/d/Y', $result->expires_on);
			return $result->access_token;
		}

		function prepare_headers($headers) {
		    return
		    implode('', array_map(function($key, $value) {
		            return "$key: $value\r\n";
		        }, array_keys($headers), array_values($headers))
		    );
		}


		public function getReportDetail() {
			$access_token = $this->usingPostRequest();

			$url = 'https://app.powerbi.com/groups/9332d98b-9550-4d2b-82cf-9fb24b0188d1/reports/b2fd945a-ee6a-4995-8590-ce0fd1ff2f33/ReportSection';

			$headers = array(
				'Authorization' => "Bearer $access_token"
		    );

			 $options = array(
 				'http' => array (
 				  'method' => 'GET',
 				  'header'=> $this->prepare_headers($headers)
 				  )
 			);
 			$context  = stream_context_create($options);
 			$result = file_get_contents($url, false, $context);
 			if ($result === FALSE) {
 				echo 'fail';
 				die;
 			}

 			$result = json_decode($result);
 			echo '<pre>';
 			var_dump($result);
		}

		public function getEmbedToken() {
			$access_token = $this->usingPostRequest();

			$url = 'https://api.powerbi.com/v1.0/myorg/groups/9332d98b-9550-4d2b-82cf-9fb24b0188d1/reports/b2fd945a-ee6a-4995-8590-ce0fd1ff2f33/GenerateToken';
			$data = array(
				"accessLevel" => "View",
 				"allowSaveAs" => "false"
			);

			$data_query = http_build_query($data);
    		$data_len = strlen($data_query);

			$headers = array(
				'Authorization' => "Bearer $access_token",
		      'Content-Type' => 'application/x-www-form-urlencoded',
		      'Accept' => 'application/xml',
		      'Content-Length' => $data_len
		    );

			// use key 'http' even if you send the request to https://...
			$options = array(
				'http' => array (
				  'method' => 'POST',
				  'header'=> $this->prepare_headers($headers),
				  'content' => $data_query
				  )
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			if ($result === FALSE) {
				echo 'fail';
				die;
			}

			$result = json_decode($result);
			echo '<pre>';
			var_dump($result);
		}
	}

 ?>
