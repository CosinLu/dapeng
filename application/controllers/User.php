<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('user_model','user');
    }

    public function index()
    {
    	$user_data = $this -> user -> getAll();
    	$this -> assign('user_data',$user_data);
        $this -> display('user/index.html');
    }
}
