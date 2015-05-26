<?php
//error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = mysql_prep($_GET['line']);
$line_options = get_line_options($line);
$datafile = "data/{$line_options['data_file']}";
if ($datafile == NULL) { get_error($lang,'1002'); exit; }
if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
include("$datafile");
if (filesize($datafile)<100) { get_error($lang,'1004'); exit; }
function draw($dev,$line) { if(!($dev == NULL)) { echo "<a class='btn btn-default' href='t_m_res.php?line=$line&id=$dev[0]&inv=$dev[1]'>$dev[1]</a>\n"; } }
if(!($dev0 == NULL)) { $dev0d = explode(" ", $dev0); draw($dev0d,$line); }
if(!($dev1 == NULL)) { $dev1d = explode(" ", $dev1); draw($dev1d,$line); }
if(!($dev2 == NULL)) { $dev2d = explode(" ", $dev2); draw($dev2d,$line); }
if(!($dev3 == NULL)) { $dev3d = explode(" ", $dev3); draw($dev3d,$line); }
if(!($dev4 == NULL)) { $dev4d = explode(" ", $dev4); draw($dev4d,$line); }
if(!($dev5 == NULL)) { $dev5d = explode(" ", $dev5); draw($dev5d,$line); }
if(!($dev6 == NULL)) { $dev6d = explode(" ", $dev6); draw($dev6d,$line); }
if(!($dev7 == NULL)) { $dev7d = explode(" ", $dev7); draw($dev7d,$line); }
if(!($dev8 == NULL)) { $dev8d = explode(" ", $dev8); draw($dev8d,$line); }
if(!($dev9 == NULL)) { $dev9d = explode(" ", $dev9); draw($dev9d,$line); }
if(!($dev10 == NULL)) { $dev10d = explode(" ", $dev10); draw($dev10d,$line); }
if(!($dev11 == NULL)) { $dev11d = explode(" ", $dev11); draw($dev11d,$line); }
if(!($dev12 == NULL)) { $dev12d = explode(" ", $dev12); draw($dev12d,$line); }
if(!($dev13 == NULL)) { $dev13d = explode(" ", $dev13); draw($dev13d,$line); }
if(!($dev14 == NULL)) { $dev14d = explode(" ", $dev14); draw($dev14d,$line); }
if(!($dev15 == NULL)) { $dev15d = explode(" ", $dev15); draw($dev15d,$line); }
if(!($dev16 == NULL)) { $dev16d = explode(" ", $dev16); draw($dev16d,$line); }
if(!($dev17 == NULL)) { $dev17d = explode(" ", $dev17); draw($dev17d,$line); }
if(!($dev18 == NULL)) { $dev18d = explode(" ", $dev18); draw($dev18d,$line); }
if(!($dev19 == NULL)) { $dev19d = explode(" ", $dev19); draw($dev19d,$line); }
if(!($dev20 == NULL)) { $dev20d = explode(" ", $dev20); draw($dev20d,$line); }
if(!($dev21 == NULL)) { $dev21d = explode(" ", $dev21); draw($dev21d,$line); }
if(!($dev22 == NULL)) { $dev22d = explode(" ", $dev22); draw($dev22d,$line); }
if(!($dev23 == NULL)) { $dev23d = explode(" ", $dev23); draw($dev23d,$line); }
if(!($dev24 == NULL)) { $dev24d = explode(" ", $dev24); draw($dev24d,$line); }
if(!($dev25 == NULL)) { $dev25d = explode(" ", $dev25); draw($dev25d,$line); }
if(!($dev26 == NULL)) { $dev26d = explode(" ", $dev26); draw($dev26d,$line); }
if(!($dev27 == NULL)) { $dev27d = explode(" ", $dev27); draw($dev27d,$line); }
if(!($dev28 == NULL)) { $dev28d = explode(" ", $dev28); draw($dev28d,$line); }
if(!($dev29 == NULL)) { $dev29d = explode(" ", $dev29); draw($dev29d,$line); }
if(!($dev30 == NULL)) { $dev30d = explode(" ", $dev30); draw($dev30d,$line); }
if(!($dev31 == NULL)) { $dev31d = explode(" ", $dev31); draw($dev31d,$line); }
if(!($dev32 == NULL)) { $dev32d = explode(" ", $dev32); draw($dev32d,$line); }
if(!($dev33 == NULL)) { $dev33d = explode(" ", $dev33); draw($dev33d,$line); }
if(!($dev34 == NULL)) { $dev34d = explode(" ", $dev34); draw($dev34d,$line); }
if(!($dev35 == NULL)) { $dev35d = explode(" ", $dev35); draw($dev35d,$line); }
if(!($dev36 == NULL)) { $dev36d = explode(" ", $dev36); draw($dev36d,$line); }
if(!($dev37 == NULL)) { $dev37d = explode(" ", $dev37); draw($dev37d,$line); }
if(!($dev38 == NULL)) { $dev38d = explode(" ", $dev38); draw($dev38d,$line); }
if(!($dev39 == NULL)) { $dev39d = explode(" ", $dev39); draw($dev39d,$line); }
if(!($dev40 == NULL)) { $dev40d = explode(" ", $dev40); draw($dev40d,$line); }
if(!($dev41 == NULL)) { $dev41d = explode(" ", $dev41); draw($dev41d,$line); }
if(!($dev42 == NULL)) { $dev42d = explode(" ", $dev42); draw($dev42d,$line); }
if(!($dev43 == NULL)) { $dev43d = explode(" ", $dev43); draw($dev43d,$line); }
if(!($dev44 == NULL)) { $dev44d = explode(" ", $dev44); draw($dev44d,$line); }
if(!($dev45 == NULL)) { $dev45d = explode(" ", $dev45); draw($dev45d,$line); }
if(!($dev46 == NULL)) { $dev46d = explode(" ", $dev46); draw($dev46d,$line); }
if(!($dev47 == NULL)) { $dev47d = explode(" ", $dev47); draw($dev47d,$line); }
if(!($dev48 == NULL)) { $dev48d = explode(" ", $dev48); draw($dev48d,$line); }
if(!($dev49 == NULL)) { $dev49d = explode(" ", $dev49); draw($dev49d,$line); }
if(!($dev50 == NULL)) { $dev50d = explode(" ", $dev50); draw($dev50d,$line); }
if(!($dev51 == NULL)) { $dev51d = explode(" ", $dev51); draw($dev51d,$line); }
if(!($dev52 == NULL)) { $dev52d = explode(" ", $dev52); draw($dev52d,$line); }
if(!($dev53 == NULL)) { $dev53d = explode(" ", $dev53); draw($dev53d,$line); }
if(!($dev54 == NULL)) { $dev54d = explode(" ", $dev54); draw($dev54d,$line); }
if(!($dev55 == NULL)) { $dev55d = explode(" ", $dev55); draw($dev55d,$line); }
if(!($dev56 == NULL)) { $dev56d = explode(" ", $dev56); draw($dev56d,$line); }
if(!($dev57 == NULL)) { $dev57d = explode(" ", $dev57); draw($dev57d,$line); }
if(!($dev58 == NULL)) { $dev58d = explode(" ", $dev58); draw($dev58d,$line); }
if(!($dev59 == NULL)) { $dev59d = explode(" ", $dev59); draw($dev59d,$line); }
if(!($dev60 == NULL)) { $dev60d = explode(" ", $dev60); draw($dev60d,$line); }
if(!($dev61 == NULL)) { $dev61d = explode(" ", $dev61); draw($dev61d,$line); }
if(!($dev62 == NULL)) { $dev62d = explode(" ", $dev62); draw($dev62d,$line); }
if(!($dev63 == NULL)) { $dev63d = explode(" ", $dev63); draw($dev63d,$line); }
if(!($dev64 == NULL)) { $dev64d = explode(" ", $dev64); draw($dev64d,$line); }
?>