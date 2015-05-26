<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
if ($user_settings['level']>5) {
    $krouter = $_GET['krouter'];
    $inv = $_GET['inv'];
    mysql_query("SET NAMES utf8");
    mysql_query("DELETE FROM `klimatik` WHERE `inv`='$inv' AND `router`='$krouter'");
	insert_log($lang,$user_settings['user_name'],'error','ad316',$krouter."|".$inv);
} else { exit; }
?>