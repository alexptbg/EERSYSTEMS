<?php
//error_reporting(0);
include ('cron2.php');
$tp = explode(' ', $ep);
$x = time() * 1000;
header("Content-type: text/json");
$ret = array($x,
    $tp[33],$tp[34],$tp[35],$tp[36],$tp[37],$tp[38],$tp[41],$tp[39],$tp[40],$tp[42]);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>