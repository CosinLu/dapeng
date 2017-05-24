<?php
    //临时添加打印数组
    function dd($data){
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die;
    }

    function info_log($content)
    {
        $file = APPPATH . 'logs/'.date('Y-m').'_info.log';

        $uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : '';
        error_log(date('Y-m-d H:i:s')."========={$uri}\n".$content."\n\n",3, $file);
    }

    //生成激活码
    /*function make_code(){
        $str = 'ABCDEFuvwGH012IJKLMNOPQpqrstR56STUVWXYZabcdefghijklmnoxyz34789';
        $length = strlen($str) - 7;
        $start = rand(0,$length);
        $code = substr($str,$start,6);
        return $code;
    }*/
    function make_code(){
        $arr = array(
            'A'=>1,
            'B'=>2,
            'C'=>3,
            'D'=>4,
            'E'=>5,
            'F'=>6,
            'G'=>7,
            'H'=>8,
            'I'=>9,
            'J'=>10,
            'K'=>11,
            'L'=>12,
            'M'=>13,
            'N'=>14,
            'O'=>15,
            'P'=>16,
            'Q'=>17,
            'R'=>18,
            'S'=>19,
            'T'=>20,
            'U'=>21,
            'V'=>22,
            'W'=>23,
            'X'=>24,
            'Y'=>25,
            'Z'=>26);
        $rand_code1 = array_rand($arr,4);
        $rand_code2 = array_rand($arr,4);
        $rand_code3 = array_rand($arr,4);
        $rand_code4 = array_rand($arr,4);
        $code = implode('',$rand_code1).'-'.implode('',$rand_code2).'-'.implode('',$rand_code3).'-'.implode('',$rand_code4);
        return $code;
    }

    function http_get($url){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }

    function http_post($url,$param,$post_file=false){
        $oCurl = curl_init();
        curl_setopt ( $oCurl, CURLOPT_SAFE_UPLOAD, false);
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if(is_string($param) || $post_file){
            $strPOST = $param;
        }else{
            $aPOST = array();
            foreach($param as $key=>$val){
                $aPOST[] = $key."=".urlencode($val);
            }
            $strPOST =  join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($oCurl, CURLOPT_POST,true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }


    function replace_user_status($status){
        $arr = array(0=>'关注',1=>'查询',2=>'禁用',3=>'取关');
        return $arr[$status];
    }