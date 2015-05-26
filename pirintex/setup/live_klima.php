<?php
error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/setup_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
$line = mysql_prep($_GET['line']);
$id = mysql_prep($_GET['id']);
get_line_options($line);
$datafile = "../data/{$line_options['data_file']}";
include("$datafile");
$dev = ${'dev' . $id};
$d = explode(" ", $dev);
$x = time() * 1000;
function c($x) { $c = ($x-371)/13.07; return $c; }
$s1 = $d[10];
$s2 = $d[12];
$sl1 = $d[10];
$sl2 = $d[12];
$st1 = $d[10]+1;
$st2 = $d[12]+1;
$t1 = c($d[24]); 
$t2 = c($d[26]);
if ($t1 < 0) { $t1 = get_lang($lang, 'Error'); $d[9] = '0'; $d[5] = '0'; } else { $t1 = number_format($t1,2); $k1 = "ºC"; }
if ($t2 < 0) { $t2 = get_lang($lang, 'Error'); $d[8] = '0'; $d[5] = '0'; } else { $t2 = number_format($t2,2); }
if ($t1<$st1) {
	$temp1 = "<span class=\"label label-warning\"><h2><span id=\"stk1\">".$t1."".$k1."</span></h2></span>";
} elseif ($t1>$st1) {
	$temp1 = "<span class=\"label label-success\"><h2><span id=\"stk1\">".$t1."".$k1."</span></h2></span>";
} else {
	$temp1 = "<span class=\"label label-important\"><h2><span id=\"stk1\">".$t1."".$k1."</span></h2></span>";
}
if ($t2<$st2) {
	$temp2 = "<span class=\"label label-warning\"><h2><span id=\"stk2\">".$t2."".$k1."</h2></span>";
} elseif ($t2>$st2) {
	$temp2 = "<span class=\"label label-success\"><h2><span id=\"stk2\">".$t2."".$k1."</span></h2></span>";
} else {
	$temp2 = "<span class=\"label label-important\"><h2><span id=\"stk2\">".$t2."".$k1."</h2></span>";
}
if (($s1 < 0) || ($s1 == NULL)) { $d[9] = 'OFF'; $s1 = ""; } else { $s1 = "<span class=\"label label-info\"><h4>".$s1."ºC</h4></span>"; }
if (($s2 < 0) || ($s2 == NULL)) { $d[9] = 'OFF'; $s2 = ""; } else { $s2 = "<span class=\"label label-info\"><h4>".$s2."ºC</h4></span>"; }
if (($sl1 < 0) || ($sl1 == NULL)) { $d[9] = 'OFF'; $sl1 = ""; } else { $sl1 = "<span class=\"label label-warning\"><h5>".$sl1."ºC</h5></span>"; }
if (($sl2 < 0) || ($sl2 == NULL)) { $d[9] = 'OFF'; $sl2 = ""; } else { $sl2 = "<span class=\"label label-warning\"><h5>".$sl2."ºC</h5></span>"; }
if ($d[9] == 'ON') { $status = "<span class='label label-success'><h4>".$d[9]."</h4></span>"; }
elseif ($d[9] == 'OFF') { $status = "<span class='label label-important'><h4>".$d[9]."</h4></span>"; }
elseif ($d[9] == '0') { $status = "<span class='label label-warning'><h4>".$d[9]."</h4></span>"; }
if ($d[8] == 'A') { $reg = "<span class='label label-success'><h4>".$d[8]."</h4></span>"; }
elseif ($d[8] == 'M') { $reg = "<span class='label label-warning'><h4>".$d[8]."</h4></span>"; }
elseif ($d[8] == '0') { $reg = "<span class='label label-warning'><h4>".$d[8]."</h4></span>"; }
if ($d[5] == '0'||$d[5] == '12') { $v1 = "<img src=\"img/s.gif\" />"; } else { $v1 = "<img src=\"img/l.gif\" />"; }
if ($d[5] == '0'||$d[5] == '3') { $v2 = "<img src=\"img/s.gif\" />"; } else { $v2 = "<img src=\"img/r.gif\" />"; }
header("Content-type: text/json");
$ret = array($x,$s1,$s2,$temp1,$temp2,$status,$sl1,$sl2,$v1,$v2,$reg);
$json = json_encode($ret);
echo $json;
?>