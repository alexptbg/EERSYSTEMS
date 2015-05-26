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
$t_ht = $d[7];
$xrg = $d[8];
$xst = $d[9];
if ($xrg == 'OFF') { $xrg = "<span class='label label-important'>" . $xrg . '</span>'; }
elseif ($xrg == 'M') { $xrg = "<span class='label label-warning'>" . $xrg . '</span>'; }
elseif ($xrg == 'A') { $xrg = "<span class='label label-success'>" . $xrg. '</span>'; }		  
else { $xrg = "<span class='label label-success'>" . $xrg . "</span>"; }
    if ($xst == 'OFF') { $xst = "<span class='label label-important'>" . $xst . '</span>'; } 
    elseif ($xst == 'LT') { $xst = "<span class='label label-warning'>" . $xst . '</span>'; } 
	elseif ($xst == '1') { $xst = "<span class='label label-info'>" . $xst . '</span>'; }
	elseif ($xst == '2') { $xst = "<span class='label label-info'>" . $xst . '</span>'; }
	else { $xst = "<span class='label label-success'>" . $xst . "</span>"; }
if ($t_ht < '90') { $t_ht = "<span class='label label-inverse'>N</span>"; } else { $t_ht = "<span class='label label-info'>S</span>"; }
echo "
    <table cellpadding='0' cellspacing='0' class='table'>
		<thead>
            <tr>                                    
            <th width='50%'>".get_lang($lang, 'inter78')."</th>
            <th width='50%'>".get_lang($lang, 'Status')."</th>                                  
            </tr>
		</thead>
		<tbody>
            <tr><td>".$xrg."</td>
				<td>".$xst."</td></tr>
        </tbody>
	</table>";
echo "
    <table cellpadding='0' cellspacing='0' class='table'>
		<thead>
            <tr>                                    
            <th width='50%'>".get_lang($lang, 'info23')."</th>                                
            </tr>
		</thead>
		<tbody>
            <tr><td>".$t_ht."</td></tr>
        </tbody>
	</table>";
?>