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
include('includes/klimatik_functions.php');
echo "
  <table class='data $site_theme'>
  <caption>". get_lang($lang, 'Updated_at') . " " . $updated. "</caption>
  <thead><tr>
  <th class='tip' title='".get_lang($lang, 'Settings')."'>SET</th>
  <th class='tip' title='".get_lang($lang, 'ad333')."'>VIEW</th>
  <th class='tip' title='".get_lang($lang, 'td2')."'>GRA</th>
  <th class='tip' title='".get_lang($lang, 'ad322')."'>INF</th>
  <th class='tip' title='".get_lang($lang, 'td4')."'>INV</th>
  <th class='tip' title='".get_lang($lang, 'info6')."'>DATE</th>
  <th class='tip' title='".get_lang($lang, 'inter72')."'>TIME</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad452')."'>oUT U t</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad324')."'>TEMP</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad280')."'>SET POINT</th>
  <th class='th2 tip' title='".get_lang($lang, 'ad336')."'>-> TEMP</th>
  <th class='th4 tip' title='".get_lang($lang, 'ad337')."'>&lt;- TEMP</th>
  <th class='tip' title='".get_lang($lang, 'inter78')."'>MODE</th>
  <th class='tip' title='".get_lang($lang, 'ad446')."'>STEP</th>
  <th class='tip_' title='".get_lang($lang, 'ad325')."'>VENT</th>  
  <th class='tip_' title='".get_lang($lang, 'ad326')." ".get_lang($lang, 'ad335')."'>E COLD</th>
  <th class='tip_' title='".get_lang($lang, 'ad326')." ".get_lang($lang, 'ad334')."'>E HOT</th>
  <th class='tip_' title='".get_lang($lang, 'Status')."'>S</th>
  </tr></thead>
  <tfoot><tr>
  <th class='tip' title='".get_lang($lang, 'Settings')."'>SET</th>
  <th class='tip' title='".get_lang($lang, 'ad333')."'>VIEW</th>
  <th class='tip' title='".get_lang($lang, 'td2')."'>GRA</th>
  <th class='tip' title='".get_lang($lang, 'ad322')."'>INF</th>
  <th class='tip' title='".get_lang($lang, 'td4')."'>INV</th>
  <th class='tip' title='".get_lang($lang, 'info6')."'>DATE</th>
  <th class='tip' title='".get_lang($lang, 'inter72')."'>TIME</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad452')."'>oUT U t</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad324')."'>TEMP</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad280')."'>SET POINT</th>
  <th class='th2 tip' title='".get_lang($lang, 'ad336')."'>-> TEMP</th>
  <th class='th4 tip' title='".get_lang($lang, 'ad337')."'>&lt;- TEMP</th>
  <th class='tip' title='".get_lang($lang, 'inter78')."'>MODE</th>
  <th class='tip' title='".get_lang($lang, 'ad446')."'>STEP</th>
  <th class='tip_' title='".get_lang($lang, 'ad325')."'>VENT</th>  
  <th class='tip_' title='".get_lang($lang, 'ad326')." ".get_lang($lang, 'ad335')."'>E COLD</th>
  <th class='tip_' title='".get_lang($lang, 'ad326')." ".get_lang($lang, 'ad334')."'>E HOT</th>
  <th class='tip_' title='".get_lang($lang, 'Status')."'>S</th>
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
	$co_v = ('<font color=#0da2f2>');
	
	$d0 = $dev[0];//id//inv
	$d1 = $dev[1];//date
	$d2 = $dev[2];//time
		  $tnow = strtotime($d2);
		  $tck1 = strtotime("+5 Minutes");
		  $tck2 = strtotime("-5 Minutes");
          if (($tnow<$tck2) || ($tnow>$tck1)) { $d2 = $co_r . $d2 . '</font>'; } else { $d2 = $d2; }	
	$d3 = ($dev[3]*256+$dev[4])/10;//outside temp
	
	$d4 = ($dev[5]*256+$dev[6])/10;//inside temp
	$d5 = ($dev[7]*256+$dev[8])/10;//set point temp
	$d6 = ($dev[9]*256+$dev[10])/10;///entrance temp
	$d7 = ($dev[11]*256+$dev[12])/10;//outrance temp
	$d8 = $dev[13]*256+$dev[14];//mode
	$d9 = $dev[15]*256+$dev[16];//set of the ventilation
	$d10 = $dev[17]*256+$dev[18];//step
	$d11 = ($dev[19]*256+$dev[20])/10;//set point energy saving cold
	$d12 = ($dev[21]*256+$dev[22])/10;//set point energy saving hot

	if ($dev[3] == 255) { $d31 = ((255-$dev[3]) * 256 + (255-$dev[4]+1))/-10; $d3 = number_format($d31,1); }
	
	//$d3 = ($d3*256+$d4)/10;//outside temp
	
	if (($d4 > 35) || ($d4 < 15)) { $d4 = 'NULL'; }
	if (($d5 > 35) || ($d5 < 15)) { $d5 = 'NULL'; }
	if (($d6 > 35) || ($d6 < 10)) { $d6 = 'NULL'; }
	if (($d7 > 35) || ($d7 < 15)) { $d7 = 'NULL'; }
	//if (($d8 > 12) || ($d8 < 1)) { $d8 = 0; }
	//led
	if (($d8 < 8) && ($d8 > 0)) { 
	    $led = 'off'; $ledt = get_lang($lang, 'Off'); 
		$setpath = "setup/klimatik_setup.php?inv=$d0&lang=$lang&line=$kline&sys=klimatik";
		$c = ''; 
	} 
	elseif (($d8 < 13) && ($d8 > 8)) { 
	    $led = 'on'; $ledt = get_lang($lang, 'On'); 
	    $setpath = "setup/klimatik_setup.php?inv=$d0&lang=$lang&line=$kline&sys=klimatik";
		$c = '';
	}
	else { $led = 'err'; $ledt = get_lang($lang, '1052'); /*$setpath = "javascript:void(0);"; $c = 'style=color:#dddddd;';*/
	$setpath = "setup/klimatik_setup.php?inv=$d0&lang=$lang&line=$kline&sys=klimatik"; }
	//led end
	//if (($d9 > 3) || ($d9 < 0)) { $d9 = 0; }
	//if (($d10 > 3) || ($d10 < 0)) { $d10 = 0; }
	if (($d11 > 30) || ($d11 < 15)) { $d11 = 'NULL'; }
	if (($d12 > 30) || ($d12 < 15)) { $d12 = 'NULL'; }	
	$viewpath = "klimatik_ext.php?inv=$d0&lang=$lang&kline=$kline";
	$chartpath = "klimatik_charts.php?inv=$d0&lang=$lang&kline=$kline";
	$infopath = "klimatik_info.php?inv=$d0&lang=$lang&kline=$kline";	
    if ($i=='d') { echo "<tr class='d'>\n"; } else { echo "<tr class='l'>\n"; }
    echo "<td><a href=\"".$setpath."\"><i class=\"fa fa-cog icon-t\" ".$c."></i></a></td>";
    echo "<td><a href=\"".$viewpath."\"><i class=\"fa fa-eye icon-t\"></i></a></td>";	
    echo "<td><a href=\"".$chartpath."\"><i class=\"fa fa-bar-chart-o icon-t\"></i></a></td>";
    echo "<td><a href=\"".$infopath."\"><i class=\"fa fa-info-circle icon-t\"></i></a></td>";
    echo "<td>".$d0."</td>";
    echo "<td>".$d1."</td>";
    echo "<td>".$d2."</td>";
    echo "<td>".$d3."</td>";
    echo "<td>".$d4."</td>";
	//set point
	if (($d5 != 'NULL') && ($d5 > "15")) {
		echo "<td>".$co_g.$d5."</font></td>";
	} else {
	    echo "<td>".$d5."</td>";	
	}
	//end set point
    echo "<td>".$d6."</td>";
    echo "<td>".$d7."</td>";
	//mode
	/*
	if ($d8 == "1") {
		echo "<td class=\"tip\" title=\"".get_lang($lang, 'ad330')." - ".get_lang($lang, 'Off')."\">".$co_b.$d8."</font></td>";
	} elseif ($d8 == "9") {
		echo "<td class=\"tip\" title=\"".get_lang($lang, 'ad330')." - ".get_lang($lang, 'On')."\">".$co_b.$d8."</font></td>";
	} elseif ($d8 == "2") {
		echo "<td class=\"tip\" title=\"".get_lang($lang, 'ad328')." - ".get_lang($lang, 'Off')."\">".$co_v.$d8."</font></td>";
	} elseif ($d8 == "10") {
		echo "<td class=\"tip\" title=\"".get_lang($lang, 'ad328')." - ".get_lang($lang, 'On')."\">".$co_v.$d8."</font></td>";
	} elseif ($d8 == "3") {
		echo "<td class=\"tip\" title=\"".get_lang($lang, 'ad331')." - ".get_lang($lang, 'Off')."\">".$co_g.$d8."</font></td>";
	} elseif ($d8 == "11") {
		echo "<td class=\"tip\" title=\"".get_lang($lang, 'ad331')." - ".get_lang($lang, 'On')."\">".$co_g.$d8."</font></td>";
	} elseif ($d8 == "4") {
		echo "<td class=\"tip\" title=\"".get_lang($lang, 'ad329')." - ".get_lang($lang, 'Off')."\">".$co_r.$d8."</font></td>";
	} elseif ($d8 == "12") {
		echo "<td class=\"tip\" title=\"".get_lang($lang, 'ad329')." - ".get_lang($lang, 'On')."\">".$co_r.$d8."</font></td>";
	} elseif ($d8 == "0") {
        echo "<td class=\"tip\" title=\"".get_lang($lang, 'ad445')."\">".$d8."</td>";
	} else {*/
		echo "<td>".$d8."</td>";
	//}
	//end mode
    echo "<td>".$d9."</td>";
    echo "<td>".$d10."</td>";
    echo "<td>".$d11."</td>";
    echo "<td>".$d12."</td>";
	echo "<td class=\"lamp tip_\" title=\"".$ledt."\"><span class=\"".$led."\"></span></td>";
    echo "</tr>";
}
if(!($dev0101 == NULL)) { $i='d'; $dev0101d = explode(" ", $dev0101); table($dev0101d,$kline,$lang,$i);}
if(!($dev0102 == NULL)) { $i='l'; $dev0102d = explode(" ", $dev0102); table($dev0102d,$kline,$lang,$i);}
if(!($dev0103 == NULL)) { $i='d'; $dev0103d = explode(" ", $dev0103); table($dev0103d,$kline,$lang,$i);}
if(!($dev0104 == NULL)) { $i='l'; $dev0104d = explode(" ", $dev0104); table($dev0104d,$kline,$lang,$i);}
if(!($dev0105 == NULL)) { $i='d'; $dev0105d = explode(" ", $dev0105); table($dev0105d,$kline,$lang,$i);}
if(!($dev0106 == NULL)) { $i='l'; $dev0106d = explode(" ", $dev0106); table($dev0106d,$kline,$lang,$i);}

