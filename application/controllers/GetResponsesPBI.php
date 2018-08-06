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
	}

 ?>
