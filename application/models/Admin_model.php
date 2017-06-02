<?php
/**
 * 后台控制器
 */
class Admin_model extends MY_Model {


    protected $table = 'admin';
    protected $pkey = 'id';

    public function __construct()
    {
        parent::__construct();
    }
}