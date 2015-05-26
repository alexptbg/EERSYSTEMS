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
include("$datafile");
$dev = ${'dev' . $id};
$d = explode(" ", $dev);
$cinv = get_check_controller_db($line,$inv);
if ($cinv == NULL) { $inv_checked = "<font color='red'>" . $inv . "</font>"; } else { $inv_checked = $inv; }
$time = $d[2];
$date = $d[3];
$tnow = strtotime($time);
$tck1 = strtotime("+5 Minutes");
$tck2 = strtotime("-5 Minutes");
if (($tnow<$tck2) || ($tnow>$tck1)) { $time_checked = "<font color='red'>" . $time . "</font>"; } else { $time_checked = $time; } 
$today = date("j/n/Y"); 
if ($date != $today) { $date_checked = "<font color='red'>" . $date . "</font>"; } else { $date_checked = $date; } 	 
echo "
    <table cellpadding='0' cellspacing='0' class='table'>
		<thead>
            <tr>                                    
            <th width='10%'>".get_lang($lang, 'inter71')."</th>
            <th width='50%'>".get_lang($lang, 'inter80')."</th>
            <th width='20%'>".get_lang($lang, 'inter72')."</th>
            <th width='20%'>".get_lang($lang, 'info6')."</th>                                    
            </tr>
		</thead>
		<tbody>
            <tr><td>".$id."</td>
			    <td>".$inv_checked."</td>
                <td>".$time_checked."</td>
				<td>".$date_checked."</td></tr>
        </tbody>
	</table>";
?>