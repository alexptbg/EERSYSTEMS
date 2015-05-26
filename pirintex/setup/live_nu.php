<?php
include ('cron.php');
$nu = explode(' ', $ap);
$inv1 = $nu[1]; $inv2 = $nu[2]; $inv3 = $nu[3];
$mrk1 = $nu[4]; $mrk2 = $nu[5]; $mrk3 = $nu[6];
$typ1 = $nu[7]; $typ2 = $nu[8]; $typ3 = $nu[9];
$usr1 = $nu[10]; $usr2 = $nu[11]; $usr3 = $nu[12];
$plc1 = $nu[13]; $plc2 = $nu[14]; $plc3 = $nu[15];
$x = time() * 1000;
header("Content-type: text/json");
$ret = array($x,$inv3,$inv2,$inv1,$mrk3,$mrk2,$mrk1,$typ3,$typ2,$typ1,$usr3,$usr2,$usr1,$plc3,$plc2,$plc1);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>