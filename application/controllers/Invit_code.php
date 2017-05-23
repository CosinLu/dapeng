<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invit_code extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this -> display('invit/index.html');
    }
}
