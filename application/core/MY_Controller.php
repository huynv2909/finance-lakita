<?php
	if (!defined('BASEPATH')) die('Bad request!');

	class MY_Controller extends CI_Controller
	{
		var $data = array();
		var $controller = NULL;
		var $method = NULL;
		var $user = NULL;
		var $role = NULL;
		var $navbar = NULL;
		var $routes = NULL;

		function __construct()
		{
			parent::__construct();

			// Get notify
         $message_errors = $this->session->flashdata('message_errors');
         $message_success = $this->session->flashdata('message_success');
         $this->data['message_errors'] = $message_errors;
         $this->data['message_success'] = $message_success;

			$configs = $this->input->cookie('configs_json');
			$this->data['check'] = 'no cookie';
			// Get config
			if ($configs == NULL) {
				$this->data['check'] = 'cookie';
				$this->load->model('Config_model');
				$config_db = $this->Config_model->get_list();
				$config_arr = array();
				foreach ($config_db as $row) {
					$config_arr[$row->name] = $row->value;
				}
				$configs = json_encode($config_arr);
				$cookie= array(
	           'name'   => 'configs_json',
	           'value'  => $configs,
	           'expire' => '604800'	 // a week
	       	);
				$this->input->set_cookie($cookie);
			}
			$this->data['configs'] = $configs;

			$this->check();
		}

		// Check user loged_in
		private function check()
		{
			$this->controller = strtolower($this->uri->rsegment('1'));
			$this->method = strtolower($this->uri->rsegment('2'));

			$loged_in = $this->session->userdata('username');

			if ($loged_in) {
				$this->load->model('User_model');
				$input = array(
					'where' => array('username' => $loged_in)
				);
				$this->user = $this->User_model->get_list($input)[0];

				$this->checkPermission();
				$this->initNavbar();
			}

			if ($loged_in && $this->controller == 'login') {
				redirect(base_url('dashboard.html'));
			}

			if (!$loged_in && $this->controller != 'login') {
				redirect(base_url('login.html'));
			}
		}



		private function checkPermission() {
			$this->load->model('Operation_model');
			$input = array(
				'where' => array(
					'name' => $this->controller . '_' . $this->method
				)
			);
			$action = $this->Operation_model->get_list($input);
			$this->preProcessPermission();
			if (count($action) == 0 || $action[0]->is_default == 0) {
				if (!array_key_exists($this->controller, $this->role->permission) || !in_array($this->method, $this->role->permission[$this->controller])) {
					redirect($this->routes['redirect_accessdenied']);
				}
			}

		}

		private function preProcessPermission() {
			$this->load->model('Permission_model');
			$role = $this->Permission_model->get_info($this->user->permission);

			$per_str = $role->permission_list;
			$per_arr = array();

			if (trim($per_str) != '') {
				$per_list = explode(',', $per_str);
				foreach ($per_list as $per) {
					$split = explode('_', $per);
					if (array_key_exists($split[0], $per_arr)) {
						array_push($per_arr[$split[0]], $split[1]);
					} else {
						$temp_arr = array($split[1]);
						$per_arr[$split[0]] = $temp_arr;
					}
				}
			}

			$role->{"permission"} = $per_arr;
			$this->role = $role;
		}

		private function initNavbar() {

			$this->load->model('Operation_model');
			$input = array(
				'order' => 'sequence desc'
			);
			$all_opes = $this->Operation_model->get_list($input);
			$this->navbar = array();
			$this->routes = array();

			foreach ($all_opes as $ope) {
				if ($ope->is_nav) {
					$add = false;
					if ($ope->is_default) {
						// Add to navbar
						$add = true;
					} else {
						$split = explode('_', $ope->name);
						if (array_key_exists($split[0], $this->role->permission)) {
							if (in_array($split[1], $this->role->permission[$split[0]])) {
								// Add to navbar
								$add = true;
							}
						}
					}

					if ($add) {
						$temp = array(
							'name' => $ope->name,
							'description' => $ope->description,
							'icon' => $ope->icon,
							'link' => base_url($ope->link)
						);
						if (array_key_exists($ope->entity, $this->navbar)) {
							array_push($this->navbar[$ope->entity], $temp);
						} else {
							$this->navbar[$ope->entity] = array($temp);
						}
					}

				}

				// initial Routes
				$this->routes[$ope->name] = base_url($ope->link);

			}


		}
	}
 ?>
