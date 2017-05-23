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
        $this->load->library('Wechat/Wechat_receive');
        $this->load->library('Wechat/Wechat_user',$config);
        $this -> load -> model('User_model','user');
		
	}
	
	public function index(){
        $type   = $this -> wechat_receive -> getRev ()
            ->getRevType ();
        $openid = $this -> wechat_receive -> getRevFrom ();
        switch ($type) {
            case common::MSGTYPE_TEXT:
                $this->text("您的消息已经收到，我们会尽快根据您输入的内容完善汉朗霓虹公众号。您可以添加微信号hlneon咨询。")->reply();
                exit();
                break;
            case common::MSGTYPE_EVENT:
                $event = $this -> wechat_receive -> getRevEvent ();
                $event = isset($event['event']) ? $event['event'] : $event['EventKey'];
                switch ($event) {
                    case common::EVENT_SUBSCRIBE:
                        info_log('发送消息');
                        /*$pid = $this->getRevSceneId ();
                        $this->_subscribe ($openid);
                        $this->text("感谢您关注汉朗霓虹公众号公众号！在线报修功能已经开通，欢迎您使用。了解更多，请单击底部菜单项或访问 www.hlneon.com")->reply();*/
                        exit();
                        break;
                    case common::EVENT_UNSUBSCRIBE:
                        $this->_unsubscribe ($openid);
                        exit();
                        break;
                    default:
                        $this->_subscribe ($openid);
                        exit();
                }
                break;
            default:
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
        if (empty($openid)) {
            return false;
        }
        $user_info = $this -> wechat_user -> getUserInfo($openid);
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
            $res = $this -> user -> updateByCondition($condition,$data);
        } else {
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
