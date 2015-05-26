<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = mysql_prep($_GET['line']);
$id = mysql_prep($_GET['id']);
get_line_options($line);
$datafile = "data/{$line_options['data_file']}";
header("Content-type: text/json");
include("$datafile");
$dev = ${'dev' . $id};
$d = explode(" ", $dev);
$x = time() * 1000;
$ret = array($x,$d[16],$d[17],$d[18],$d[19],$d[20],$d[21],$d[22],$d[23]);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>