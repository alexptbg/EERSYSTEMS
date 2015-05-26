<?php
$wmi = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
$total_memory = 0;
$free_memory = 0;
foreach ($wmi->ExecQuery("SELECT TotalPhysicalMemory FROM Win32_ComputerSystem") as $cs) {
	$total_memory = $cs->TotalPhysicalMemory;
	break;
}
foreach ($wmi->ExecQuery("SELECT FreePhysicalMemory FROM Win32_OperatingSystem") as $os) {
	$free_memory = $os->FreePhysicalMemory;
	break;
}
$free_memory = $free_memory * 1024;
$used_memory=$total_memory-$free_memory;
header("Content-type: text/json");
$x = time() * 1000;
$ret = array($x,$used_memory);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>