<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('user_model','user');
    }

    public function index()
    {
    	$user_data = $this -> user -> getAll();
    	$this -> assign('user_data',$user_data);
        $this -> display('user/index.html');
    }

    public function opera_status(){
    	$status = 0;
    	$id = $this -> getParams('id');
    	$action = $this -> getParams('action');
    	if($action == 'dis')
			$status = 2;    
		if($action == 'cancel'){
	    	$this -> load -> model('invit_code_model','code');
	    	$where['uid'] = $id;
	    	$is_active = $this -> code -> getOneByCondition($where);
	    	if($is_active)
	    		$status = 1;
		}
		$data['status'] = $status;
		$res = $this -> user -> update($id,$data);		
		if($res){
			$result = array('code'=>200,'message'=>'操作成功');
			echo json_encode($result);exit;
		}else{
			$result = array('code'=>500,'message'=>'操作失败');
			echo json_encode($result);exit;
		}	
    }








}
