<?php if (!defined('BASEPATH')) exit('NO direct script access allowed');
/*
|--------------------------------------------------------------------------
| Smarty config
|--------------------------------------------------------------------------
|
*/
$config['cache_lifetime'] = 30*24*3600;
$config['caching']        = false;
$config['template_dir']   = APPPATH.'views';
$config['compile_dir']    = APPPATH.'views/template_c';
$config['cache_dir']      = APPPATH.'views/cache';
$config['use_sub_dirs']   = true;
$config['left_delimiter'] = '{%';
$config['right_delimiter']= '%}';
