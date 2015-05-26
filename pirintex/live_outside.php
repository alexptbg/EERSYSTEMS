<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = $_GET['line'];
$id = $_GET['id'];
$tk = $_GET['tk'];
$data = get_device($line,$id);
$dev = explode(" ", $data);
if ($tk == 'tk1') { $temp = $dev[16]; $treq = $dev[10]; }
elseif ($tk == 'tk2') { $temp = $dev[17]; $treq = $dev[11]; }
elseif ($tk == 'tk3') { $temp = $dev[18]; $treq = $dev[12]; }
elseif ($tk == 'tk4') { $temp = $dev[19]; $treq = $dev[13]; }
elseif ($tk == 'tk5') { $temp = $dev[20]; $treq = $dev[14]; }
elseif ($tk == 'tk6') { $temp = $dev[21]; $treq = $dev[15]; }
else { $temp = 0; $treq = 0; }
if ($temp != NULL) {
    $t = ((($treq*256+$temp)-1194)/22.733)+10;
    $t = number_format($t,2);   
    if (($t>10) && ($t<25)) { $out = "<font color='#00ff00'>$t ºC</font>"; }
    elseif (($t<31) && ($t>24)){ $out = "<font color='orange'>$t ºC</font>"; }
    elseif ($t>30){ $out = "<font color='red'>$t ºC</font>"; }
    else { $out = "<font color='#39A2FF'>$t ºC</font>"; }
    echo $out;
} else {
	$t = '<font color="red">Error</font>';
	echo $t;
}
?>