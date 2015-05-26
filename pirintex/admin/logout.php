<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
//session_start();
//session_destroy();
$_SESSION[$web_dir] = NULL;
unset($_COOKIE['EESYSTEMS']);
$location = "login.php?lang=".$lang;
header("location:$location");
?>