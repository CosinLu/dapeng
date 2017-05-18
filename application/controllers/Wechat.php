<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wechat extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    	$token = 'dapeng';
    	$encodingAesKey = 'e1Z1Rp855zB15oD5GEOibGBOsv1q80osuL1g1Q9blEd';
    	$corpId = 'wx3431de4713ceb3bb';
        $this -> load -> library('WXBizMsgCrypt',array($token, $encodingAesKey, $corpId));
		// $wxcpt = new WXBizMsgCrypt($token, $encodingAesKey, $corpId);
		$errCode = $this -> wxbizmsgcrypt -> VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
    }
}
