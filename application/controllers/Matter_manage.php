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

    public function upload(){
        if ($_FILES['file'])
        {
            $filePath = $_FILES['file']['tmp_name'];
            $fileName = md5($_FILES['file']['name'] . time());
            $fileSize = $_FILES["file"]["size"];

            $photoSize   = getimagesize($_FILES['file']['tmp_name']);

            $paramter['width']  = $photoSize[0];
            $paramter['height'] = $photoSize[1];

            if (!empty($filePath))
            {
                $this -> load -> library('oss');
                $response = $this->oss->uploadFile($filePath, $fileName);
                dd($response);
                if ($response)
                {
                    $paramter['url'] = $this->config->item('pic_server_url').$response;
                    $paramter['createline'] = time();
                }
            }
        }
    }
}
