<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$kline = mysql_prep($_GET['kline']);
$l = mysql_prep($_GET['l']);
$kline_options = get_krouter_options($kline);
$datafile = "data/{$kline_options['data_file']}";
$updated = date('H:i:s');
if ($datafile == NULL) { get_error($lang,'1002'); exit; }
if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
include("$datafile");
if (filesize($datafile)<100) { get_error($lang,'1004'); exit; }
echo "<script type='text/javascript' src='js/table.js'></script>";
include('includes/table_style.php');
include('includes/klima_functions.php');
echo "
  <table class='data $site_theme'>
  <caption>". get_lang($lang, 'Updated_at') . " " . $updated. "</caption>
  <thead><tr>
  <th class='tip' title='".get_lang($lang, 'td4')."'>INV</th>
  <th class='tip' title='".get_lang($lang, 'info6')."'>DATE</th>
  <th class='tip' title='".get_lang($lang, 'inter72')."'>TIME</th>
  <th class='th1 tip' title='".get_lang($lang, 'egi05')."'>OUT TEMP</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad324')."'>TEMP</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad280')."'>SET POINT</th>
  <th class='th2 tip' title='".get_lang($lang, 'ad336')."'>-> TEMP</th>
  <th class='th4 tip' title='".get_lang($lang, 'ad337')."'><- TEMP</th>
  <th class='tip' title='".get_lang($lang, 'inter78')."'>MODE</th>
  <th class='tip' title='".get_lang($lang, 'ad325')."'>VENT STEP</th>
  <th class='tip_' title='".get_lang($lang, 'ad325')."'>VENT</th>  
  <th class='tip_' title='".get_lang($lang, 'ad326')." ".get_lang($lang, 'ad335')."'>E COLD</th>
  <th class='tip_' title='".get_lang($lang, 'ad326')." ".get_lang($lang, 'ad334')."'>E HOT</th>
  </tr></thead>
  <tfoot><tr>
  <th class='tip' title='".get_lang($lang, 'td4')."'>INV</th>
  <th class='tip' title='".get_lang($lang, 'info6')."'>DATE</th>
  <th class='tip' title='".get_lang($lang, 'inter72')."'>TIME</th>
  <th class='th1 tip' title='".get_lang($lang, 'egi05')."'>OUT TEMP</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad324')."'>TEMP</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad280')."'>SET POINT</th>
  <th class='th2 tip' title='".get_lang($lang, 'ad336')."'>-> TEMP</th>
  <th class='th4 tip' title='".get_lang($lang, 'ad337')."'><- TEMP</th>
  <th class='tip' title='".get_lang($lang, 'inter78')."'>MODE</th>
  <th class='tip' title='".get_lang($lang, 'ad325')."'>VENT STEP</th>
  <th class='tip_' title='".get_lang($lang, 'ad325')."'>VENT</th>  
  <th class='tip_' title='".get_lang($lang, 'ad326')." ".get_lang($lang, 'ad335')."'>E COLD</th>
  <th class='tip_' title='".get_lang($lang, 'ad326')." ".get_lang($lang, 'ad334')."'>E HOT</th>
  </tr></tfoot><tbody>\n";
function table($dev,$kline,$lang,$i) {
    $co_r = ('<font color=#d50000>');
    $co_o = ('<font color=#d96c00>');
    $co_g = ('<font color=#008040>');
	$co_p = ('<font color=#d5006a>');
	$co_b = ('<font color=#006bd7>');
	$co_y = ('<font color=#bfa302>');
	$co_w = ('<font color=#666666>');		
	$co_l = ('<font color=#FF5500>');
	
	$d0 = $dev[0];//id//inv
	$d1 = $dev[1];//date
	$d2 = $dev[2];//time
		  $tnow = strtotime($d2);
		  $tck1 = strtotime("+5 Minutes");
		  $tck2 = strtotime("-5 Minutes");
          if (($tnow<$tck2) || ($tnow>$tck1)) { $d2 = $co_r . $d2 . '</font>'; } else { $d2 = $d2; }	
	$d3 = $dev[3]/10;//outside temp
	$d4 = $dev[4]/10;//inside temp
	$d5 = $dev[5]/10;//set point temp
	$d6 = $dev[6]/10;///entrance temp
	$d7 = $dev[7]/10;//outrance temp
	$d8 = $dev[8];//mode
	$d9 = $dev[9];//set of the ventilation
	$d10 = $dev[10];//step
	$d11 = $dev[11]/10;//set point energy saving cold
	$d12 = $dev[12]/10;//set point energy saving hot

	if ($d3 > 45) { $d3 = 'NULL'; }
	if (($d4 > 35) || ($d4 < 15)) { $d4 = 'NULL'; }
	if (($d5 > 35) || ($d5 < 15)) { $d5 = 'NULL'; }
	if (($d6 > 35) || ($d6 < 10)) { $d6 = 'NULL'; }
	if (($d7 > 35) || ($d7 < 15)) { $d7 = 'NULL'; }
	if (($d8 > 15) || ($d8 < 0)) { $d8 = 0; }
	if (($d9 > 5) || ($d9 < 0)) { $d9 = 0; }
	if (($d10 > 5) || ($d10 < 0)) { $d10 = 0; }
	if (($d11 > 30) || ($d11 < 15)) { $d11 = 'NULL'; }
	if (($d12 > 30) || ($d12 < 15)) { $d12 = 'NULL'; }	
    if ($i=='d') { echo "<tr class='d'>\n"; } else { echo "<tr class='l'>\n"; }
    echo "<td>".$d0."</td>";
    echo "<td>".$d1."</td>";
    echo "<td>".$d2."</td>";
    echo "<td>".$d3."</td>";
    echo "<td>".$d4."</td>";
    echo "<td>".$d5."</td>";
    echo "<td>".$d6."</td>";
    echo "<td>".$d7."</td>";
    echo "<td>".$d8."</td>";
    echo "<td>".$d9."</td>";
    echo "<td>".$d10."</td>";
    echo "<td>".$d11."</td>";
    echo "<td>".$d12."</td>";
    echo "</tr>";
}
if(!($dev0501 == NULL)) { $i='d'; $dev0501d = explode(" ", $dev0501); table($dev0501d,$kline,$lang,$i);}
if(!($dev0502 == NULL)) { $i='l'; $dev0502d = explode(" ", $dev0502); table($dev0502d,$kline,$lang,$i);}
if(!($dev0503 == NULL)) { $i='d'; $dev0503d = explode(" ", $dev0503); table($dev0503d,$kline,$lang,$i);}
if(!($dev0504 == NULL)) { $i='l'; $dev0504d = explode(" ", $dev0504); table($dev0504d,$kline,$lang,$i);}
if(!($dev0505 == NULL)) { $i='d'; $dev0505d = explode(" ", $dev0505); table($dev0505d,$kline,$lang,$i);}
if(!($dev0506 == NULL)) { $i='l'; $dev0506d = explode(" ", $dev0506); table($dev0506d,$kline,$lang,$i);}
if(!($dev0507 == NULL)) { $i='d'; $dev0507d = explode(" ", $dev0507); table($dev0507d,$kline,$lang,$i);}
if(!($dev0508 == NULL)) { $i='l'; $dev0508d = explode(" ", $dev0508); table($dev0508d,$kline,$lang,$i);}
if(!($dev0509 == NULL)) { $i='d'; $dev0509d = explode(" ", $dev0509); table($dev0509d,$kline,$lang,$i);}
echo "</tbody></table>";
?>