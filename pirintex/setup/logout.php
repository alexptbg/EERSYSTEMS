<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/setup_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
$line = $_GET['line'];
$id = $_GET['id'];
$inv = $_GET['inv'];
$sys = $_GET['sys'];
//session_start();
//session_destroy();
$_SESSION[$web_dir] = NULL;
unset($_COOKIE['EESYSTEMS']);
$location = "login.php?lang=$lang&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
header("location:$location");
?>