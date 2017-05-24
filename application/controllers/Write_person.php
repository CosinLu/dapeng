<?php
/**
 * Created by PhpStorm.
 * User: Cosin
 * Date: 2017/5/24
 * Time: 下午11:18
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Write_person extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('write_person_model','write');
    }

    public function index()
    {
        $datas = $this -> write -> getAll();
        $this -> assign('datas',$datas);
        $this -> display('write_person/index.html');
    }

    public function add_person(){
        $name = $this -> getParams('name');
        if(!empty($name)){
            $condition['name'] = $name;
            $is_in = $this -> write -> getOneByCondition($condition);
            if($is_in){
                $result = array('code'=>500,'message'=>'该名称已经存在,请重新添加');
                echo json_encode($result);exit;
            }else{
                $res = $this -> write -> insert($condition);
                if($res){
                    $result = array('code'=>200,'message'=>'添加成功');
                    echo json_encode($result);exit;
                }else{
                    $result = array('code'=>500,'message'=>'添加失败');
                    echo json_encode($result);exit;
                }
            }
        }else{
            $result = array('code'=>500,'message'=>'书写人名称不能为空');
            echo json_encode($result);exit;
        }
    }

    public function opera_status(){
        $id = $this -> getParams('id');
        $action = $this -> getParams('action');
        if($action == 'dis')
            $status = 1;
        if($action == 'cancel')
            $status = 0;
        $data['status'] = $status;
        $res = $this -> write -> update($id,$data);
        if($res){
            $result = array('code'=>200,'message'=>'操作成功');
            echo json_encode($result);exit;
        }else{
            $result = array('code'=>500,'message'=>'操作失败');
            echo json_encode($result);exit;
        }
    }
}
