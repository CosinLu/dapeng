<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 模型基类
 * author: cosin
 * date: 2015-09-6 10:56:25
 */
class MY_Model extends CI_Model
{
    protected $table;
    protected $pkey;

    public function __construct()
    {
        parent::__construct();
    }

    public function doQuery($sql)
    {
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function lastQuery()
    {
        return $this->db->last_query();
    }

    public function getOne($id)
    {
        if ($id <= 0) return array();

        $this->db->where($this->pkey, $id);
        $rows = $this->db->get($this->table);

        return $rows->row_array();
    }

    /**
     * 获得单条
     */
    public function getOneByCondition($condition)
    {
        $data = array();
        if (!is_array($condition)) return $data;

        $this->setCondition($condition);
        $this->db->order_by($this->pkey, 'desc');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $data = $query->row_array();
        return $data;
    }

    public function update($id, $data)
    {
        if ($id <= 0 || !is_array($data) || empty($data)) return 0;

        $this->db->where($this->pkey, $id);
        return $this->db->update($this->table, $data);
    }


    public function insert($data)
    {
        if (!is_array($data) || empty($data)) return 0;

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }


    public function delete($id)
    {
        if ($id <= 0) return;

        $this->db->where($this->pkey, $id);
        $this->db->delete($this->table);

        return $this->db->affected_rows();
    }

}