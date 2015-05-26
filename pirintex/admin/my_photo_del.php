<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
$user_n = $_GET['u'];
if ($user_n != NULL) {
    mysql_query("SET NAMES utf8");
    mysql_query("DELETE FROM `profile_img` WHERE `user`='$user_n'");
}
?>
