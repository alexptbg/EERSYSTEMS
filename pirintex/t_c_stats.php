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
$mvc=0; $devc=0;
if(!($dev0 == NULL)) { $dev0d = explode(" ", $dev0); $mvc=$mvc+$dev0d[6];$devc++;}
if(!($dev1 == NULL)) { $dev1d = explode(" ", $dev1); $mvc=$mvc+$dev1d[6];$devc++;}
if(!($dev2 == NULL)) { $dev2d = explode(" ", $dev2); $mvc=$mvc+$dev2d[6];$devc++;}
if(!($dev3 == NULL)) { $dev3d = explode(" ", $dev3); $mvc=$mvc+$dev3d[6];$devc++;}
if(!($dev4 == NULL)) { $dev4d = explode(" ", $dev4); $mvc=$mvc+$dev4d[6];$devc++;}
if(!($dev5 == NULL)) { $dev5d = explode(" ", $dev5); $mvc=$mvc+$dev5d[6];$devc++;}
if(!($dev6 == NULL)) { $dev6d = explode(" ", $dev6); $mvc=$mvc+$dev6d[6];$devc++;}
if(!($dev7 == NULL)) { $dev7d = explode(" ", $dev7); $mvc=$mvc+$dev7d[6];$devc++;}
if(!($dev8 == NULL)) { $dev8d = explode(" ", $dev8); $mvc=$mvc+$dev8d[6];$devc++;}
if(!($dev9 == NULL)) { $dev9d = explode(" ", $dev9); $mvc=$mvc+$dev9d[6];$devc++;}
if(!($dev10 == NULL)) { $dev10d = explode(" ", $dev10); $mvc=$mvc+$dev10d[6];$devc++;}
if(!($dev11 == NULL)) { $dev11d = explode(" ", $dev11); $mvc=$mvc+$dev11d[6];$devc++;}
if(!($dev12 == NULL)) { $dev12d = explode(" ", $dev12); $mvc=$mvc+$dev12d[6];$devc++;}
if(!($dev13 == NULL)) { $dev13d = explode(" ", $dev13); $mvc=$mvc+$dev13d[6];$devc++;}
if(!($dev14 == NULL)) { $dev14d = explode(" ", $dev14); $mvc=$mvc+$dev14d[6];$devc++;}
if(!($dev15 == NULL)) { $dev15d = explode(" ", $dev15); $mvc=$mvc+$dev15d[6];$devc++;}
if(!($dev16 == NULL)) { $dev16d = explode(" ", $dev16); $mvc=$mvc+$dev16d[6];$devc++;}
if(!($dev17 == NULL)) { $dev17d = explode(" ", $dev17); $mvc=$mvc+$dev17d[6];$devc++;}
if(!($dev18 == NULL)) { $dev18d = explode(" ", $dev18); $mvc=$mvc+$dev18d[6];$devc++;}
if(!($dev19 == NULL)) { $dev19d = explode(" ", $dev19); $mvc=$mvc+$dev19d[6];$devc++;}
if(!($dev20 == NULL)) { $dev20d = explode(" ", $dev20); $mvc=$mvc+$dev20d[6];$devc++;}
if(!($dev21 == NULL)) { $dev21d = explode(" ", $dev21); $mvc=$mvc+$dev21d[6];$devc++;}
if(!($dev22 == NULL)) { $dev22d = explode(" ", $dev22); $mvc=$mvc+$dev22d[6];$devc++;}
if(!($dev23 == NULL)) { $dev23d = explode(" ", $dev23); $mvc=$mvc+$dev23d[6];$devc++;}
if(!($dev24 == NULL)) { $dev24d = explode(" ", $dev24); $mvc=$mvc+$dev24d[6];$devc++;}
if(!($dev25 == NULL)) { $dev25d = explode(" ", $dev25); $mvc=$mvc+$dev25d[6];$devc++;}
if(!($dev26 == NULL)) { $dev26d = explode(" ", $dev26); $mvc=$mvc+$dev26d[6];$devc++;}
if(!($dev27 == NULL)) { $dev27d = explode(" ", $dev27); $mvc=$mvc+$dev27d[6];$devc++;}
if(!($dev28 == NULL)) { $dev28d = explode(" ", $dev28); $mvc=$mvc+$dev28d[6];$devc++;}
if(!($dev29 == NULL)) { $dev29d = explode(" ", $dev29); $mvc=$mvc+$dev29d[6];$devc++;}
if(!($dev30 == NULL)) { $dev30d = explode(" ", $dev30); $mvc=$mvc+$dev30d[6];$devc++;}
if(!($dev31 == NULL)) { $dev31d = explode(" ", $dev31); $mvc=$mvc+$dev31d[6];$devc++;}
if(!($dev32 == NULL)) { $dev32d = explode(" ", $dev32); $mvc=$mvc+$dev32d[6];$devc++;}
if(!($dev33 == NULL)) { $dev33d = explode(" ", $dev33); $mvc=$mvc+$dev33d[6];$devc++;}
if(!($dev34 == NULL)) { $dev34d = explode(" ", $dev34); $mvc=$mvc+$dev34d[6];$devc++;}
if(!($dev35 == NULL)) { $dev35d = explode(" ", $dev35); $mvc=$mvc+$dev35d[6];$devc++;}
if(!($dev36 == NULL)) { $dev36d = explode(" ", $dev36); $mvc=$mvc+$dev36d[6];$devc++;}
if(!($dev37 == NULL)) { $dev37d = explode(" ", $dev37); $mvc=$mvc+$dev37d[6];$devc++;}
if(!($dev38 == NULL)) { $dev38d = explode(" ", $dev38); $mvc=$mvc+$dev38d[6];$devc++;}
if(!($dev39 == NULL)) { $dev39d = explode(" ", $dev39); $mvc=$mvc+$dev39d[6];$devc++;}
if(!($dev40 == NULL)) { $dev40d = explode(" ", $dev40); $mvc=$mvc+$dev40d[6];$devc++;}
if(!($dev41 == NULL)) { $dev41d = explode(" ", $dev41); $mvc=$mvc+$dev41d[6];$devc++;}
if(!($dev42 == NULL)) { $dev42d = explode(" ", $dev42); $mvc=$mvc+$dev42d[6];$devc++;}
if(!($dev43 == NULL)) { $dev43d = explode(" ", $dev43); $mvc=$mvc+$dev43d[6];$devc++;}
if(!($dev44 == NULL)) { $dev44d = explode(" ", $dev44); $mvc=$mvc+$dev44d[6];$devc++;}
if(!($dev45 == NULL)) { $dev45d = explode(" ", $dev45); $mvc=$mvc+$dev45d[6];$devc++;}
if(!($dev46 == NULL)) { $dev46d = explode(" ", $dev46); $mvc=$mvc+$dev46d[6];$devc++;}
if(!($dev47 == NULL)) { $dev47d = explode(" ", $dev47); $mvc=$mvc+$dev47d[6];$devc++;}
if(!($dev48 == NULL)) { $dev48d = explode(" ", $dev48); $mvc=$mvc+$dev48d[6];$devc++;}
if(!($dev49 == NULL)) { $dev49d = explode(" ", $dev49); $mvc=$mvc+$dev49d[6];$devc++;}
if(!($dev50 == NULL)) { $dev50d = explode(" ", $dev50); $mvc=$mvc+$dev50d[6];$devc++;}
if(!($dev51 == NULL)) { $dev51d = explode(" ", $dev51); $mvc=$mvc+$dev51d[6];$devc++;}
if(!($dev52 == NULL)) { $dev52d = explode(" ", $dev52); $mvc=$mvc+$dev52d[6];$devc++;}
if(!($dev53 == NULL)) { $dev53d = explode(" ", $dev53); $mvc=$mvc+$dev53d[6];$devc++;}
if(!($dev54 == NULL)) { $dev54d = explode(" ", $dev54); $mvc=$mvc+$dev54d[6];$devc++;}
if(!($dev55 == NULL)) { $dev55d = explode(" ", $dev55); $mvc=$mvc+$dev55d[6];$devc++;}
if(!($dev56 == NULL)) { $dev56d = explode(" ", $dev56); $mvc=$mvc+$dev56d[6];$devc++;}
if(!($dev57 == NULL)) { $dev57d = explode(" ", $dev57); $mvc=$mvc+$dev57d[6];$devc++;}
if(!($dev58 == NULL)) { $dev58d = explode(" ", $dev58); $mvc=$mvc+$dev58d[6];$devc++;}
if(!($dev59 == NULL)) { $dev59d = explode(" ", $dev59); $mvc=$mvc+$dev59d[6];$devc++;}
if(!($dev60 == NULL)) { $dev60d = explode(" ", $dev60); $mvc=$mvc+$dev60d[6];$devc++;}
if(!($dev61 == NULL)) { $dev61d = explode(" ", $dev61); $mvc=$mvc+$dev61d[6];$devc++;}
if(!($dev62 == NULL)) { $dev62d = explode(" ", $dev62); $mvc=$mvc+$dev62d[6];$devc++;}
if(!($dev63 == NULL)) { $dev63d = explode(" ", $dev63); $mvc=$mvc+$dev63d[6];$devc++;}
if(!($dev64 == NULL)) { $dev64d = explode(" ", $dev64); $mvc=$mvc+$dev64d[6];$devc++;}
$c_dev = count_controllers($line);
$c_mv = count_valves($line);
  echo "<table width='100%'>
        <tr>
	    <th></th>
	    <th>".get_lang($lang, 'td46')."</th>
	    <th>".get_lang($lang, 'td45')."</th>
        </tr>
        <tr><td style='text-align:right;font-weight:700;'>".get_lang($lang, 'td47')."</td>
		<td style='text-align:center;'><span class='badge badge-success'>" .$devc . "</span></td>
		<td style='text-align:center;'><span class='badge badge-success'>" .$c_dev . "</span></td></tr>
		<tr><td style='text-align:right;font-weight:700;'>".get_lang($lang, 'td48')."</td>
		<td style='text-align:center;'><span class='badge badge-success'>". $mvc. "</span></td>
		<td style='text-align:center;'><span class='badge badge-success'>". $c_mv. "</span></td></tr>
		</table>";
?>