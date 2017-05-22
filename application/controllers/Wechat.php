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
        $this->load->library('wechat_receive');
		
	}
	
	public function index(){
        $type   = $this -> wechat_receive -> getRev ()
            ->getRevType ();
        $openid = $this -> wechat_receive -> getRevFrom ();
        info_log('111');
        info_log($type);
        info_log($openid);
	}

    public function valid()
   {
      $echoStr = $_GET["echostr"];
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
