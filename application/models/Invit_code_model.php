<?php
/**
 * Created by PhpStorm.
 * User: Cosin
 * Date: 2017/5/23
 * Time: 下午11:06
 */
class Invit_code_model extends MY_Model {


    protected $table = 'invit_code';
    protected $pkey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

}