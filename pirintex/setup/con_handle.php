<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/setup_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$line,$id,$inv,$web_dir,$sys);
include ('../includes/socket.php');
    $action = $_POST['action'];
    $line = $_POST['line'];
    $id = $_POST['id'];	
	get_line_options($line);
    $socket_ip = $line_options['ip_address'];
    $socket_port = $line_options['port'];
    if ($action == 'on') { $com = 'ON'; }
    elseif ($action == 'off') { $com = 'OFF'; }
    else { return false; }
    try {
        if(!($com == NULL)) {
			$server = 'r';
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$server $com $id\r\n");
			$obs = $line."|".$id." ".$com;
			insert_log($lang,$user_settings['user_name'],'error','ad116',$obs);
		}
	}
    catch (Exception $e){ echo $e->getMessage(); }
?>