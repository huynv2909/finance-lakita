<?php
	/**
	 * Config
	 */
	class Config extends MY_Controller
	{
		public function __construct() {
			parent::__construct();
			$this->load->model('Config_model');
		}

		public function index()
		{
			$this->data['title'] = "Thiết lập";
			$this->data['template'] = 'config/index';
			$this->data['active'] = 'config';
			$this->data['configs_db'] = $this->Config_model->get_list();

			if ($this->input->post()) {
				$id_changed = $this->input->post('have_changed');
				$list_id = explode(',', $id_changed);

				foreach ($list_id as $index) {
					$value = 0;
					if (null !== $this->input->post('config_' . $index)) {
						$value = 1;
					}
					$data = array(
						'value' => $value
					);
					if (!$this->Config_model->update($index, $data)) {
						$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
						redirect($this->routes['config_index']);
					}
				}

				delete_cookie('configs_json');
				$this->session->set_flashdata('message_success', 'Đã cập nhật!');
				redirect($this->routes['config_index']);
			}

			$this->load->view('layout', $this->data);
		}
	}
 ?>
