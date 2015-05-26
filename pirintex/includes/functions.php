<?php
error_reporting(0);
defined('start') or die('Direct access not allowed.');
function confirm_query($query) { if (!$query) { die("Database Query failed !. Check Database Settings." . mysql_error()); } }
function mysql_prep($value) {
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists("mysql_real_escape_string");
    if ($new_enough_php) {
        if ($magic_quotes_active) { $value = stripslashes($value); }
        $value = mysql_real_escape_string($value);
    } else {
        if (!$magic_quotes_active) { $value = addslashes($value); }
    }
    return $value;
}
function get_error($lang,$id) {
    $query = "SELECT * FROM `translations` WHERE `keyword`='$id'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
    if ($check != 0) {
        $e_m = get_lang($lang, $id);
	    $e_e = get_lang($lang, 'Error');
        $e_n = $id;
        echo "<div class=\"alert alert-error\"> $e_e <code>$e_n</code> : <strong>$e_m</strong> </div>";
    } else {
	    $e_e = get_lang($lang, 'Error');
		$e_m = get_lang($lang, 'Unknown_Error');
		echo "<div class=\"alert alert-error\"> $e_e <code>$id</code> : <strong>$e_m</strong> </div>";
    }
}
function get_success($lang,$id) {
    $query = "SELECT * FROM `translations` WHERE `keyword`='$id'";
    $result = mysql_query($query);
    confirm_query($result);
    $check = mysql_num_rows($result);
    if ($check != 0) {
        $e_m = get_lang($lang, $id);
	    $e_e = get_lang($lang, 'Info');
        $e_n = $id;
        echo "<div class=\"alert alert-success\"> $e_e <code class='success'>$e_n</code> : <strong>$e_m</strong> </div>";
    } else {
	    $e_e = get_lang($lang, 'Error');
		$e_m = get_lang($lang, 'Unknown_Error');
		echo "<div class=\"alert alert-error\"> $e_e <code>$id</code> : <strong>$e_m</strong> </div>";
    }
}
function get_warning($lang,$id) {
    $query = "SELECT * FROM `translations` WHERE `keyword`='$id'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
    if ($check != 0) {
        $e_m = get_lang($lang, $id);
	    $e_e = get_lang($lang, 'Info');
        $e_n = $id;
        echo "<div class=\"alert alert-warning\"> $e_e <code class='warning'>$e_n</code> : <strong>$e_m</strong> </div>";
    } else {
	    $e_e = get_lang($lang, 'Error');
		$e_m = get_lang($lang, 'Unknown_Error');
		echo "<div class=\"alert alert-error\"> $e_e <code>$id</code> : <strong>$e_m</strong> </div>";
    }
}
function get_info($lang,$id) {
    $query = "SELECT * FROM `translations` WHERE `keyword`='$id'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
    if ($check != 0) {
        $e_m = get_lang($lang, $id);
	    $e_e = get_lang($lang, 'Info');
        $e_n = $id;
        echo "<div class=\"alert alert-info\"> $e_e <code class='info'>$e_n</code> : <strong>$e_m</strong> </div>";
    } else {
	    $e_e = get_lang($lang, 'Error');
		$e_m = get_lang($lang, 'Unknown_Error');
		echo "<div class=\"alert alert-error\"> $e_e <code>$id</code> : <strong>$e_m</strong> </div>";
    }
}
function check_date_is_within_range($start_date, $end_date, $todays_date) {
  $start_timestamp = strtotime($start_date);
  $end_timestamp = strtotime($end_date);
  $today_timestamp = strtotime($todays_date);
  return (($today_timestamp >= $start_timestamp) && ($today_timestamp <= $end_timestamp));
}
function get_settings() {
    global $settings;
    $query = "SELECT * FROM `settings`";
    $result = mysql_query($query);
    confirm_query($result);
    $settings = mysql_fetch_array($result);
    return $settings;
}
function get_global_settings() {
    global $global_settings;
    $query = "SELECT * FROM `global`";
    $result = mysql_query($query);
    confirm_query($result);
    $global_settings = mysql_fetch_array($result);
    return $global_settings;
}
function get_line_options($line) {
	global $line_options;
    $query = "SELECT * FROM `lines` WHERE `line_name`='$line'";
    $result = mysql_query($query);
    confirm_query($result);
    $line_options = mysql_fetch_array($result);
    return $line_options;
}
function multiexplode($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return $launch;
}
function check_print_controller($lang,$inv,$line) {
    $result = mysql_query("SELECT * FROM `controller` WHERE `inv`='$inv' AND `main_line`='$line'"); 
	confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		echo "
              <ul class=\"buttons\">
                  <li class=\"tip_\" title=\"".get_lang($lang, 'inter05')."\">
                      <a href=\"javascript: history.go(-1)\" class=\"isw-left_circle\"></a>
                  </li>
                  <li class=\"tip_\" title=\"".get_lang($lang, 'info2')."\">
                      <a target=\"_blank\" href=\"print_c_info.php?lang=".$lang."&inv=".$inv."&line=".$line."\" class=\"isw-print\"></a>
                  </li>
              </ul>";
	} else {
		echo "
              <ul class=\"buttons\">
                  <li class=\"tip_\" title=\"".get_lang($lang, 'inter05')."\">
                      <a href=\"javascript: history.go(-1)\" class=\"isw-left_circle\"></a>
                  </li>
              </ul>";
	}
}
function get_controller($lang,$inv,$line) {
    $result = mysql_query("SELECT * FROM `controller` WHERE `inv`='$inv' AND `main_line`='$line'");  
	confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		get_controller_data($inv,$line);
	} else {
	    echo "<div class=\"z100\">";
	    get_error($lang, '1005'); 
		exit;
	}
}
function get_controller_data($inv,$line) {
	global $controller_data;
    $query = "SELECT * FROM `controller` WHERE `inv`='$inv' AND `main_line`='$line'";
    $result = mysql_query($query);
    confirm_query($result);
    $controller_data = mysql_fetch_array($result);
    return $controller_data;
}
function get_controller_list($lang,$line) {
    $query = "SELECT `inv` FROM `controller` WHERE `main_line`='$line'";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
        while($row = mysql_fetch_array($result)) {
            $controller_list[] = $row['inv'];
        }
	}
	else { $controller_list = get_error($lang, '1006'); }
    return $controller_list;
}
function get_controller_slines($lang,$line,$tk,$tl) {
    $query = "SELECT * FROM `controller` WHERE `main_line`='$line' AND `".$tk."` LIKE $tl";
    $result = mysql_query($query); 
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
        while($row = mysql_fetch_array($result)) {
            $controllers[] = $row["inv"]."-".$tk;
        }
	}
	else { $controllers = get_error($lang, '1006'); }
    return $controllers;
}
function count_controllers($line) {
	$count=0;
    $query = "SELECT `inv` FROM `controller` WHERE `main_line`='$line'";
    $result = mysql_query($query);
    confirm_query($result);
	$count=mysql_num_rows($result);
	return $count;
}
function count_valves($line) {
    $query = "SELECT SUM(cmode) AS cmodesum FROM `controller` WHERE `main_line`='$line'";
    $result = mysql_query($query);
    confirm_query($result);
    $sum=mysql_fetch_assoc($result);
	$value = $sum['cmodesum'];
	if ($value == NULL) { $value = 0; }
	return $value;
}
function count_m3($line,$inv,$id,$v_id) {
    $query = "SELECT SUM(v_k) AS v_ksum FROM `vodomer` WHERE `line`='$line' AND `inv`='$inv' AND `v_id`='$v_id'"; 
    $result = mysql_query($query);
    confirm_query($result);
    $sum=mysql_fetch_assoc($result);
	$value = $sum['v_ksum'];
	if ($value == NULL) { $value = 0; }
	return $value;
}
function count_m3_dated($line,$inv,$id,$v_id,$dates,$datex) {
    $query = "SELECT SUM(v_k) AS v_ksum FROM `vodomer` WHERE `line`='$line' AND `inv`='$inv' AND `v_id`='$v_id' AND `datetime` BETWEEN '$dates 00:00:00' AND '$datex 00:00:00' "; 
    $result = mysql_query($query);
    confirm_query($result);
    $sum=mysql_fetch_assoc($result);
	$value = $sum['v_ksum'];
	if ($value == NULL) { $value = 0; }
	return $value;
}
function get_line_data($lang,$line,$l) {
	echo "
    <script>
    jQuery(document).ready(function($) {
    	/*
        if ( $(window).width() > 767) {
		*/
			//clearInterval(refreshIdx);
 	        $('#data').load('t.php?lang=".$lang."&line=".$line."&l=".$l."&x=');
            var refreshId = setInterval(function() {
                $('#data').load('t.php?lang=".$lang."&line=".$line."&l=".$l."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });
        /*
        } else {
			clearInterval(refreshId);
 	        $('#data').load('t_m.php?lang=".$lang."&line=".$line."&l=".$l."&x=');
            var refreshIdx = setInterval(function() {
                $('#data').load('t_m.php?lang=".$lang."&line=".$line."&l=".$l."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });  
        }*/
    });
    /*
    $(window).bind('resize',function(){
        window.location.href = window.location.href;
    });*/
    </script>
    <div id=\"data\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_mobile_data($lang,$line,$id) {
	echo "
    <script>
    jQuery(document).ready(function($) {
 	        $('#data').load('t_ajax.php?lang=".$lang."&line=".$line."&id=".$id."&x=');
            var refreshIdx = setInterval(function() {
                $('#data').load('t_ajax.php?lang=".$lang."&line=".$line."&id=".$id."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });  
    });
    </script>
    <div id=\"data\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_line_data_extended($lang,$line,$l) {
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#data').load('t_e.php?lang=".$lang."&line=".$line."&l=".$l."&x=');
            var refreshId = setInterval(function() {
                $('#data').load('t_e.php?lang=".$lang."&line=".$line."&l=".$l."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id=\"data\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_new_controllers($line) {
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#new_c').load('t_c_new.php?line=".$line."&x=');
            var refreshId = setInterval(function() {
                $('#new_c').load('t_c_new.php?line=".$line."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id=\"new_c\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_dis_controllers($line) {
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#dis_c').load('t_c_dis.php?line=".$line."&x=');
            var refreshId = setInterval(function() {
                $('#dis_c').load('t_c_dis.php?line=".$line."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id=\"dis_c\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_stats_controllers($line,$lang) {
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#stats_c').load('t_c_stats.php?line=".$line."&x=');
            var refreshId = setInterval(function() {
                $('#stats_c').load('t_c_stats.php?line=".$line."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id=\"stats_c\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_line_printable_data($lang,$line,$l) {
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#data').load('t_p.php?lang=".$lang."&line=".$line."&l=".$l."&x=');
            var refreshId = setInterval(function() {
                $('#data').load('t_p.php?lang=".$lang."&line=".$line."&l=".$l."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id=\"data\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_check_controller_db($line,$inv) {
    $query = "SELECT `inv` FROM `controller` WHERE `main_line`='$line' AND `inv`='$inv'";
    $result = mysql_query($query);
    confirm_query($result);
    $inv = mysql_fetch_array($result);
	$cinv=$inv['inv'];
    return $cinv;
}
function get_controller_mode($line,$inv) {
    $query = "SELECT `cmode` FROM `controller` WHERE `main_line`='$line' AND `inv`='$inv'";
    $result = mysql_query($query);
    confirm_query($result);
    $mode = mysql_fetch_array($result);
	$cmode=$mode['cmode'];
    return $cmode;
}
function get_controllers_for_edit($lang,$line) {
    $query = "SELECT * FROM `lines` ORDER BY `line_name` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
		$page = curPageName();
        while ($lines = mysql_fetch_array($result)) {
		if (($line == $lines['line_name']) && ($page == 'controllers.php')) {
			echo "
                <li class=\"active\">
                    <a href=\"controllers.php?line={$lines['line_name']}&lang=$lang\">
                        <i class=\"fa fa-list-ul\"></i><span class=\"text\">{$lines['line_name']}</span>
                    </a>
                </li>";
		} else {
			echo "
                <li>
                    <a href=\"controllers.php?line={$lines['line_name']}&lang=$lang\">
                        <i class=\"fa fa-list-ul\"></i><span class=\"text\">{$lines['line_name']}</span>
                    </a>
                </li>";
	    }
	}
	} else {
        //do nothing
	}
}
function get_all_controllers($line) {
    $query = "SELECT `inv` FROM `controller` WHERE `main_line`='$line' ORDER BY `inv` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
        while($row = mysql_fetch_array($result)) {
            $controller_list[] = $row['inv'];
        }
	}
	else { $controller_list = ""; }
    return $controller_list;
}
function search_controller($inv) {
    $query = "SELECT inv, main_line FROM `controller` WHERE `inv` LIKE '%$inv%' ORDER BY `main_line` ASC, `inv` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		$found = array();
        while($row = mysql_fetch_array($result)) {
            //$found[] = $row['main_line'] . "," . $row['inv'];
            $found[$row['main_line']][] = $row['inv']; 
        }
	} 
	else { $found = NULL; }
	return $found;
}
function get_hits($lang) {
    $query = "SELECT * FROM `counter`";
    $result = mysql_query($query);
    confirm_query($result);
    $hits = mysql_fetch_array($result);
	$counter=$hits['counter'];
	echo "<span class=\"fr\"><em class=\"color\">#</em>0".$counter." ".get_lang($lang, 'Visits')."</span>";
	$addone=$counter+1;
    $add ="UPDATE counter SET counter='$addone'";
    $insert=mysql_query($add);
	confirm_query($insert);
}
function get_lang($lang, $ins) {
    $translation = Translate::getInstance();
    if (!$translation->languageExist($lang))
    $lang = "en";
    $translation->setLanguage($lang);
	return $translation->getTranslation($ins);
}
function set_lang() {
	get_settings();
    $lang = isset($_GET["lang"]) ? $_GET["lang"] : $settings['init_lang'];
	return $lang;
}
function calc_minutes($inv,$channel,$dates,$datex) {
    $coe = 289;
	$times = calc_alarms($inv,$channel,$dates,$datex);
	$minutes = $times*$coe;
	return number_format($minutes,0,'','');//return time of alarm
}
function sum_minutes($filter) {
	$query = "SELECT SUM(minutes) FROM `reports` WHERE `energy`>='$filter'";
    $rx = mysql_query($query);
    confirm_query($rx);
    while($row = mysql_fetch_array($rx)){
	    $r = $row['SUM(minutes)'];
	}
	if ($r == NULL) { $r = 0; }
    return number_format($r,0,'','');
}
function sum_min($filter) {
	$query = "SELECT SUM(minutes) FROM `reports` WHERE `energy`>='$filter'";
    $rx = mysql_query($query);
    confirm_query($rx);
    while($row = mysql_fetch_array($rx)){
	    $r = $row['SUM(minutes)'];
	}
	if ($r == NULL) { $r = 0; }
	else { $r = $r/60; }
    return number_format($r,0,'','');
}
function calc_temp($inv,$channel,$dates,$datex) {
    $query = "SELECT SUM(log_temp) AS log_tempsum FROM `alarms` WHERE `log_device` LIKE '$inv' AND `log_channel` LIKE '$channel' AND `log_date` BETWEEN '$dates' AND '$datex'";
    $rx = mysql_query($query);
    confirm_query($rx);
    $sum=mysql_fetch_assoc($rx);
	$value = $sum['log_tempsum'];
	if ($value == NULL) { $value = 0; }
	else { $alarms = calc_alarms($inv,$channel,$dates,$datex); $temp = $value/$alarms; }
	return number_format($temp,2); //return average temperature
}
function calc_treqt($inv,$channel,$dates,$datex) {
    $query = "SELECT SUM(log_treqt) AS log_treqtsum FROM `alarms` WHERE `log_device` LIKE '$inv' AND `log_channel` LIKE '$channel' AND `log_date` BETWEEN '$dates' AND '$datex'";
    $rx = mysql_query($query);
    confirm_query($rx);
    $sum=mysql_fetch_assoc($rx);
	$value = $sum['log_treqtsum'];
	if ($value == NULL) { $value = 0; }
	else { $alarms = calc_alarms($inv,$channel,$dates,$datex); $temp = $value/$alarms; }
	return number_format($temp,0); //return average temperature
}
function calc_alarms($inv,$channel,$dates,$datex) {
    $query = "SELECT * FROM `alarms` WHERE `log_device` LIKE '$inv' AND `log_channel` LIKE '$channel' AND `log_date` BETWEEN '$dates' AND '$datex'";
    $rx = mysql_query($query);
    confirm_query($rx);
	$count=mysql_num_rows($rx);
	if ($count == NULL) { $count = 0; }
	return $count; //total of alarms
}
function sum_alarms($filter) {
	$query = "SELECT SUM(alarms) FROM `reports` WHERE `energy`>='$filter'";
    $rx = mysql_query($query);
    confirm_query($rx);
    while($row = mysql_fetch_array($rx)){
	    $r = $row['SUM(alarms)'];	
	}
	if ($r == NULL) { $r = 0; }
    return $r;
}
function calc_energy_loss($temp,$treqt,$minutes) {
    $energy = ($temp-$treqt)*$minutes/1000;
	$energy = number_format($energy,2);
	return $energy;
}
function sum_energy($filter) {
	$query = "SELECT SUM(energy) FROM `reports` WHERE `energy`>='$filter'";
    $rx = mysql_query($query);
    confirm_query($rx);
    while($row = mysql_fetch_array($rx)){
	    $r = $row['SUM(energy)'];	
	}
	if ($r == NULL) { $r = 0; }
    return number_format($r, 2, '.', '');
}
function energo_loss_t($linex,$dates,$datex){
	$query = "truncate table reports";
	mysql_query($query);
	$dates = $dates . ' 00:00:00';
	$datex = $datex . ' 23:59:59';
	$result = mysql_query("SELECT * FROM `alarms` WHERE `log_line`='$linex' AND `log_date` BETWEEN '$dates' AND '$datex' group by `log_device`,`log_channel` ORDER BY `log_id` desc");
	confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
        while($row = mysql_fetch_array($result)) {
			$inv = $row['log_device'];
			$controller_data = get_controller_data($inv,$linex);
			$main_line = $linex;
			$line = $controller_data['line'];
			$group_number = $controller_data['group_number'];
			$group_name = $controller_data['group_name'];
            $channel = $row['log_channel'];
	        $treqt = calc_treqt($inv,$channel,$dates,$datex);//$row['log_treqt'];
            $temp = calc_temp($inv,$channel,$dates,$datex);
			$minutes = calc_minutes($inv,$channel,$dates,$datex);
			$energy = calc_energy_loss($temp,$treqt,$minutes);
			$alarms = calc_alarms($inv,$channel,$dates,$datex);
            insert_report($main_line,$line,$inv,$group_number,$group_name,$channel,$treqt,$temp,$energy,$minutes,$alarms);
        }
	} else {
		//do nothing
	}
}
function energo_loss_t_all($linex,$dates,$datex){
	$query = "truncate table reports";
	mysql_query($query);
	$dates = $dates . ' 00:00:00';
	$datex = $datex . ' 00:00:00';
	$result = mysql_query("SELECT * FROM `alarms` WHERE `log_line`='$linex' AND `log_date` BETWEEN '$dates' AND '$datex' group by `log_device`,`log_channel` ORDER BY `log_id` desc");
	confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
        while($row = mysql_fetch_array($result)) {
			$inv = $row['log_device'];
			$controller_data = get_controller_data($inv,$linex);
			$main_line = $linex;
			$line = $controller_data['line'];
			$group_number = $controller_data['group_number'];
			$group_name = $controller_data['group_name'];
            $channel = $row['log_channel'];
	        $treqt = calc_treqt($inv,$channel,$dates,$datex);//$row['log_treqt'];
            $temp = calc_temp($inv,$channel,$dates,$datex);
			$minutes = calc_minutes($inv,$channel,$dates,$datex);
			$energy = calc_energy_loss($temp,$treqt,$minutes);
			$alarms = calc_alarms($inv,$channel,$dates,$datex);
            insert_report($main_line,$line,$inv,$group_number,$group_name,$channel,$treqt,$temp,$energy,$minutes,$alarms);
        }
	} else {
		//do nothing
	}
}
function insert_report($main_line,$line,$inv,$group_number,$group_name,$channel,$treq,$temp,$energy,$minutes,$alarms) {
	$query = "INSERT INTO `reports` (`main_line`, `line`, `inv`, `group_number`, `group_name`, `channel`, `treq`, `temp`, `energy`, `minutes`, `alarms`) 
		      VALUES ('$main_line', '$line', '$inv', '$group_number', '$group_name', '$channel', '$treq', '$temp', '$energy', '$minutes', '$alarms')";
    $result = mysql_query($query);
    confirm_query($result);
}
function get_diagnostics($lang,$line) {
    $query = "SELECT * FROM `lines` ORDER BY `line_name` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
		$page = curPageName();
        while ($lines = mysql_fetch_array($result)) {
		if (($line == $lines['line_name']) && ($page == 'diagnostics.php')) {
			echo "<li class=\"active\">
                    <a href=\"diagnostics.php?line={$lines['line_name']}&lang=$lang\">
                        <i class=\"fa fa-warning\"></i><span class=\"text\">{$lines['line_name']}</span>
                    </a>
                </li>";
		} else {
			echo "<li>
                    <a href=\"diagnostics.php?line={$lines['line_name']}&lang=$lang\">
                        <i class=\"fa fa-warning\"></i><span class=\"text\">{$lines['line_name']}</span>
                    </a>
                </li>";
	    }
	}
	}
}
function get_line_status($line) {
    $options = get_line_options($line);
	$file = $options['data_file'];
    $datafile = "data/".$file;
	if ($datafile == NULL) { $caption = "caption_w"; }
	elseif (!file_exists($datafile)) { $caption = "caption_w"; } 
	elseif (filesize($datafile)<100) { $caption = "caption_r"; } 
	else { $caption = "caption_g"; }
	return $caption;
}
function get_lines($lang,$line) {
    $query = "SELECT * FROM `lines` ORDER BY `line_name` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
		$page = curPageName();
        while ($lines = mysql_fetch_array($result)) {
		$c = count_controllers($lines['line_name']);
		$caption = get_line_status($lines['line_name']);		
		if (($line == $lines['line_name']) && ($page == 'table.php')) {
			echo "<li class=\"active\">
                    <a href=\"table.php?line={$lines['line_name']}&l={$lines['line_sname']}&lang=$lang\">
                        <span class=\"isw-list\"></span><span class=\"text\">{$lines['line_name']}</span>
						<em class=\"".$caption." ttRC\" title=\"".get_lang($lang, 'inter115')."\">".$c."</em>
                    </a>
                </li>";
		} else {
			echo "<li>
                    <a href=\"table.php?line={$lines['line_name']}&l={$lines['line_sname']}&lang=$lang\">
                        <span class=\"isw-list\"></span><span class=\"text\">{$lines['line_name']}</span>
						<em class=\"".$caption." ttRC\" title=\"".get_lang($lang, 'inter115')."\">".$c."</em>
                    </a> 
                </li>";
	    }
	}
	}
}
function get_klines($lang,$kline) {
    $query = "SELECT * FROM `klima_lines` ORDER BY `router_name` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
		$page = curPageName();
        while ($klines = mysql_fetch_array($result)) {
		$c = count_klima($klines['router_name']);
		$caption = get_kline_status($klines['router_name']);		
		if (($kline == $klines['router_name']) && ($page == 'klimatik.php')) {
			echo "<li class=\"active\">
                    <a href=\"klimatik.php?kline={$klines['router_name']}&l={$klines['router_sname']}&lang=$lang\">
                        <span class=\"isw-list\"></span><span class=\"text\">{$klines['router_name']}</span>
						<em class=\"".$caption." ttRC\" title=\"".get_lang($lang, 'ad323')."\">".$c."</em>
                    </a>
                </li>";
		} else {
			echo "<li>
                    <a href=\"klimatik.php?kline={$klines['router_name']}&l={$klines['router_sname']}&lang=$lang\">
                        <span class=\"isw-list\"></span><span class=\"text\">{$klines['router_name']}</span>
						<em class=\"".$caption." ttRC\" title=\"".get_lang($lang, 'ad323')."\">".$c."</em>
                    </a> 
                </li>";
	    }
	}
	}
}
function count_klima($krouter) {
	$count=0;
    $query = "SELECT `id` FROM `klimatik` WHERE `router`='$krouter'";
    $result = mysql_query($query);
    confirm_query($result);
	$count=mysql_num_rows($result);
	return $count;
}
function get_krouter_options($krouter) {
	global $krouter_options;
    $query = "SELECT * FROM `klima_lines`";
	$query .= " WHERE `router_name`='$krouter'";
    $result = mysql_query($query);
    confirm_query($result);
    $krouter_options = mysql_fetch_array($result);
    return $krouter_options;
}
function get_kline_status($krouter) {
    $koptions = get_krouter_options($krouter);
	$file = $koptions['data_file'];
    $datafile = "data/".$file;
	if ($datafile == NULL) { $caption = "caption_w"; }
	elseif (!file_exists($datafile)) { $caption = "caption_w"; } 
	elseif (filesize($datafile)<100) { $caption = "caption_r"; } 
	else { $caption = "caption_g"; }
	return $caption;
}
function get_klima_data($inv,$krouter) {
	global $klima_data;
    $query = "SELECT * FROM `klimatik`";
	$query .= " WHERE `inv`='$inv' AND `router`='$krouter'";
    $result = mysql_query($query);
    confirm_query($result);
    $klima_data = mysql_fetch_array($result);
    return $klima_data;
}
function get_all_klimas($krouter) {
    $query = "SELECT `inv` FROM `klimatik`";
	$query .= " WHERE `router`='$krouter'";
	$query .= " order by `inv` asc";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
        while($row = mysql_fetch_array($result)) {
            $klima_list[] = $row['inv'];
        }
	}
	else { $klima_list = ""; }
    return $klima_list;
}
function get_klima_temps($kline,$inv) {
    $koptions = get_krouter_options($kline);
	$file = $koptions['data_file'];
    $datafile = "data/".$file;
    include("$datafile");
    $device = ${'dev'.$inv};
	return $device;
}
function get_device($line,$id) {
    $options = get_line_options($line);
	$file = $options['data_file'];
    $datafile = "data/".$file;
    if ($datafile == NULL) { get_error($lang,'1002'); exit; }
    if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
    include("$datafile");
    if (filesize($datafile)<100) { get_error($lang,'1004'); exit; }
    $device = ${'dev'.$id};
	return $device;
}

function get_device_for_widget($line,$id) {
    $options = get_line_options($line);
	$file = $options['data_file'];
    $datafile = "data/".$file;
    if ($datafile == NULL) { $device = NULL; }
    if (file_exists($datafile)) { } else { $device = NULL; }
    include("$datafile");
    if (filesize($datafile)<100) { $device = NULL; }
    $device = ${'dev'.$id};
	return $device;
}
function cron_side($lang,$seconds) {
	$s = $seconds*1000;
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#cron_side').load('cron_side.php?lang=".$lang."&x=');
            var refreshId = setInterval(function() {
                $('#cron_side').load('cron_side.php?lang=".$lang."&x='+ Math.random());
                }, $s);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id=\"cron_side\"></div>
	";
}
function curPageURL() {
    $pageURL = 'http';
    //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
function curPageName() {
    return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
function get_domain($domain) { 
    $domain = explode('/', str_replace('www.', '', str_replace('http://', '', $domain)));
    return $domain[0];
}
function decrypt($string, $key) {
  $result = '';
  $string = base64_decode($string);
  for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }
  return $result;
}
function array_insert($array,$pos,$val) {
    $array2 = array_splice($array,$pos);
    $array[] = $val;
    $array = array_merge($array,$array2);
    return $array;
}
function decodeSize($bytes) {
    $types = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    for($i = 0; $bytes >= 1024 && $i < (count($types ) -1 ); $bytes /= 1024, $i++);
    return(round($bytes, 2) . " " . $types[$i]);
}
function get_disk_free_space($drive) {
	$df = disk_free_space($drive);
	return $df;
}
function get_disk_total_space($drive) {
	$dt = disk_total_space($drive);
	return $dt;
}
function get_disk_used_space($drive) {
    $du = disk_total_space($drive) - disk_free_space($drive);
	return $du;
}
function get_disk_used_percent($drive) {
	$dp = (get_disk_used_space($drive) / get_disk_total_space($drive)) * 100;
	return $dp;
}
function byte_c($size, $precision = 2) {
	if (!is_numeric($size)) return '?';
	$notation = 1024;
	$types = array('B', 'KB', 'MB', 'GB', 'TB');
	for($i = 0; $size >= $notation && $i < (count($types) -1 ); $size /= $notation, $i++);
	return(round($size, $precision));
}
function count_online_controllers($line) { //online
    $line_options = get_line_options($line);
    $datafile = "data/{$line_options['data_file']}";
    if ($datafile == NULL) { $devc = 0; }
    if (file_exists($datafile)) { } else { $devc = 0; }
    include("$datafile");
if (filesize($datafile)<100) { $devc = 0; }
if(!($dev0 == NULL)) { $dev0d = explode(" ", $dev0); $devc++;}
if(!($dev1 == NULL)) { $dev1d = explode(" ", $dev1); $devc++;}
if(!($dev2 == NULL)) { $dev2d = explode(" ", $dev2); $devc++;}
if(!($dev3 == NULL)) { $dev3d = explode(" ", $dev3); $devc++;}
if(!($dev4 == NULL)) { $dev4d = explode(" ", $dev4); $devc++;}
if(!($dev5 == NULL)) { $dev5d = explode(" ", $dev5); $devc++;}
if(!($dev6 == NULL)) { $dev6d = explode(" ", $dev6); $devc++;}
if(!($dev7 == NULL)) { $dev7d = explode(" ", $dev7); $devc++;}
if(!($dev8 == NULL)) { $dev8d = explode(" ", $dev8); $devc++;}
if(!($dev9 == NULL)) { $dev9d = explode(" ", $dev9); $devc++;}
if(!($dev10 == NULL)) { $dev10d = explode(" ", $dev10); $devc++;}
if(!($dev11 == NULL)) { $dev11d = explode(" ", $dev11); $devc++;}
if(!($dev12 == NULL)) { $dev12d = explode(" ", $dev12); $devc++;}
if(!($dev13 == NULL)) { $dev13d = explode(" ", $dev13); $devc++;}
if(!($dev14 == NULL)) { $dev14d = explode(" ", $dev14); $devc++;}
if(!($dev15 == NULL)) { $dev15d = explode(" ", $dev15); $devc++;}
if(!($dev16 == NULL)) { $dev16d = explode(" ", $dev16); $devc++;}
if(!($dev17 == NULL)) { $dev17d = explode(" ", $dev17); $devc++;}
if(!($dev18 == NULL)) { $dev18d = explode(" ", $dev18); $devc++;}
if(!($dev19 == NULL)) { $dev19d = explode(" ", $dev19); $devc++;}
if(!($dev20 == NULL)) { $dev20d = explode(" ", $dev20); $devc++;}
if(!($dev21 == NULL)) { $dev21d = explode(" ", $dev21); $devc++;}
if(!($dev22 == NULL)) { $dev22d = explode(" ", $dev22); $devc++;}
if(!($dev23 == NULL)) { $dev23d = explode(" ", $dev23); $devc++;}
if(!($dev24 == NULL)) { $dev24d = explode(" ", $dev24); $devc++;}
if(!($dev25 == NULL)) { $dev25d = explode(" ", $dev25); $devc++;}
if(!($dev26 == NULL)) { $dev26d = explode(" ", $dev26); $devc++;}
if(!($dev27 == NULL)) { $dev27d = explode(" ", $dev27); $devc++;}
if(!($dev28 == NULL)) { $dev28d = explode(" ", $dev28); $devc++;}
if(!($dev29 == NULL)) { $dev29d = explode(" ", $dev29); $devc++;}
if(!($dev30 == NULL)) { $dev30d = explode(" ", $dev30); $devc++;}
if(!($dev31 == NULL)) { $dev31d = explode(" ", $dev31); $devc++;}
if(!($dev32 == NULL)) { $dev32d = explode(" ", $dev32); $devc++;}
if(!($dev33 == NULL)) { $dev33d = explode(" ", $dev33); $devc++;}
if(!($dev34 == NULL)) { $dev34d = explode(" ", $dev34); $devc++;}
if(!($dev35 == NULL)) { $dev35d = explode(" ", $dev35); $devc++;}
if(!($dev36 == NULL)) { $dev36d = explode(" ", $dev36); $devc++;}
if(!($dev37 == NULL)) { $dev37d = explode(" ", $dev37); $devc++;}
if(!($dev38 == NULL)) { $dev38d = explode(" ", $dev38); $devc++;}
if(!($dev39 == NULL)) { $dev39d = explode(" ", $dev39); $devc++;}
if(!($dev40 == NULL)) { $dev40d = explode(" ", $dev40); $devc++;}
if(!($dev41 == NULL)) { $dev41d = explode(" ", $dev41); $devc++;}
if(!($dev42 == NULL)) { $dev42d = explode(" ", $dev42); $devc++;}
if(!($dev43 == NULL)) { $dev43d = explode(" ", $dev43); $devc++;}
if(!($dev44 == NULL)) { $dev44d = explode(" ", $dev44); $devc++;}
if(!($dev45 == NULL)) { $dev45d = explode(" ", $dev45); $devc++;}
if(!($dev46 == NULL)) { $dev46d = explode(" ", $dev46); $devc++;}
if(!($dev47 == NULL)) { $dev47d = explode(" ", $dev47); $devc++;}
if(!($dev48 == NULL)) { $dev48d = explode(" ", $dev48); $devc++;}
if(!($dev49 == NULL)) { $dev49d = explode(" ", $dev49); $devc++;}
if(!($dev50 == NULL)) { $dev50d = explode(" ", $dev50); $devc++;}
if(!($dev51 == NULL)) { $dev51d = explode(" ", $dev51); $devc++;}
if(!($dev52 == NULL)) { $dev52d = explode(" ", $dev52); $devc++;}
if(!($dev53 == NULL)) { $dev53d = explode(" ", $dev53); $devc++;}
if(!($dev54 == NULL)) { $dev54d = explode(" ", $dev54); $devc++;}
if(!($dev55 == NULL)) { $dev55d = explode(" ", $dev55); $devc++;}
if(!($dev56 == NULL)) { $dev56d = explode(" ", $dev56); $devc++;}
if(!($dev57 == NULL)) { $dev57d = explode(" ", $dev57); $devc++;}
if(!($dev58 == NULL)) { $dev58d = explode(" ", $dev58); $devc++;}
if(!($dev59 == NULL)) { $dev59d = explode(" ", $dev59); $devc++;}
if(!($dev60 == NULL)) { $dev60d = explode(" ", $dev60); $devc++;}
if(!($dev61 == NULL)) { $dev61d = explode(" ", $dev61); $devc++;}
if(!($dev62 == NULL)) { $dev62d = explode(" ", $dev62); $devc++;}
if(!($dev63 == NULL)) { $dev63d = explode(" ", $dev63); $devc++;}
if(!($dev64 == NULL)) { $dev64d = explode(" ", $dev64); $devc++;}
return $devc;
}
function strToHex($string) {
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}
function hexToStr($hex) {
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
function authgMail($lang,$from,$namefrom,$to,$nameto,$subject,$message,$smtpServer,$port,$username,$password) {
    $timeout = "30";
    $localhost = $_SERVER['HTTP_HOST'];
    $newLine = "\r\n";
    $secure = 0;
    $smtpConnect = fsockopen($smtpServer,$port,$errno,$errstr,$timeout);
    $smtpResponse = fgets($smtpConnect, 4096);
    if(empty($smtpConnect)) {
        $output = get_lang($lang,'inter128').": ".$smtpResponse;
        echo $output;
        return $output;
    }
    else {
        /*$logArray['connection'] = "<span>".get_lang($lang,'inter129').": ".$smtpResponse."</span><br/>";*/
        echo "<span>".get_lang($lang,'inter130').": ".substr($smtpResponse,0,3)." OK ".substr($smtpResponse,4,12)."</span><br/>
		      <span>".substr($smtpResponse,-33)."</span><br/>";
    }
    fputs($smtpConnect, "HELO $localhost". $newLine);
    $smtpResponse = fgets($smtpConnect, 4096);
    $logArray['heloresponse2'] = "$smtpResponse";
	//echo "<span>HELO ".substr($smtpResponse,0,3)." OK </span><br/>";
    fputs($smtpConnect,"AUTH LOGIN" . $newLine);
    $smtpResponse = fgets($smtpConnect, 4096);
    $logArray['authrequest'] = "$smtpResponse";
	//echo "<span>AUTH ".substr($smtpResponse,0,3)." OK </span><br/>";
    fputs($smtpConnect, base64_encode($username) . $newLine);
    $smtpResponse = fgets($smtpConnect, 4096);
    $logArray['authusername'] = "$smtpResponse";
	//echo "<span>USER ".substr($smtpResponse,0,3)." OK </span><br/>";
    fputs($smtpConnect, base64_encode($password) . $newLine);
    $smtpResponse = fgets($smtpConnect, 4096);
    $logArray['authpassword'] = "$smtpResponse";
	//echo "<span>PASS ".substr($smtpResponse,0,3)." OK </span><br/>";
    fputs($smtpConnect, "MAIL FROM: <$from>" . $newLine);
    $smtpResponse = fgets($smtpConnect, 4096);
    $logArray['mailfromresponse'] = "$smtpResponse";
    fputs($smtpConnect, "RCPT TO: <$to>" . $newLine);
    $smtpResponse = fgets($smtpConnect, 4096);
    $logArray['mailtoresponse'] = "$smtpResponse";
	//echo "<span>SENDING ".substr($smtpResponse,0,3)." OK </span><br/>";
    fputs($smtpConnect, "DATA" . $newLine);
    $smtpResponse = fgets($smtpConnect, 4096);
    $logArray['data1response'] = "$smtpResponse";
    $headers = "MIME-Version: 1.0" . $newLine;
    $headers .= "Content-type: text/html; charset=UTF-8" . $newLine;
    $headers .= "From: $namefrom <$from>" . $newLine;
    fputs($smtpConnect, "To: $to\r\nFrom: $from\r\nSubject: $subject\r\n$headers\r\n\r\n$message\r\n.\r\n");
    $smtpResponse = fgets($smtpConnect, 4096);
    $logArray['data2response'] = "$smtpResponse";
    fputs($smtpConnect,"QUIT" . $newLine);
    $smtpResponse = fgets($smtpConnect, 4096);
    $logArray['quitresponse'] = "$smtpResponse";
    $logArray['quitcode'] = substr($smtpResponse,0,3);
	//echo "<span>QUIT ".substr($smtpResponse,0,3)." OK </span><br/>";
    fclose($smtpConnect);
    return($logArray);
}
final class BarcodeQR {
	const API_CHART_URL = "http://chart.apis.google.com/chart";
	private $_data;
	public function bookmark($title = null, $url = null) {
		$this->_data = "MEBKM:TITLE:{$title};URL:{$url};;";
	}
	public function contact($name = null, $address = null, $phone = null, $email = null) {
		$this->_data = "MECARD:N:{$name};ADR:{$address};TEL:{$phone};EMAIL:{$email};;";
	}
	public function content($type = null, $size = null, $content = null) {
		$this->_data = "CNTS:TYPE:{$type};LNG:{$size};BODY:{$content};;";
	}
	public function draw($size = 512, $filename = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::API_CHART_URL);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($this->_data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$img = curl_exec($ch);
		curl_close($ch);
		if($img) {
			if($filename) {
				if(!preg_match("#\.png$#i", $filename)) {
					$filename .= ".png";
				}
				return file_put_contents($filename, $img);
			} else {
				header("Content-type: image/png");
				print $img;
				return true;
			}
		}
		return false;
	}
	public function email($email = null, $subject = null, $message = null) {
		$this->_data = "MATMSG:TO:{$email};SUB:{$subject};BODY:{$message};;";
	}
	public function geo($lat = null, $lon = null, $height = null) {
		$this->_data = "GEO:{$lat},{$lon},{$height}";
	}
	public function phone($phone = null) {
		$this->_data = "TEL:{$phone}";
	}
	public function sms($phone = null, $text = null) {
		$this->_data = "SMSTO:{$phone}:{$text}";
	}
	public function text($text = null) {
		$this->_data = $text;
	}
	public function url($url = null) {
		$this->_data = preg_match("#^https?\:\/\/#", $url) ? $url : "http://{$url}";
	}
	public function wifi($type = null, $ssid = null, $password = null) {
		$this->_data = "WIFI:T:{$type};S{$ssid};{$password};;";
	}
}
function time_since($original) {
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'),
        array(60 * 60 , 'hour'),
        array(60 , 'minute'),
    );
    $today = time();
    $since = $today - $original;
	if($since > 604800) {
		$print = date("M jS", $original);
		if($since > 31536000) {
				$print .= ", " . date("Y", $original);
		}
		return $print;
	}
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }
    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
      return $print . " ago";
}
function get_temp_from_bar($bar) {
    $a=8.14019;
    $b=1810.94;
    $c=244.485;
    $d=log10($bar*750.061683);
    $r = $b/($a-$d)-$c;
    return number_format($r,2);
}
function charts_init() {
	echo "
<script type='text/javascript' charset='UTF-8'>
    $(function () {
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]
		        ]
		    };
		});
    });
</script>";
}
function explodeX($delimiters,$string){
    $return_array = Array($string);
    $d_count = 0;
    while (isset($delimiters[$d_count])) {
        $new_return_array = Array();
        foreach($return_array as $el_to_split) {
            $put_in_new_return_array = explode($delimiters[$d_count],$el_to_split);
            foreach($put_in_new_return_array as $substr) {
                $new_return_array[] = $substr;
            }
        }
        $return_array = $new_return_array;
        $d_count++;
    }
    return $return_array;
}
function CRC16_by_one($str) {
    $crc16 = 0xFFFF;//the CRC seed
    $len = strlen($str);
    for($i = 0; $i < $len; $i++ ) {
		$crc16 = $crc16 ^ $str[$i];
		for($j = 0; $j < 8; $j++ ) {
		    $k = $crc16 & 1;	
			$crc16 = (($crc16 & 0xfffe) /2) & 0x7FFF;
			if ($k > 0) {
				$crc16 = $crc16 ^ 0xA001;
			}
		}
	}
    return $crc16;
}
function CRC16HexDigest($str) {
    return sprintf('%02X', crc16($str));
}
function get_crc16_of($str) {
	$str = CRC16HexDigest($str);
	//return $str;
	return chunk_split($str,2);
}
function crc16($values) {
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
	return dechex($hi) ." ". dechex($lo);
}
//new
function get_problem($id) {
    $query = "SELECT `problem` FROM `tasks_problems` WHERE `id`='".$id."'";
    $result = mysql_query($query);
    confirm_query($result);
    $problem = mysql_fetch_array($result);
    return $problem['problem'];
}
function get_part($id) {
	if ($id != '0') {
        $query = "SELECT `parts` FROM `tasks_parts` WHERE `id`='".$id."'";
        $result = mysql_query($query);
        confirm_query($result);
        $part = mysql_fetch_array($result);
        return $part['parts'];
	} else {
		return '0';
	}
}
function get_name_from($user) {
    $query = "SELECT * FROM `users` WHERE `user_name`='$user'";
    $result = mysql_query($query);
    confirm_query($result);
    $name = mysql_fetch_array($result);
    return $name['first_name']." ".$name['last_name'];
}
function get_line_from($inv) {
    $query = "SELECT `main_line` FROM `controller` WHERE `inv`='$inv'";
    $result = mysql_query($query);
    confirm_query($result);
    $name = mysql_fetch_array($result);
    return $name['main_line'];
}
function seconds2human($ss,$lang) {
    $s = $ss%60;
    $m = floor(($ss%3600)/60);
    $h = floor(($ss%86400)/3600);
    $d = floor(($ss%2592000)/86400);
    $M = floor($ss/2592000);
    $return = "";
    if ($M > 0) { $return .= $M." ".get_lang($lang,'ad465')." "; }
    if ($d > 0) { $return .= $d." ".get_lang($lang,'inter21')." "; }
    if ($h > 0) { $return .= $h." ".get_lang($lang,'inter19')." "; }    
    if ($m > 0) { $return .= $m." ".get_lang($lang,'inter23')." "; }
    //$return .= $s." Seconds";
    return $return;
}
function sec2hm($sec) {
    $hours = floor($sec / 3600);
    $minutes = floor(($sec / 60) % 60);
    if ($hours < 10) { $hours = "0".$hours; }
    if ($minutes < 10) { $minutes = "0".$minutes; }
    return $hours.".".$minutes;
}
?>