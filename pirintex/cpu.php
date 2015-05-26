<?php
$wmi = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
$cpus = $wmi->execquery("SELECT * FROM Win32_Processor");
foreach ($cpus as $cpu) { $load = $cpu->loadpercentage; }
header("Content-type: text/json");
$x = time() * 1000;
$ret = array($x,$load);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>