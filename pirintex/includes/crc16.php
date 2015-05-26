<?php
define('start', TRUE);
include('includes/socket.php');
$x = array("05","03","00","81","00","01");

function zx($values) {
	$o=0;
    $crc16 = 0xFFFF;//the CRC seed
	foreach ($values as $value) {
		$crc16 = $crc16 ^ $value;
		for($j = 0; $j < 8; $j++ ) {
		    $k = $crc16 & 1;	
			$crc16 = (($crc16 & 0xfffe) /2) & 0x7FFF;
			if ($k > 0) {
				$crc16 = $crc16 ^ 0xA001;
			}
		}
		$o++;
	}
	$lo = (int)($crc16/256);
	$mid = $lo*256;
	$hi = $crc16-$mid;
	return dechex($hi) . " - ". dechex($lo);
}
echo zx($x);

//$z = get_crc16_of($value);
//echo $z."<br/>";
