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

    public function add_matter(){
        $this -> load -> model('write_person_model','write');
        $condition['status'] = 0;
        $write_person_datas = $this -> write -> getAllByCondition($condition);
        $this -> assign('write_person_datas',$write_person_datas);
        $this -> display('matter_manage/add_matter.html');
    }

    public function do_add_matter(){
        if ($_FILES['img_path'])
        {
            $filePath = $_FILES['img_path']['tmp_name'];
            $suf_name = explode('.',$_FILES['img_path']['name']);
            $fileName = md5($_FILES['img_path']['name'] . time()).'.'.$suf_name[1];

            if (!empty($filePath))
            {
                $this->load->library('oss/alioss');
                $response = $this -> alioss -> upload_file_by_file('cosinlu',$fileName,$filePath);
                dd($response);
                if ($response['status'] == 200)
                {
                    $paramter['url'] = $this->config->item('pic_server_url').$fileName;
                    $paramter['createline'] = time();
                }
            }
        }
        $a =
        dd($a);
    }

    public function test_oss(){
        $this->load->library('oss/alioss');
        $a = $this -> alioss -> get_sign_url('cosinlu','f972b8f1db191df4c6428582a2ad4cf2.jpg');
        echo "<img src='{$a}' />";
    }
}
