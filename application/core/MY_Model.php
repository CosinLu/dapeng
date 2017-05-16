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

}