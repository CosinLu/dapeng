<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-05-16 17:45:50
         compiled from "D:\WWW\dapeng\application\views\public\top.html" */ ?>
<?php /*%%SmartyHeaderCode:14862591ac0890dc366-67883062%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '509af274049aeb36c163b031405280cdeb7ddcb2' => 
    array (
      0 => 'D:\\WWW\\dapeng\\application\\views\\public\\top.html',
      1 => 1494927941,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14862591ac0890dc366-67883062',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_591ac0890eddd3_26087692',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591ac0890eddd3_26087692')) {function content_591ac0890eddd3_26087692($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<!-- container-fluid -->
<head>
    <title>后台管理系统</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/static/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="/static/css/fullcalendar.css" />
    <link rel="stylesheet" href="/static/css/unicorn.main.css" />
    <link rel="stylesheet" href="/static/css/unicorn.grey.css" class="skin-color" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>


<div id="header">
    <h1><a href="./dashboard.html">UniAdmin</a></h1>
</div>
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav btn-group">
        <li class="btn btn-inverse"><a title="" href="#"><i class="icon icon-user"></i> <span class="text">个人资料</span></a></li>
        <li class="btn btn-inverse dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">消息</span> <span class="label label-important">5</span> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a class="sAdd" title="" href="#">新消息</a></li>
                <li><a class="sInbox" title="" href="#">收件箱</a></li>
                <li><a class="sOutbox" title="" href="#">发件箱</a></li>
                <li><a class="sTrash" title="" href="#">发送</a></li>
            </ul>
        </li>
        <li class="btn btn-inverse"><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">设置</span></a></li>
        <li class="btn btn-inverse"><a title="" href="login.html"><i class="icon icon-share-alt"></i> <span class="text">退出</span></a></li>
    </ul>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../public/left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate ("../public/bottom.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
