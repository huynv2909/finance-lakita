<?php
	/**
	 * Log
	 */
	class Log extends MY_Controller
	{
		public function __construct() {
			parent::__construct();
			$this->load->model('Log_model');
			$this->load->model('Operation_model');
		}

		public function index()
		{
			$this->data['title'] = "Lịch sử hoạt động";
			$this->data['template'] = 'log/index';
			$this->data['active'] = 'log';
			$this->data['js_files'] = array('log_index');

			$this->data['limit_loading'] = json_decode($this->data['configs'])->NUMBER_LOADING;

         $input = array(
            'select' => array($this->Log_model->table . '.*', $this->Operation_model->table . '.description',$this->Operation_model->table . '.entity'),
            'join' => array($this->Operation_model->table => $this->Operation_model->table . '.name = ' . $this->Log_model->table . '.action'),
            'order' => 'time desc',
            'limit' => array($this->data['limit_loading'], 0)
         );

			$logs = $this->Log_model->get_list($input);

			$this->data['logs'] = $logs;

			$this->load->model('User_model');
			$this->data['users'] = $this->User_model->get_list();

			$this->load->view('layout', $this->data);
		}

		public function viewMore() {
			if ($this->input->post()) {
				$id = $this->input->post('id');
				$model = $this->input->post('model') . '_model';

				$this->load->model($model);
				pre($this->{$model}->get_info($id));
			}
		}

	}
 ?>
