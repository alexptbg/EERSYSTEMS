<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = mysql_prep($_GET['line']);
get_line_options($line);
$datafile = "data/{$line_options['data_file']}";
if ($datafile == NULL) { get_error($lang,'1002'); exit; }
if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
include("$datafile");
if (filesize($datafile)<100) { exit; }
echo "<style type='text/css'>span.label.label-info a { color:#FFFFFF; }</style>";
$to = get_controller_list($lang,$line);
$on = array();
if(!($dev0 == NULL)) { $dev0d = explode(" ", $dev0); $on = array_insert($on,0,$dev0d[1]); }
if(!($dev1 == NULL)) { $dev1d = explode(" ", $dev1); $on = array_insert($on,1,$dev1d[1]); }
if(!($dev2 == NULL)) { $dev2d = explode(" ", $dev2); $on = array_insert($on,2,$dev2d[1]); }
if(!($dev3 == NULL)) { $dev3d = explode(" ", $dev3);$on = array_insert($on,3,$dev3d[1]); }
if(!($dev4 == NULL)) { $dev4d = explode(" ", $dev4);$on = array_insert($on,4,$dev4d[1]); }
if(!($dev5 == NULL)) { $dev5d = explode(" ", $dev5);$on = array_insert($on,5,$dev5d[1]); }
if(!($dev6 == NULL)) { $dev6d = explode(" ", $dev6);$on = array_insert($on,6,$dev6d[1]); }
if(!($dev7 == NULL)) { $dev7d = explode(" ", $dev7);$on = array_insert($on,7,$dev7d[1]); }
if(!($dev8 == NULL)) { $dev8d = explode(" ", $dev8);$on = array_insert($on,8,$dev8d[1]); }
if(!($dev9 == NULL)) { $dev9d = explode(" ", $dev9);$on = array_insert($on,9,$dev9d[1]); }
if(!($dev10 == NULL)) { $dev10d = explode(" ", $dev10); $on = array_insert($on,10,$dev10d[1]); }
if(!($dev11 == NULL)) { $dev11d = explode(" ", $dev11); $on = array_insert($on,11,$dev11d[1]); }
if(!($dev12 == NULL)) { $dev12d = explode(" ", $dev12); $on = array_insert($on,12,$dev12d[1]); }
if(!($dev13 == NULL)) { $dev13d = explode(" ", $dev13); $on = array_insert($on,13,$dev13d[1]); }
if(!($dev14 == NULL)) { $dev14d = explode(" ", $dev14); $on = array_insert($on,14,$dev14d[1]); }
if(!($dev15 == NULL)) { $dev15d = explode(" ", $dev15); $on = array_insert($on,15,$dev15d[1]); }
if(!($dev16 == NULL)) { $dev16d = explode(" ", $dev16); $on = array_insert($on,16,$dev16d[1]); }
if(!($dev17 == NULL)) { $dev17d = explode(" ", $dev17); $on = array_insert($on,17,$dev17d[1]); }
if(!($dev18 == NULL)) { $dev18d = explode(" ", $dev18); $on = array_insert($on,18,$dev18d[1]); }
if(!($dev19 == NULL)) { $dev19d = explode(" ", $dev19); $on = array_insert($on,19,$dev19d[1]); }
if(!($dev20 == NULL)) { $dev20d = explode(" ", $dev20); $on = array_insert($on,20,$dev20d[1]); }
if(!($dev21 == NULL)) { $dev21d = explode(" ", $dev21); $on = array_insert($on,21,$dev21d[1]); }
if(!($dev22 == NULL)) { $dev22d = explode(" ", $dev22); $on = array_insert($on,22,$dev22d[1]); }
if(!($dev23 == NULL)) { $dev23d = explode(" ", $dev23); $on = array_insert($on,23,$dev23d[1]); }
if(!($dev24 == NULL)) { $dev24d = explode(" ", $dev24); $on = array_insert($on,24,$dev24d[1]); }
if(!($dev25 == NULL)) { $dev25d = explode(" ", $dev25); $on = array_insert($on,25,$dev25d[1]); }
if(!($dev26 == NULL)) { $dev26d = explode(" ", $dev26); $on = array_insert($on,26,$dev26d[1]); }
if(!($dev27 == NULL)) { $dev27d = explode(" ", $dev27); $on = array_insert($on,27,$dev27d[1]); }
if(!($dev28 == NULL)) { $dev28d = explode(" ", $dev28); $on = array_insert($on,28,$dev28d[1]); }
if(!($dev29 == NULL)) { $dev29d = explode(" ", $dev29); $on = array_insert($on,29,$dev29d[1]); }
if(!($dev30 == NULL)) { $dev30d = explode(" ", $dev30); $on = array_insert($on,30,$dev30d[1]); }
if(!($dev31 == NULL)) { $dev31d = explode(" ", $dev31); $on = array_insert($on,31,$dev31d[1]); }
if(!($dev32 == NULL)) { $dev32d = explode(" ", $dev32); $on = array_insert($on,32,$dev32d[1]); }
if(!($dev33 == NULL)) { $dev33d = explode(" ", $dev33); $on = array_insert($on,33,$dev33d[1]); }
if(!($dev34 == NULL)) { $dev34d = explode(" ", $dev34); $on = array_insert($on,34,$dev34d[1]); }
if(!($dev35 == NULL)) { $dev35d = explode(" ", $dev35); $on = array_insert($on,35,$dev35d[1]); }
if(!($dev36 == NULL)) { $dev36d = explode(" ", $dev36); $on = array_insert($on,36,$dev36d[1]); }
if(!($dev37 == NULL)) { $dev37d = explode(" ", $dev37); $on = array_insert($on,37,$dev37d[1]); }
if(!($dev38 == NULL)) { $dev38d = explode(" ", $dev38); $on = array_insert($on,38,$dev38d[1]); }
if(!($dev39 == NULL)) { $dev39d = explode(" ", $dev39); $on = array_insert($on,39,$dev39d[1]); }
if(!($dev40 == NULL)) { $dev40d = explode(" ", $dev40); $on = array_insert($on,40,$dev40d[1]); }
if(!($dev41 == NULL)) { $dev41d = explode(" ", $dev41); $on = array_insert($on,41,$dev41d[1]); }
if(!($dev42 == NULL)) { $dev42d = explode(" ", $dev42); $on = array_insert($on,42,$dev42d[1]); }
if(!($dev43 == NULL)) { $dev43d = explode(" ", $dev43); $on = array_insert($on,43,$dev43d[1]); }
if(!($dev44 == NULL)) { $dev44d = explode(" ", $dev44); $on = array_insert($on,44,$dev44d[1]); }
if(!($dev45 == NULL)) { $dev45d = explode(" ", $dev45); $on = array_insert($on,45,$dev45d[1]); }
if(!($dev46 == NULL)) { $dev46d = explode(" ", $dev46); $on = array_insert($on,46,$dev46d[1]); }
if(!($dev47 == NULL)) { $dev47d = explode(" ", $dev47); $on = array_insert($on,47,$dev47d[1]); }
if(!($dev48 == NULL)) { $dev48d = explode(" ", $dev48); $on = array_insert($on,48,$dev48d[1]); }
if(!($dev49 == NULL)) { $dev49d = explode(" ", $dev49); $on = array_insert($on,49,$dev49d[1]); }
if(!($dev50 == NULL)) { $dev50d = explode(" ", $dev50); $on = array_insert($on,50,$dev50d[1]); }
if(!($dev51 == NULL)) { $dev51d = explode(" ", $dev51); $on = array_insert($on,51,$dev51d[1]); }
if(!($dev52 == NULL)) { $dev52d = explode(" ", $dev52); $on = array_insert($on,52,$dev52d[1]); }
if(!($dev53 == NULL)) { $dev53d = explode(" ", $dev53); $on = array_insert($on,53,$dev53d[1]); }
if(!($dev54 == NULL)) { $dev54d = explode(" ", $dev54); $on = array_insert($on,54,$dev54d[1]); }
if(!($dev55 == NULL)) { $dev55d = explode(" ", $dev55); $on = array_insert($on,55,$dev55d[1]); }
if(!($dev56 == NULL)) { $dev56d = explode(" ", $dev56); $on = array_insert($on,56,$dev56d[1]); }
if(!($dev57 == NULL)) { $dev57d = explode(" ", $dev57); $on = array_insert($on,57,$dev57d[1]); }
if(!($dev58 == NULL)) { $dev58d = explode(" ", $dev58); $on = array_insert($on,58,$dev58d[1]); }
if(!($dev59 == NULL)) { $dev59d = explode(" ", $dev59); $on = array_insert($on,59,$dev59d[1]); }
if(!($dev60 == NULL)) { $dev60d = explode(" ", $dev60); $on = array_insert($on,60,$dev60d[1]); }
if(!($dev61 == NULL)) { $dev61d = explode(" ", $dev61); $on = array_insert($on,61,$dev61d[1]); }
if(!($dev62 == NULL)) { $dev62d = explode(" ", $dev62); $on = array_insert($on,62,$dev62d[1]); }
if(!($dev63 == NULL)) { $dev63d = explode(" ", $dev63); $on = array_insert($on,63,$dev63d[1]); }
if(!($dev64 == NULL)) { $dev64d = explode(" ", $dev64); $on = array_insert($on,64,$dev64d[1]); }
if(!empty($to)) {
    sort($on); 
    sort($to);
    $result = array_diff($on, $to);
    if (($on == NULL) || (filesize($datafile) == 0)) {
      //do noting
    }
    if(empty($result)) {
        //get_info($lang, '2001');
		echo "0";
    }
    else {//new controllers
        foreach ( $result AS $diff ) {
            echo "<span class=\"label label-info\">".$diff."</span>&nbsp;";
        }
    }
} else {
	echo $to;
}
?>