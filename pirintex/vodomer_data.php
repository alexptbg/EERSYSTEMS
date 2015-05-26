<?php
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = $_GET['line'];
$inv = $_GET['inv'];
$id = $_GET['id'];
$v_id = $_GET['v_id'];
	mysql_query("SET NAMES 'utf8'");
    $query = "SELECT * FROM `vodomer` WHERE `line`='$line' AND `inv`='$inv' AND `v_id`='$v_id' order by `timestamp` asc"; 
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
        while($row = mysql_fetch_array($result)) {
            $return_data[] = array($row['timestamp']*1000,$row['v_k']/1000);
        }
	}
	header('Content-type: application/json');
$json = json_encode($return_data);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>