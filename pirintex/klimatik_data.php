<?php
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$kline = mysql_prep($_GET['kline']);
$inv = mysql_prep($_GET['inv']);
$n1 = get_lang($lang, 'ad452');
$n2 = get_lang($lang, 'ad324');
$n3 = get_lang($lang, 'ad280');
$n4 = get_lang($lang, 'ad336');
$n5 = get_lang($lang, 'ad337');
$n6 = get_lang($lang, 'Status');
	mysql_query("SET NAMES 'utf8'");
    $query = "SELECT `timestamp`,`out_temp` FROM `klima_temp` WHERE `kline`='$kline' AND `inv`='$inv' order by `timestamp` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $rows1 = array();
    $rows1['name'] = "$n1";
	$rows1['color'] = "#020059";
	$rows1['type'] = "spline";
	$rows1['tooltip']['valueSuffix'] = ' ºC';
	$rows1['tooltip']['valueDecimals'] = '1';
    while($r = mysql_fetch_array($result)) {
        $rows1['data'][] = array($r['timestamp']*1000,$r['out_temp']);
    }
    $query = "SELECT `timestamp`,`temp` FROM `klima_temp` WHERE `kline`='$kline' AND `inv`='$inv' order by `timestamp` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $rows2 = array();
    $rows2['name'] = "$n2";
	$rows2['color'] = "#1de800";
	$rows2['type'] = "spline";
	$rows2['tooltip']['valueSuffix'] = ' ºC';
	$rows2['tooltip']['valueDecimals'] = '1';
    while($rr = mysql_fetch_array($result)) {
        $rows2['data'][] = array($rr['timestamp']*1000,$rr['temp']);
    }
    $query = "SELECT `timestamp`,`set_p` FROM `klima_temp` WHERE `kline`='$kline' AND `inv`='$inv' order by `timestamp` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $rows3 = array();
    $rows3['name'] = "$n3";
	$rows3['color'] = "#be16e9";
	$rows3['type'] = "spline";
	$rows3['tooltip']['valueSuffix'] = ' ºC';
	$rows3['tooltip']['valueDecimals'] = '1';
    while($rrr = mysql_fetch_array($result)) {
        $rows3['data'][] = array($rrr['timestamp']*1000,$rrr['set_p']);
    }
    $query = "SELECT `timestamp`,`e_temp` FROM `klima_temp` WHERE `kline`='$kline' AND `inv`='$inv' order by `timestamp` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $rows4 = array();
    $rows4['name'] = "$n4";
	$rows4['color'] = "#0da2f2";
	$rows4['type'] = "spline";
	$rows4['tooltip']['valueSuffix'] = ' ºC';
	$rows4['tooltip']['valueDecimals'] = '1';
    while($rrrr = mysql_fetch_array($result)) {
        $rows4['data'][] = array($rrrr['timestamp']*1000,$rrrr['e_temp']);
    }
    $query = "SELECT `timestamp`,`o_temp` FROM `klima_temp` WHERE `kline`='$kline' AND `inv`='$inv' order by `timestamp` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $rows5 = array();
    $rows5['name'] = "$n5";
	$rows5['color'] = "#c60215";
	$rows5['type'] = "spline";
	$rows5['tooltip']['valueSuffix'] = ' ºC';
	$rows5['tooltip']['valueDecimals'] = '1';
    while($rrrrr = mysql_fetch_array($result)) {
        $rows5['data'][] = array($rrrrr['timestamp']*1000,$rrrrr['o_temp']);
    }
    $query = "SELECT `timestamp`,`status` FROM `klima_temp` WHERE `kline`='$kline' AND `inv`='$inv' order by `timestamp` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $rows6 = array();
    $rows6['name'] = "$n6";
	$rows6['color'] = "#26bd00";
	$rows6['type'] = "area";
    while($rrrrrr = mysql_fetch_array($result)) {
        $rows6['data'][] = array($rrrrrr['timestamp']*1000,$rrrrrr['status']);
    }
$output = array();
array_push($output,$rows1);
array_push($output,$rows2);
array_push($output,$rows3);
array_push($output,$rows4);
array_push($output,$rows5);
array_push($output,$rows6);
print json_encode($output, JSON_NUMERIC_CHECK);	
?>