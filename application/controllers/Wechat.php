<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wechat extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		# 配置参数
		$config = array(
		'token'          => 'dapeng',
		'appid'          => 'wx3431de4713ceb3bb',
		'encodingaeskey' => 'e1Z1Rp855zB15oD5GEOibGBOsv1q80osuL1g1Q9blEd',
		);
		
		# 加载对应操作接口
		//文件夹名注意大写
		// $this->load->library('wechat_user', $config);
		
	}
	
	public function index(){
		
		# 配置参数
		/*$config = array(
			'token'          => 'dapeng',
			'appid'          => 'wx3431de4713ceb3bb',
			// 'appsecret'      => '39ea2b90c55ec14462b1967909316895',
			'encodingaeskey' => 'e1Z1Rp855zB15oD5GEOibGBOsv1q80osuL1g1Q9blEd',
		);

		# 加载对应操作接口
		$this->wechat->get('User', $config);*/
		//$userlist = $wechat->getUserList();
		$this -> _valid();
	}
	public function _valid(){    
        $token = 'dapeng'; 
        $signature = $this->input->get('signature'); 
        $timestamp = $this->input->get('timestamp'); 
        $nonce = $this->input->get('nonce'); 
        $echostr = $this->input->get('echostr'); 
        $tmp_arr = array($token, $timestamp, $nonce); 
        sort($tmp_arr); 
        $tmp_str = implode($tmp_arr); 
        $tmp_str = sha1($tmp_str); 
        return ($tmp_str==$signature); 
    }
}
