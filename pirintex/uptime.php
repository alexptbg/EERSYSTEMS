<?php
//error_reporting(0);
$lang = $_GET['lang'];
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
$wmi = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
$booted_str = "";
foreach ($wmi->ExecQuery("SELECT LastBootUpTime FROM Win32_OperatingSystem") as $os) { $booted_str = $os->LastBootUpTime; }
$booted = array(
	'year'   => substr($booted_str, 0, 4),
	'month'  => substr($booted_str, 4, 2),
	'day'    => substr($booted_str, 6, 2),
	'hour'   => substr($booted_str, 8, 2),
	'minute' => substr($booted_str, 10, 2),
	'second' => substr($booted_str, 12, 2)
);
$booted_ts = mktime($booted['hour'], $booted['minute'], $booted['second'], $booted['month'], $booted['day'], $booted['year']);
$uptime = seconds_convert($lang,time() - $booted_ts);
function seconds_convert($lang,$uptime) {
	$uptime += $uptime > 60 ? 30 : 0;
	$years = floor($uptime / 31556926);
	$uptime %= 31556926;
	$days = floor($uptime / 86400);
	$uptime %= 86400;
	$hours = floor($uptime / 3600);
	$uptime %= 3600;
	$minutes = floor($uptime / 60);
	$seconds = floor($uptime % 60);
	$return = array();
	if ($years > 0)
		$return[] = $years.' '.($years > 1 ? get_lang($lang, 'inter17') : get_lang($lang, 'inter16'));
	if ($days > 0)
		$return[] = $days.' '.($days > 1 ? get_lang($lang, 'inter21') : get_lang($lang, 'inter20'));
	if ($hours > 0)
		$return[] = $hours.' '.($hours > 1 ? get_lang($lang, 'inter19') : get_lang($lang, 'inter18'));
	if ($minutes > 0)
		$return[] = $minutes.' '.($minutes > 1 ? get_lang($lang, 'inter23') : get_lang($lang, 'inter22'));
	if ($seconds > 0)
		$return[] = $seconds.' '.($seconds > 1 ? get_lang($lang, 'inter25') : get_lang($lang, 'inter24'));
	return implode(', ', $return);
}
header("Content-type: text/json");
$x = time() * 1000;
$ret = array($x,$uptime);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>