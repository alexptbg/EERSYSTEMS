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
if ($dev != null){
    if ($d[6] == '0') { $c = "FF0000"; $s = get_lang($lang,'Off'); } else { $c = "00C400"; $s = get_lang($lang,'On'); }
    $st = "<font color=\"".$c."\">".$s."</font>";
    $r = array($x,$d[26],$st);//$dev0d[26]minutes//$d[6]//pomp_status
} else {
    $r = array($x,'0','<strong>0</strong>');
}
$j = json_encode($r);
echo $j;
?>