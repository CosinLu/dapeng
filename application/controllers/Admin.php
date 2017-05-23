<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    	echo common::EVENT_SUBSCRIBE;die;
        $this -> display('admin/admin_index.html');
    }
}
