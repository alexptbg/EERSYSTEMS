<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = mysql_prep($_GET['line']);
$id = mysql_prep($_GET['id']);
get_line_options($line);
$datafile = "data/{$line_options['data_file']}";
include("$datafile");
$dev = ${'dev' . $id};
$d = explode(" ", $dev);
header("Content-type: text/json");
$x = time() * 1000;
$m3 = ($d[25]*65536+$d[24])-($d[27]*65536+$d[26]);
$v_k = ($d[27]*65536+$d[26])-($d[29]*65536+$d[28]);
if ($dev != null){
	$k = $m3/1000 . " м&sup3;";
	if ($d[9] == 'OFF') { $c = "FF0000"; $s = get_lang($lang,'Off'); } else { $c = "00C400"; $s = get_lang($lang,'On'); }	
    $st = "<font color=\"".$c."\">".$s."</font>";
	$v = $v_k/1000 . " м&sup3;";
    $r = array($x,$k,$st,$v);
} else {
    $r = array($x,'0','<strong>0</strong>');
}
$j = json_encode($r);
echo $j;
?>