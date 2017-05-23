<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invit_code extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('Invit_code_model','code');
    }

    public function index()
    {
        $code_data = $this -> code -> getAll();
        $this -> assign('code_data',$code_data);
        $this -> display('invit/index.html');
    }
}
