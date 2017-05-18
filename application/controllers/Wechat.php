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
		$this -> valid();
	}

    public function valid()
   {
      $echoStr = $_GET["echostr"];

      //valid signature , option
      if($this->checkSignature()){
         echo $echoStr;
         exit;
      }
   }

   private function checkSignature()
   {
      $signature = $_GET["signature"];
      $timestamp = $_GET["timestamp"];
      $nonce = $_GET["nonce"];

      $token = 'dapeng'; 
      $tmpArr = array($token, $timestamp, $nonce);
      sort($tmpArr);
      $tmpStr = implode( $tmpArr );
      $tmpStr = sha1( $tmpStr );

      if( $tmpStr == $signature ){
         return true;
      }else{
         return false;
      }
   }

   
}
