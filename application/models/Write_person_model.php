<?php
/**
 * Created by PhpStorm.
 * User: Cosin
 * Date: 2017/5/24
 * Time: 下午11:22
 */
class Write_person_model extends MY_Model {


    protected $table = 'write_person';
    protected $pkey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

}