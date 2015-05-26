<?php
//error_reporting(0);
include ('cron2.php');
$stb = explode(' ', $ep);
$st = $stb[44];
if ($st == '1') { $b = "<input type='checkbox' name='stby' checked='checked' />"; }
else { $b = "<input type='checkbox' name='stby' />"; }
$x = time() * 1000;
header("Content-type: text/json");
$ret = array($x,$b);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>