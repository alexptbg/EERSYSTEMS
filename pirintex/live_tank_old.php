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
    $stk1 = $dev[24];
    $stk2 = $dev[25];
    $s = ($stk1*256+$stk2)/61;//30 = full || 220 = empty
    $t = 8.63;//full = 8.63 //empty = 0.0
    $z = (220-$s)*45.4/1000;
    $p = ($z/$t)*100;
    $p = number_format($p,2);
    if ($p > 100) { $p = 99.9; }
    if ($p < 0) { $p = 0.1; }	
} else { $p = 0; }
$x = time() * 1000;
$r = '&value='.$p;
echo $r;
?>