if(!($dev0201 == NULL)) { $i='d'; $dev0201d = explode(" ", $dev0201); table($dev0201d,$kline,$lang,$i);}
if(!($dev0202 == NULL)) { $i='l'; $dev0202d = explode(" ", $dev0202); table($dev0202d,$kline,$lang,$i);}
if(!($dev0203 == NULL)) { $i='d'; $dev0203d = explode(" ", $dev0203); table($dev0203d,$kline,$lang,$i);}
if(!($dev0204 == NULL)) { $i='l'; $dev0204d = explode(" ", $dev0204); table($dev0204d,$kline,$lang,$i);}
if(!($dev0205 == NULL)) { $i='d'; $dev0205d = explode(" ", $dev0205); table($dev0205d,$kline,$lang,$i);}
if(!($dev0206 == NULL)) { $i='l'; $dev0206d = explode(" ", $dev0206); table($dev0206d,$kline,$lang,$i);}

if(!($dev0301 == NULL)) { $i='d'; $dev0301d = explode(" ", $dev0301); table($dev0301d,$kline,$lang,$i);}
if(!($dev0302 == NULL)) { $i='l'; $dev0302d = explode(" ", $dev0302); table($dev0302d,$kline,$lang,$i);}
if(!($dev0303 == NULL)) { $i='d'; $dev0303d = explode(" ", $dev0303); table($dev0303d,$kline,$lang,$i);}
if(!($dev0304 == NULL)) { $i='l'; $dev0304d = explode(" ", $dev0304); table($dev0304d,$kline,$lang,$i);}
if(!($dev0305 == NULL)) { $i='d'; $dev0305d = explode(" ", $dev0305); table($dev0305d,$kline,$lang,$i);}
if(!($dev0306 == NULL)) { $i='l'; $dev0306d = explode(" ", $dev0306); table($dev0306d,$kline,$lang,$i);}

