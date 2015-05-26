<?php
//error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = mysql_prep($_GET['line']);
$id = mysql_prep($_GET['id']);
$data = get_device_for_widget($line,$id);
$dev = explode(" ", $data);
if ($data != null) {
	$rand = rand(1000,9999);
	$factor = $rand/100000;
    $tk1 = $dev[16];
    $tk2 = $dev[17];
    if (($tk1<70) && ($tk2<70)) {
		$p = 100;
	} elseif (($tk1>70) && ($tk2<70)) {
		$p = 50+$factor;
	} elseif (($tk1>70) && ($tk2>70)) {
		$p = 0;
	} else {
		$p = 0;
	}
    if ($p > 100) { $p = 99.9; }
    if ($p < 0) { $p = 0.1; }	
} else { $p = 0; }
$x = time() * 1000;
$r = '&value='.$p;
echo $r;
?>