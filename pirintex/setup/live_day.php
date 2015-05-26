<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/setup_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
include ('cron.php');
$dw = explode(' ', $ap);
$dr = $dw[22];
if ($dr == '1') { $d = ucfirst(get_lang($lang, 'Monday')); }
if ($dr == '2') { $d = ucfirst(get_lang($lang, 'Tuesday')); }
if ($dr == '3') { $d = ucfirst(get_lang($lang, 'Wednesday')); }
if ($dr == '4') { $d = ucfirst(get_lang($lang, 'Thursday')); }
if ($dr == '5') { $d = ucfirst(get_lang($lang, 'Friday')); }
if ($dr == '6') { $d = ucfirst(get_lang($lang, 'Saturday')); }
if ($dr == '7') { $d = ucfirst(get_lang($lang, 'Sunday')); }
$x = time() * 1000;
header("Content-type: text/json");
$ret = array($x,$d,$dr);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>