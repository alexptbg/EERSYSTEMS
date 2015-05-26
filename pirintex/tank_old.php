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
if ($data != NULL) { if ($dev[6] == '0') { $c = "FF0000"; } else { $c = "00C400"; } } else { $c = "FFFFFF"; }
header("Content-Type: text/xml");
$xmlBody = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$xmlBody .= "<chart 
    manageResize='1'
	upperLimit='100' 
	lowerLimit='0' 
	tickMarkGap='5'
	showBorder='0'
    bgColor='F9F9F9'
	bgAlpha='100'
	cylFillColor='".$c."'
	numberSuffix='%' 
	dataStreamURL='".$real_path."/live_tank.php?line=".$line."&id=".$id."&lang=".$lang."' 
	refreshInterval='1'>
<value>0</value>
</chart>";
echo $xmlBody;
?>