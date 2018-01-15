<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
    var $table = 'category c';
    var $column_order = array('c.name','c.created','c.modified'); //set column field database for datatable orderable
    var $column_search = array('c.name','c.created','c.modified'); //set column field database for datatable searchable
    var $order = array('c.created' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('c.id,c.name,c.created,c.modified');
        $this->db->from($this->table);
        // $this->db->join('users u','c.user_id = u.id','left');
        // $this->db->join('object_status os','os.id = c.status');

        $i = 0;

        // loop column
        foreach($this->column_search as $item) {
            // if datatable send POST for search
            if($_POST['search']['value']) {
                // first loop
                if($i === 0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                // last loop
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); //close bracket
            } elseif(!empty($_POST['columns'][$i]['search']['value'])) { // single column search
                // daterange
                if($i === 2) {
                    $exp = explode("|", $_POST['columns'][$i]['search']['value']);
                    $this->db->where($item. " >=", $exp[0].":00");
                    $this->db->where($item. " <=", $exp[1].":00");
                } else {
                    $this->db->where($item, $_POST['columns'][$i]['search']['value']);
                }
            }

            $i++;
        }

        // here order processing
        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);

        return $this->db->count_all_results();
    }
}