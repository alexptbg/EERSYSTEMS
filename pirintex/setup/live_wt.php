<?php
//error_reporting(0);
include ('cron.php');
$dw = explode(' ', $ap);
$wt = $dw[23];
if ($wt == '1') { $e = "<input type='checkbox' disabled='disabled' checked='checked' DISABLED />"; }
else { $e = "<input type='checkbox' disabled='disabled' DISABLED />"; }
$x = time() * 1000;
header("Content-type: text/json");
$ret = array($x,$e);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>