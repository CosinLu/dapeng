<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    	$this -> load -> model('user_model','user');
    	$begintime=mktime(0,0,0,date('m'),date('d'),date('Y'));
		$endtime=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
		$where['status'] = 1;
		$all_use_num = $this -> user -> getNumberByCondition($where);
		$where['create_time >='] = $begintime;
		$where['create_time <='] = $endtime;
		$now_use_num = $this -> user -> getNumberByCondition($where);
		$this -> assign('all',$all_use_num);
		$this -> assign('now',$now_use_num);
        $this -> display('admin/admin_index.html');
    }
}
