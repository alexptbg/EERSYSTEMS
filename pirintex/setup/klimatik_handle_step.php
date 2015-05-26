<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/setup_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
include('includes/klimatik_functions.php');
$action = $_POST['action'];
$kline = mysql_prep($_POST['kline']);
$inv = mysql_prep($_POST['inv']);
$sys = $_POST['sys'];
$step = "0".$_POST['step'];
check_login($lang,$line,$id,$inv,$web_dir,$sys);

include('../includes/socket.php');
$kline_options = get_krouter_options($kline);
$socket_ip = $kline_options['ip_address'];
$socket_port = $kline_options['port'];
$klimatik_options = get_klima_data($inv,$kline);
$rtu = $klimatik_options['rtu'];
$addr = $klimatik_options['addr'];

$device = substr(chunk_split($inv, 2, ' '), 0, -1);
$klimatik = explode(" ", $device);
$klima = $klimatik[1];//end na klimatik id

if ($action == 'ST') { $command = 'ST'; } else { return false; }

if ($command == "ST") {//mode
	if ($klima == "01") {
	    $cc = array("$addr","16","00","03","00","01","02","00","$step");
	}
	elseif ($klima == "02") {
	    $cc = array("$addr","16","00","08","00","01","02","00","$step");
	}
	elseif ($klima == "03") {
	    $cc = array("$addr","16","00","13","00","01","02","00","$step");
	}
	elseif ($klima == "04") {
	    $cc = array("$addr","16","00","18","00","01","02","00","$step");
	}
	elseif ($klima == "05") {
	    $cc = array("$addr","16","00","23","00","01","02","00","$step");
	}
	elseif ($klima == "06") {
	    $cc = array("$addr","16","00","28","00","01","02","00","$step");
	}	
}

foreach ($cc as $e) {//dehex frame
	if($e < 16) { $e = "0".dechex($e); } else { $e = dechex($e); }
	$ee[] = strtoupper($e);
}

$xx = strtoupper(crc16($cc));//hex soma
$xx = explode(" ", $xx); 

foreach ($xx as $h) {
	if ($h == "0") { $h = "00"; }
	if ($h == "1") { $h = "01"; }
	if ($h == "2") { $h = "02"; }
	if ($h == "3") { $h = "03"; }
	if ($h == "4") { $h = "04"; }
	if ($h == "5") { $h = "05"; }
	if ($h == "6") { $h = "06"; }
	if ($h == "7") { $h = "07"; }
	if ($h == "8") { $h = "08"; }
	if ($h == "9") { $h = "09"; }
	if ($h == "A") { $h = "0A"; }
	if ($h == "B") { $h = "0B"; }
	if ($h == "C") { $h = "0C"; }
	if ($h == "D") { $h = "0D"; }
	if ($h == "E") { $h = "0E"; }
	if ($h == "F") { $h = "0F"; }
	$hh[] = $h;
}

$frame = implode(" ",$ee)." ".implode(" ",$hh);

try {
    if(!($command == NULL)) {
		$server = 'r';
	    if ($command == 'ST') {
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$server $command $rtu $frame\r\n");
			$obs = $kline." | ".$inv." | ".$step;
			insert_log($lang,$user_settings['user_name'],'warning','ad449',$obs);
		}
	}
}
catch (Exception $e){
	echo $e->getMessage();
}
?>