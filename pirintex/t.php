<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = mysql_prep($_GET['line']);
$l = mysql_prep($_GET['l']);
$line_options = get_line_options($line);
$datafile = "data/{$line_options['data_file']}";
$ala = $line_options['alarm'];
$red = $line_options['red'];
$ex_red = $line_options['ex_red'];
$ex_red = explode(',', $ex_red);
$ex_alarm = $line_options['ex_alarm'];
$ex_alarm = explode(',', $ex_alarm);
$ex_table = $line_options['ex_table'];
$ex_table = explode(',', $ex_table);
$updated = date('H:i:s');
$ip = $line_options['ip_address'];
$port = $line_options['port'];
if ($datafile == NULL) { get_error($lang,'1002'); exit; }
if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
include("$datafile");
if (filesize($datafile)<100) { get_error($lang,'1004'); exit; }
echo "<script type='text/javascript' src='js/table.js'></script>";
include('includes/table_style.php');
include('includes/socket.php');
include('includes/table_functions.php');
echo "
  <table class='data $site_theme'>
  <caption>". get_lang($lang, 'Updated_at') . " " . $updated. "</caption>
  <thead><tr>
  <th id='hfp' class='tip' title='". get_lang($lang, 'td1') ."'>SET</th>
  <th id='hfp' class='tip' title='". get_lang($lang, 'td2') ."'>GRA</th>
  <th id='hfp' class='tip' title='". get_lang($lang, 'td3') ."'>INF</th>
  <th class='tip' title='". get_lang($lang, 'td4') ."'>INV</th>
  <th class='tip' title='". get_lang($lang, 'td5') ."'>ID</th>
  <th class='tip' title='". get_lang($lang, 'td6') ."'>TIME</th>
  <th class='tip' title='". get_lang($lang, 'td7') ."'>DATE</th>
  <th class='tip' title='". get_lang($lang, 'td8') ."'>Tht</th>
  <th class='th2 tip' title='". get_lang($lang, 'td9') ."'>Tr1</th>
  <th class='th2 tip' title='". get_lang($lang, 'td10') ."'>Tr2</th>
  <th class='th2 tip' title='". get_lang($lang, 'td11') ."'>Tr3</th>
  <th class='th2 tip' title='". get_lang($lang, 'td12') ."'>Tr4</th>
  <th class='th2 tip' title='". get_lang($lang, 'td13') ."'>Tr5</th>
  <th class='th2 tip' title='". get_lang($lang, 'td14') ."'>Tr6</th>
  <th class='tip' title='". get_lang($lang, 'td15') ."'>His</th>
  <th class='tip' title='". get_lang($lang, 'td16') ."'>Tok</th>
  <th class='tip' title='". get_lang($lang, 'td17') ."'>MD</th>
  <th class='th1 tip' title='". get_lang($lang, 'td18') ."'>Tk1</th>
  <th class='th1 tip' title='". get_lang($lang, 'td19') ."'>Tk2</th>
  <th class='th1 tip' title='". get_lang($lang, 'td20') ."'>Tk3</th>
  <th class='th1 tip' title='". get_lang($lang, 'td21') ."'>Tk4</th>
  <th class='th1 tip' title='". get_lang($lang, 'td22') ."'>Tk5</th>
  <th class='th1 tip' title='". get_lang($lang, 'td23') ."'>Tk6</th>
  <th class='th3 tip_' title='". get_lang($lang, 'td24') ."'>Tf1</th>
  <th class='th3 tip_' title='". get_lang($lang, 'td25') ."'>Tf2</th>
  <th class='tip_' title='". get_lang($lang, 'td26') ."'>RG</th>
  <th class='tip_' title='". get_lang($lang, 'td27') ."'>ST</th>
  </tr></thead>
  <tfoot><tr>
  <th id='hfp' class='tip' title='". get_lang($lang, 'td1') ."'>SET</th>
  <th id='hfp' class='tip' title='". get_lang($lang, 'td2') ."'>GRA</th>
  <th id='hfp' class='tip' title='". get_lang($lang, 'td3') ."'>INF</th>
  <th class='tip' title='". get_lang($lang, 'td4') ."'>INV</th>
  <th class='tip' title='". get_lang($lang, 'td5') ."'>ID</th>
  <th class='tip' title='". get_lang($lang, 'td6') ."'>TIME</th>
  <th class='tip' title='". get_lang($lang, 'td7') ."'>DATE</th>
  <th class='tip' title='". get_lang($lang, 'td8') ."'>Tht</th>
  <th class='th2 tip' title='". get_lang($lang, 'td9') ."'>Tr1</th>
  <th class='th2 tip' title='". get_lang($lang, 'td10') ."'>Tr2</th>
  <th class='th2 tip' title='". get_lang($lang, 'td11') ."'>Tr3</th>
  <th class='th2 tip' title='". get_lang($lang, 'td12') ."'>Tr4</th>
  <th class='th2 tip' title='". get_lang($lang, 'td13') ."'>Tr5</th>
  <th class='th2 tip' title='". get_lang($lang, 'td14') ."'>Tr6</th>
  <th class='tip' title='". get_lang($lang, 'td15') ."'>His</th>
  <th class='tip' title='". get_lang($lang, 'td16') ."'>Tok</th>
  <th class='tip' title='". get_lang($lang, 'td17') ."'>MD</th>
  <th class='th1 tip' title='". get_lang($lang, 'td18') ."'>Tk1</th>
  <th class='th1 tip' title='". get_lang($lang, 'td19') ."'>Tk2</th>
  <th class='th1 tip' title='". get_lang($lang, 'td20') ."'>Tk3</th>
  <th class='th1 tip' title='". get_lang($lang, 'td21') ."'>Tk4</th>
  <th class='th1 tip' title='". get_lang($lang, 'td22') ."'>Tk5</th>
  <th class='th1 tip' title='". get_lang($lang, 'td23') ."'>Tk6</th>
  <th class='th3 tip_' title='". get_lang($lang, 'td24') ."'>Tf1</th>
  <th class='th3 tip_' title='". get_lang($lang, 'td25') ."'>Tf2</th>
  <th class='tip_' title='". get_lang($lang, 'td26') ."'>RG</th>
  <th class='tip_' title='". get_lang($lang, 'td27') ."'>ST</th>
  </tr></tfoot><tbody>\n";
