<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
$pass1 = mysql_prep($_GET['p1']);
$pass2 = mysql_prep($_GET['p2']);
$p1 = md5($pass1); $p2 = md5($pass2);
$me = $user_settings['user_name'];
if ($me != NULL) {
    if (($p1 == $p2) && ($user_settings['level'] > 0)) {
		mysql_query("SET NAMES utf8");
		$query = "UPDATE `users` SET `h_password`='$p2' WHERE `user_name`='$me'";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
		    insert_log($lang,$user_settings['user_name'],'warning','ad137',$me);
        }
    } else {
	    exit;
    }
} else {
	exit;
}
?>