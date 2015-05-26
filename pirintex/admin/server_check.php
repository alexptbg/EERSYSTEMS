<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
$name = $_GET['name'];
if ($name == NULL) { echo "<span></span>"; } else {
    $c = get_check_server_db($name);
    if ($c == NULL) { 
	    echo "<font color=\"green\">".get_lang($lang,'Available')."</font>"; } 
		else { echo "<font color=\"red\">".get_lang($lang,'Unavailable')."</font>"; }
}
?>