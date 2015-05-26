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
		$query = "SELECT `inv` FROM `tasks` GROUP BY `inv` ORDER BY `inv` ASC";
	} else {
		$query = "SELECT `inv` FROM `tasks` WHERE `line`='".$line."' GROUP BY `inv` ORDER BY `inv` ASC";
	}
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
    	echo "
            <option value=\"ALL\">".get_lang($lang,'ad469')."</option>
            <option></option>
    	";
        while ($invs = mysql_fetch_array($result)) {
			echo "<option value=\"".$invs['inv']."\">".$invs['inv']."</option>";
	    }
	}
}
?>