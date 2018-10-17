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
			$this->data['js_files'] = array('config_index');

			$input = array(
				'where' => array('is_check' => 1)
			);
			$this->data['configs_db'] = $this->Config_model->get_list($input);

			$input = array(
				'where' => array('is_check' => 0)
			);
			$this->data['defaults_db'] = $this->Config_model->get_list($input);

			if ($this->input->post()) {
				$id_changed = $this->input->post('have_changed');
				$list_id = explode(',', $id_changed);

				foreach ($list_id as $index) {
					$value = 0;
					if (null !== $this->input->post('config_' . $index)) {
						$value = $this->input->post('config_' . $index);
					}
					$data = array(
						'value' => $value
					);
					if (!$this->Config_model->update($index, $data)) {
						$this->session->set_flashdata('message_errors', 'Đã có lỗi xảy ra!');
						redirect($this->routes['config_index']);
					}
				}

				$this->session->set_flashdata('message_success', 'Đã cập nhật!');
				redirect($this->routes['config_index']);
			}

			$this->load->view('layout', $this->data);
		}
	}
 ?>
