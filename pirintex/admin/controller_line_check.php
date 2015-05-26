<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
$line = $_GET['line'];
if ($line != NULL) {
	$l = get_line_options($line);
    header("Content-type: text/json");
    $ret = array($line,$l['org'],$l['plant'],$l['floor']);
    echo json_encode($ret);
}
?>