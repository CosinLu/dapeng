<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require BASEPATH . 'libraries/Oss/sdk.class.php';

/**
 * OSS 模型类
 */
class CI_OSS {

    private $_ossServer;
    private $_bucket;

    public function __construct()
    {
        $this->_ossServer = new ALIOSS();

        // 设置是否打开curl调试模式
        $this->_ossServer->set_debug_mode(FALSE);

        // 设置开启三级域名，三级域名需要注意，域名不支持一些特殊符号，所以在创建bucket的时候若想使用三级域名，最好不要使用特殊字符
        // $this->_ossServer->set_enable_domain_style(TRUE);

        $this->_bucket = 'moka';
    }


    /**
     * 获取object列表
     */
    public function listObject()
    {
        $options = array(
            'delimiter' => '/',
            'prefix' => '',
            'max-keys' => 10,
            //'marker' => 'myobject-1330850469.pdf',
        );

        $response = $this->_ossServer->list_object($this->_bucket, $options);
        $this->_format($response);
    }


    /**
     * 通过路径上传文件
     * @param string $file_path
     * @param string $filename
     * @return boolean
     */
    public function uploadFile($filepath, $filename)
    {
        $response = $this->_ossServer->upload_file_by_file($this->_bucket, $filename, $filepath);
        if ($response->status == 200)
        {
            return $filename;
        }
        else
        {
            return false;
        }
    }


    /**
     * 通过multipart上传文件
     * @param string $file_path
     * @param string $filename
     * @param int $filesize
     * @return boolean
     */
    public function uploadPhoto($filepath, $filename, $filesize)
    {
        $str    = $filename . time();
        $object = md5($str);
        $options = array(
            ALIOSS::OSS_FILE_UPLOAD => $filepath,
            'partSize' => $filesize,
        );

        $response = $this->_ossServer->create_mpu_object($this->_bucket, $object, $options);
        if ($response->status == 200)
        {
            return $object;
        }
        else
        {
            return false;
        }
    }


    /**
     * 上传pkg文件
     * @param string $file_path
     * @param string $filename
     * @return boolean
     */
    public function uploadPkg($filepath, $filename)
    {
        $object = $filename;
        $response = $this->_ossServer->upload_file_by_file($this->_bucket, $object, $filepath);

        if ($response->status == 200)
        {
            return $response->header;
        }
        else {
            return false;
        }
    }

    /**
     * 删除pkg文件
     * @param string $filename
     * @return boolean
     */
    public function deletePkg($filename)
    {
        $object = $filename;
        $response = $this->_ossServer->delete_object($this->_bucket, $object);
        if ($response->status >= 200 && $response->status < 300) {
            return true;
        }
        return false;
    }


    /**
     * 通过文件内容上传
     * @param string $file_path
     * @param string $filename
     * @return boolean
     */
    public function uploadByContent($content, $length)
    {
        $str    = time().microtime().mt_rand(1, 10000000);
        $object = md5($str);
        $options= array('content' => $content, 'length' => $length);

        $response = $this->_ossServer->upload_file_by_content($this->_bucket, $object, $options);
        if ($response->status == 200)
        {
            return $object;
        }
        else {
            return false;
        }
    }

    // 格式化返回结果，测试使用
    private function _format($response) {
        echo '|-----------------------Start---------------------------------------------------------------------------------------------------'."<br>";
        echo '|-Status:' . $response->status . "<br>";
        echo '|-Body:' ."<br>";
        echo $response->body . "<br><br>";
        echo "|-Header:<br>";
        print_r ( $response->header );
        echo '<br>-----------------------End-----------------------------------------------------------------------------------------------------'."<br><br>";
    }
}