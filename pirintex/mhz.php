<?php
$wmi = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
$cpus = array();
$alt = false;
$object = $wmi->ExecQuery("SELECT Name, Manufacturer, CurrentClockSpeed, NumberOfLogicalProcessors FROM Win32_Processor");
if (!is_object($object)) {
$object = $wmi->ExecQuery("SELECT Name, Manufacturer, CurrentClockSpeed FROM Win32_Processor");
$alt = true;
}
foreach($object as $cpu) {
$curr = array(
'Model' => $cpu->Name,
'Vendor' => $cpu->Manufacturer,
'MHz' => $cpu->CurrentClockSpeed,
);
$curr['Model'] = $cpu->Name;
if (!$alt) {
for ($i = 0; $i < $cpu->NumberOfLogicalProcessors; $i++)
$cpus[] = $curr;} else { $cpus[] = $curr; }
}
$mhz = $cpus['0']['MHz'];
header("Content-type: text/json");
$x = time() * 1000;
$ret = array($x,$mhz);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>