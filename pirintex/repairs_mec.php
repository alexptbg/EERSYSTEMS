<?php
//error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
if(isset($_POST['line'])) {
    $line = $_POST['line'];
    if ($line == "ALL") {
		$query = "SELECT `mec` FROM `tasks` GROUP BY `mec` ORDER BY `mec` ASC";
	} else {
		$query = "SELECT `mec` FROM `tasks` WHERE `line`='".$line."' GROUP BY `mec` ORDER BY `mec` ASC";
	}
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
    	echo "
            <option value=\"ALL\">".get_lang($lang,'ad469')."</option>
            <option></option>
    	";
        while ($mecs = mysql_fetch_array($result)) {
			echo "<option value=\"".$mecs['mec']."\">".get_name_from($mecs['mec'])."</option>";
	    }
	}
}
?>