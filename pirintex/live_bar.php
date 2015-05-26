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
$tk = mysql_prep($_GET['tk']);
$data = get_device($line,$id);
$dev = explode(" ", $data);
	if ($tk == 'tk1') { $temp = $dev[16]; }
	elseif ($tk == 'tk2') { $temp = $dev[17]; }
	elseif ($tk == 'tk3') { $temp = $dev[18]; }
	elseif ($tk == 'tk4') { $temp = $dev[19]; }
	elseif ($tk == 'tk5') { $temp = $dev[20]; }
	elseif ($tk == 'tk6') { $temp = $dev[21]; }
	elseif ($tk == 'tf1') { $temp = $dev[22]; }
	elseif ($tk == 'tf2') { $temp = $dev[23]; }
	else { $temp = 0; }
header("Content-type: text/json");
$x = time() * 1000;
$bar = $temp/10;
$bar = number_format($bar,1,'.','');
$ret = array($x,$bar);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>