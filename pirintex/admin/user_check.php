<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
$username = $_GET['username'];
if ($username == NULL) { echo "<span></span>"; } else {
    mysql_query("SET NAMES 'utf8'");
    $query = "SELECT `user_name` FROM `users` WHERE `user_name`='$username'";
    $result = mysql_query($query);
    confirm_query($result);
    $c = mysql_num_rows($result);
    if ($c == 0) { 
	    echo "<font color=\"green\">".get_lang($lang,'Available')."</font>"; } 
		else { echo "<font color=\"red\">".get_lang($lang,'Unavailable')."</font>"; }
}
?>