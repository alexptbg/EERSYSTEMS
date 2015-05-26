<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/setup_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
include('../includes/socket.php');
$lang = $_POST['lang'];
$line = $_POST['line'];
$id = $_POST['id'];
$treg1 = $_POST['treg1'];
$treg2 = $_POST['treg2'];
$treg3 = $_POST['treg3'];
$treg4 = $_POST['treg4'];
$treg5 = $_POST['treg5'];
$treg6 = $_POST['treg6'];
$t_is = $_POST['t_is'];
$t_ok = $_POST['t_ok'];
$tmde = $_POST['tmde'];
$tkon = $_POST['tkon'];
check_login($lang,$line,$id,$inv,$web_dir,$sys);
get_line_options($line);
$datafile = "../data/{$line_options['data_file']}";
$socket_ip = $line_options['ip_address'];
$socket_port = $line_options['port'];
$server = 'r';
$command = "PT";
try {
	$sc = new ClientSocket();
	$sc->open($socket_ip,$socket_port);
	$sc->send("$server $command $id $treg1 $treg2 $treg3 $treg4 $treg5 $treg6 $t_is $t_ok $tmde $tkon\r\n");
	$obs = $line." | ".$id." | ".$treg1."/".$treg3." ºC";
	insert_log($lang,$user_settings['user_name'],'warning','ad278',$obs);
}
catch (Exception $e){ echo $e->getMessage(); }
?>