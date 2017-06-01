<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//微信公众号相关控制器
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
        $this -> load -> library('Wechat/lib/Wechat_common.php',$config);
        $this -> load -> library('Wechat/Wechat_receive',$config);
        $this -> load -> library('Wechat/Wechat_user',$config);
        $this -> load -> model('User_model','user');
		
	}
	
	public function index(){
//	    $this -> wechat_receive -> valid();
        $type   = $this -> wechat_receive -> getRev ()
            ->getRevType ();
        $openid = $this -> wechat_receive -> getRevFrom ();
        switch ($type) {
            case common::MSGTYPE_TEXT:
                $msg = $this -> wechat_receive -> getRevContent();
                $this -> _do_msg_text($openid,$msg);
                exit();
                break;
            case common::MSGTYPE_EVENT:
                $event = $this -> wechat_receive -> getRevEvent ();
                $event = isset($event['event']) ? $event['event'] : $event['EventKey'];
                switch ($event) {
                    case common::EVENT_SUBSCRIBE:
                        $this->_subscribe ($openid);
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
        $this->wechat_receive->text("感谢您的关注,您的支持就是我们最大的动力。")->reply();
        /*$user_info = $this -> wechat_user -> getUserInfo($openid);
        $data['city'] = $user_info['city'];
        $data['province'] = $user_info['province'];
        $data['sex'] = $user_info['sex'];
        $data['head_pic'] = $user_info['headimgurl'];
        $data['nickname']          = urlencode ($user_info['nickname']);*/
        $data['openid'] = $openid;
        $data['create_time'] = time();
        $data['status'] = 0;
        $data['nickname'] = '微信用户'.time();
        $condition['openid'] = $openid;
        $rs = $this -> user -> getOneByCondition($condition);
        if ($rs) {
            $this -> load -> model('Invit_code_model','code');
            $code_info = $this -> code -> getOneByCondition(array('uid'=>$rs['id']));
            if($code_info)
                $data['status'] = 1;
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

    //接收用户发送来的消息判断是否要激活
    private function _do_msg_text($openid = '',$msg = ''){
	    $user_condition['openid'] = $openid;
	    $user_info = $this -> user -> getOneByCondition($user_condition);
        $this -> load -> model('Invit_code_model','code');
        $code_condition['code'] = $msg;
        $code_info = $this -> code -> getOneByCondition($code_condition);
	    if(!empty($code_info)){
            if($user_info['status'] == 1){
                $this->wechat_receive->text("您已激活成功,无需再次发送激活码。")->reply();
            }elseif($user_info['status'] == 0 && !empty($code_info['uid'])){
                $this->wechat_receive->text("此激活码已使用。")->reply();
            }elseif($user_info['status'] == 2){
                $this->wechat_receive->text("您已被禁用,无法发送激活码。")->reply();
            }else{
                $where = ['openid' => $openid];
                $data = ['status' => 1];
                $res   = $this -> user -> updateByCondition($where,$data);
                $c_cond['uid'] = $user_info['id'];
                $c_code['id'] = $code_info['id'];
                $this -> code -> updateByCondition($c_code,$c_cond);
                if($res)
                    $this->wechat_receive->text("恭喜您,您已激活成功。")->reply();
            }
        }else{
            $this -> load -> model('Matter_manage_model','matter');
            $this -> load -> library('oss/alioss');
            $matter_condition['field_name'] = $msg;
            $matter_info = $this -> matter -> getOneByCondition($matter_condition);
            if(!empty($matter_info)){
                if($user_info['status'] == 1){
                    $send_data['Title'] = $matter_info['field_name'];
                    $send_data['Description'] = $matter_info['description'];
                    $send_data['PicUrl'] = $this -> alioss -> get_sign_url('cosinlu',$matter_info['img_path']);
                    $send_data['Url'] = 'baidu.com';
                    $this->wechat_receive->text($msg)->reply();
//                    $this->wechat_receive->news($send_data)->reply();
                }else{
                    $this->wechat_receive->text("对不起,您目前还没有权限搜索关键字。")->reply();
                }
            }else{
                $this->wechat_receive->text("对不起,系统目前无法识别您发送的消息,后续功能会逐步完善,敬请期待哦。")->reply();
            }
        }
    }
   
}
