<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
if ($user_settings['level']>10) {
	$obs = "";
    mysql_query("TRUNCATE TABLE `logs`");
    insert_log($lang,$user_settings['user_name'],'error','ad126',$obs);
} else {
	$error = get_lang($lang, '1024');
	$error .= "<br/>"; 
	$error .= get_lang($lang, '2007');
    $location = "error.php?lang=".$lang."&error=".$error;
	header("location:$location");
}
?>