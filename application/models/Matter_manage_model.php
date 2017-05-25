<?php
/**
 * 用户模型
 */
class Matter_manage_model extends MY_Model {


    protected $table = 'matter_manage';
    protected $pkey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    
}