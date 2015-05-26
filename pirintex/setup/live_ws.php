<?php
//error_reporting(0);
include ('cron2.php');
$ws = explode(' ', $ep);
$x = time() * 1000;
header("Content-type: text/json");
$ret = array($x,$ws[1],$ws[9],$ws[17],$ws[25],$ws[2],$ws[10],$ws[18],$ws[26],$ws[3],$ws[11],$ws[19],$ws[27],$ws[4],$ws[12],$ws[20],$ws[28],$ws[5],$ws[13],$ws[21],$ws[29],$ws[6],$ws[14],$ws[22],$ws[30],$ws[7],$ws[15],$ws[23],$ws[31],$ws[8],$ws[16],$ws[24],$ws[32]);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>