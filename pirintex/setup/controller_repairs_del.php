<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/setup_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$line,$id,$inv,$web_dir,$sys);
if ($user_settings['level']>3) {
    $id = $_GET['id'];
    mysql_query("DELETE FROM `tasks` WHERE `id`='$id'");
	insert_log($lang,$user_settings['user_name'],'error','ad114',$s);
} else {
    exit;
}
?>