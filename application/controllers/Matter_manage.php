<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matter_manage extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('Matter_manage_model','matter');
    }

    public function index()
    {
        $condition['status !='] = 0;
        $datas = $this -> matter -> getAllByCondition($condition);
        $this -> assign('datas',$datas);
        $this -> display('matter_manage/index.html');
    }
}
