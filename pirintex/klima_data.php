<?php
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$color = array("#20ff00","#fe01bf","#0600ff","#7d0000","#ef9601");
    $line = $_GET['line'];
	mysql_query("SET NAMES 'utf8'");
    $query = "SELECT * FROM `klima` WHERE `line`='$line' GROUP BY `name` order by `name` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
        while ($place = mysql_fetch_array($result)) {
			$places[] = $place['name'];
	    }
	}
	$i=0;
    foreach ($places as $place) {
		$sql[$i] = mysql_query("SELECT * FROM `klima` WHERE `line`='$line' AND `name`='$place' order by `timestamp` asc");
	    confirm_query($sql[$i]);
		if (mysql_num_rows($sql[$i]) != 0) {
            while($row[$i] = mysql_fetch_array($sql[$i])) {
	            $date[$i] = $row[$i]['timestamp']*1000;
                $values[$i] = floatval($row[$i]['temp']);
                $response[$i][] = array($date[$i], $values[$i]);
			}
			$series[] = array(
                 'name' => $place,
                 'data' => $response[$i],
				 'color' => $color[$i],
			     'type' => 'spline',
                 'tooltip' => array('valueDecimals' => '2', 'valueSuffix' => ' °C')
           );
        }
		$i++;
	}
	$query = mysql_query("SELECT * FROM `klima` WHERE `name`='Outside' order by `timestamp` asc");
	confirm_query($query);
	if (mysql_num_rows($query) != 0) {
        while($row = mysql_fetch_array($query)) {
	        $dateo = $row['timestamp']*1000;
            $valueso = floatval($row['temp']);
            $responseo[] = array($dateo, $valueso);
	    }
	    $series[] = array(
             'name' => 'Outside',
             'data' => $responseo,
			 'color' => '#64004b',
			 'type' => 'spline',
             'tooltip' => array('valueDecimals' => '2', 'valueSuffix' => ' °C')
        );
    }
	header('Content-type: application/json');
    echo json_encode($series);
?>