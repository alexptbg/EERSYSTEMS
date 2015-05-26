<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
include ('../includes/socket.php');
if ($user_settings['level']>5) {
    $action = $_POST['action'];
    $line = $_POST['line'];
	get_line_options($line);
    $socket_ip = $line_options['ip_address'];
    $socket_port = $line_options['port'];
    if ($action == 'on') { $com = 'zita -1'; $filter = 'warning'; $action = 'ad117'; }
    elseif ($action == 'off') { $com = 'zita -c'; $filter = 'error'; $action = 'ad118'; }
    else { return false; }
    try {
        if(!($com == NULL)) {
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("server $com\r\n");
			insert_log($lang,$user_settings['user_name'],$filter,$action,$line);
		}
	}
    catch (Exception $e){ echo $e->getMessage(); }
} else {
    //do nothing
}
?>