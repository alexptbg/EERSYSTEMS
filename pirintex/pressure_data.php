<?php
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = $_GET['line'];
$inv = $_GET['inv'];
$color = array("#FF0000","#023afd");
	mysql_query("SET NAMES 'utf8'");
    $query = "SELECT * FROM `pressure` WHERE `line`='$line' AND `inv`='$inv' GROUP BY `channel` order by `channel` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
        while ($name = mysql_fetch_array($result)) {
			$names[] = $name['name'];
	    }
	}
	$i=0;
    foreach ($names as $name) {
		$sql[$i] = mysql_query("SELECT * FROM `pressure` WHERE `line`='$line' AND `inv`='$inv' AND `name`='$name' order by `timestamp` asc");
	    confirm_query($sql[$i]);
		if (mysql_num_rows($sql[$i]) != 0) {
            while($row[$i] = mysql_fetch_array($sql[$i])) {
	            $date[$i] = $row[$i]['timestamp']*1000;
                $values[$i] = floatval($row[$i]['value']);
                $response[$i][] = array($date[$i], $values[$i]);
			}
			$series[] = array(
                 'name' => $name,
                 'data' => $response[$i],
				 'color' => $color[$i],
			     'type' => 'spline',
                 'tooltip' => array('valueDecimals' => '2', 'valueSuffix' => ' '.get_lang($lang,'inter60'))
           );
        }
		$i++;
	}
	header('Content-type: application/json');
    echo json_encode($series);
?>