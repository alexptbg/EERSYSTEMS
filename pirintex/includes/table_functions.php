<?php
function insert_alarm($line,$device,$channel,$temp,$treqt) {
	$global_settings = get_global_settings();
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
	        $check == 35 || $check == 40 || $check == 45 || $check == 50 || $check == 55) && ($check2<10)){
            $date = date("Y-m-d");
            $time = date("H:i:s");
	        mysql_query("SET NAMES utf8");
	        $query = "INSERT INTO `alarms` (`log_date`, `log_line`, `log_device`, `log_channel`, `log_temp`, `log_treqt`) 
		                     VALUES ('$date $time', '$line', '$device', '$channel', '$temp', '$treqt')";
            $result = mysql_query($query);
            confirm_query($result);
        } else { 
			 return false;
	    }
	}
}
function set_time($line,$id,$ip,$port) {
	$line_options = get_line_options($line);
	if ($line_options['time_s'] == 1) {
	    $start_h = $line_options['time_start'];
	    $end_h = $line_options['time_stop'];
	    $check = date("i");
	    $check2 = date('s');
	    $start = $start_h.":00:00";
	    $end = $end_h.":00:00";
        if(check_date_is_within_range($start, $end, date("H:i:s"))){
            if (($check == 05 || $check == 10 || $check == 15 || $check == 20 || $check == 25 || $check == 30 || $check == 35 || $check == 40 || 
	             $check == 42 || $check == 45 || $check == 49 || $check == 53 || $check == 57 || $check == 00)){
	             try {
			         $server = 'r';
	                 $command = 'ST';
		             $dayl = date('N');
                     $w = '1';
    	             $sc = new ClientSocket();
    	             $sc->open($ip,$port);
    	             $sc->send("$server $command $id $dayl $w\r\n");	
                 }
                 catch (Exception $e) { }
            }
	    }
    }
}  
function reset_($line,$id,$ip,$port) {
	$line_options = get_line_options($line);
	if ($line_options['lt_s'] == 1) {
	    $start_h = $line_options['lt_start'];
	    $end_h = $line_options['lt_stop'];
	    $check = date("i");
	    $check2 = date('s');
	    $start = $start_h.":00:00";
	    $end = $end_h.":00:00";
        if(check_date_is_within_range($start, $end, date("H:i:s"))){
            if (($check == 05 || $check == 10 || $check == 15 || $check == 20 || $check == 25 || $check == 30 || $check == 35 || $check == 40 || 
	             $check == 42 || $check == 45 || $check == 49 || $check == 53 || $check == 57 || $check == 00) && ($check2<10)){
	            try {
			        $server = 'r';
	                $command = 'DR';
    	            $sc = new ClientSocket();
    	            $sc->open($ip,$port);
    	            $sc->send("$server $command $id\r\n");
                }
                catch (Exception $e) { }
            }
	    }
    }
}
function reset__($line,$id,$ip,$port) {
    try {
        $server = 'r';
	    $command = 'DR';
        $sc = new ClientSocket();
    	$sc->open($ip,$port);
    	$sc->send("$server $command $id\r\n");
    }
    catch (Exception $e) { }
}
function sensor_verification($line,$id,$tk1,$tk2,$tk3,$tk4,$tk5,$tk6,$this,$tok,$mode,$timeheat,$ip,$port) { //set mode 0
	$line_options = get_line_options($line);
	if ($line_options['mod_s'] == 1) {
	    $start_h = $line_options['mod_start'];
	    $end_h = $line_options['mod_stop'];
	    $check = date("i");
	    $check2 = date('s');
	    $start = $start_h.":00:00";
	    $end = $end_h.":00:00";
        if(check_date_is_within_range($start, $end, date("H:i:s"))){
            if (($check == 05 || $check == 10 || $check == 15 || $check == 20 || $check == 25 || $check == 30 || $check == 35 || $check == 40 || 
	             $check == 45 || $check == 50 || $check == 55 || $check == 00) && ($check2<10) && ($mode != '0')){	
	            try {
				    $server = 'r';
			        $topkond = '4';
	                $command = 'PT';
    	            $sc = new ClientSocket();
    	            $sc->open($ip,$port);
    	            $sc->send("$server $command $id $tk1 $tk2 $tk3 $tk4 $tk5 $tk6 $this $tok 0 $topkond\r\n");
                }
                catch (Exception $e) { }
            }
	    }
    }
}
function zero($line,$id,$inv,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$tk1,$tk2,$tk3,$tk4,$tk5,$tk6,$this,$tok,$timeheat,$ip,$port){
	$line_options = get_line_options($line);
	if ($line_options['mod_s'] == 1) {
	    $start_h = $line_options['mod_start'];
	    $end_h = $line_options['mod_stop'];
	    $check = date("i");
	    $check2 = date('s');
	    $start = $start_h.":00:00";
	    $end = $end_h.":00:00";
        if(check_date_is_within_range($start, $end, date("H:i:s"))){
            if (($check == 03 || $check == 06 || $check == 09 || $check == 12 || $check == 15 || $check == 18 || $check == 21 || $check == 24 || 
			     $check == 27 || $check == 30 || $check == 33 || $check == 36 || $check == 39 || $check == 42 || $check == 45 || $check == 48 || 
				 $check == 51 || $check == 54 || $check == 57 || $check == 00) && ($check2<10)){
	            $c_mode = get_cmode($line,$inv);
	            if (($c_mode == '1') && ($tk1>7)){
		            if ($timeheat<20) {
	                    mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,1,2,$ip,$port);
	                } else {
				        mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,1,4,$ip,$port);
			        }
		        }	
	            if (($c_mode == '2') && ($tk1>7) && ($tk2>7)){
		            if ($timeheat<20) {
	                    mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,2,2,$ip,$port);
	                } else {
				        mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,2,4,$ip,$port);
			        }
		        }	
	            if (($c_mode == '3') && ($tk1>7) && ($tk2>7) && ($tk3>7)){
		            if ($timeheat<20) {
	                    mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,3,2,$ip,$port);
	                } else {
				        mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,3,4,$ip,$port);
			        }
		        }
	            if (($c_mode == '4') && ($tk1>7) && ($tk2>7) && ($tk3>7) && ($tk4>7)){
		            if ($timeheat<20) {
	                    mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,4,2,$ip,$port);
	                } else {
				        mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,4,4,$ip,$port);
			        }
		        }
	            if (($c_mode == '5') && ($tk1>7) && ($tk2>7) && ($tk3>7) && ($tk4>7) && ($tk5>7)){
		            if ($timeheat<20) {
	                    mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,5,2,$ip,$port);
	                } else {
				        mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,5,4,$ip,$port);
			        }
		        }
	            if (($c_mode == '6') && ($tk1>7) && ($tk2>7) && ($tk3>7) && ($tk4>7) && ($tk5>7) && ($tk6>7)){
		            if ($timeheat<20) {
	                    mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,6,2,$ip,$port);
	                } else {
				        mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,6,4,$ip,$port);
			        }
		        }									
				reset__($line,$id,$ip,$port);
	        }
		}
    }
}
function mode_verification($line,$id,$tr1,$tr2,$tr3,$tr4,$tr5,$tr6,$this,$tok,$c_mode,$topkond,$ip,$port){
	try {
		$server = 'r';
	    $command = 'PT';
    	$sc = new ClientSocket();
    	$sc->open($ip,$port);
    	$sc->send("$server $command $id $tr1 $tr2 $tr3 $tr4 $tr5 $tr6 $this $tok $c_mode $topkond\r\n");
    }
    catch (Exception $e){ }	
}
function get_cmode($line,$inv) {
    mysql_query("SET NAMES 'utf8'");
    $result = mysql_query("SELECT * FROM `controller` WHERE `inv`='$inv' AND `main_line`='$line'");  
	confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
        while($row = mysql_fetch_array($result)) {
            $cmode = $row['cmode'];
	    }
		return $cmode;
    }
}
?>