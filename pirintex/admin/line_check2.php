<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
$lineid = $_GET['lineid'];
$linename = $_GET['linename'];
if ($linename == NULL) { echo "<span></span>"; } else {
	mysql_query("SET NAMES 'utf8'");
    $query = "SELECT `id`,`line_name` FROM `lines` WHERE `line_name`='$linename' AND `id` NOT LIKE '$lineid'";
    $result = mysql_query($query);
    confirm_query($result);
	$c = mysql_num_rows($result);
    if ($c == 0) { 
	    echo "<font color=\"green\">".get_lang($lang,'Available')."</font>"; } 
		else { echo "<font color=\"red\">".get_lang($lang,'Unavailable')."</font>"; }
}
?>