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
        $file = APPPATH . 'logs/'.date('Y-m').'_phone.log';

        $uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : '';
        error_log(date('Y-m-d H:i:s')."========={$uri}\n".$content."\n\n",3, $file);
    }