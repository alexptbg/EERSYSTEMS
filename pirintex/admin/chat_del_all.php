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
	$obs = "";
    mysql_query("TRUNCATE TABLE `messages`");
    insert_log($lang,$user_settings['user_name'],'error','ad264',$obs);
} else {
    exit;
}
?>