if(!($dev0401 == NULL)) { $i='d'; $dev0401d = explode(" ", $dev0401); table($dev0401d,$kline,$lang,$i);}
if(!($dev0402 == NULL)) { $i='l'; $dev0402d = explode(" ", $dev0402); table($dev0402d,$kline,$lang,$i);}
if(!($dev0403 == NULL)) { $i='d'; $dev0403d = explode(" ", $dev0403); table($dev0403d,$kline,$lang,$i);}
if(!($dev0404 == NULL)) { $i='l'; $dev0404d = explode(" ", $dev0404); table($dev0404d,$kline,$lang,$i);}
if(!($dev0405 == NULL)) { $i='d'; $dev0405d = explode(" ", $dev0405); table($dev0405d,$kline,$lang,$i);}
if(!($dev0406 == NULL)) { $i='l'; $dev0406d = explode(" ", $dev0406); table($dev0406d,$kline,$lang,$i);}

if(!($dev0501 == NULL)) { $i='d'; $dev0501d = explode(" ", $dev0501); table($dev0501d,$kline,$lang,$i);}
if(!($dev0502 == NULL)) { $i='l'; $dev0502d = explode(" ", $dev0502); table($dev0502d,$kline,$lang,$i);}
if(!($dev0503 == NULL)) { $i='d'; $dev0503d = explode(" ", $dev0503); table($dev0503d,$kline,$lang,$i);}
if(!($dev0504 == NULL)) { $i='l'; $dev0504d = explode(" ", $dev0504); table($dev0504d,$kline,$lang,$i);}
if(!($dev0505 == NULL)) { $i='d'; $dev0505d = explode(" ", $dev0505); table($dev0505d,$kline,$lang,$i);}
if(!($dev0506 == NULL)) { $i='l'; $dev0506d = explode(" ", $dev0506); table($dev0506d,$kline,$lang,$i);}

if(!($dev0601 == NULL)) { $i='d'; $dev0601d = explode(" ", $dev0601); table($dev0601d,$kline,$lang,$i);}
if(!($dev0602 == NULL)) { $i='l'; $dev0602d = explode(" ", $dev0602); table($dev0602d,$kline,$lang,$i);}
if(!($dev0603 == NULL)) { $i='d'; $dev0603d = explode(" ", $dev0603); table($dev0603d,$kline,$lang,$i);}
if(!($dev0604 == NULL)) { $i='l'; $dev0604d = explode(" ", $dev0604); table($dev0604d,$kline,$lang,$i);}
if(!($dev0605 == NULL)) { $i='d'; $dev0605d = explode(" ", $dev0605); table($dev0605d,$kline,$lang,$i);}
if(!($dev0606 == NULL)) { $i='l'; $dev0606d = explode(" ", $dev0606); table($dev0606d,$kline,$lang,$i);}

echo "</tbody></table>";
?>