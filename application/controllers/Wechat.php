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
        'appsecret'      => '3cc719d64bbe81bb619b96545c93105d',   
		);
		
		# 加载对应操作接口
		//文件夹名注意大写
        $this -> load -> library('Wechat/Wechat_receive',$config,'wechat_receive');
        $this -> load -> library('Wechat/Wechat_user',$config,'wechat_user');
        $this -> load -> model('User_model','user');
		
	}
	
	public function index(){
        $type   = $this -> wechat_receive -> getRev ()
            ->getRevType ();
        $openid = $this -> wechat_receive -> getRevFrom ();
        switch ($type) {
            case common::MSGTYPE_TEXT:
            info_log('111');
                exit();
                break;
            case common::MSGTYPE_EVENT:
            info_log('222');
                $event = $this -> wechat_receive -> getRevEvent ();
                $event = isset($event['event']) ? $event['event'] : $event['EventKey'];
                info_log($event);
                switch ($event) {
                    case common::EVENT_SUBSCRIBE:
                        info_log('发送消息');
                        info_log('openid:'.$openid);
                        $this->_subscribe ($openid);
                        exit();
                        break;
                    case common::EVENT_UNSUBSCRIBE:
            info_log('333');
                        $this->_unsubscribe ($openid);
                        exit();
                        break;
                    default:
            info_log('444');
                        $this->_subscribe ($openid);
                        exit();
                }
                break;
            default:
            info_log('555');
                $this->_subscribe ($openid);
                exit();
        }
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


   // 获取关注用户信息
    public function _subscribe ($openid = '')
    {
        info_log('ll');
        if (empty($openid)) {
            return false;
        }
        $user_info = $this -> wechat_user -> getUserInfo($openid);
        info_log(json_encode($user_info));
        $data['city'] = $user_info['city'];
        $data['province'] = $user_info['province'];
        $data['sex'] = $user_info['sex'];
        $data['head_pic'] = $user_info['headimgurl'];
        $data['openid'] = $openid;
        $data['create_time'] = $user_info['subscribe_time'];
        $data['nickname']          = urlencode ($user_info['nickname']);
        $condition['openid'] = $openid;
        $rs = $this -> user -> getOneByCondition($condition);
        if ($rs) {
            info_log('修改');
            $res = $this -> user -> updateByCondition($condition,$data);
        } else {
            info_log('添加');
            $res = $this -> user -> insert($data);
        }

        return $res;
    }

    // 取消关注
    public function _unsubscribe ($openid = '')
    {
        if (empty($openid)) {
            return true;
        }
        $where = [
            'openid' => $openid
        ];
        $data  = [
            'close_time'         => time(),
            'status'            => 3
        ];
        $res   = $this -> user -> updateByCondition($where,$data);
        return $res;
    }

   
}