function table($dev,$line,$lang,$i,$red,$ala,$ex,$ex2,$ip,$port,$ex3) {
	$x=0;
    if(!($dev == NULL)) {
    $co_r = ('<font color=#d50000>');
    $co_o = ('<font color=#d96c00>');
    $co_g = ('<font color=#008040>');
	$co_p = ('<font color=#d5006a>');
	$co_b = ('<font color=#006bd7>');
	$co_y = ('<font color=#bfa302>');
	$co_w = ('<font color=#666666>');		
	$co_l = ('<font color=#FF5500>');		 
	$mi1 = 75; 
	$mi2 = 29;
	$chartpat = "controller_charts.php?inv=$dev[1]&id=$dev[0]&lang=$lang&line=$line";
	$infopat = "controller_info.php?inv=$dev[1]&lang=$lang&line=$line";
    if (!in_array($dev[1], $ex3)) {
	if ($i=='d') { echo "<tr class='d'>\n"; } else { echo "<tr class='l'>\n"; }
    echo "<td><a href='setup/setup.php?inv=$dev[1]&id=$dev[0]&line=$line&sys=t'>
	          <i class='fa fa-cog icon-t'></i></a></td>
          <td><a href='$chartpat'><i class='fa fa-bar-chart-o icon-t'></i></a></td>
          <td><a href='$infopat'><i class='fa fa-info-circle icon-t'></i></a></td>";
		  //$cinv = get_check_controller_db($line,$dev[1]);
    //if ($cinv == NULL) { echo "<td class='tip' title='".get_lang($lang,'td49')."'>$co_r $dev[1]</td>"; } else { echo "<td>$dev[1]</td>"; }
	echo "<td>$dev[1]</td>
          <td>$dev[0]</td>";
		  $tnow = strtotime($dev[2]);
		  $tck1 = strtotime("+5 Minutes");
		  $tck2 = strtotime("-5 Minutes");
          if (($tnow<$tck2) || ($tnow>$tck1)) { $tcheck = $co_r . $dev[2]; set_time($line,$dev[0],$ip,$port); } else { $tcheck = $dev[2]; }	  
          echo "<td>$tcheck</td>";
          $today = date("j/n/Y"); 
		  $check = $dev[3];
          if ($check != $today) { $check2 = $co_r . $dev[3]; } else { $check2 = $dev[3]; } 	 
		  echo "<td>$check2</td>
          <td> $dev[7] </td>
          <td class='td2'>$dev[10]</td>
          <td class='td2'>$dev[11]</td>
          <td class='td2'>$dev[12]</td>
          <td class='td2'>$dev[13]</td>
          <td class='td2'>$dev[14]</td>
          <td class='td2'>$dev[15]</td>
          <td>$dev[4]</td>
          <td>$dev[5]</td>";
		  if (($dev[6] == '0') && ($dev[9] != 'OFF') && ($dev[7] < '90')) {
		      echo "<td class='tip' title='".get_lang($lang,'td35')."'>$co_p $dev[6]</td>";
              zero($line,$dev[0],$dev[1],$dev[10],$dev[11],$dev[12],$dev[13],$dev[14],$dev[15],$dev[16],$dev[17],$dev[18],$dev[19],$dev[20],$dev[21],$dev[4],$dev[5],$dev[7],$ip,$port);
          } else {
		  	$md = get_controller_mode($line,$dev[1]);
			if (($dev[6] != $md) && ($md != NULL) && ($dev[6] != '0')) {
				echo "<td class='tip' title='".get_lang($lang,'td50')."'>$co_r $dev[6]</td>";
			} else {
				echo "<td class='tip' title='".get_lang($lang,'td17')."'>$dev[6]</td>";
			}
		  }
    //tk1 ===========================================================================================================
    if (($dev[16] > $dev[10] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[16] > 165) && ($dev[16] < 255)) { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[16]</td>"; }
		elseif ($dev[16] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[16]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[16]</td>"; } 
	} 
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 0) && ($dev[16] < $mi1) && ($dev[16] > $mi2) && !in_array($dev[1], $ex2)))) { 
	    if ($dev[9] == 'LT') {
			echo "<td class='tip' title='".get_lang($lang,'td28')."'>$co_o $dev[16]</td>";
		}
	    elseif ($dev[9] == '1') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 1'>$co_b $dev[16]</td>";
		}
	    elseif ($dev[9] == '2') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 2'>$co_b $dev[16]</td>";
		}
	     else {
		    echo "<td class='tip' title='".get_lang($lang,'td33')."'><u>$co_l $dev[16]</u></td>";	
		} 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 0) && ($dev[16] < 8) && ($dev[16] > 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[16]</td>";
		sensor_verification($line,$dev[0],$dev[10],$dev[11],$dev[12],$dev[13],$dev[14],$dev[15],$dev[4],$dev[5],$dev[6],$dev[7],$ip,$port);
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 0) && ($dev[16] == 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[16]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 0) && ($dev[16] < $mi1) && ($dev[16] > 19) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[16]</td>"; 
	}
	elseif (($dev[6] < 6) && ($dev[16] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[16]</td>"; }
	elseif (($dev[6] < 6) && ($dev[16] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[16]</td>"; }
	elseif (($dev[6] == 0) && ($dev[9] != 'OFF') && ($dev[16] < 8)) { echo "<td class='td1 tip' title='".get_lang($lang,'td35')."'>$co_p $dev[16]</td>"; }
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[16]</td>"; }
	//tk2================================================================================================================================
    if (($dev[17] > $dev[11] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[17] > 165) && ($dev[17] < 255))  { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[17]</td>"; }
		elseif ($dev[17] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[17]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[17]</td>"; } 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 1) && ($dev[17] < $mi1) && ($dev[17] > $mi2) && !in_array($dev[1], $ex2)))) { 
	    if ($dev[9] == 'LT') {
			echo "<td class='tip' title='".get_lang($lang,'td28')."'>$co_o $dev[17]</td>";
		}
	    elseif ($dev[9] == '1') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 1'>$co_b $dev[17]</td>";
		}
	    elseif ($dev[9] == '2') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 2'>$co_b $dev[17]</td>";
		}
	     else {
		    echo "<td class='tip' title='".get_lang($lang,'td33')."'><u>$co_l $dev[17]</u></td>";	
		} 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 1) && ($dev[17] < 8) && ($dev[17] > 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[17]</td>"; 
		sensor_verification($line,$dev[0],$dev[10],$dev[11],$dev[12],$dev[13],$dev[14],$dev[15],$dev[4],$dev[5],$dev[6],$dev[7],$ip,$port);
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 1) && ($dev[17] == 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[17]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 1) && ($dev[17] < $mi1) && ($dev[17] > 19) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[17]</td>"; 
	}	
	elseif (($dev[6] < 6) && ($dev[17] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[17]</td>"; }
	elseif (($dev[6] < 6) && ($dev[17] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[17]</td>"; }
	elseif (($dev[6] == 0) && ($dev[9] != 'OFF') && ($dev[17] < 8)) { echo "<td class='td1 tip' title='".get_lang($lang,'td35')."'>$co_p $dev[17]</td>"; }
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[17]</td>"; }
	//tk3==============================================================================================================================
    if (($dev[18] > $dev[12] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[18] > 165) && ($dev[18] < 255)) { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[18]</td>"; }
		elseif ($dev[18] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[18]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[18]</td>"; } 
	} 
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 2) && ($dev[18] < $mi1) && ($dev[18] > $mi2) && !in_array($dev[1], $ex2)))) { 
	    if ($dev[9] == 'LT') {
			echo "<td class='tip' title='".get_lang($lang,'td28')."'>$co_o $dev[18]</td>";
		}
	    elseif ($dev[9] == '1') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 1'>$co_b $dev[18]</td>";
		}
	    elseif ($dev[9] == '2') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 2'>$co_b $dev[18]</td>";
		}
	     else {
		    echo "<td class='tip' title='".get_lang($lang,'td33')."'><u>$co_l $dev[18]</u></td>";	
		} 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 2) && ($dev[18] < 8) && ($dev[18] > 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[18]</td>"; 
		sensor_verification($line,$dev[0],$dev[10],$dev[11],$dev[12],$dev[13],$dev[14],$dev[15],$dev[4],$dev[5],$dev[6],$dev[7],$ip,$port);
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 2) && ($dev[18] == 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[18]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 2) && ($dev[18] < $mi1) && ($dev[18] > 19) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[18]</td>"; 
	}
	elseif (($dev[6] < 6) && ($dev[18] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[18]</td>"; }
	elseif (($dev[6] < 6) && ($dev[18] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[18]</td>"; }
	elseif (($dev[6] == 0) && ($dev[9] != 'OFF') && ($dev[18] < 8)) { echo "<td class='td1 tip' title='".get_lang($lang,'td35')."'>$co_p $dev[18]</td>"; }
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[18]</td>"; }
	//tk4===============================================================================================================================
    if (($dev[19] > $dev[13] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[19] > 165) && ($dev[19] < 255)) { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[19]</td>"; }
		elseif ($dev[19] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[19]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[19]</td>"; } 
	}  
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 3) && ($dev[19] < $mi1) && ($dev[19] > $mi2) && !in_array($dev[1], $ex2)))) { 
	    if ($dev[9] == 'LT') {
			echo "<td class='tip' title='".get_lang($lang,'td28')."'>$co_o $dev[19]</td>";
		}
	    elseif ($dev[9] == '1') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 1'>$co_b $dev[19]</td>";
		}
	    elseif ($dev[9] == '2') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 2'>$co_b $dev[19]</td>";
		}
	     else {
		    echo "<td class='tip' title='".get_lang($lang,'td33')."'><u>$co_l $dev[19]</u></td>";	
		} 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 3) && ($dev[19] < 8) && ($dev[19] > 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[19]</td>"; 
		sensor_verification($line,$dev[0],$dev[10],$dev[11],$dev[12],$dev[13],$dev[14],$dev[15],$dev[4],$dev[5],$dev[6],$dev[7],$ip,$port);
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 3) && ($dev[19] == 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[19]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 3) && ($dev[19] < $mi1) && ($dev[19] > 19) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[19]</td>"; 
	}
	elseif (($dev[6] < 6) && ($dev[19] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[19]</td>"; }
	elseif (($dev[6] < 6) && ($dev[19] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[19]</td>"; }
	elseif (($dev[6] == 0) && ($dev[9] != 'OFF') && ($dev[19] < 8)) { echo "<td class='td1 tip' title='".get_lang($lang,'td35')."'>$co_p $dev[19]</td>"; }
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[19]</td>"; }
	//tk5================================================================================================================================
    if (($dev[20] > $dev[14] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[20] > 165) && ($dev[20] < 255)) { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[20]</td>"; }
		elseif ($dev[20] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[20]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[20]</td>"; } 
	} 
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 4) && ($dev[20] < $mi1) && ($dev[20] > $mi2) && !in_array($dev[1], $ex2)))) { 
	    if ($dev[9] == 'LT') {
			echo "<td class='tip' title='".get_lang($lang,'td28')."'>$co_o $dev[20]</td>";
		}
	    elseif ($dev[9] == '1') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 1'>$co_b $dev[20]</td>";
		}
	    elseif ($dev[9] == '2') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 2'>$co_b $dev[20]</td>";
		}
	     else {
		    echo "<td class='tip' title='".get_lang($lang,'td33')."'><u>$co_l $dev[20]</u></td>";	
		} 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 4) && ($dev[20] < 8) && ($dev[20] > 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[20]</td>"; 
		sensor_verification($line,$dev[0],$dev[10],$dev[11],$dev[12],$dev[13],$dev[14],$dev[15],$dev[4],$dev[5],$dev[6],$dev[7],$ip,$port);
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 4) && ($dev[20] == 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[20]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 4) && ($dev[20] < $mi1) && ($dev[20] > 19) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[20]</td>"; 
	}
	elseif (($dev[6] < 6) && ($dev[20] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[20]</td>"; }
	elseif (($dev[6] < 6) && ($dev[20] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[20]</td>"; }
	elseif (($dev[6] == 0) && ($dev[9] != 'OFF') && ($dev[20] < 8)) { echo "<td class='td1 tip' title='".get_lang($lang,'td35')."'>$co_p $dev[20]</td>"; }
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[20]</td>"; }
	//tk6================================================================================================================================
    if (($dev[21] > $dev[15] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[21] > 165) && ($dev[21] < 255)) { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[21]</td>"; }
		elseif ($dev[21] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[21]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[21]</td>"; } 
	} 
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 5) && ($dev[21] < $mi1) && ($dev[21] > $mi2) && !in_array($dev[1], $ex2)))) { 
	    if ($dev[9] == 'LT') {
			echo "<td class='tip' title='".get_lang($lang,'td28')."'>$co_o $dev[21]</td>";
		}
	    elseif ($dev[9] == '1') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 1'>$co_b $dev[21]</td>";
		}
	    elseif ($dev[9] == '2') {
			echo "<td class='tip' title='".get_lang($lang,'td59')." 2'>$co_b $dev[21]</td>";
		}
	     else {
		    echo "<td class='tip' title='".get_lang($lang,'td33')."'><u>$co_l $dev[21]</u></td>";	
		} 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 5) && ($dev[21] < 8) && ($dev[21] > 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[21]</td>";
		sensor_verification($line,$dev[0],$dev[10],$dev[11],$dev[12],$dev[13],$dev[14],$dev[15],$dev[4],$dev[5],$dev[6],$dev[7],$ip,$port); 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 5) && ($dev[21] == 0) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[21]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 5) && ($dev[21] < $mi1) && ($dev[21] > 19) && !in_array($dev[1], $ex2)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[21]</td>"; 
	}
	elseif (($dev[6] < 6) && ($dev[21] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[21]</td>"; }
	elseif (($dev[6] < 6) && ($dev[21] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[21]</td>"; }
	elseif (($dev[6] == 0) && ($dev[9] != 'OFF') && ($dev[21] < 8)) { echo "<td class='td1 tip' title='".get_lang($lang,'td35')."'>$co_p $dev[21]</td>"; }
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[21]</td>"; }
    if (($dev[16] > $dev[10] + $ala) && ($dev[16] != 255) && !in_array($dev[1], $ex)) { insert_alarm("$line","$dev[1]","1","$dev[16]","$dev[10]"); }
    if (($dev[17] > $dev[11] + $ala) && ($dev[17] != 255) && !in_array($dev[1], $ex)) { insert_alarm("$line","$dev[1]","2","$dev[17]","$dev[11]"); }
    if (($dev[18] > $dev[12] + $ala) && ($dev[18] != 255) && !in_array($dev[1], $ex)) { insert_alarm("$line","$dev[1]","3","$dev[18]","$dev[12]"); }
    if (($dev[19] > $dev[13] + $ala) && ($dev[19] != 255) && !in_array($dev[1], $ex)) { insert_alarm("$line","$dev[1]","4","$dev[19]","$dev[13]"); }
    if (($dev[20] > $dev[14] + $ala) && ($dev[20] != 255) && !in_array($dev[1], $ex)) { insert_alarm("$line","$dev[1]","5","$dev[20]","$dev[14]"); }
    if (($dev[21] > $dev[15] + $ala) && ($dev[21] != 255) && !in_array($dev[1], $ex)) { insert_alarm("$line","$dev[1]","6","$dev[21]","$dev[15]"); }
	if ($dev[22] == 0) { echo "<td>$co_w $dev[22]</td>"; }
	elseif ($dev[22] == 255) { echo "<td>$co_w $dev[22]</td>"; }	
	else { echo "<td class='td1'> $dev[22]</td>"; }	
	if ($dev[23] == 0) { echo "<td>$co_w $dev[23]</td>"; }
	elseif ($dev[23] == 255) { echo "<td>$co_w $dev[23]</td>"; }
	else { echo "<td class='td1'>$dev[23]</td>"; }    
	$xrg = $dev[8]; 		  
    if ($xrg == 'OFF') { $xrg = '<td class="tip_" title="'.get_lang($lang,'td29').'">'.$co_r . $xrg.'</td>'; }
	elseif ($xrg == 'M') { $xrg = '<td class="tip_" title="'.get_lang($lang,'td30').'">'.$co_o . $xrg.'</td>'; }
	elseif ($xrg == 'A') { $xrg = '<td class="tip_" title="'.get_lang($lang,'td31').'">'.$co_g . $xrg.'</td>'; }		  
	else { $xrg = '<td>'.$co_g . $xrg.'</td>'; }
    echo "$xrg";
    $xst = $dev[9]; 		  
    if ($xst == 'OFF') { $xst = '<td class="tip_" title="'.get_lang($lang,'td29').'">'.$co_r . $xst.'</td>'; } 
    elseif ($xst == 'LT') { $xst = '<td class="tip_" title="'.get_lang($lang,'td28').'">'.$co_o . $xst.'</td>'; reset_($line,$dev[0],$ip,$port); } 
	elseif ($xst == '1') { $xst = '<td class="tip_" title="'.get_lang($lang,'td59').' 1">'.$co_b . $xst.'</td>'; }
	elseif ($xst == '2') { $xst = '<td class="tip_" title="'.get_lang($lang,'td59').' 2">'.$co_b . $xst.'</td>'; }
	else { $xst = '<td>'.$co_g . $xst.'</td>'; }
    echo "$xst</tr>\n";
    }
  }
}
if(!($dev0 == NULL)) { $i='d'; $dev0d = explode(" ", $dev0); table($dev0d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev1 == NULL)) { $i='l'; $dev1d = explode(" ", $dev1); table($dev1d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev2 == NULL)) { $i='d'; $dev2d = explode(" ", $dev2); table($dev2d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev3 == NULL)) { $i='l'; $dev3d = explode(" ", $dev3); table($dev3d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev4 == NULL)) { $i='d'; $dev4d = explode(" ", $dev4); table($dev4d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev5 == NULL)) { $i='l'; $dev5d = explode(" ", $dev5); table($dev5d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev6 == NULL)) { $i='d'; $dev6d = explode(" ", $dev6); table($dev6d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev7 == NULL)) { $i='l'; $dev7d = explode(" ", $dev7); table($dev7d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev8 == NULL)) { $i='d'; $dev8d = explode(" ", $dev8); table($dev8d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev9 == NULL)) { $i='l'; $dev9d = explode(" ", $dev9); table($dev9d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev10 == NULL)) { $i='d'; $dev10d = explode(" ", $dev10); table($dev10d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev11 == NULL)) { $i='l'; $dev11d = explode(" ", $dev11); table($dev11d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev12 == NULL)) { $i='d'; $dev12d = explode(" ", $dev12); table($dev12d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev13 == NULL)) { $i='l'; $dev13d = explode(" ", $dev13); table($dev13d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev14 == NULL)) { $i='d'; $dev14d = explode(" ", $dev14); table($dev14d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev15 == NULL)) { $i='l'; $dev15d = explode(" ", $dev15); table($dev15d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev16 == NULL)) { $i='d'; $dev16d = explode(" ", $dev16); table($dev16d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev17 == NULL)) { $i='l'; $dev17d = explode(" ", $dev17); table($dev17d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev18 == NULL)) { $i='d'; $dev18d = explode(" ", $dev18); table($dev18d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev19 == NULL)) { $i='l'; $dev19d = explode(" ", $dev19); table($dev19d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev20 == NULL)) { $i='d'; $dev20d = explode(" ", $dev20); table($dev20d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev21 == NULL)) { $i='l'; $dev21d = explode(" ", $dev21); table($dev21d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev22 == NULL)) { $i='d'; $dev22d = explode(" ", $dev22); table($dev22d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev23 == NULL)) { $i='l'; $dev23d = explode(" ", $dev23); table($dev23d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev24 == NULL)) { $i='d'; $dev24d = explode(" ", $dev24); table($dev24d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev25 == NULL)) { $i='l'; $dev25d = explode(" ", $dev25); table($dev25d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev26 == NULL)) { $i='d'; $dev26d = explode(" ", $dev26); table($dev26d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev27 == NULL)) { $i='l'; $dev27d = explode(" ", $dev27); table($dev27d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev28 == NULL)) { $i='d'; $dev28d = explode(" ", $dev28); table($dev28d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev29 == NULL)) { $i='l'; $dev29d = explode(" ", $dev29); table($dev29d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev30 == NULL)) { $i='d'; $dev30d = explode(" ", $dev30); table($dev30d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev31 == NULL)) { $i='l'; $dev31d = explode(" ", $dev31); table($dev31d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev32 == NULL)) { $i='d'; $dev32d = explode(" ", $dev32); table($dev32d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev33 == NULL)) { $i='l'; $dev33d = explode(" ", $dev33); table($dev33d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev34 == NULL)) { $i='d'; $dev34d = explode(" ", $dev34); table($dev34d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev35 == NULL)) { $i='l'; $dev35d = explode(" ", $dev35); table($dev35d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev36 == NULL)) { $i='d'; $dev36d = explode(" ", $dev36); table($dev36d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev37 == NULL)) { $i='l'; $dev37d = explode(" ", $dev37); table($dev37d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev38 == NULL)) { $i='d'; $dev38d = explode(" ", $dev38); table($dev38d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev39 == NULL)) { $i='l'; $dev39d = explode(" ", $dev39); table($dev39d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev40 == NULL)) { $i='d'; $dev40d = explode(" ", $dev40); table($dev40d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev41 == NULL)) { $i='l'; $dev41d = explode(" ", $dev41); table($dev41d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev42 == NULL)) { $i='d'; $dev42d = explode(" ", $dev42); table($dev42d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev43 == NULL)) { $i='l'; $dev43d = explode(" ", $dev43); table($dev43d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev44 == NULL)) { $i='d'; $dev44d = explode(" ", $dev44); table($dev44d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev45 == NULL)) { $i='l'; $dev45d = explode(" ", $dev45); table($dev45d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev46 == NULL)) { $i='d'; $dev46d = explode(" ", $dev46); table($dev46d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev47 == NULL)) { $i='l'; $dev47d = explode(" ", $dev47); table($dev47d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev48 == NULL)) { $i='d'; $dev48d = explode(" ", $dev48); table($dev48d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev49 == NULL)) { $i='l'; $dev49d = explode(" ", $dev49); table($dev49d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev50 == NULL)) { $i='d'; $dev50d = explode(" ", $dev50); table($dev50d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev51 == NULL)) { $i='l'; $dev51d = explode(" ", $dev51); table($dev51d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev52 == NULL)) { $i='d'; $dev52d = explode(" ", $dev52); table($dev52d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev53 == NULL)) { $i='l'; $dev53d = explode(" ", $dev53); table($dev53d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev54 == NULL)) { $i='d'; $dev54d = explode(" ", $dev54); table($dev54d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev55 == NULL)) { $i='l'; $dev55d = explode(" ", $dev55); table($dev55d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev56 == NULL)) { $i='d'; $dev56d = explode(" ", $dev56); table($dev56d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev57 == NULL)) { $i='l'; $dev57d = explode(" ", $dev57); table($dev57d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev58 == NULL)) { $i='d'; $dev58d = explode(" ", $dev58); table($dev58d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev59 == NULL)) { $i='l'; $dev59d = explode(" ", $dev59); table($dev59d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev60 == NULL)) { $i='d'; $dev60d = explode(" ", $dev60); table($dev60d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev61 == NULL)) { $i='l'; $dev61d = explode(" ", $dev61); table($dev61d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev62 == NULL)) { $i='d'; $dev62d = explode(" ", $dev62); table($dev62d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev63 == NULL)) { $i='l'; $dev63d = explode(" ", $dev63); table($dev63d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev64 == NULL)) { $i='d'; $dev64d = explode(" ", $dev64); table($dev64d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
if(!($dev65 == NULL)) { $i='l'; $dev65d = explode(" ", $dev65); table($dev65d,$line,$lang,$i,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table);}
echo "</tbody></table>";
?>