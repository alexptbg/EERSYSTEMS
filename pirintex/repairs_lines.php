<?php
//error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$query = "SELECT `line_name` FROM `lines` ORDER BY `line_name` ASC";
$result = mysql_query($query);
confirm_query($result);
$num_rows = mysql_num_rows($result);
if ($num_rows != 0) {
    echo "
        <option value=\"ALL\">".get_lang($lang,'ad469')."</option>
        <option></option>
    ";
    while ($lines = mysql_fetch_array($result)) {
		echo "<option value=\"".$lines['line_name']."\">".$lines['line_name']."</option>";
	}
}
?>