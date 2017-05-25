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
    	echo 111;die;
        $this -> display('matter_manage/index.html');
    }
}
