<?php
/**
 * Created by PhpStorm.
 * User: Cosin
 * Date: 2017/5/24
 * Time: 下午11:18
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Write_person extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('write_person_model','write');
    }

    public function index()
    {
        $datas = $this -> write -> getAll();
        $this -> assign('datas',$datas);
        $this -> display('write_person/index.html');
    }
}
