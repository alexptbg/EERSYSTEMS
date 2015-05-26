<?php
defined('start') or die('Direct access not allowed.');
function off($dev,$line,$lang,$i,$red,$ex_red){ /* controller off in status */
    $dev = explode(" ", $dev); 
	if (($dev[8] == 'OFF') && ($dev[9] == 'OFF') /*&& ($dev[6]<9)*/) { 
		 drawt($dev,$line,$lang,$i,$red,$ex_red); 
	} 
}
function lt($dev,$line,$lang,$i,$red,$ex_red){ /* low temperature */
    $dev = explode(" ", $dev); 
	if ($dev[9] == 'LT') { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); 
	} 
}
function mode0($dev,$line,$lang,$i,$red,$ex_red){ /* mode 0 */
	$dev = explode(" ", $dev);
	if (($dev[6] == '0') && ($dev[9] != 'OFF')) {
	    drawt($dev,$line,$lang,$i,$red,$ex_red);
	}
}
function ht($dev,$line,$lang,$i,$red,$ex_red){ /* high temperature */
    $dev = explode(" ", $dev);
    if ((($dev[16] > $dev[10] + $red) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif ((($dev[17] > $dev[11] + $red) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif ((($dev[18] > $dev[12] + $red) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif ((($dev[19] > $dev[13] + $red) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif ((($dev[20] > $dev[14] + $red) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif ((($dev[21] > $dev[15] + $red) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }	
}
function tkoff($dev,$line,$lang,$i,$red,$ex_red){ /* tk/channel off */
    $dev = explode(" ", $dev); $mi1 = 31; 	
    if (((($dev[9] == 'ON') && ($dev[6]>0) && ($dev[6]<9) && ($dev[16]<$mi1) && ($dev[16]>19) && !in_array($dev[1],$ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] == 'ON') && ($dev[6]>1) && ($dev[6]<9) && ($dev[17]<$mi1) && ($dev[17]>19) && !in_array($dev[1],$ex_red)))){ 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] == 'ON') && ($dev[6]>2) && ($dev[6]<9) && ($dev[18]<$mi1) && ($dev[18]>19) && !in_array($dev[1],$ex_red)))){ 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] == 'ON') && ($dev[6]>3) && ($dev[6]<9) && ($dev[19]<$mi1) && ($dev[19]>19) && !in_array($dev[1],$ex_red)))){ 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] == 'ON') && ($dev[6]>4) && ($dev[6]<9) && ($dev[20]<$mi1) && ($dev[20]>19) && !in_array($dev[1],$ex_red)))){ 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] == 'ON') && ($dev[6]>5) && ($dev[6]<9) && ($dev[21]<$mi1) && ($dev[21]>19) && !in_array($dev[1],$ex_red)))){ 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
}
function poff($dev,$line,$lang,$i,$red,$ex_red){/* plunger */ 
    $dev = explode(" ", $dev);
	$mi1 = 31;
	$mi2 = 79; 	
    if (((($dev[9] == 'ON') && ($dev[6] > 0) && ($dev[16] < $mi2) && ($dev[16] > $mi1) && !in_array($dev[1], $ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] == 'ON') && ($dev[6] > 1) && ($dev[17] < $mi2) && ($dev[17] > $mi1) && !in_array($dev[1], $ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] == 'ON') && ($dev[6] > 2) && ($dev[18] < $mi2) && ($dev[18] > $mi1) && !in_array($dev[1], $ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] == 'ON') && ($dev[6] > 3) && ($dev[19] < $mi2) && ($dev[19] > $mi1) && !in_array($dev[1], $ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] == 'ON') && ($dev[6] > 4) && ($dev[20] < $mi2) && ($dev[20] > $mi1) && !in_array($dev[1], $ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] == 'ON') && ($dev[6] > 5) && ($dev[21] < $mi2) && ($dev[21] > $mi1) && !in_array($dev[1], $ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
}
function soff($dev,$line,$lang,$i,$red,$ex_red){ /* sensor problem */
    $dev = explode(" ", $dev); $mi1 = 31; $mi2 = 79; 	
    if (((($dev[9] != 'OFF') && ($dev[6]> 0) && ($dev[6]<9) && ($dev[16] == 0) && !in_array($dev[1],$ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] != 'OFF') && ($dev[6]>1) && ($dev[6]<9) && ($dev[17] == 0) && !in_array($dev[1],$ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] != 'OFF') && ($dev[6]>2) && ($dev[6]<9) && ($dev[18] == 0) && !in_array($dev[1],$ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] != 'OFF') && ($dev[6]>3) && ($dev[6]<9) && ($dev[19] == 0) && !in_array($dev[1],$ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] != 'OFF') && ($dev[6]>4) && ($dev[6]<9) && ($dev[20] == 0) && !in_array($dev[1],$ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif (((($dev[9] != 'OFF') && ($dev[6]>5) && ($dev[6]<9) && ($dev[21] == 0) && !in_array($dev[1],$ex_red)))) { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); }	
}
function coff($dev,$line,$lang,$i,$red,$ex_red){ /* cable problem */
    $dev = explode(" ", $dev);
	$r = 150 + $red; 
    if ((($dev[16] > $r) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif ((($dev[17] > $r) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif ((($dev[18] > $r) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif ((($dev[19] > $r) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif ((($dev[20] > $r) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }
    elseif ((($dev[21] > $r) && !in_array($dev[1], $ex_red) && ($dev[9] != 'OFF'))) { drawt($dev,$line,$lang,$i,$red,$ex_red); }	
}
function stb($dev,$line,$lang,$i,$red,$ex_red){ /* low temperature */
    $dev = explode(" ", $dev); 
	if ($dev[9] == '1' || $dev[9] == '2') { 
	    drawt($dev,$line,$lang,$i,$red,$ex_red); 
	} 
}
function drawt($dev,$line,$lang,$i,$red,$ex) {
    $co_r = ('<font color=#d50000>');
    $co_o = ('<font color=#d96c00>');
    $co_g = ('<font color=#008040>');
	$co_p = ('<font color=#d5006a>');
	$co_b = ('<font color=#006bd7>');
	$co_y = ('<font color=#bfa302>');
	$co_w = ('<font color=#666666>');		
	$co_l = ('<font color=#FF5500>');	 
	$mi1 = 79;
	$mi2 = 31;
	$ct1 = '#ddd';
    $ct2 = '#eee';	
  if(!($dev == NULL)) {
  	
  	if ($i=='d') { echo "<tr class='d'>\n"; } else { echo "<tr class='l'>\n"; }
  	echo "<td><a href='setup/setup.php?inv=$dev[1]&id=$dev[0]&line=$line&sys=t'>
	          <i class='fa fa-cog icon-t'></i></a></td>";
		  $cinv = get_check_controller_db($line,$dev[1]);
    if ($cinv == NULL) { echo "<td class='tip' title='".get_lang($lang,'td49')."'>$co_r $dev[1]</td>"; } else { echo "<td>$dev[1]</td>"; }
    echo "<td>$dev[0]</td>";
		  $tnow = strtotime($dev[2]);
		  $tck1 = strtotime("+5 Minutes");
		  $tck2 = strtotime("-5 Minutes");
          if (($tnow<$tck2) || ($tnow>$tck1)) { $tcheck = $co_r . $dev[2]; } else { $tcheck = $dev[2]; }	  
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
		  if (($dev[6] == '0') && ($dev[9] != 'OFF')) {
		      echo "<td class='tip' title='".get_lang($lang,'td35')."'>$co_p $dev[6]</td>";
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
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 0) && ($dev[16] < $mi1) && ($dev[16] > $mi2) && !in_array($dev[1], $ex)))) { 
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
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 0) && ($dev[16] < 8) && ($dev[16] > 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[16]</td>";
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 0) && ($dev[16] == 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[16]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 0) && ($dev[16] < $mi1) && ($dev[16] > 19) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[16]</td>"; 
	}
	elseif (($dev[6] < 6) && ($dev[16] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[16]</td>"; }
	elseif (($dev[6] < 6) && ($dev[16] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[16]</td>"; }	 
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[16]</td>"; }
	//tk2================================================================================================================================
    if (($dev[17] > $dev[11] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[17] > 165) && ($dev[17] < 255))  { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[17]</td>"; }
		elseif ($dev[17] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[17]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[17]</td>"; } 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 1) && ($dev[17] < $mi1) && ($dev[17] > $mi2) && !in_array($dev[1], $ex)))) { 
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
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 1) && ($dev[17] < 8) && ($dev[17] > 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[17]</td>"; 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 1) && ($dev[17] == 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[17]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 1) && ($dev[17] < $mi1) && ($dev[17] > 19) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[17]</td>"; 
	}	
	elseif (($dev[6] < 6) && ($dev[17] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[17]</td>"; }
	elseif (($dev[6] < 6) && ($dev[17] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[17]</td>"; }
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[17]</td>"; }
	//tk3==============================================================================================================================
    if (($dev[18] > $dev[12] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[18] > 165) && ($dev[18] < 255)) { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[18]</td>"; }
		elseif ($dev[18] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[18]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[18]</td>"; } 
	} 
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 2) && ($dev[18] < $mi1) && ($dev[18] > $mi2) && !in_array($dev[1], $ex)))) { 
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
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 2) && ($dev[18] < 8) && ($dev[18] > 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[18]</td>"; 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 2) && ($dev[18] == 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[18]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 2) && ($dev[18] < $mi1) && ($dev[18] > 19) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[18]</td>"; 
	}
	elseif (($dev[6] < 6) && ($dev[18] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[18]</td>"; }
	elseif (($dev[6] < 6) && ($dev[18] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[18]</td>"; }
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[18]</td>"; }
	//tk4===============================================================================================================================
    if (($dev[19] > $dev[13] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[19] > 165) && ($dev[19] < 255)) { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[19]</td>"; }
		elseif ($dev[19] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[19]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[19]</td>"; } 
	}  
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 3) && ($dev[19] < $mi1) && ($dev[19] > $mi2) && !in_array($dev[1], $ex)))) { 
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
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 3) && ($dev[19] < 8) && ($dev[19] > 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[19]</td>"; 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 3) && ($dev[19] == 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[19]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 3) && ($dev[19] < $mi1) && ($dev[19] > 19) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[19]</td>"; 
	}
	elseif (($dev[6] < 6) && ($dev[19] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[19]</td>"; }
	elseif (($dev[6] < 6) && ($dev[19] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[19]</td>"; }
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[19]</td>"; }
	//tk5================================================================================================================================
    if (($dev[20] > $dev[14] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[20] > 165) && ($dev[20] < 255)) { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[20]</td>"; }
		elseif ($dev[20] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[20]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[20]</td>"; } 
	} 
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 4) && ($dev[20] < $mi1) && ($dev[20] > $mi2) && !in_array($dev[1], $ex)))) { 
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
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 4) && ($dev[20] < 8) && ($dev[20] > 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[20]</td>"; 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 4) && ($dev[20] == 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[20]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 4) && ($dev[20] < $mi1) && ($dev[20] > 19) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[20]</td>"; 
	}
	elseif (($dev[6] < 6) && ($dev[20] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[20]</td>"; }
	elseif (($dev[6] < 6) && ($dev[20] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[20]</td>"; }
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[20]</td>"; }
	//tk6================================================================================================================================
    if (($dev[21] > $dev[15] + $red) && !in_array($dev[1], $ex)) { 
	    if (($dev[21] > 165) && ($dev[21] < 255)) { echo "<td class='tip' title='".get_lang($lang,'td34')."'>$co_r $dev[21]</td>"; }
		elseif ($dev[21] == 255) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_r $dev[21]</td>"; }
	    else { echo "<td class='tip' title='".get_lang($lang,'td32')."'>$co_r $dev[21]</td>"; } 
	} 
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 5) && ($dev[21] < $mi1) && ($dev[21] > $mi2) && !in_array($dev[1], $ex)))) { 
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
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 5) && ($dev[21] < 8) && ($dev[21] > 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td37')."'>$co_p $dev[21]</td>"; 
	}
	elseif (((($dev[9] != 'OFF') && ($dev[6] > 5) && ($dev[21] == 0) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td38')."'>$co_b $dev[21]</td>"; 
	}
	elseif (((($dev[9] == 'ON') && ($dev[6] > 5) && ($dev[21] < $mi1) && ($dev[21] > 19) && !in_array($dev[1], $ex)))) { 
	    echo "<td class='tip' title='".get_lang($lang,'td36')."'>$co_y $dev[21]</td>"; 
	}
	elseif (($dev[6] < 6) && ($dev[21] < 1)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[21]</td>"; }
	elseif (($dev[6] < 6) && ($dev[21] == 255)) { echo "<td class='tip' title='".get_lang($lang,'td39')."'>$co_w $dev[21]</td>"; }	
	else { echo "<td class='td1 tip' title='".get_lang($lang,'td40')."'>$dev[21]</td>"; }
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
    elseif ($xst == 'LT') { $xst = '<td class="tip_" title="'.get_lang($lang,'td28').'">'.$co_o . $xst.'</td>'; } 
	elseif ($xst == '1') { $xst = '<td class="tip_" title="'.get_lang($lang,'td59').' 1">'.$co_b . $xst.'</td>'; }
	elseif ($xst == '2') { $xst = '<td class="tip_" title="'.get_lang($lang,'td59').' 2">'.$co_b . $xst.'</td>'; }
	else { $xst = '<td>'.$co_g . $xst.'</td>'; }
    echo "$xst</tr>\n";
    }
  }
function drawoffth($lang,$line,$theme){
  include('includes/table_style.php');
  $updated = date('H:i:s');
  echo "
  <table class='data $theme'>
  <caption>". get_lang($lang, 'Updated_at') . " " . $updated. "</caption>
  <thead><tr>
  <th class='tip' title='". get_lang($lang, 'td1') ."'>SET</th>
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
  <th class='tip' title='". get_lang($lang, 'td1') ."'>SET</th>
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
}
function drawtend(){
	echo "</tbody></table>";
}
?>