<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/setup_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
$line = mysql_prep($_GET['line']);
$id = mysql_prep($_GET['id']);
$inv = mysql_prep($_GET['inv']);
get_line_options($line);
$datafile = "../data/{$line_options['data_file']}";
$ala = $line_options['alarm'];
$red = $line_options['red'];
$ex_red = $line_options['ex_red'];
$ex_red = explode(',', $ex_red);
$ex_alarm = $line_options['ex_alarm'];
$ex_alarm = explode(',', $ex_alarm);
$mi1 = 75; 
$mi2 = 29;
include("$datafile");
$dev = ${'dev' . $id};
$d = explode(" ", $dev);
$xst = $d[9];
$mode = $d[6];
$tr1 = $d[10];
$tr2 = $d[11];
$tr3 = $d[12];
$tr4 = $d[13];
$tr5 = $d[14];
$tr6 = $d[15];
    //tk1==========
	$tk1 = $d[16];
    if (($tk1 > $tr1 + $red) && !in_array($inv, $ex_red)) { 
	    if (($tk1 > 165) && ($tk1 < 255)) { $tk1 = "<font color='red'>" . $tk1 . "</font>"; }
		elseif ($tk1 == 255) { $tk1 = "<font color='red'>" . $tk1 . "</font>"; }
	    else { $tk1 = "<font color='red'>" . $tk1 . "</font>"; } 
	}
	elseif (((($xst != 'OFF') && ($mode > 0) && ($tk1 < $mi1) && ($tk1 > $mi2) && !in_array($inv, $ex_alarm)))) { 
	    if ($xst == 'LT') {
			$tk1 = "<font color='orange'>" . $tk1 . "</font>";
		}
	    elseif ($xst == '1') {
			$tk1 = "<font color='blue'>" . $tk1 . "</font>";
		}
	    elseif ($xst == '2') {
			$tk1 = "<font color='blue'>" . $tk1 . "</font>";
		}
	     else {
		    $tk1 = "<font color='orange'><u>" . $tk1 . "</u></font>";	
		} 
	}
	elseif (((($xst != 'OFF') && ($mode > 0) && ($tk1 < 8) && ($tk1 > 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk1 = "<font color='fuchsia'>" . $tk1 . "</font>";
	}
	elseif (((($xst != 'OFF') && ($mode > 0) && ($tk1 == 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk1 = "<font color='blue'>" . $tk1 . "</font>";
	}
	elseif (((($xst == 'ON') && ($mode > 0) && ($tk1 < $mi1) && ($tk1 > 19) && !in_array($inv, $ex_alarm)))) { 
	    $tk1 = "<font color='goldenrod'>" . $tk1 . "</font>"; 
	}
	elseif (($mode < 2) && ($tk1 < 1)) { $tk1 = $tk1; }
	elseif (($mode < 2) && ($tk1 == 255)) { $tk1 = $tk1; }
	else { $tk1 = "<font color='green'>" . $tk1 . "</font>";  }
    //tk2==========
	$tk2 = $d[17];
    if (($tk2 > $tr2 + $red) && !in_array($inv, $ex_red)) { 
	    if (($tk2 > 165) && ($tk2 < 255)) { $tk2 = "<font color='red'>" . $tk2 . "</font>"; }
		elseif ($tk2 == 255) { $tk2 = "<font color='red'>" . $tk2 . "</font>"; }
	    else { $tk2 = "<font color='red'>" . $tk2 . "</font>"; } 
	}
	elseif (((($xst != 'OFF') && ($mode > 1) && ($tk2 < $mi1) && ($tk2 > $mi2) && !in_array($inv, $ex_alarm)))) { 
	    if ($xst == 'LT') {
			$tk2 = "<font color='orange'>" . $tk2 . "</font>";
		}
	    elseif ($xst == '1') {
			$tk2 = "<font color='blue'>" . $tk2 . "</font>";
		}
	    elseif ($xst == '2') {
			$tk2 = "<font color='blue'>" . $tk2 . "</font>";
		}
	     else {
		    $tk2 = "<font color='orange'><u>" . $tk2 . "</u></font>";	
		} 
	}
	elseif (((($xst != 'OFF') && ($mode > 1) && ($tk2 < 8) && ($tk2 > 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk2 = "<font color='fuchsia'>" . $tk2 . "</font>";
	}
	elseif (((($xst != 'OFF') && ($mode > 1) && ($tk2 == 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk2 = "<font color='blue'>" . $tk2 . "</font>";
	}
	elseif (((($xst == 'ON') && ($mode > 1) && ($tk2 < $mi1) && ($tk2 > 19) && !in_array($inv, $ex_alarm)))) { 
	    $tk2 = "<font color='goldenrod'>" . $tk2 . "</font>"; 
	}
	elseif (($mode < 3) && ($tk2 < 1)) { $tk2 = $tk2; }
	elseif (($mode < 3) && ($tk2 == 255)) { $tk2 = $tk2; }
	else { $tk2 = "<font color='green'>" . $tk2 . "</font>"; }
    //tk3========
    $tk3 = $d[18];
    if (($tk3 > $tr3 + $red) && !in_array($inv, $ex_red)) { 
	    if (($tk3 > 165) && ($tk3 < 255)) { $tk3 = "<font color='red'>" . $tk3 . "</font>"; }
		elseif ($tk3 == 255) { $tk3 = "<font color='red'>" . $tk3 . "</font>"; }
	    else { $tk3 = "<font color='red'>" . $tk3 . "</font>"; } 
	}
	elseif (((($xst != 'OFF') && ($mode > 2) && ($tk3 < $mi1) && ($tk3 > $mi2) && !in_array($inv, $ex_alarm)))) { 
	    if ($xst == 'LT') {
			$tk3 = "<font color='orange'>" . $tk3 . "</font>";
		}
	    elseif ($xst == '1') {
			$tk3 = "<font color='blue'>" . $tk3 . "</font>";
		}
	    elseif ($xst == '2') {
			$tk3 = "<font color='blue'>" . $tk3 . "</font>";
		}
	     else {
		    $tk3 = "<font color='orange'><u>" . $tk3 . "</u></font>";	
		} 
	}
	elseif (((($xst != 'OFF') && ($mode > 2) && ($tk3 < 8) && ($tk3 > 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk3 = "<font color='fuchsia'>" . $tk3 . "</font>";
	}
	elseif (((($xst != 'OFF') && ($mode > 2) && ($tk3 == 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk3 = "<font color='blue'>" . $tk3 . "</font>";
	}
	elseif (((($xst == 'ON') && ($mode > 2) && ($tk3 < $mi1) && ($tk3 > 19) && !in_array($inv, $ex_alarm)))) { 
	    $tk3 = "<font color='goldenrod'>" . $tk3 . "</font>"; 
	}
	elseif (($mode < 4) && ($tk3 < 1)) { $tk3 = $tk3; }
	elseif (($mode < 4) && ($tk3 == 255)) { $tk3 = $tk3; }
	else { $tk3 = "<font color='green'>" . $tk3 . "</font>"; }
    //tk4==========
    $tk4 = $d[19];
    if (($tk4 > $tr4 + $red) && !in_array($inv, $ex_red)) { 
	    if (($tk4 > 165) && ($tk4 < 255)) { $tk4 = "<font color='red'>" . $tk4 . "</font>"; }
		elseif ($tk4 == 255) { $tk4 = "<font color='red'>" . $tk4 . "</font>"; }
	    else { $tk4 = "<font color='red'>" . $tk4 . "</font>"; } 
	}
	elseif (((($xst != 'OFF') && ($mode > 3) && ($tk4 < $mi1) && ($tk4 > $mi2) && !in_array($inv, $ex_alarm)))) { 
	    if ($xst == 'LT') {
			$tk4 = "<font color='orange'>" . $tk4 . "</font>";
		}
	    elseif ($xst == '1') {
			$tk4 = "<font color='blue'>" . $tk4 . "</font>";
		}
	    elseif ($xst == '2') {
			$tk4 = "<font color='blue'>" . $tk4 . "</font>";
		}
	     else {
		    $tk4 = "<font color='orange'><u>" . $tk4 . "</u></font>";	
		} 
	}
	elseif (((($xst != 'OFF') && ($mode > 3) && ($tk4 < 8) && ($tk4 > 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk4 = "<font color='fuchsia'>" . $tk4 . "</font>";
	}
	elseif (((($xst != 'OFF') && ($mode > 3) && ($tk4 == 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk4 = "<font color='blue'>" . $tk4 . "</font>";
	}
	elseif (((($xst == 'ON') && ($mode > 3) && ($tk4 < $mi1) && ($tk4 > 19) && !in_array($inv, $ex_alarm)))) { 
	    $tk4 = "<font color='goldenrod'>" . $tk4 . "</font>"; 
	}
	elseif (($mode < 5) && ($tk4 < 1)) { $tk4 = $tk4; }
	elseif (($mode < 5) && ($tk4 == 255)) { $tk4 = $tk4; }
	else { $tk4 = "<font color='green'>" . $tk4 . "</font>"; }
    //tk5==========
    $tk5 = $d[20];
    if (($tk5 > $tr5 + $red) && !in_array($inv, $ex_red)) { 
	    if (($tk5 > 165) && ($tk5 < 255)) { $tk5 = "<font color='red'>" . $tk5 . "</font>"; }
		elseif ($tk5 == 255) { $tk5 = "<font color='red'>" . $tk5 . "</font>"; }
	    else { $tk5 = "<font color='red'>" . $tk5 . "</font>"; } 
	}
	elseif (((($xst != 'OFF') && ($mode > 4) && ($tk5 < $mi1) && ($tk5 > $mi2) && !in_array($inv, $ex_alarm)))) { 
	    if ($xst == 'LT') {
			$tk5 = "<font color='orange'>" . $tk5 . "</font>";
		}
	    elseif ($xst == '1') {
			$tk5 = "<font color='blue'>" . $tk5 . "</font>";
		}
	    elseif ($xst == '2') {
			$tk5 = "<font color='blue'>" . $tk5 . "</font>";
		}
	     else {
		    $tk5 = "<font color='orange'><u>" . $tk5 . "</u></font>";	
		} 
	}
	elseif (((($xst != 'OFF') && ($mode > 4) && ($tk5 < 8) && ($tk5 > 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk5 = "<font color='fuchsia'>" . $tk5 . "</font>";
	}
	elseif (((($xst != 'OFF') && ($mode > 4) && ($tk5 == 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk5 = "<font color='blue'>" . $tk5 . "</font>";
	}
	elseif (((($xst == 'ON') && ($mode > 4) && ($tk5 < $mi1) && ($tk5 > 19) && !in_array($inv, $ex_alarm)))) { 
	    $tk5 = "<font color='goldenrod'>" . $tk5 . "</font>"; 
	}
	elseif (($mode < 6) && ($tk5 < 1)) { $tk5 = $tk5; }
	elseif (($mode < 6) && ($tk5 == 255)) { $tk5 = $tk5; }
	else { $tk5 = "<font color='green'>" . $tk5 . "</font>"; }
    //tk6=========
    $tk6 = $d[21];
    if (($tk6 > $tr6 + $red) && !in_array($inv, $ex_red)) { 
	    if (($tk6 > 165) && ($tk6 < 255)) { $tk6 = "<font color='red'>" . $tk6 . "</font>"; }
		elseif ($tk6 == 255) { $tk6 = "<font color='red'>" . $tk6 . "</font>"; }
	    else { $tk6 = "<font color='red'>" . $tk6 . "</font>"; } 
	}
	elseif (((($xst != 'OFF') && ($mode > 5) && ($tk6 < $mi1) && ($tk6 > $mi2) && !in_array($inv, $ex_alarm)))) { 
	    if ($xst == 'LT') {
			$tk6 = "<font color='orange'>" . $tk6 . "</font>";
		}
	    elseif ($xst == '1') {
			$tk6 = "<font color='blue'>" . $tk6 . "</font>";
		}
	    elseif ($xst == '2') {
			$tk6 = "<font color='blue'>" . $tk6 . "</font>";
		}
	     else {
		    $tk6 = "<font color='orange'><u>" . $tk6 . "</u></font>";	
		} 
	}
	elseif (((($xst != 'OFF') && ($mode > 5) && ($tk6 < 8) && ($tk6 > 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk6 = "<font color='fuchsia'>" . $tk6 . "</font>";
	}
	elseif (((($xst != 'OFF') && ($mode > 5) && ($tk6 == 0) && !in_array($inv, $ex_alarm)))) { 
	    $tk6 = "<font color='blue'>" . $tk6 . "</font>";
	}
	elseif (((($xst == 'ON') && ($mode > 5) && ($tk6 < $mi1) && ($tk6 > 19) && !in_array($inv, $ex_alarm)))) { 
	    $tk6 = "<font color='goldenrod'>" . $tk6 . "</font>"; 
	}
	elseif (($mode < 7) && ($tk6 < 1)) { $tk6 = $tk6; }
	elseif (($mode < 7) && ($tk6 == 255)) { $tk6 = $tk6; }
	else { $tk6 = "<font color='green'>" . $tk6 . "</font>"; }
    //tforms========
$tf1 = $d[22];
if ($tf1 != '0') {
	$tf1 = "<font color='green'>" . $tf1 . "</font>";
} else {
	$tf1 = $tf1;
}
$tf2 = $d[23];
if ($tf2 != '0') {
	$tf2 = "<font color='green'>" . $tf2 . "</font>";
} else {
	$tf2 = $tf2;
}
echo "
    <table cellpadding='0' cellspacing='0' class='table'>
		<thead>
            <tr>                                    
            <th width='12%'>TR1</th>
            <th width='12%'>TR2</th>
            <th width='12%'>TR3</th>
            <th width='12%'>TR4</th>
            <th width='12%'>TR5</th>
            <th width='12%'>TR6</th>
            <th width='14%'>&nbsp;</th>
            <th width='14%'>&nbsp;</th>			                                  
            </tr>
		</thead>
		<tbody>
            <tr><td>".$tr1."</td>
			    <td>".$tr2."</td>
			    <td>".$tr3."</td>
			    <td>".$tr4."</td>
			    <td>".$tr5."</td>
			    <td>".$tr6."</td>
			    <td>&nbsp;</td>
				<td>&nbsp;</td></tr>
        </tbody>
	</table>
    <table cellpadding='0' cellspacing='0' class='table'>
		<thead>
            <tr>                                    
            <th width='12%'>TK1</th>
            <th width='12%'>TK2</th>
            <th width='12%'>TK3</th>
            <th width='12%'>TK4</th>
            <th width='12%'>TK5</th>
            <th width='12%'>TK6</th>
            <th width='14%'>TF1</th>
            <th width='14%'>TF2</th>			                                  
            </tr>
		</thead>
		<tbody>
            <tr><td>".$tk1."</td>
			    <td>".$tk2."</td>
			    <td>".$tk3."</td>
			    <td>".$tk4."</td>
			    <td>".$tk5."</td>
			    <td>".$tk6."</td>
			    <td>".$tf1."</td>
				<td>".$tf2."</td></tr>
        </tbody>
	</table>";
?>