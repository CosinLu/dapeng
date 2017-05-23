<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 控制器基类
 * author: cosin
 * date: 2015-09-6 10:56:25
 */
class MY_Controller extends CI_Controller {

    public function __construct($needLogin = true)
    {
        parent::__construct();
        include_once APPPATH.'config/common.php';

    }

    /**
     * 获取 GET/POST 参数
     * @param string $param 参数名称
     * @return boolean
     */
    public function getParams($param)
    {
        $value = $this->input->get_post($param, true);
        return $value === NULL ? '' : $value;
    }

    public function getInt($key)
    {
        $value = $this->getParams($key);
        return $value ? intval($value) : '';
    }

    public function getStr($key)
    {
        $value = $this->getParams($key);
        return $value ? strip_tags(trim($value)) : '';
    }

    public function assign($key, $val)
    {
        $this->smarty->assign($key, $val);
    }

    public function display($html)
    {
        $this->smarty->display($html);
    }
}
