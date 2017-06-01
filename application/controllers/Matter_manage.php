<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matter_manage extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('Matter_manage_model','matter');
        $this -> load -> model('write_person_model','person');
    }
    private $bucket = 'cosinlu';
    public function index()
    {
        $condition['status !='] = 0;
        $datas = $this -> matter -> getAllByCondition($condition);
        $this -> assign('datas',$datas);
        $this -> display('matter_manage/index.html');
    }

    public function add_matter(){
        $condition['status'] = 0;
        $write_person_datas = $this -> person -> getAllByCondition($condition);
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
                    $paramter['url'] = $fileName;
                    $paramter['createline'] = time();
                }
            }
        }
        dd($a);
    }

    public function file_upload(){
        if ($_FILES['img_path']){
            $file_path = $_FILES['img_path']['tmp_name'];
            $suf_name = explode('.',$_FILES['img_path']['name']);
            $file_name = md5($_FILES['img_path']['name'] . time()).'.'.$suf_name[1];

            if (!empty($file_path))
            {
                $this->load->library('oss/alioss');
                $response = $this -> alioss -> upload_file_by_file($this -> bucket,$file_name,$file_path);
                if ($response['status'] == 200)
                {
                    $img_path = $this -> alioss -> get_sign_url($this -> bucket,$file_name);
                    $result = array('code' => 200,'message'=>'成功','data'=>$img_path);
                    echo json_encode($result);exit;
                }else{
                    $result = array('code' => 500,'message'=>'失败');
                    echo json_encode($result);exit;
                }
            }else{
                $result = array('code' => 500,'message'=>'失败');
                echo json_encode($result);exit;
            }
        }

        if ($_FILES['gif_path']){
            $filePath = $_FILES['gif_path']['tmp_name'];
            $sufName = explode('.',$_FILES['gif_path']['name']);
            $fileName = md5($_FILES['gif_path']['name'] . time()).'.'.$sufName[1];

            if (!empty($filePath)){
                $this->load->library('oss/alioss');
                $response = $this -> alioss -> upload_file_by_file($this -> bucket,$fileName,$filePath);
                if ($response['status'] == 200){
                    $imgPath = $this -> alioss -> get_sign_url($this -> bucket,$file_name);
                    $result = array('code' => 200,'message'=>'成功','data'=>$imgPath);
                    echo json_encode($result);exit;
                }else{
                    $result = array('code' => 500,'message'=>'失败');
                    echo json_encode($result);exit;
                }
            }else{
                $result = array('code' => 500,'message'=>'失败');
                echo json_encode($result);exit;
            }
        }
    }

    public function test_oss(){
        $this->load->library('oss/alioss');
        $a = $this -> alioss -> get_sign_url('cosinlu','f972b8f1db191df4c6428582a2ad4cf2.jpg');
        echo "<img src='{$a}' />";
    }
}
