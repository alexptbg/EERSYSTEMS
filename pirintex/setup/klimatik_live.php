<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/setup_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
include('includes/klimatik_functions.php');
$kline = mysql_prep($_GET['kline']);
$inv = mysql_prep($_GET['inv']);
$kline_options = get_krouter_options($kline);
$datafile = "../data/{$kline_options['data_file']}";
include("$datafile");
$dev = ${'dev' . $inv};
$d = explode(" ", $dev);
$x = time() * 1000;
$d0 = $d[0];
$d1 = $d[1];
$d2 = $d[2];
$d3 = ($d[3]*256+$d[4])/10;//outside temp
$d4 = ($d[5]*256+$d[6])/10;//inside temp
$d5 = ($d[7]*256+$d[8])/10;//set point temp
$d6 = ($d[9]*256+$d[10])/10;///entrance temp
$d7 = ($d[11]*256+$d[12])/10;//outrance temp
$d8 = $d[13]*256+$d[14];//mode
$d9 = $d[15]*256+$d[16];//set of the ventilation
$d10 = $d[17]*256+$d[18];//step
$d11 = ($d[19]*256+$d[20])/10;//set point energy saving cold
$d12 = ($d[21]*256+$d[22])/10;//set point energy saving hot
$d13 = date('H:i:s');
if ($d3 > 45) { $d3 = 'NULL'; }
if (($d4 > 35) || ($d4 < 15)) { $d4 = 'NULL'; }
if (($d5 > 35) || ($d5 < 15)) { $d5 = 'NULL'; }
if (($d6 > 35) || ($d6 < 10)) { $d6 = 'NULL'; }
if (($d7 > 35) || ($d7 < 15)) { $d7 = 'NULL'; }
if (($d8 > 12) || ($d8 < 1)) { $d8 = 0; }
if (($d8 < 8) && ($d8 > 0)) { $d14 = 'OFF'; } elseif (($d8 < 13) && ($d8 >8)) { $d14 = 'ON'; } else { $d14 = 'ERR'; }
if (($d9 > 3) || ($d9 < 0)) { $d9 = 0; }
if (($d10 > 3) || ($d10 < 0)) { $d10 = 0; }
if (($d11 > 30) || ($d11 < 15)) { $d11 = 'NULL'; }
if (($d12 > 30) || ($d12 < 15)) { $d12 = 'NULL'; }
$ret = array($x,$d0,$d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$d9,$d10,$d11,$d12,$d13,$d14);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>