<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//邀请码控制器
class Invit_code extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('Invit_code_model','code');
    }

    public function index()
    {
        $code_data = $this -> code -> getAll();
        $this -> assign('code_data',$code_data);
        $this -> display('invit/index.html');
    }

    //添加激活码
    public function add_code(){
        $code = make_code();
        $condition['code'] = $code;
        $is_use = $this -> code -> getOneByCondition($condition);
        if($is_use){
            $this -> add_code();
        }else{
            $data['code'] = $code;
            $this -> code -> insert($data);
            $result = array('code' => 200,'message'=>'成功');
            echo json_encode($result);exit;
        }
    }
}
