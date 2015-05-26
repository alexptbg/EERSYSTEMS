<?php
//error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$global_settings = get_global_settings();
$addresses = explode(',', $global_settings['system_addresses']);
//if (in_array($_SERVER['REMOTE_ADDR'], $addresses)) {
if (in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $addresses)) {
	echo "<img src=\"img/loaders/s_loader_gr.gif\" alt=\"\" />";
	$start_h = $global_settings['work_s_h'];
	$start_m = $global_settings['work_s_m'];
	$end_h = $global_settings['work_e_h'];
	$end_m = $global_settings['work_e_m'];
	$check = date("i");
	$check2 = date('s');
	$start = $start_h.":".$start_m.":00";
	$end = $end_h.":".$end_m.":00";
    if(check_date_is_within_range($start, $end, date("H:i:s"))){
        if (($check == 00 || $check == 05 || $check == 10 || $check == 15 || $check == 20 || $check == 25 || $check == 30 || 
	        $check == 35 || $check == 40 || $check == 45 || $check == 50 || $check == 55)){
            echo "<img src=\"img/loaders/s_loader.gif\" alt=\"\" />";
			insert_temp('Strellson/Joop1','0','tk1','Outside','5');
			insert_klima_out('Strellson/Joop1','0','0','Outside','5');
			insert_temp('Boss2','3','tk1','Boss1','5.5');
			insert_temp('Boss2','3','tk2','Boss2','3');
			insert_temp('Strellson/Joop2','5','tk1','Strellson/Joop1','2');
			insert_temp('Strellson/Joop2','5','tk2','Strellson/Joop2','2');
			insert_klima('Boss1','4','35','Cutting Area','Modeler Area');
			insert_klima('Boss1','5','36','North Area','South Area');
			insert_klima('Boss2','4','45','North Area','South Area');
			insert_temp2('Bukovo','0','tk6','Bukovo','5');
			insert_vodomer('Bukovo','0');
			insert_pressure('Bukovo','0','69','tf2','Налягане на конденз след помпа');
			insert_pressure('Bukovo','0','69','tf1','Налягане на парата');
			//get_temp_klimas('Klima');						
        }
	}
}
function insert_pressure($line,$id,$inv,$ch,$name) {
    $data = get_device($line,$id);
    $dev = explode(" ", $data);
    if ($ch == 'tk1') { $value = $dev[16]; }
    elseif ($ch == 'tk2') { $value = $dev[17]; }
    elseif ($ch == 'tk3') { $value = $dev[18]; }
    elseif ($ch == 'tk4') { $value = $dev[19]; }
    elseif ($ch == 'tk5') { $value = $dev[20]; }
    elseif ($ch == 'tk6') { $value = $dev[21]; }
    elseif ($ch == 'tf1') { $value = $dev[22]; }
    elseif ($ch == 'tf2') { $value = $dev[23]; }	
    else { $value = 0; }
    if (($value != NULL) && ($value != 0) && ($value > 30) && ($value < 222)) {
        $v = ($value-22)/20;
        $v = number_format($v,2);
        $date = date("Y-m-d");
        $time = date("H:i:s");
	    $timestamp = time();
	    mysql_query("SET NAMES utf8");
	    $query = "INSERT INTO `pressure` (`datetime`, `timestamp`, `day`, `line`, `inv`, `channel`, `value`, `name`) 
		                 VALUES ('$date $time', '$timestamp', '$date', '$line', '$inv', '$ch', '$v', '$name')";
        $result = mysql_query($query);
        confirm_query($result);
    }
}
function insert_temp2($line,$id,$tk,$place,$algo) {//bukovo
    $data = get_device($line,$id);
    $dev = explode(" ", $data);
    if ($tk == 'tk1') { $temp = $dev[16]; }
    elseif ($tk == 'tk2') { $temp = $dev[17]; }
    elseif ($tk == 'tk3') { $temp = $dev[18]; }
    elseif ($tk == 'tk4') { $temp = $dev[19]; }
    elseif ($tk == 'tk5') { $temp = $dev[20]; }
    elseif ($tk == 'tk6') { $temp = $dev[21]; }
    else { $temp = 0; }
    if ($temp != NULL) {
        $t = (($temp-30)/3.3)-$algo;
        $t = number_format($t,2);
        $date = date("Y-m-d");
        $time = date("H:i:s");
	    $timestamp = time();
		if ($t < 50) {
			mysql_query("SET NAMES utf8");
	        $query = "INSERT INTO `temp` (`datetime`, `timestamp`, `place`, `temp`) 
		                     VALUES ('$date $time', '$timestamp', '$place', '$t')";
            $result = mysql_query($query);
            confirm_query($result);
		}
    }
}
function insert_temp($line,$id,$tk,$place,$algo) {
    $data = get_device($line,$id);
    $dev = explode(" ", $data);
    if ($tk == 'tk1') { $temp = $dev[16]; $treq = $dev[10]; }
    elseif ($tk == 'tk2') { $temp = $dev[17]; $treq = $dev[11]; }
    elseif ($tk == 'tk3') { $temp = $dev[18]; $treq = $dev[12]; }
    elseif ($tk == 'tk4') { $temp = $dev[19]; $treq = $dev[13]; }
    elseif ($tk == 'tk5') { $temp = $dev[20]; $treq = $dev[14]; }
    elseif ($tk == 'tk6') { $temp = $dev[21]; $treq = $dev[15]; }
    else { $temp = 0; $treq = 0; }
    if ($temp != NULL) {
		$t = ((($treq*256+$temp)-1194)/22.733)+$algo;
        $t = number_format($t,2);
        $date = date("Y-m-d");
        $time = date("H:i:s");
	    $timestamp = time();
		if ($t < 50) {
	        mysql_query("SET NAMES utf8");
	        $query = "INSERT INTO `temp` (`datetime`, `timestamp`, `place`, `temp`) 
		                     VALUES ('$date $time', '$timestamp', '$place', '$t')";
            $result = mysql_query($query);
            confirm_query($result);
		}
    }
}
function insert_klima_out($line,$id,$inv,$place,$algo) {
    $data = get_device($line,$id);
    $dev = explode(" ", $data);
    $temp = $dev[16]; 
	$treq = $dev[10];
	if (($temp != NULL) && ($treq != NULL) && ($dev[1] == $inv)) {
        $t = ((($treq*256+$temp)-1194)/22.733)+5;
        $t = number_format($t,2);
        $date = date("Y-m-d");
        $time = date("H:i:s");
	    $timestamp = time();
		if ($t < 50) {
	        mysql_query("SET NAMES utf8");
	        $query = "INSERT INTO `klima` (`datetime`, `timestamp`, `line`, `name`, `temp`) 
		                     VALUES ('$date $time', '$timestamp', '$place', '$place', '$t')";
            $result = mysql_query($query);
            confirm_query($result);
		}
    }
}
function insert_temp_klima($kline,$inv,$out_temp,$temp,$set_p,$e_temp,$o_temp,$status) {
        $date = date("Y-m-d");
        $time = date("H:i:s");
	    $timestamp = time();
	    mysql_query("SET NAMES utf8");
	    $query = "INSERT INTO `klima_temp` (`date_time`, `timestamp`, `kline`, `inv`, `out_temp`, `temp`, `set_p`, `e_temp`, `o_temp`, `status`) 
		                 VALUES ('$date $time', '$timestamp', '$kline', '$inv', '$out_temp', '$temp', '$set_p', '$e_temp', '$o_temp', '$status')";
        $result = mysql_query($query);
        confirm_query($result);
}
function insert_klima($line,$id,$inv,$name1,$name2) {
    $data = get_device($line,$id);
    $dev = explode(" ", $data);
    $t1 = c($dev[24]); $t1 = number_format($t1,2);
    $t2 = c($dev[26]); $t2 = number_format($t2,2);
    if (($t1 != NULL) && ($t2 != NULL) && ($dev[1] == $inv)){
		write_klima($line,$name1,$t1);
		write_klima($line,$name2,$t2);		
    }
}
function write_klima($l,$n,$t) {
    if ($t != NULL){
        $date = date("Y-m-d");
        $time = date("H:i:s");
	    $timestamp = time();
	    mysql_query("SET NAMES utf8");
	    $query = "INSERT INTO `klima` (`datetime`, `timestamp`, `line`, `name`, `temp`) 
		                 VALUES ('$date $time', '$timestamp', '$l', '$n', '$t')";
        $result = mysql_query($query);
        confirm_query($result);
    }
}
function c($x) { $c = ($x-371)/13.07; return $c; }
function insert_vodomer($line,$id) {//v_id=dynamic mode/one day back = stk4*65536+stk3
    $data = get_device($line,$id);
    $dev = explode(" ", $data);
	$inv = $dev[1];
	//$stk1 = $dev[24]; 
	//$stk2 = $dev[25];
	$stk3 = $dev[26];
	$stk4 = $dev[27];
	$stk5 = $dev[28];
	$stk6 = $dev[29];		
	$v_id = $dev[6];
	$v_k = ($stk4*65536+$stk3)-($stk6*65536+$stk5);
    if (($v_k != NULL) && ($v_k > 0)) {
        $date = date('Y-m-d', time() - 60 * 60 * 24);
        $time = date("H:i:s");
	    $timestamp = time()-(60 * 60 * 24);
	    mysql_query("SET NAMES utf8");
        $result = mysql_query("SELECT * FROM `vodomer` WHERE `day`='$date' AND `line`='$line'AND `inv`='$inv' AND `v_id`='$v_id'");
        if (mysql_fetch_row($result)) {
			//do nothing
        } else {
	        $query = "INSERT INTO `vodomer` (`datetime`, `timestamp`, `day`, `line`, `inv`, `v_id`, `v_k`) 
		                     VALUES ('$date $time', '$timestamp', '$date', '$line', '$inv', '$v_id', '$v_k')";
            $result = mysql_query($query);
            confirm_query($result);
        }
    }
}
?>