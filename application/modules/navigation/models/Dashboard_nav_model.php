<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_nav_model extends CI_Model {
	protected $table = "dashboard_nav";
  	protected $primary_key = "id";

	function __construct() {
		parent::__construct();
	}

	/**
	 * insert function
	 * @param  array $data
	 * @return mixed (dashboard nav id/false)
	 */
	public function insert($data)
	{
		$q = $this->db->insert($this->table,$data);
		$result = empty($q) ? false : $this->db->insert_id();
		return $result;
	}

	/**
	 * delete function
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete($id)
	{
		$result = $this->db->delete($this->table, array('id' => $id));
		return $result;
	}

	/**
	 * update function
	 * @param  integer $id  
	 * @param  array $data
	 * @return boolean
	 */
	public function update($id,$data)
	{
		$this->db->where('id', $id);
		$result = $this->db->update($this->table,$data);
		return $result;
	}

	/**
	 * select data with dashboard nav id
	 * @param  integer $id
	 * @return mixed (object/false)    
	 */
	public function selectById($id)
	{
		$q = $this->db->select()
			->from($this->table)
			->where('id',$id)
			->limit(1)
			->get();

		return empty($q) ? false : $q->row();
	}

	/**
	 * get all dashboard navs
	 * @return mixed (object/false)
	 */
	public function getAll()
	{
		$q = $this->db->select()
			->from($this->table)
			->get();

		return empty($q) ? false : $q->result();
	}

	/**
	 * get all dashboard navs with condition
	 * @return mixed (object/false)
	 */
	public function getAllWithCondition($where = array(), $limit = 0, $order = 'sequence')
	{
		$q = $this->db->select()
			->from($this->table)
			->where($where)
        	->limit($limit)
        	->order_by($order)
			->get();

		return empty($q) ? false : $q->result();
	}

	/**
	 * get single dashboard nav data with condition 
	 * @param  mixed $where (array/string)
	 * @return mixed (object/false)
	 */
	public function selectWhere($where)
	{
		$q = $this->db->select()
			->from($this->table)
			->where($where)
			->limit(1)
			->get();

		return empty($q) ? false : $q->row();
	}

	/**
	 * select column on table with condition
	 * @param  string  $column
	 * @param  array   $where 
	 * @param  integer $limit 
	 * @return mixed (object/false)         
	 */
	public function selectColumnWithCondition($column, $where = array(), $limit = 0)
  	{
    	$q = $this->db->select($column)
        	->from($this->table)
        	->where($where)
        	->limit($limit)
        	->get();

    	return empty($q) ? false : $q;
  	}

  	/**
  	 * get post and dashboard nav relation
  	 * @param  array $where 
  	 * @return mixed (object/false)
  	 */
  	public function postRelation($where)
	{
		$query = $this->db->select('t.id,t.name,t.slug')
		    ->from('post_dashboard navs pt')
		    ->join('dashboard navs t','t.id = pt.dashboard nav_id')
		    ->where($where)
		    ->get();

		return ($query->num_rows() > 0 ? $query->result() : false);
	}

}