<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matter_manage extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('Matter_manage_model','matter');
        $this -> load -> model('write_person_model','person');
        $this -> load -> library('oss/alioss');
    }
    private $bucket = 'cosinlu';
    public function index()
    {
        $condition['status !='] = 0;
        $datas = $this -> matter -> getAllByCondition($condition);
        foreach($datas as $key => &$value){
            $value['img_path'] = $this -> alioss -> get_sign_url($this -> bucket,$value['img_path']);
        }
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
        $field_name = $this -> getParams('field_name');
        if(empty($field_name)){
            echo "<script>alert('字不能为空');
            window.location.href='/matter_manage/index';
            </script>";
            exit;
        }
        $params['field_name'] = $field_name;
        $description = $this -> getParams('description');
        if(empty($description)){
            echo "<script>alert('描述不能为空');
            window.location.href='/matter_manage/index';</script>";
            exit;
        }
        $params['description'] = $description;
        $params['w_id'] = $this -> getParams('w_id');
        if ($_FILES['img_path']){
            $file_path = $_FILES['img_path']['tmp_name'];
            $suf_name = explode('.',$_FILES['img_path']['name']);
            $file_name = md5($_FILES['img_path']['name'] . time()).'.'.$suf_name[1];
            if (!empty($file_path)){
                $response = $this -> alioss -> upload_file_by_file($this -> bucket,$file_name,$file_path);
                if ($response->status == 200)
                {
                    $params['img_path'] = $file_name;
                }else{
                    echo "<script>alert('图片上传失败');
            window.location.href='/matter_manage/index';</script>";
                    exit;
                }
            }else{
                echo "<script>alert('图片不能为空');
            window.location.href='/matter_manage/index';</script>";
                exit;
            }
        }

        if ($_FILES['gif_path']){
            $filePath = $_FILES['gif_path']['tmp_name'];
            $sufName = explode('.',$_FILES['gif_path']['name']);
            $fileName = md5($_FILES['gif_path']['name'] . time()).'.'.$sufName[1];
            if (!empty($filePath)){
                $response = $this -> alioss -> upload_file_by_file($this -> bucket,$fileName,$filePath);
                if ($response->status == 200){
                    $params['gif_path'] = $fileName;
                }else{
                    echo "<script>alert('gif图上传失败');
            window.location.href='/matter_manage/index';</script>";
                exit;
                }
            }else{
                echo "<script>alert('gif图不能为空');
            window.location.href='/matter_manage/index';</script>";
                exit;
            }
        }
        $coord = $this -> getParams('coord');
        if(empty($coord)){
            echo "<script>alert('坐标不能为空');
            window.location.href='/matter_manage/index';
            </script>";
            exit;
        }
        $params['coord'] = json_encode($coord);
        $res = $this -> matter -> insert($params);
        if($res){
            echo "<script>alert('添加成功');
            window.location.href='/matter_manage/index';</script>";
            exit;
        }else{
            echo "<script>alert('添加失败');
            window.location.href='/matter_manage/index';</script>";
            exit;
        }
    }

    //修改matter
    public function update_matter(){
        $id = $this -> getParams('id');
        if(!is_numeric($id) && $id < 1)
            redirct('/matter_manage/index');
        $info = $this -> matter -> getOne($id);
        $condition['status'] = 0;
        $write_person_datas = $this -> person -> getAllByCondition($condition);
        $info['coord'] = json_decode($info['coord'],true);
        $this -> assign('write_person_datas',$write_person_datas);
        $this -> assign('info',$info);
        $this -> display('matter_manage/update_matter.html');
    }


    public function do_update_matter(){
        $id = $this -> getParams('id');
        $field_name = $this -> getParams('field_name');
        if(empty($field_name)){
            echo "<script>alert('字不能为空');
            window.location.href='/matter_manage/index';
            </script>";
            exit;
        }
        $params['field_name'] = $field_name;
        $description = $this -> getParams('description');
        if(empty($description)){
            echo "<script>alert('描述不能为空');
            window.location.href='/matter_manage/index';</script>";
            exit;
        }
        $params['description'] = $description;
        $params['w_id'] = $this -> getParams('w_id');
        if (!empty($_FILES['img_path']['tmp_name'])){
            $file_path = $_FILES['img_path']['tmp_name'];
            $suf_name = explode('.',$_FILES['img_path']['name']);
            $file_name = md5($_FILES['img_path']['name'] . time()).'.'.$suf_name[1];
            if (!empty($file_path)){
                $response = $this -> alioss -> upload_file_by_file($this -> bucket,$file_name,$file_path);
                if ($response->status == 200)
                {
                    $params['img_path'] = $file_name;
                }else{
                    echo "<script>alert('图片上传失败');
            window.location.href='/matter_manage/index';</script>";
                    exit;
                }
            }else{
                echo "<script>alert('图片不能为空');
            window.location.href='/matter_manage/index';</script>";
                exit;
            }
        }

        if (!empty($_FILES['gif_path']['tmp_name'])){
            $filePath = $_FILES['gif_path']['tmp_name'];
            $sufName = explode('.',$_FILES['gif_path']['name']);
            $fileName = md5($_FILES['gif_path']['name'] . time()).'.'.$sufName[1];
            if (!empty($filePath)){
                $response = $this -> alioss -> upload_file_by_file($this -> bucket,$fileName,$filePath);
                if ($response->status == 200){
                    $params['gif_path'] = $fileName;
                }else{
                    echo "<script>alert('gif图上传失败');
            window.location.href='/matter_manage/index';</script>";
                exit;
                }
            }else{
                echo "<script>alert('gif图不能为空');
            window.location.href='/matter_manage/index';</script>";
                exit;
            }
        }
        $coord = $this -> getParams('coord');
        if(empty($coord)){
            echo "<script>alert('坐标不能为空');
            window.location.href='/matter_manage/index';
            </script>";
            exit;
        }
        $params['coord'] = json_encode($coord);
        $res = $this -> matter -> update($id,$params);
        if($res){
            echo "<script>alert('修改成功');
            window.location.href='/matter_manage/index';</script>";
            exit;
        }else{
            echo "<script>alert('修改失败');
            window.location.href='/matter_manage/index';</script>";
            exit;
        }
    }

    public function del_matter(){
        $id = $this -> getParams('id');
        if(!is_numeric($id) || $id < 1){
            $result = array('code' => 500,'message'=>'删除失败');
            echo json_encode($result);exit;
        }
        $data['status'] = 0;
        $res = $this -> matter -> update($id,$data);
        if($res){
            $result = array('code' => 200,'message'=>'删除成功');
            echo json_encode($result);exit;
        }else{
            $result = array('code' => 500,'message'=>'删除失败');
            echo json_encode($result);exit;
        }
    }

    public function test_oss(){
        $this->load->library('oss/alioss');
        $a = $this -> alioss -> get_sign_url('cosinlu','f972b8f1db191df4c6428582a2ad4cf2.jpg');
        echo "<img src='{$a}' />";
    }
}
