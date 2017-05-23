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
        $this->load->library('Wechat/Wechat_receive');
		
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
                $event = $this->getRevEvent ();
                $event = isset($event['event']) ? $event['event'] : $event['EventKey'];
                switch ($event) {
                    case self::EVENT_SUBSCRIBE:
                        $pid = $this->getRevSceneId ();
                        $this->_subscribe ($openid);
                        $this->text("感谢您关注汉朗霓虹公众号公众号！在线报修功能已经开通，欢迎您使用。了解更多，请单击底部菜单项或访问 www.hlneon.com")->reply();
                        exit();
                        break;
                    case self::EVENT_UNSUBSCRIBE:
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
        $user_info = $this->getUserInfo($openid);
        $wx_info = array();
        $wx_info['language'] = $user_info['language'];
        $wx_info['city'] = $user_info['city'];
        $wx_info['province'] = $user_info['province'];
        if(isset($user_info['unionid'])){
            $data['wx_unionid'] = $user_info['unionid'];
        }
        $data['sex'] = $user_info['sex'];
        $data['headimgurl'] = $user_info['headimgurl'];
        $data['wx_openid'] = $openid;
        $data['subscribe'] = $user_info['subscribe'];
        $data['subscribe_time'] = $user_info['subscribe_time'];
        $data['un_subscribe_time'] = 0;
        $data['wx_info'] = serialize($wx_info);
        $data['status'] = 1;
        $data['nickname']          = urlencode ($user_info['nickname']);
        $rs = $model->where ("wx_openid='{$openid}'") ->find ();
        if ($rs) {
            $res = $model->where("wx_openid='{$openid}'")->save($data);
        } else {
            $res = $model->add ($data);
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
            'wx_openid' => $openid
        ];
        $data  = [
            'subscribe'         => 0,
            'un_subscribe_time' => time(),
            'w_id'              => 0,
            'status'            => 0
        ];
        $res   = $model->where ($where)
            ->save ($data);
        return $res;
    }

   
}
