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
$xst = $d[9];
$stk1 = $d[24];
if (($mode > 0) && ($stk1 > '0') && ($xst != 'OFF')) {
	$stk1 = "<font color='green'>" . $stk1 . "</font>";
} elseif (($mode > 0) && ($stk1 == '0') && ($xst != 'OFF')) {
	$stk1 = "<font color='red'>" . $stk1 . "</font>";
} else {
	$stk1 = $stk1;
}
$stk2 = $d[25];
if (($mode > 1) && ($stk2 > '0') && ($xst != 'OFF')) {
	$stk2 = "<font color='green'>" . $stk2 . "</font>";
} elseif (($mode > 1) && ($stk2 == '0') && ($xst != 'OFF')) {
	$stk2 = "<font color='red'>" . $stk2 . "</font>";
} else {
	$stk2 = $stk2;
}
$stk3 = $d[26];
if (($mode > 2) && ($stk3 > '0') && ($xst != 'OFF')) {
	$stk3 = "<font color='green'>" . $stk3 . "</font>";
} elseif (($mode > 2) && ($stk3 == '0') && ($xst != 'OFF')) {
	$stk3 = "<font color='red'>" . $stk3 . "</font>";
} else {
	$stk3 = $stk3;
}
$stk4 = $d[27];
if (($mode > 3) && ($stk4 > '0') && ($xst != 'OFF')) {
	$stk4 = "<font color='green'>" . $stk4 . "</font>";
} elseif (($mode > 3) && ($stk4 == '0') && ($xst != 'OFF')) {
	$stk4 = "<font color='red'>" . $stk4 . "</font>";
} else {
	$stk4 = $stk4;
}
$stk5 = $d[28];
if (($mode > 4) && ($stk5 > '0') && ($xst != 'OFF')) {
	$stk5 = "<font color='green'>" . $stk5 . "</font>";
} elseif (($mode > 4) && ($stk5 == '0') && ($xst != 'OFF')) {
	$stk5 = "<font color='red'>" . $stk5 . "</font>";
} else {
	$stk5 = $stk5;
}
$stk6 = $d[29];
if (($mode > 5) && ($stk6 > '0') && ($xst != 'OFF')) {
	$stk6 = "<font color='green'>" . $stk6 . "</font>";
} elseif (($mode > 5) && ($stk6 == '0') && ($xst != 'OFF')) {
	$stk6 = "<font color='red'>" . $stk6 . "</font>";
} else {
	$stk6 = $stk6;
}
echo "
    <table cellpadding='0' cellspacing='0' class='table'>
		<thead>
            <tr>                                    
            <th width='17%'>SK1</th>
            <th width='17%'>SK2</th>
            <th width='17%'>SK3</th>
            <th width='17%'>SK4</th>
            <th width='16%'>SK5</th>
            <th width='16%'>SK6</th>      
            </tr>
		</thead>
		<tbody>
            <tr>
			    <td>".$stk1."</td>
			    <td>".$stk2."</td>
			    <td>".$stk3."</td>
			    <td>".$stk4."</td>
			    <td>".$stk5."</td>
			    <td>".$stk6."</td>
            </tr>
        </tbody>
	</table>";
?>