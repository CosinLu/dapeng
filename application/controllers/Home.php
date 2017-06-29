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
        $this -> load -> model('matter_manage_model','matter');
        $info = $this -> matter -> getOne($id);
        if(!empty($info)){
            $condition['w_id'] = $info['w_id'];
            $condition['id <>'] = $info['id'];
            $other_datas = $this -> matter -> getAllByCondition($condition);
            $this -> load -> library('oss/alioss');
            if(!empty($other_datas)){
                foreach ($other_datas as &$value){
                    $value['img_path'] = $this -> alioss -> get_sign_url($this -> config -> item('bucket'),$value['img_path']);
                }
            }
            $this -> load -> model('write_person_model','person');
            $write_person_info = $this -> person -> getOne($info['w_id']);
            $info['img_path'] = $this -> alioss -> get_sign_url($this -> config -> item('bucket'),$info['img_path']);
            $info['gif_path'] = $this -> alioss -> get_sign_url($this -> config -> item('bucket'),$info['gif_path']);
        }
        $this -> smarty -> assign('info',$info);
        $this -> smarty -> assign('write_person_info',$write_person_info);
        $this -> smarty -> assign('other_datas',$other_datas);
        $this -> smarty -> display('home/h5_doc.html');
    }
}
