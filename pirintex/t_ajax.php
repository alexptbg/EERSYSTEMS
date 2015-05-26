<?php
//error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = $_GET['line'];
$id = $_GET['id'];
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
if ($datafile == NULL) { get_error($lang,'1002'); exit; }
if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
include("$datafile");
if (filesize($datafile)<100) { get_error($lang,'1004'); exit; }
$dev = ${dev.$id};
if(!($dev == NULL)) { $d=explode(" ", $dev); }
if ($d[0] != NULL) { draw($d[0],$line,$lang,$red,$ala,$ex_red,$ex_alarm,$ip,$port,$ex_table); }
include('includes/table_style.php');
function draw($d,$line,$lang,$red,$ala,$ex,$ex2,$ip,$port,$ex3) {
    $line_options = get_line_options($line);
    $datafile = "data/{$line_options['data_file']}";
    if ($datafile == NULL) { get_error($lang,'1002'); exit; }
    if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
    include("$datafile");
    if (filesize($datafile)<100) { get_error($lang,'1004'); exit; }
    $device = ${dev.$d};
    $dev=explode(" ", $device);
    $updated = date('H:i:s');
	$chartpat = "controller_charts.php?inv=$dev[1]&id=$dev[0]&lang=$lang&line=$line";
	$infopat = "controller_info.php?inv=$dev[1]&lang=$lang&line=$line";
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
echo "
  <table class='data $site_theme'>
  <caption>". get_lang($lang, 'Updated_at') . " " . $updated. "</caption>
  <tbody>
  <tr class='d'><td>SET</td><td><a href='setup/setup.php?inv=$dev[1]&id=$dev[0]&line=$line'><i class='fa fa-cog icon-t'></i></a></td></tr>
  <tr class='l'><td>GRA</td><td><a href='$chartpat'><i class='fa fa-bar-chart-o icon-t'></i></a></td></tr>
  <tr class='d'><td>INF</td><td><a href='$infopat'><i class='fa fa-info-circle icon-t'></i></a></td></tr>
  <tr class='l'><td>INV</td><td>$dev[1]</td></tr>
  <tr class='d'><td>ID</td><td>$dev[0]</td></tr>
  <tr class='l'><td>TIME</td>";
		  $tnow = strtotime($dev[2]);
		  $tck1 = strtotime("+5 Minutes");
		  $tck2 = strtotime("-5 Minutes");
          if (($tnow<$tck2) || ($tnow>$tck1)) { $tcheck = $co_r . $dev[2]; } else { $tcheck = $dev[2]; }	  
          echo "<td>$tcheck</td>";  
  echo "</tr>
  <tr class='d'><td>DATE</td>";
          $today = date("j/n/Y"); 
		  $check = $dev[3];
          if ($check != $today) { $check2 = $co_r . $dev[3]; } else { $check2 = $dev[3]; } 	 
		  echo "<td>$check2</td>";
  echo "</tr>
  <tr class='l'><td>THT</td><td>$dev[7]</td></tr>
  <tr class='d'><td>TR1</td><td class='td2'>$dev[10]</td></tr>
  <tr class='l'><td>TR2</td><td class='td2'>$dev[11]</td></tr>
  <tr class='d'><td>TR3</td><td class='td2'>$dev[12]</td></tr>
  <tr class='l'><td>TR4</td><td class='td2'>$dev[13]</td></tr>
  <tr class='d'><td>TR5</td><td class='td2'>$dev[14]</td></tr>
  <tr class='l'><td>TR6</td><td class='td2'>$dev[15]</td></tr>
  <tr class='d'><td>HIS</td><td>$dev[4]</td></tr>
  <tr class='l'><td>TOK</td><td>$dev[5]</td></tr>
  <tr class='d'><td>MOD</td>";
		  if (($dev[6] == '0') && ($dev[9] != 'OFF') && ($dev[7] < '90')) {
		      echo "<td>$co_p $dev[6]</td>";
          } else {
		  	$md = get_controller_mode($line,$dev[1]);
			if (($dev[6] != $md) && ($md != NULL) && ($dev[6] != '0')) {
				echo "<td>$co_r $dev[6]</td>";
			} else {
				echo "<td>$dev[6]</td>";
			}
		  }
  echo "</tr>
  <tr class='l'><td>TK1</td>";
    //tk1================================================================================================================================
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
  echo "</tr>
  <tr class='d'><td>TK2</td>";
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
  echo "</tr>
  <tr class='l'><td>TK3</td>";
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
  echo "</tr>
  <tr class='d'><td>TK4</td>";
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
  echo "</tr>
  <tr class='l'><td>TK5</td>";
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
  echo "</tr>
  <tr class='d'><td>TK6</td>";
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
  echo "</tr>
    <tr class='l'><td>TF1</td>";
	if ($dev[22] == 0) { echo "<td>$co_w $dev[22]</td>"; }
	elseif ($dev[22] == 255) { echo "<td>$co_w $dev[22]</td>"; }	
	else { echo "<td class='td1'> $dev[22]</td>"; }	
  echo "</tr>
    <tr class='d'><td>TF2</td>";
	if ($dev[23] == 0) { echo "<td>$co_w $dev[23]</td>"; }
	elseif ($dev[23] == 255) { echo "<td>$co_w $dev[23]</td>"; }
	else { echo "<td class='td1'>$dev[23]</td>"; }  
  echo "</tr>
    <tr class='l'><td>REG</td>";
	$xrg = $dev[8]; 		  
    if ($xrg == 'OFF') { $xrg = '<td class="tip_" title="'.get_lang($lang,'td29').'">'.$co_r . $xrg.'</td>'; }
	elseif ($xrg == 'M') { $xrg = '<td class="tip_" title="'.get_lang($lang,'td30').'">'.$co_o . $xrg.'</td>'; }
	elseif ($xrg == 'A') { $xrg = '<td class="tip_" title="'.get_lang($lang,'td31').'">'.$co_g . $xrg.'</td>'; }		  
	else { $xrg = '<td>'.$co_g . $xrg.'</td>'; }
    echo "$xrg";
  echo "</tr>
    <tr class='d'><td>STB</td>";
    $xst = $dev[9]; 		  
    if ($xst == 'OFF') { $xst = '<td class="tip_" title="'.get_lang($lang,'td29').'">'.$co_r . $xst.'</td>'; } 
    elseif ($xst == 'LT') { $xst = '<td class="tip_" title="'.get_lang($lang,'td28').'">'.$co_o . $xst.'</td>'; } 
	elseif ($xst == '1') { $xst = '<td class="tip_" title="'.get_lang($lang,'td59').' 1">'.$co_b . $xst.'</td>'; }
	elseif ($xst == '2') { $xst = '<td class="tip_" title="'.get_lang($lang,'td59').' 2">'.$co_b . $xst.'</td>'; }
	else { $xst = '<td>'.$co_g . $xst.'</td>'; }
    echo "$xst";
  echo "</tr>
    <tr class='l'><td>SK1</td>";
	if ($dev[24] != 0) { echo "<td>$co_b $dev[24]</td>"; } else { echo "<td>$co_y $dev[24]</td>"; }
echo "</tr>
    <tr class='d'><td>SK2</td>";
	if ($dev[25] != 0) { echo "<td>$co_b $dev[25]</td>"; } else { echo "<td>$co_y $dev[25]</td>"; }
echo "</tr>
    <tr class='l'><td>SK3</td>";
	if ($dev[26] != 0) { echo "<td>$co_b $dev[26]</td>"; } else { echo "<td>$co_y $dev[26]</td>"; }
echo "</tr>
    <tr class='d'><td>SK4</td>";
	if ($dev[27] != 0) { echo "<td>$co_b $dev[27]</td>"; } else { echo "<td>$co_y $dev[27]</td>"; }
echo "</tr>
    <tr class='l'><td>SK5</td>";
	if ($dev[28] != 0) { echo "<td>$co_b $dev[28]</td>"; } else { echo "<td>$co_y $dev[28]</td>"; }
echo "</tr>
    <tr class='d'><td>SK6</td>";
	if ($dev[29] != 0) { echo "<td>$co_b $dev[29]</td>"; } else { echo "<td>$co_y $dev[29]</td>"; }
echo "</tr>
  </tbody>
  </table>
  <br/>
  <div class='footer'>
      <button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
        <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button>
  </div>
";
}
?>