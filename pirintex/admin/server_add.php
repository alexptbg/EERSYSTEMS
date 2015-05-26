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
$ip = mysql_prep($_GET['ip']);
$port = mysql_prep($_GET['port']);
if ($user_settings['level'] > 5) {
    if (($name != NULL) && ($ip != NULL) && ($port != NULL)) {
        mysql_query("SET NAMES utf8");
        $query = "INSERT INTO `servers_info` (`name`, `ip_addr`, `port`) VALUES ('$name', '$ip', '$port')";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
		    $obs = $ip.":".$port;
		    insert_log($lang,$user_settings['user_name'],'warning','ad113',$obs);
        }
    } else {
	    exit;
    }
} else {
	exit;
}
?>