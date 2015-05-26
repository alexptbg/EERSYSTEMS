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
$mode = $d[6];
$t_ht = $d[7];
$t_hi = $d[4];
$t_ok = $d[5];
$xst = $d[9];
if (($mode == '0') && ($xst != 'OFF') && ($t_ht < '90')) {
    $mode_checked = "<font color='fuchsia'>" . $mode . "</font>";
} else {
$md = get_controller_mode($line,$inv);
if (($mode != $md) && ($md != NULL) && ($mode != '0')) { $mode_checked = "<font color='red'>" . $mode . "</font>"; } else { $mode_checked = $mode; }
}
echo "
    <table cellpadding='0' cellspacing='0' class='table'>
		<thead>
            <tr>                                    
            <th width='15%'>".get_lang($lang, 'inter73')."</th>
            <th width='40%'>".get_lang($lang, 'inter74')."</th>
            <th width='20%'>".get_lang($lang, 'td15')."</th>
            <th width='20%'>".get_lang($lang, 'inter75')."</th>                                    
            </tr>
		</thead>
		<tbody>
            <tr><td>".$mode_checked."</td>
			    <td>".$t_ht."</td>
                <td>".$t_hi."</td>
				<td>".$t_ok."</td></tr>
        </tbody>
	</table>";
?>