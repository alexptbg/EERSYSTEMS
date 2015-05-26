<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
ini_set("session.gc_maxlifetime", "14400");
session_name($web_dir);
session_start();
if(isset($_SESSION[$web_dir.'_username']) && ($_SESSION[$web_dir] == $web_dir)) {
    $username = $_SESSION[$web_dir.'_username'];	
	//setcookie("EESYSTEMS", $web_dir.".eesystems.net", time()+14400);
	setcookie("EESYSTEMS", $web_dir.".eesystems.net", time()+14400, "/".$web_dir."/", $web_dir.".eesystems.net", 0, true);
    update_login($lang,$username);
} else {
	//session_destroy();
	$_SESSION[$web_dir] = NULL;
	$location = "login.php?lang=".$lang;
	header("location:$location");
}
?>