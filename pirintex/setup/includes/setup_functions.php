<?php
error_reporting(0);
defined('start') or die('Direct access not allowed.');
function confirm_query($query) {
    if (!$query) { die("Database Query failed !. Check Database Settings." . mysql_error()); }
}
function mysql_prep($value) {
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists("mysql_real_escape_string");
    if ($new_enough_php) {
        if ($magic_quotes_active) {
            $value = stripslashes($value);
        }
        $value = mysql_real_escape_string($value);
    } else {
        if (!$magic_quotes_active) {
            $value = addslashes($value);
        }
    }
    return $value;
}
function check_email($email) {
	$e = base64_decode($email);
    $query = "SELECT * FROM `users` ";
    $query .= "WHERE `email`='$e'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
	if ($check==1) { return TRUE; }
    else { return FALSE; }
}
function check_s_email($email) {
	$e = base64_decode($email);
    $query = "SELECT * FROM `users` ";
    $query .= "WHERE `s_email`='$e'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
	if ($check==1) { return TRUE; }
    else { return FALSE; }
}
function check_user_settings($username) {
	$u = base64_decode($username);
    return get_user_for_edit($u);
}
function get_user_for_edit($user) {
    $query = "SELECT * FROM `users` ";
    $query .= "WHERE `user_name`='$user'";
    $result = mysql_query($query);
    confirm_query($result);
    $user_settings = mysql_fetch_array($result);
    return $user_settings;
}
function check_username($lang,$username,$password,$line,$id,$inv,$web_dir,$sys) {
	$u = base64_decode($username);
	$p = md5(base64_decode($password));
    $query = "SELECT * FROM `users` ";
    $query .= "WHERE `user_name`='$u'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
	if ($check==1) {
	    check_password($lang,$u,$p,$line,$id,$inv,$web_dir,$sys);
	}
    else {
	    $error = get_lang($lang, '1010');
		$location = "error.php?lang=".$lang."&error=".$error."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
		header("location:$location");
    }
}
function check_password($lang,$username,$password,$line,$id,$inv,$web_dir,$sys) {
    $query = "SELECT * FROM `users` ";
    $query .= "WHERE `user_name`='$username' and `h_password`='$password'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
	if ($check==1) {
	    check_status($lang,$username,$password,$line,$id,$inv,$web_dir,$sys);
	}
    else {
	    $error = get_lang($lang, '1011');
		$location = "error.php?lang=".$lang."&error=".$error."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
		header("location:$location");
    }
}
function check_status($lang,$username,$password,$line,$id,$inv,$web_dir,$sys) {
    $query = "SELECT * FROM `users` ";
    $query .= "WHERE `user_name`='$username' and `h_password`='$password'";
    $result = mysql_query($query);
    confirm_query($result);
	if (mysql_num_rows($result) == 1) {
        while($row = mysql_fetch_array($result)) {
		    $status = $row['status'];
        }
        if ($status == 'Active') {
			session_name($web_dir);
            session_start();
			$_SESSION[$web_dir] = $web_dir;
            $_SESSION[$web_dir.'_username'] = $username;
			$location = "success.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
            header("location:$location");
        }
        elseif ($status == 'Deactivated') {
	        $error = get_lang($lang, '1012');
		    $location = "error.php?lang=".$lang."&error=".$error."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
		    header("location:$location");	
        } 
        elseif ($status == 'Pending') {
	        $error = get_lang($lang, '1013');
		    $location = "error.php?lang=".$lang."&error=".$error."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
		    header("location:$location");	
        }
        else {
	        $error = get_lang($lang, '1001');
		    $location = "error.php?lang=".$lang."&error=".$error."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
		    header("location:$location");	
        }
	}
    else {
	        $error = get_lang($lang, '1001');
		    $location = "error.php?lang=".$lang."&error=".$error."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
		    header("location:$location");	
    }
}
function update_login($lang,$username,$line,$id,$inv,$sys) {
	$updated = date('Y-m-d H:i:s');
    mysql_query("UPDATE `users` SET `last_login`='$updated' WHERE `user_name`='$username'");
	if ($sys == 'klima') {
	    $location = "klima.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
	    header("location:$location");
	} elseif ($sys == 'klimatik') {
	    $location = "klimatik_setup.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
	    header("location:$location");
	} else {
	    $location = "setup.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
	    header("location:$location");
	}
}
function check_login($lang,$line,$id,$inv,$web_dir,$sys){
    //session_start();
	//new php 5.4
    if (session_status() == PHP_SESSION_NONE) {
		session_name($web_dir);
        session_start();
    }	
    function check_loggedin($web_dir) {
		if(isset($_SESSION[$web_dir.'_username']) && ($_SESSION[$web_dir] == $web_dir)) {
			return TRUE;
        } else {
			return FALSE;
		}
        //return isset($_SESSION[$web_dir.'_username']) && ($_SESSION['APP'] == $web_dir);
    }
    if (!check_loggedin($web_dir)) {
        //session_destroy();
		$_SESSION[$web_dir] = NULL;
        unset($_COOKIE['EESYSTEMS']);
		$location = "login.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys;
	    header("location:$location");
    }
    else {
       header('Content-Type: text/html; charset=utf-8');
	   $user_settings = get_user_settings($_SESSION[$web_dir.'_username']);
	   $_SESSION[$web_dir] = $web_dir;
    }
}
function get_user_settings($user) {
	global $user_settings;
    $query = "SELECT * FROM `users` ";
    $query .= "WHERE `user_name`='$user'";
    $result = mysql_query($query);
    confirm_query($result);
    $user_settings = mysql_fetch_array($result);
    return $user_settings;
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
function get_settings() {
    global $settings;
    $query = "SELECT * FROM `settings`";
    $result = mysql_query($query);
    confirm_query($result);
    $settings = mysql_fetch_array($result);
    return $settings;
}
function get_line_options($line) {
	global $line_options;
    $query = "SELECT * FROM `lines`";
	$query .= " WHERE `line_name`='$line'";
    $result = mysql_query($query);
    confirm_query($result);
    $line_options = mysql_fetch_array($result);
    return $line_options;
}
function insert_log($lang,$user,$filter,$action,$obs) {
	$date = date('Y-m-d');
	$time = date('H:i:s');
	if ($obs == NULL) { $obs = ""; }
	$query = "INSERT INTO `logs` (`date`, `time`, `user`, `filter`, `action`, `obs`) 
		      VALUES ('$date', '$time', '$user', '$filter', '$action', '$obs')";
    $result = mysql_query($query);
    confirm_query($result);
}
function multiexplode($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return $launch;
}
function get_c_info($lang,$line,$id,$inv) {
	$rand = rand(1000,9999);
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#data_$rand').load('live_td.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&x=');
            var refreshId = setInterval(function() {
                $('#data_$rand').load('live_td.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&x='+ Math.random());
                }, 1000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id='data_$rand'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
}
function get_c_params($lang,$line,$id,$inv) {
	$rand = rand(1000,9999);
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#data_$rand').load('live_pa.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&x=');
            var refreshId = setInterval(function() {
                $('#data_$rand').load('live_pa.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&x='+ Math.random());
                }, 5000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id='data_$rand'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
}
function get_c_status($lang,$line,$id,$inv) {
	$rand = rand(1000,9999);
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#data_$rand').load('live_st.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&x=');
            var refreshId = setInterval(function() {
                $('#data_$rand').load('live_st.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&x='+ Math.random());
                }, 4000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id='data_$rand'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
}
function get_c_temps($lang,$line,$id,$inv) {
	$rand = rand(1000,9999);
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#data_$rand').load('live_temp.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&x=');
            var refreshId = setInterval(function() {
                $('#data_$rand').load('live_temp.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&x='+ Math.random());
                }, 2000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id='data_$rand'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
}
function get_c_stk($lang,$line,$id,$inv) {
	$rand = rand(1000,9999);
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#data_$rand').load('live_stk.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&x=');
            var refreshId = setInterval(function() {
                $('#data_$rand').load('live_stk.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&x='+ Math.random());
                }, 2000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id='data_$rand'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
}
function sys_console($lang,$msg) {
    $rand = rand(1000,9999);
	$time_f = date('H:i:s');
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_console() {
		$('span#l1').text(' ".get_lang($lang,$msg)."...');		
	}
    $(function () { get_console(); });
</script>";
    echo "<span>".$time_f." </span><i class='fa fa-angle-right'></i><span id='l1'></span><br/>";
}
function error_console($lang,$msg) {
    $rand = rand(1000,9999);
	$time_f = date('H:i:s');
    echo "
<script type='text/javascript' charset='UTF-8'>
    function error_console() {
		$('span#e1').text(' ".get_lang($lang,$msg)."...');		
	}
    $(function () { error_console(); });
</script>";
    echo "<span>".$time_f." </span><i class='fa fa-angle-right'></i><span class='text-error' id='e1'></span><br/>";
}
function clear_cron() {
	$fh = fopen('cron.php', 'w');
	$fh2 = fopen('cron2.php', 'w');
    fclose($fh);
    fclose($fh2);
}
function setup_ti($lang,$line,$id) {
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_ti() {
	    setInterval(function () {
			$.ajax({
				url: 'live_ti.php?lang=$lang&line=$line&id=$id', 
				success: function(point) {
		    y = eval(point);
			$('span#t').text(y[1]);
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () { get_live_ti(); });
</script>";
echo "<span id='t'>0</span>";
}
function setup_di($lang,$line,$id) {
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_di() {
	    setInterval(function () {
			$.ajax({
				url: 'live_di.php?lang=$lang&line=$line&id=$id', 
				success: function(point) {
		    y = eval(point);
			$('span#d').text(y[1]);
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () { get_live_di(); });
</script>";
echo "<span id='d'>0</span>";
}
function setup_day($lang) {
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_day() {
	    setInterval(function () {
			$.ajax({
				url: 'live_day.php?lang=$lang', 
				success: function(point) {
		    y = eval(point);
			$('span#da').text(y[1]);
			$('span#dn').text(y[2]);
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () { get_live_day(); });
</script>";
echo "<span id='da'>0</span> (<span id='dn'>0</span>)";
}
function setup_wt() {
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_wt() {
	    setInterval(function () {
			$.ajax({
				url: 'live_wt.php', 
				success: function(point) {
		    y = eval(point);
			$('span#wt').html(y[1]);
			},
				cache: false
			});
	    }, 2000);
	}
    $(function () { get_live_wt(); });
</script>";
echo "<span id='wt'>0</span>";
}
function server_time() {
    echo "
<script type='text/javascript' charset='UTF-8'>
    $('#stime').load('time.php');
    function get_server_time() {
	    setInterval(function () {
			$.ajax({
				url: 'time.php', 
				success: function(data) {
			$('span#stime').html(data);
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () { get_server_time(); });
</script>";
echo "<span id='stime'>0</span>";
}
function server_date() {
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_server_date() {
		$('#sdate').load('date.php');
	    setInterval(function () {
			$.ajax({
				url: 'date.php', 
				success: function(data) {
			$('span#sdate').html(data);
			},
				cache: false
			});
	    }, 60000);
	}
    $(function () { get_server_date(); });
</script>";
echo "<span id='sdate'>0</span>";
}
function setup_work_schedule() {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_work_schedule() {
			$.ajax({
				url: 'live_ws.php', 
				success: function(point) {
		    y = eval(point);
			$('#x1').val(y[1]);
			$('#x2').val(y[2]);
			$('#x3').val(y[3]);
			$('#x4').val(y[4]);
			$('#x5').val(y[5]);
			$('#x6').val(y[6]);
			$('#x7').val(y[7]);
			$('#x8').val(y[8]);
			$('#x9').val(y[9]);
			$('#x10').val(y[10]);
			$('#x11').val(y[11]);
			$('#x12').val(y[12]);
			$('#x13').val(y[13]);
			$('#x14').val(y[14]);
			$('#x15').val(y[15]);
			$('#x16').val(y[16]);
			$('#x17').val(y[17]);
			$('#x18').val(y[18]);
			$('#x19').val(y[19]);
			$('#x20').val(y[20]);
			$('#x21').val(y[21]);
			$('#x22').val(y[22]);
			$('#x23').val(y[23]);
			$('#x24').val(y[24]);
			$('#x25').val(y[25]);
			$('#x26').val(y[26]);
			$('#x27').val(y[27]);
			$('#x28').val(y[28]);
			$('#x29').val(y[29]);
			$('#x30').val(y[30]);
			$('#x31').val(y[31]);
			$('#x32').val(y[32]);
			},
				cache: false
			});
	}
$(document).ready(function(){
  var clicked_$rand = false;
  var Start_$rand = function () {
      if (clicked_$rand) return;
      get_work_schedule();
      setTimeout(Start_$rand, 1000);
  };
  Start_$rand();
  $(document).on('click','.temp',function() {
     clicked_$rand = true;
  });
});
</script>";
}
function setup_numbers() {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_numbers() {
			$.ajax({
				url: 'live_nu.php', 
				success: function(point) {
		    n = eval(point);
			$('#nu1').val(n[1]);
			$('#nu2').val(n[2]);
			$('#nu3').val(n[3]);
			$('#nu4').val(n[4]);
			$('#nu5').val(n[5]);
			$('#nu6').val(n[6]);
			$('#nu7').val(n[7]);
			$('#nu8').val(n[8]);
			$('#nu9').val(n[9]);
			$('#nu10').val(n[10]);
			$('#nu11').val(n[11]);
			$('#nu12').val(n[12]);
			$('#nu13').val(n[13]);
			$('#nu14').val(n[14]);
			$('#nu15').val(n[15]);			
			},
				cache: false
			});
	}
$(document).ready(function(){
  var clicked_$rand = false;
  var Start_$rand = function () {
      if (clicked_$rand) return;
      get_numbers();
      setTimeout(Start_$rand, 1000);
  };
  Start_$rand();
  $(document).on('click','.numb',function() {
     clicked_$rand = true;
  });
});
</script>";
}
function setup_stb() {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_stb() {
			$.ajax({
				url: 'live_stb.php', 
				success: function(point) {
		    y = eval(point);
			$('span#stb').html(y[1]);
			},
				cache: false
			});
	}
$(document).ready(function(){
  var clicked_$rand = false;
  var Start_$rand = function () {
      if (clicked_$rand) return;
      get_live_stb();
      setTimeout(Start_$rand, 1000);
  };
  Start_$rand();
  $(document).on('click','#stb',function() {
     clicked_$rand = true;
  });
});
</script>";
echo "<span id='stb'>0</span>";
}
function setup_lv() {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_lv() {
			$.ajax({
				url: 'live_lv.php', 
				success: function(point) {
		    y = eval(point);
			$('span#lv').html(y[1]);
			},
				cache: false
			});
	}
$(document).ready(function(){
  var clicked_$rand = false;
  var Start_$rand = function () {
      if (clicked_$rand) return;
      get_live_lv();
      setTimeout(Start_$rand, 1000);
  };
  Start_$rand();
  $(document).on('click','#lv',function() {
     clicked_$rand = true;
  });
});
</script>";
echo "<span id='lv'>0</span>";
}
function setup_tempx() {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_tempx() {
			$.ajax({
				url: 'live_tp.php', 
				success: function(point) {
		    tx = eval(point);
			$('#te1').val(tx[1]);
			$('#te2').val(tx[2]);
			$('#te3').val(tx[3]);
			$('#te4').val(tx[4]);
			$('#te5').val(tx[5]);
			$('#te6').val(tx[6]);
			$('#te7').val(tx[7]);
			$('#te8').val(tx[8]);
			$('#te9').val(tx[9]);
			$('#te10').val(tx[10]);	
			},
				cache: false
			});
	}
$(document).ready(function(){
  var clicked_$rand = false;
  var Start_$rand = function () {
      if (clicked_$rand) return;
      get_tempx();
      setTimeout(Start_$rand, 1000);
  };
  Start_$rand();
  $(document).on('click','.tempx',function() {
     clicked_$rand = true;
  });
});
</script>";
}
function setup_stp() {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_stp() {
			$.ajax({
				url: 'live_stp.php', 
				success: function(point) {
		    stp = eval(point);
			$('#stp1').val(stp[1]);
			$('#stp2').val(stp[2]);
			$('#stp3').val(stp[3]);
			},
				cache: false
			});
	}
$(document).ready(function(){
  var clicked_$rand = false;
  var Start_$rand = function () {
      if (clicked_$rand) return;
      get_live_stp();
      setTimeout(Start_$rand, 1000);
  };
  Start_$rand();
  $(document).on('click','.stp',function() {
     clicked_$rand = true;
  });
});
</script>";
}
function read_parameters($socket_ip,$socket_port,$id) {
    $server = 'r';
    $command = "AP";
    sleep(3);
    try {
	    $sc = new ClientSocket();
	    $sc->open($socket_ip,$socket_port);
	    $sc->send("$server $command $id\r\n");
    }
    catch (Exception $e){
	    echo $e->getMessage();
    }
}
function get_controller_data($inv,$line) {
	global $controller_data;
    $query = "SELECT * FROM `controller`";
	$query .= " WHERE `inv`='$inv' AND `main_line`='$line'";
    $result = mysql_query($query);
    confirm_query($result);
    $controller_data = mysql_fetch_array($result);
    return $controller_data;
}
function redir($url,$seconds) {
    echo "
<script type='text/javascript' charset='UTF-8'>
function redirect() {
    window.location = '" . $url . "';
}
timer = setTimeout('redirect()', '" . ($seconds*1000) . "')
</script>\n";
return true;
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
function random_password() {
	$randomp = rand(10000000,99999999);
	return $randomp;
}
function update_random_password($lang,$username) {
	$rand_pass = random_password();
	$random_password = md5($rand_pass);
    $query = "UPDATE `users` SET `h_password`='$random_password' WHERE `user_name`='$username'";
    $result = mysql_query($query);
    confirm_query($result);
    if ($result) {
	    $updated = date('Y-m-d H:i:s');
        mysql_query("UPDATE `users` SET `last_reset`='$updated' WHERE `user_name`='$username'");
        $result = mysql_query($query);
        confirm_query($result);
        return $rand_pass;
    } else {
		return FALSE;
    }
}
function get_controller_list($lang,$line) {
    $query = "SELECT `inv` FROM `controller`";
	$query .= " WHERE `main_line`='$line'";
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
function count_controllers($line) {
	$count=0;
    $query = "SELECT `inv` FROM `controller`";
	$query .= " WHERE `main_line`='$line'";
    $result = mysql_query($query);
    confirm_query($result);
	$count=mysql_num_rows($result);
	return $count;
}
function count_valves($line) {
    $query = "SELECT SUM(cmode) AS cmodesum FROM controller WHERE main_line='$line'";
    $result = mysql_query($query);
    confirm_query($result);
    $sum=mysql_fetch_assoc($result);
	$value = $sum['cmodesum'];
	if ($value == NULL) { $value = 0; }
	return $value;
}
function quick_switch($lang,$line,$id,$inv,$sys) {
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#quick').load('controller_switch.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys."&x=');
            var refreshId = setInterval(function() {
                $('#quick').load('controller_switch.php?lang=".$lang."&line=".$line."&id=".$id."&inv=".$inv."&sys=".$sys."&x='+ Math.random());
                }, 8000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id='quick'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
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
    <div id='new_c'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
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
    <div id='dis_c'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
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
    <div id='stats_c'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
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
    <div id='cron_side'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
}









function get_check_controller_db($line,$inv) {
    $query = "SELECT `inv` FROM `controller`";
	$query .= " WHERE `main_line`='$line' AND `inv`='$inv'";
    $result = mysql_query($query);
    confirm_query($result);
    $inv = mysql_fetch_array($result);
	$cinv=$inv['inv'];
    return $cinv;
}
function get_controller_mode($line,$inv) {
    $query = "SELECT `cmode` FROM `controller`";
	$query .= " WHERE `main_line`='$line' AND `inv`='$inv'";
    $result = mysql_query($query);
    confirm_query($result);
    $mode = mysql_fetch_array($result);
	$cmode=$mode['cmode'];
    return $cmode;
}
function get_hits($lang) {
    $query = "SELECT * FROM `counter`";
    $result = mysql_query($query);
    confirm_query($result);
    $hits = mysql_fetch_array($result);
	$counter=$hits['counter'];
	echo "<span class='fr'><em class='color'>#</em>0".$counter." ".get_lang($lang, 'Visits')."</span>";
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
    $lang = isset($_GET["lang"]) ? $_GET["lang"] : "en";
	return $lang;
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
class Base64 {
     private static $BinaryMap = array(
         'i', 'j', 'c', 'd', 'e', 'f', 'g', 'h', //  7
         'a', 'b', 'k', 'l', 'm', 'n', 'o', 'x', // 15
         'q', 'r', '9', 't', 'u', 'v', 'w', 'x', // 23
         'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', // 31
         'G', 'H', 'I', 'J', 'K', 'L', 'M', 'V', // 39
         'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'N', // 47
         'W', 'P', 'Y', 'Z', '0', '1', '2', '3', // 55
         '4', '5', '6', '7', '8', 'S', '+', '/', // 63 
         '=', //64
     );
     public function __construct() {}
     public function base64_encode($input) {
         $output = "";
         $chr1 = $chr2 = $chr3 = $enc1 = $enc2 = $enc3 = $enc4 = null;
         $i = 0;
         while($i < strlen($input)) {
             $chr1 = ord($input[$i++]);
             $chr2 = ord($input[$i++]);
             $chr3 = ord($input[$i++]);
             $enc1 = $chr1 >> 2;
             $enc2 = (($chr1 & 3) << 4) | ($chr2 >> 4);
             $enc3 = (($chr2 & 15) << 2) | ($chr3 >> 6);
             $enc4 = $chr3 & 63;
             if (is_nan($chr2)) {
                 $enc3 = $enc4 = 64;
             } else if (is_nan($chr3)) {
                 $enc4 = 64;
             }
             $output .=  self::$BinaryMap[$enc1]
                       . self::$BinaryMap[$enc2]
                       . self::$BinaryMap[$enc3]
                       . self::$BinaryMap[$enc4]; 
         }
         return $output;
     }
     public function utf8_encode($input) {
         $utftext = null;   
         for ($n = 0; $n < strlen($input); $n++) {
             $c = ord($input[$n]);
             if ($c < 128) {
                 $utftext .= chr($c);
             } else if (($c > 128) && ($c < 2048)) {
                 $utftext .= chr(($c >> 6) | 192);
                 $utftext .= chr(($c & 63) | 128);
             } else {
                 $utftext .= chr(($c >> 12) | 224);
                 $utftext .= chr((($c & 6) & 63) | 128);
                 $utftext .= chr(($c & 63) | 128);
             }
         }
         return $utftext;
     }
}
function byte_c($size, $precision = 2) {
	if (!is_numeric($size)) return '?';
	$notation = 1024;
	$types = array('B', 'KB', 'MB', 'GB', 'TB');
	for($i = 0; $size >= $notation && $i < (count($types) -1 ); $size /= $notation, $i++);
	return(round($size, $precision));
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
function get_day_name($nday) {
	if ($nday == '0') { $day = 'Неделя'; }
	if ($nday == '1') { $day = 'Понеделник'; }
	if ($nday == '2') { $day = 'Вторник'; }
	if ($nday == '3') { $day = 'Сряда'; }
	if ($nday == '4') { $day = 'Четвъртък'; }
	if ($nday == '5') { $day = 'Петък'; }
	if ($nday == '6') { $day = 'Събота'; }
	return $day;
}
function get_month_name($nmonth) {
	if ($nmonth == '1') { $month = 'Януари'; }
	if ($nmonth == '2') { $month = 'Февруари'; }
	if ($nmonth == '3') { $month = 'Март'; }
	if ($nmonth == '4') { $month = 'Април'; }
	if ($nmonth == '5') { $month = 'Май'; }
	if ($nmonth == '6') { $month = 'Юни'; }
	if ($nmonth == '7') { $month = 'Юли'; }
	if ($nmonth == '8') { $month = 'Август'; }
	if ($nmonth == '9') { $month = 'Септември'; }
	if ($nmonth == '10') { $month = 'Октомври'; }
	if ($nmonth == '11') { $month = 'Ноември'; }
	if ($nmonth == '12') { $month = 'Декември'; }
	return $month;
}
function sum_the_time($timex) {
  $times = $timex;
  $seconds = 0;
  foreach ($times as $time) {
    list($hour,$minute,$second) = explode(':', $time);
    $seconds += $hour*3600;
    $seconds += $minute*60;
    $seconds += $second;
  }
  $hours = floor($seconds/3600);
  $seconds -= $hours*3600;
  $minutes  = floor($seconds/60);
  $seconds -= $minutes*60;
  //return "{$hours}:{$minutes}:{$seconds}";
  return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}
function roundToQuarterHour($timestring) {
	$hours = date('H', strtotime($timestring));
    $minutes = date('i', strtotime($timestring));
    $r = $minutes - ($minutes % 15);
    if ($r<10) { $r = "0".$r; }
    return $hours.":".$r;
}
function roundToQuarterHourC($timestring) {
	$hours = date('H', strtotime($timestring));
    $minutes = date('i', strtotime($timestring));
    $r = $minutes - ($minutes % 15);
    if ($r<10) { $r = "0".$r; }
    return $hours.":".$r.":00";
}
function hm2sec($hm) {
    list($h,$m) = explode (":", $hm);
    $seconds = 0;
    $seconds += (intval($h) * 3600);
    $seconds += (intval($m) * 60);
    return $seconds;
}
function sec2hm($sec) {
    $hours = floor($sec / 3600);
    $minutes = floor(($sec / 60) % 60);
    if ($hours < 10) { $hours = "0".$hours; }
    if ($minutes < 10) { $minutes = "0".$minutes; }
    return $hours.":".$minutes;
}
?>