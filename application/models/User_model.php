<?php
/**
 * 用户模型
 */
class User_model extends MY_Model {


    protected $table = 'user';
    protected $pkey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function setIncDecs($id, array $fields)
    {
        if (empty($id) || !is_array($fields) || empty($fields)) return;

        $this->db->where($this->pkey, $id);
        foreach ($fields as $field=>$num)
        {
            $this->db->set($field, "`{$field}` + {$num}", false);
        }

        $this->db->update($this->table);
    }

    public function get_field_by_uid($uid,$field){
        if(!is_numeric($uid) || $uid < 1) return array();
        if(!isNes($field)) return array();
        $data = array();
        $this -> db -> select($field);
        $this -> db -> from($this -> table);
        $this -> db -> where('id',$uid);
        $rows = $this -> db -> get();
        if($rows && $rows -> num_rows() > 0){
            $data = $rows -> row_array();
        }
        return $data;
    }
}