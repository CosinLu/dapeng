<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
    {
        $this -> load -> view('home/login.html');
    }

    public function do_login(){
    	$name = $this -> input -> post('name');
    	$passwd = md5($this -> input -> post('passwd'));
    	if(!empty($name) && !empty($passwd)){
    		$this -> load -> model('admin_model','admin');
    		$condition['name'] = $name;
    		$condition['passwd'] = $passwd;
    		$res = $this -> admin -> getOneByCondition($condition);
    		if($res){
    			$this -> session -> name = $res['name'];
    			$this -> session -> id = $res['id'];
    			redirect('/admin/index');
    		}else{
    			echo "<script>alert('登录失败');
            window.location.href='/home/index';
            </script>";
            exit;
    		}
    	}else{
            echo "<script>alert('登录失败');
            window.location.href='/home/index';
            </script>";
            exit;
    	}
    }

    public function logout(){
    	$sess_data = array('id','name');
    	$this->session->unset_userdata($sess_data);
    	redirect('/home/index');
    }

    public function h5_doc(){
        $id = $this -> input -> get('id');
        if(!is_numeric($id) || $id < 1){
            exit('抱歉,数据错误');
        }
        $this -> smarty -> display('home/h5_doc.html');
    }
}
