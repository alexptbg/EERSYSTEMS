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
if ($tk == 'tk1') { $temp = $dev[16]; $treq = $dev[10]; }
elseif ($tk == 'tk2') { $temp = $dev[17]; $treq = $dev[11]; }
elseif ($tk == 'tk3') { $temp = $dev[18]; $treq = $dev[12]; }
elseif ($tk == 'tk4') { $temp = $dev[19]; $treq = $dev[13]; }
elseif ($tk == 'tk5') { $temp = $dev[20]; $treq = $dev[14]; }
elseif ($tk == 'tk6') { $temp = $dev[21]; $treq = $dev[15]; }
else { $temp = 0; $treq = 0; }
$x = time() * 1000;
header("Content-type: text/json");
if ($temp != NULL) {
    $t = ($treq*256+$temp)/34.9-39.5+7;
    $t = number_format($t,2);   
}
$ret = array($x,$t);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>