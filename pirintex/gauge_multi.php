<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = mysql_prep($_GET['line']);
$id = mysql_prep($_GET['id']);
$data = get_device($line,$id);
$dev = explode(" ", $data);
$tk1 = $dev[16];
$tk2 = $dev[17];
$tk3 = $dev[18];
$tk4 = $dev[19];
$tk5 = $dev[20];
$tk6 = $dev[21];
header("Content-type: text/json");
$x = time() * 1000;
$ret = array($x,$tk1,$tk2,$tk3,$tk4,$tk5,$tk6);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>