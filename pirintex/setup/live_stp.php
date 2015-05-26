<?php
include ('cron2.php');
$stp = explode(' ', $ep);
$x = time() * 1000;
header("Content-type: text/json");
$ret = array($x,
    $stp[43],$stp[45],$stp[46]);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>