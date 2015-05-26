<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
$name = mysql_prep($_GET['name']);
$message = mysql_prep($_GET['message']);
if (($name != NULL) && ($message != NULL)) {
    mysql_query("SET NAMES utf8");
    $query = "INSERT INTO `messages` (`user`, `msg`) VALUES ('$name', '$message')";
    $result = mysql_query($query);
    confirm_query($result);
    if ($result) {
        return TRUE;
    } else {
	    return FALSE;
    }
} else {
	exit;
}
?>