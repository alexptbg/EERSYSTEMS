<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
function c($x) { $c = ($x-371)/13.07; return $c; }
$line = mysql_prep($_GET['line']);
$id = mysql_prep($_GET['id']);
$name = mysql_prep($_GET['name']);
get_line_options($line);
$datafile = "data/{$line_options['data_file']}";
include("$datafile");
$dev = ${'dev' . $id};
$d = explode(" ", $dev);
$s1 = $d[10];
$s2 = $d[12];
$st1 = $d[10]+1;
$st2 = $d[12]+1;
$t1 = c($d[24]);
$t2 = c($d[26]);
if (($s1 < 0) || ($s1 == NULL)) { $d[9] = 'OFF'; $s1 = ""; } 
  else { $s1 = "<span class=\"label label-info tipb\" title=\"".get_lang($lang, 'ad280')."\"><h4>".$s1."ºC</h4></span>"; }
if (($s2 < 0) || ($s2 == NULL)) { $d[9] = 'OFF'; $s2 = ""; } 
  else { $s2 = "<span class=\"label label-info tipb\" title=\"".get_lang($lang, 'ad280')."\"><h4>".$s2."ºC</h4></span>"; }
if ($t1 < 0) { $t1 = get_lang($lang, 'Error'); $d[9] = '0'; $d[5] = '0'; } else { $t1 = number_format($t1,2); $k1 = "ºC"; }
if ($t2 < 0) { $t2 = get_lang($lang, 'Error'); $d[8] = '0'; $d[5] = '0'; } else { $t2 = number_format($t2,2); }
echo "
<script type=\"text/javascript\" charset=\"utf-8\">
    $(document).ready(function(){ $(\".tipb\").tooltip({placement: 'bottom', trigger: 'hover'}); });
</script>
        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table klima\">
		<caption>".$name."</caption>
			<thead>
				<tr>
					<th style=\"text-align:right;\">".get_lang($lang, 'ad276')."</th>
					<th>".get_lang($lang, 'Temperature')."</th>
					<th>".get_lang($lang, 'Status')."</th>										
				</tr>
			</thead>
			<tbody>
                <tr width=\"100%\">
                    <td width=\"25%\" style=\"background-color:#f9f9f9;text-align:right;vertical-align:middle;border:none;\">";
					if ($d[9] == 'ON') { echo "<span class=\"label label-success tipb\" title=\"".get_lang($lang, 'Status')."\">
										       <h4>".$d[9]."</h4></span>"; }
					elseif ($d[9] == 'OFF') { echo "<span class=\"label label-important tipb\" title=\"".get_lang($lang, 'Status')."\">
										            <h4>".$d[9]."</h4></span>"; }
					elseif ($d[9] == '0') { echo "<span class=\"label label-warning tipb\" title=\"".get_lang($lang, 'Status')."\">
										           <h4>".$d[9]."</h4></span>"; }
					echo " ".$s1."
					</td>
                    <td width=\"50%\" style=\"background-color:#f9f9f9;text-align:left;vertical-align:middle;border:none;\">";
					if ($t1<$st1) {
						echo "<span class=\"label label-warning tipb\" title=\"".get_lang($lang, 'ad281')."\"><h2>".$t1."".$k1."</h2></span>";
					} elseif ($t1>$st1) {
						echo "<span class=\"label label-success tipb\" title=\"".get_lang($lang, 'ad281')."\"><h2>".$t1."".$k1."</h2></span>";
					} else {
						echo "<span class=\"label label-important tipb\" title=\"".get_lang($lang, 'ad281')."\"><h2>".$t1."".$k1."</h2></span>";
					}
					echo "</td>
                    <td width=\"25%\" style=\"background-color:#222222;border:none;\">";
				    if ($d[5] == '0'||$d[5] == '12') { echo "<img src=\"img/s.gif\" />"; } 
					else { echo "<img src=\"img/l.gif\" />"; }
					echo "</td>
                </tr>
                <tr width=\"100%\">
                    <td width=\"25%\" style=\"background-color:#f9f9f9;text-align:right;vertical-align:middle;border:none;\">";
					if ($d[8] == 'A') { echo "<span class=\"label label-success tipb\" title=\"".get_lang($lang, 'td31')."\"><h4>".$d[8]."</h4></span>"; }
					elseif ($d[8] == 'M') { echo "<span class=\"label label-warning tipb\" title=\"".get_lang($lang, 'td30')."\"><h4>".$d[8]."</h4></span>"; }
					elseif ($d[8] == '0') { echo "<span class=\"label label-warning tipb\" title=\"".get_lang($lang, 'td30')."\"><h4>".$d[8]."</h4></span>"; }
					echo " ".$s2."
					</td>
                    <td width=\"50%\" style=\"background-color:#f9f9f9;text-align:left;vertical-align:middle;border:none;\">";
					if ($t2<$st2) {
						echo "<span class=\"label label-warning tipb\" title=\"".get_lang($lang, 'ad281')."\"><h2>".$t2."".$k1."</h2></span>";
					} elseif ($t2>$st2) {
						echo "<span class=\"label label-success tipb\" title=\"".get_lang($lang, 'ad281')."\"><h2>".$t2."".$k1."</h2></span>";
					} else {
						echo "<span class=\"label label-important tipb\" title=\"".get_lang($lang, 'ad281')."\"><h2>".$t2."".$k1."</h2></span>";
					}
					echo "</td>
                    <td width=\"25%\" style=\"background-color:#222222;border:none;\">";
				    if ($d[5] == '0'||$d[5] == '3') {echo "<img src=\"img/s.gif\" />"; } 
					else {echo "<img src=\"img/r.gif\" />"; }
					echo "</td>
                </tr>
            </tbody>
        </table>";
?>