<?php
//error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
header("Content-Type: text/xml");
$xmlBody = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$xmlBody .= "<chart 
    chartBottomMargin='4' 
	lowerLimit='0' 
	upperLimit='100' 
	lowerLimitDisplay='0%' 
	upperLimitDisplay='100%' 
	numberSuffix='%' 
	showTickMarks='1' 
	tickValueDistance='0' 
	majorTMNumber='5' 
	majorTMHeight='4' 
	minorTMNumber='0' 
	showTickValues='1' 
	decimalPrecision='0' 
	ledGap='0' 
	ledSize='2'
    bgColor='F9F9F9'
	bgAlpha='100'
	ledBoxBgColor='FF0000' 
	ledBorderColor='0000FF' 
	borderThickness='0' 
	chartRightMargin='5'
	chartLeftMargin='5'	
	dataStreamURL='".$real_path."/live_hled.php'
	refreshInterval='2'>
	<colorRange>
		<color minValue='0' maxValue='40' code='00FF00' />
		<color minValue='40' maxValue='70' code='FFFF00' /> 
		<color minValue='70' maxValue='100' code='FF0000' /> 
	</colorRange> 
	<value>0</value>
</chart>";
echo $xmlBody;
?>