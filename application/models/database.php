<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Database extends CI_Model

{
	public function get_entries($table, $limit = 5)

	{
		// $this->db->cache_on();//db cache
		$query = $this->db->get($table, $limit);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		show_404();
	} //func
	public function get_entry($id = NULL)

	{
		$query = $this->db->get_where($this->config->item('db_table') , array(
			'id' => $id
		));
		$data = $query->row_array();
		if (!empty($data))
		{
			return $data;
		}
		show_404();
	} //func
	public function remove_entry($id = NULL)

	{
		$this->db->where('id', $id);
		$this->db->delete('servers');
	} //func
	public function insert_entry($data)

	{
		$query = $this->db->insert($this->config->item('db_table') , $data);
		if ($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	} //func
	public function update_entry($id = NULL, $data)

	{
		$this->db->update($this->config->item('db_table') , $data, array(
			'id' => $id
		));
	} //func
} //class