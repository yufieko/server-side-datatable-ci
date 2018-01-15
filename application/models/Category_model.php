<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
	protected $table = "category";
  	protected $primary_key = "id";

	function __construct() {
		parent::__construct();
	}

	/**
	 * insert function
	 * @param  array $data
	 * @return mixed (category id/false)
	 */
	public function insert($data)
	{
		$q = $this->db->insert($this->table,$data);

		if($q) {
			return $this->db->insert_id();
		} else {
			log_message('error', $this->db->error());
			return false;
		}
	}

	/**
	 * delete function
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete($id)
	{
		$result = $this->db->delete($this->table, array('id' => $id));

		if(!$result) {
			log_message('error', $this->db->error());
		}
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

		if(!$result) {
			log_message('error', $this->db->error());
		}
		return $result;
	}

	/**
	 * select data with category id
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

		if($q) {
			return $q->num_rows() > 0 ? $q->row() : false;
		} else {
			log_message('error', $this->db->error());
			return false;
		}
	}

	/**
	 * get all categories
	 * @return mixed (object/false)
	 */
	public function getAll()
	{
		$q = $this->db->select()
			->from($this->table)
			->get();

		if($q) {
			return $q->num_rows() > 0 ? $q->result() : false;
		} else {
			log_message('error', $this->db->error());
			return false;
		}
	}

	/**
	 * get all categories with condition
	 * @return mixed (object/false)
	 */
	public function getAllWithCondition($where = array(), $limit = 0, $order = 'name')
	{
		$q = $this->db->select()
			->from($this->table)
			->where($where)
        	->limit($limit)
        	->order_by($order)
			->get();

		if($q) {
			return $q->num_rows() > 0 ? $q->result() : false;
		} else {
			log_message('error', $this->db->error());
			return false;
		}
	}

	/**
	 * get single category data with condition 
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

		if($q) {
			return $q->num_rows() > 0 ? $q->row() : false;
		} else {
			log_message('error', $this->db->error());
			return false;
		}
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

        if($q) {
			return $q->num_rows() > 0 ? $q : false;
		} else {
			log_message('error', $this->db->error());
			return false;
		}
  	}

	/**
	 * get popular categories with condition
	 * @return mixed (object/false)
	 */
	public function getAllPopularWithCondition($where = array(), $limit = 0, $order = 'COUNT(p.id) DESC')
	{
		$q = $this->db->select('c.id,c.name,COUNT(p.id) AS total',false)
			->from($this->table . ' c')
			->where($where,false)
			->join('posts p','p.category = c.id','left',false)
			->group_by('c.id,c.name',false)
			->having('COUNT(p.id) > 0')
        	->limit($limit)
        	->order_by($order)
			->get();

		return empty($q) ? false : $q->result();
	}

  	/**
  	 * function to get statistic by type
  	 * @return array
  	 */
  	public function getBoxStatisticByType($type)
  	{
    	$query = $this->db
      		->select('COUNT(id) AS total')
			->from('categorys')
			->where('type_id',$type)
			->get();

    	$total = $query->row()->total;

    	$query = $this->db
			->select('COUNT(id) AS total')
			->from('categorys')
			->where('type_id',$type)
			->where('status',1)
			->get();

		$publish = $query->row()->total;

    	$query = $this->db
			->select('COUNT(id) AS total')
			->from('categorys')
			->where('type_id',$type)
			->where('status',2)
			->get();

    	$unpublish = $query->row()->total;

		$query = $this->db
			->select('COUNT(id) AS total')
			->from('categorys')
			->where('type_id',$type)
			->where('status',3)
			->get();

    	$draft = $query->row()->total;

    	$data = array(
			'total' => $total,
			'publish' => $publish,
			'unpublish' => $unpublish,
			'draft' => $draft
    	);

    	return $data;
  	}
}