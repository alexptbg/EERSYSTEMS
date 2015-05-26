<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
if ($user_settings['level']>1) {
	$user_name = $_GET['u'];
    mysql_query("SET NAMES utf8");
    mysql_query("DELETE FROM `messages` WHERE `user`='$user_name'");
	insert_log($lang,$user_settings['user_name'],'warning','ad268',$user_name);
} else {
    exit;
}
?>