<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class MY_Model extends CI_Model
	{
		var $table = '';
		var $key = 'id';
		var $order = '';
		var $select = '';

		// add new record
		function create($data)
		{
			if ($this->db->insert($this->table, $data)) {
				return true;
			}
			else {
				return false;
			}
		}

		// edit record
		function update($id, $data)
		{
			if (!$id) {
				return false;
			}

			$where = array(
				$this->key => $id
				);

			return $this->update_rule($where, $data);
		}

		// update by some col
		function update_rule($where, $data)
		{
			if (!$where) {
				return false;
			}
			else {
				$this->db->where($where);
				if ($this->db->update($this->table, $data)) {
					return true;
				}
				return false;
			}
		}

		// delete record
		function delete($id)
		{
			if (!$id) {
				return false;
			}

			if (is_numeric($id)) {
				$where = array($this->key => $id);
			}
			else {
				$where = $key . "IN (" . $id . ')';
			}

			return $this->del_rule($where);
		}

		// Delete record by some col
		function del_rule($where)
		{
			if (!$where) {
				return false;
			}

			$this->db->where($where);

			if ($this->db->delete($this->table)) {
				return true;
			}

			return false;
		}

		// Checking exist of data
		function check_exist($where = array())
		{
			$this->db->where($where);

			$query = $this->db->get($this->table);
			if ($query->num_rows() > 0) {
				return true;
			}

			return false;
		}

		// Get row
		function get_info($id, $field = '')
		{
			if (!$id) {
				return false;
			}

			$where = array(
				$this->key => $id
			);

			return $this->get_info_rule($where, $field);
		}

		// Get row by some rule
		function get_info_rule($where, $field)
		{
			if ($field) {
				$this->db->select($field);
			}

			$this->db->where($where);
			$query = $this->db->get($this->table);

			if ($query->num_rows()) {
				return $query->row();
			}

			return false;
		}

		// Get list row
		function get_list($input = array())
		{
			if ($input) {
				$this->get_list_set_input($input);
			}

			$query = $this->db->get($this->table);
			return $query->result();
		}

		// Get total record
		function get_total($input = array())
		{
			if ($input) {
				$this->get_list_set_input($input);
			}

			$query = $this->db->get($this->table);
			return $query->num_rows();
		}

		function get_random_records($quantity, $field = '')
		{
			if ($field) {
				$this->db->select($field);
			}

			$this->db->order_by('rand()');
			$this->db->limit($quantity);
			$query = $this->db->get($this->table);
			return $query->result();
		}

		function get_insert_id()
		{
			return $this->db->insert_id();
		}

		// set input
		protected function get_list_set_input($input)
		{
			if (isset($input['select'])) {
				$this->db->select($input['select']);
			}

			if (isset($input['where']) && $input['where']) {
				$this->db->where($input['where']);
			}

			if (isset($input['like']) && $input['like']) {
				$this->db->like($input['like'][0], $input['like'][1]);
			}

			if (isset($input['order'][0]) && isset($input['order'][1])) {
				$this->db->order_by($input['order'][0], $input['order'][1]);
			}
			else {
				$this->db->order_by($this->key, 'desc');
			}

			if (isset($input['limit'][0]) && isset($input['limit'][1])) {
				$this->db->limit($input['limit'][0], $input['limit'][1]);
			}
		}
	}
 ?>