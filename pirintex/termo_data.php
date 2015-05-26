<?php
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$color = array("#20ff00","#fe01bf","#7d0000","#64004b","#0600ff","#ef9601");
    $query = "SELECT * FROM `temp` GROUP BY `place` order by `place` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
        while ($place = mysql_fetch_array($result)) {
			$places[] = $place['place'];
	    }
	}
	$i=0;
    foreach ($places as $place) {
		$sql[$i] = mysql_query("SELECT * FROM `temp` WHERE `place`='$place' GROUP BY `timestamp` order by `timestamp` asc");
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
	header('Content-type: application/json');
    echo json_encode($series);
?>