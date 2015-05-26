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
function check_username($lang,$username,$password,$web_dir) {
	$u = base64_decode($username);
	$p = md5(base64_decode($password));
    $query = "SELECT * FROM `users` ";
    $query .= "WHERE `user_name`='$u'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
	if ($check==1) { check_password($lang,$u,$p,$web_dir); }
    else {
	    $error = get_lang($lang, '1010');
		$location = "error.php?lang=".$lang."&error=".$error;
		header("location:$location");
    }
}
function check_password($lang,$username,$password,$web_dir) {
    $query = "SELECT * FROM `users` ";
    $query .= "WHERE `user_name`='$username' and `h_password`='$password'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
	if ($check==1) { check_status($lang,$username,$password,$web_dir); }
    else {
	    $error = get_lang($lang, '1011');
		$location = "error.php?lang=".$lang."&error=".$error;
		header("location:$location");
    }
}
function check_status($lang,$username,$password,$web_dir) {
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
			$location = "success.php?lang=".$lang;
            header("location:$location");
        }
        elseif ($status == 'Deactivated') {
	        $error = get_lang($lang, '1012');
		    $location = "error.php?lang=".$lang."&error=".$error;
		    header("location:$location");	
        } 
        elseif ($status == 'Pending') {
	        $error = get_lang($lang, '1013');
		    $location = "error.php?lang=".$lang."&error=".$error;
		    header("location:$location");	
        }
        else {
	        $error = get_lang($lang, '1001');
		    $location = "error.php?lang=".$lang."&error=".$error;
		    header("location:$location");	
        }
	}
    else {
	    $error = get_lang($lang, '1001');
		$location = "error.php?lang=".$lang."&error=".$error;
		header("location:$location");	
    }
}
function update_login($lang,$username) {
	$updated = date('Y-m-d H:i:s');
    mysql_query("UPDATE `users` SET `last_login`='$updated' WHERE `user_name`='$username'");
	$location = "admin.php?lang=".$lang;
	header("location:$location");
}
function check_login($lang,$web_dir){
    //session_start();
	//new php 5.4
    if (session_status() == PHP_SESSION_NONE) {
		session_name($web_dir);
        session_start();
    }	
    function check_loggedin($web_dir) {
		if(isset($_SESSION[$web_dir]) && ($_SESSION[$web_dir] == $web_dir)) {
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
		$location = "login.php?lang=".$lang;
	    header("location:$location");
    }
    else {
        header('Content-Type: text/html; charset=utf-8');
	    $user_settings = get_user_settings($_SESSION[$web_dir.'_username']);
		$_SESSION[$web_dir] = $web_dir;
    }
}
function get_controllers_for_edit($lang,$line) {
    $query = "SELECT * FROM `lines`";
	$query .= " order by `line_name` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
		$page = curPageName();
        while ($lines = mysql_fetch_array($result)) {
		if (($line == $lines['line_name']) && ($page == 'controllers.php')) {
			echo "
                <li class='active'>
                    <a href='controllers.php?line={$lines['line_name']}&lang=$lang'>
                        <i class='fa fa-list-ul'></i><span class='text'>{$lines['line_name']}</span>
                    </a>
                </li>";
		} else {
			echo "
                <li>
                    <a href='controllers.php?line={$lines['line_name']}&lang=$lang'>
                        <i class='fa fa-list-ul'></i><span class='text'>{$lines['line_name']}</span>
                    </a>
                </li>";
	    }
	}
	} else {
        //do nothing
	}
}
function get_klimas($lang,$krouter) {
    $query = "SELECT * FROM `klima_lines`";
	$query .= " order by `router_name` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
		$page = curPageName();
        while ($krouters = mysql_fetch_array($result)) {
		if (($krouter == $krouters['router_name']) && ($page == 'klimatiki.php')) {
			echo "
                <li class='active'>
                    <a href='klimatiki.php?krouter={$krouters['router_name']}&lang=$lang'>
                        <i class='fa fa-list-ul'></i><span class='text'>{$krouters['router_name']}</span>
                    </a>
                </li>";
		} else {
			echo "
                <li>
                    <a href='klimatiki.php?krouter={$krouters['router_name']}&lang=$lang'>
                        <i class='fa fa-list-ul'></i><span class='text'>{$krouters['router_name']}</span>
                    </a>
                </li>";
	    }
	}
	} else {
        //do nothing
	}
}
function get_krouters_for_edit($lang,$level) {
    $query = "SELECT * FROM `klima_lines`";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		while($krouter = mysql_fetch_array($result)) {
			echo "
				<tr>
					<td>".$krouter['router_name']."</td>
					<td>".$krouter['data_file']."</td>
					<td>".$krouter['ip_address']."</td>
					<td>".$krouter['port']."</td>";
				if ($level > 4) {
					echo "
			        <td><div class=\"btn-group\">
					  <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad51')."\" onClick=\"document.location.href = 'klima_router_view.php?lang=".$lang."&krouter=".$krouter['router_name']."'; return false;\">
					      <span class=\"icon-eye-open icon-white\"></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'Edit')."\" onClick=\"document.location.href = 'klima_router_edit.php?lang=".$lang."&krouter=".$krouter['router_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>
                      <button class=\"btn btn-small btn-danger ttLB\" title=\"".get_lang($lang, 'ad308')."\" onClick=\"confirmk('".$krouter['router_name']."'); return false;\">
					      <span class=\"icon-trash icon-white\"></span></button>
					</div></td>";
			    }
                else {
					echo "
			        <td><div class=\"btn-group\">
					  <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad51')."\" onClick=\"document.location.href = 'klima_router_view.php?lang=".$lang."&krouter=".$krouter['router_name']."'; return false;\">
					      <span class=\"icon-eye-open icon-white\"></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad49')."\" onClick=\"document.location.href = 'klima_router_edit.php?lang=".$lang."&krouter=".$krouter['router_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>
                      <button class=\"btn btn-small btn-default ttLB\" title=\"".get_lang($lang, 'ad308')."\" onClick=\"confirmk('".$krouter['router_name']."'); return false;\" disabled=\"disabled\" disabled>
					      <span class=\"icon-trash icon-white\"></span></button>
					</div></td>";
				}
                echo "</tr>";
		}
	}
	else {
	    echo "<div class=\"z100\">";
	    get_error($lang, '1008'); 
	    echo "</div>"; 
	}
    echo "
<script type=\"text/javascript\">
function confirmk(routername) {
	var answer = confirm(\"".get_lang($lang, 'ad308')." \" + routername + \"?\");
	if (answer){ kdel(routername); }
	else{ alert(\"".get_lang($lang, 'ad309')."\"); }
}
function kdel(routername) {
   $.ajax({
   type: \"POST\",
   url: \"klima_router_del.php?r=\"+routername,
   success: function(){
     alert(routername + \" ".get_lang($lang, 'ad53')."\");
     var delay = 1000;
     setTimeout(function(){ window.location.href = 'klima_routers.php?lang=".$lang."'; }, delay);
   }
 });
    return false;
}
</script>";
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
function check_router_name($krouter) {
    $query = "SELECT `router_name` FROM `klima_lines` WHERE `router_name`='$krouter'";
    $result = mysql_query($query);
    confirm_query($result);
	$c = mysql_num_rows($result);
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_router_id_and_name($krouter,$rid) {
    $query = "SELECT `id`,`router_name` FROM `klima_lines` WHERE `router_name`='$krouter' AND `id` NOT LIKE '$rid'";
    $result = mysql_query($query);
    confirm_query($result);
    $c = mysql_num_rows($result);
	return $c;
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
function get_klima_data($inv,$krouter) {
	global $klima_data;
    $query = "SELECT * FROM `klimatik`";
	$query .= " WHERE `inv`='$inv' AND `router`='$krouter'";
    $result = mysql_query($query);
    confirm_query($result);
    $klima_data = mysql_fetch_array($result);
    return $klima_data;
}
function get_check_klimatik_db($router,$inv) {
    $query = "SELECT `inv` FROM `klimatik`";
	$query .= " WHERE `router`='$router' AND `inv`='$inv'";
    $result = mysql_query($query);
    confirm_query($result);
    $inv = mysql_fetch_array($result);
	$cinv=$inv['inv'];
    return $cinv;
}
function check_klima_inv_and_id($inv,$id) {
    $query = "SELECT `id`,`inv` FROM `klimatik` WHERE `inv`='$inv' AND `id` NOT LIKE '$id'";
    $result = mysql_query($query);
    confirm_query($result);
    $c = mysql_num_rows($result);
	return $c;
}
function search_klimatik($inv) {
    $query = "SELECT inv, router FROM `klimatik`";
	$query .= " WHERE `inv` LIKE '%$inv%' ORDER BY `router` ASC, `inv` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		$found = array();
        while($row = mysql_fetch_array($result)) {
            //$found[] = $row['main_line'] . "," . $row['inv'];
            $found[$row['router']][] = $row['inv']; 
        }
	} else { $found = NULL; }
	return $found;
}
function get_lines($lang,$level) {
    $query = "SELECT * FROM `lines`";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		while($lines = mysql_fetch_array($result)) {
			echo "
				<tr>
					<td>".$lines['line_name']."</td>
					<td>".$lines['data_file']."</td>
					<td>".$lines['ip_address']."</td>
					<td>".$lines['port']."</td>";
				if ($level > 4) {
					echo "
			        <td><div class=\"btn-group\">
					  <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad51')."\" onClick=\"document.location.href = 'line_view.php?lang=".$lang."&line=".$lines['line_name']."'; return false;\">
					      <span class=\"icon-eye-open icon-white\"></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad49')."\" onClick=\"document.location.href = 'line_edit.php?lang=".$lang."&line=".$lines['line_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>
                      <button class=\"btn btn-small btn-danger ttLB\" title=\"".get_lang($lang, 'ad50')."\" onClick=\"confirmx('".$lines['line_name']."'); return false;\">
					      <span class=\"icon-trash icon-white\"></span></button>
					</div></td>";
			    }
                else {
					echo "
			        <td><div class=\"btn-group\">
					  <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad51')."\" onClick=\"document.location.href = 'line_view.php?lang=".$lang."&line=".$lines['line_name']."'; return false;\">
					      <span class=\"icon-eye-open icon-white\"></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad49')."\" onClick=\"document.location.href = 'line_edit.php?lang=".$lang."&line=".$lines['line_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>
                      <button class=\"btn btn-small btn-default ttLB\" title=\"".get_lang($lang, 'ad50')."\" onClick=\"confirmx('".$lines['line_name']."'); return false;\" disabled=\"disabled\" disabled>
					      <span class=\"icon-trash icon-white\"></span></button>
					</div></td>";
				}
                echo "</tr>";
		}
	}
	else {
	    echo "<div class=\"z100\">";
	    get_error($lang, '1008'); 
	    echo "</div>"; 
	}
    echo "
<script type=\"text/javascript\">
function confirmx(linename) {
	var answer = confirm(\"".get_lang($lang, 'ad50')." \" + linename + \"?\");
	if (answer){ linedel(linename); }
	else{ alert(\"".get_lang($lang, 'ad52')."\"); }
}
function linedel(linename) {
   $.ajax({
   type: \"POST\",
   url: \"line_del.php?l=\"+linename,
   success: function(){
     alert(linename + \" ".get_lang($lang, 'ad53')."\");
     var delay = 1000;
     setTimeout(function(){ window.location.href = 'lines.php?lang=".$lang."'; }, delay);
   }
 });
    return false;
}
</script>";
}
function get_all_logs($lang) {
    $query = "SELECT * FROM `logs`";
	$query .= " order by `date` DESC, `time` DESC";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		while($log = mysql_fetch_array($result)) {
			if ($log['obs'] != NULL) { $obs = " (<strong>".$log['obs']."</strong>)"; } else { $obs = ""; }
			echo "
				<tr>
				    <td>".$log['id']."</td>
				    <td>".$log['date']."</td>
				    <td>".$log['time']."</td>
				    <td class=\"user\"><a href=\"user_profile.php?lang=".$lang."&user=".$log['user']."\">".$log['user']."</a></td>
				    <td><span class=\"log text-".$log['filter']."\">".get_lang($lang,$log['action']).$obs."</span></td>
				</tr>
			";
		}
	} else {
        //do nothing
	}
}
function get_table_size($table) {
	$query = "SHOW TABLE STATUS LIKE '$table'";
	$result = mysql_query($query);
	confirm_query($result);
    $dbsize = 0;
    while($row = mysql_fetch_array($result)) {
        $dbsize += $row["Data_length"] + $row["Index_length"];
    }
	return $dbsize;
}
function get_user_log($lang,$user) {
    $query = "SELECT * FROM `logs` WHERE `user`='$user'";
	$query .= " order by `date` DESC, `time` DESC";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		while($log = mysql_fetch_array($result)) {
			if ($log['obs'] != NULL) { $obs = " (<strong>".$log['obs']."</strong>)"; } else { $obs = ""; }
			echo "<li><span class=\"date\"><b>".$log['date']."</b> ".$log['time']."</span> 
			      <span class=\"user\">".$log['user']." </span>
			      <span class=\"log text-".$log['filter']."\">".get_lang($lang,$log['action']).$obs."</span></li>";
		}
	} else {
		echo "<li><span class=\"date\"><b>".date('Y-m-d')."</b> ".date('H:i:s')."</span> 
		      <span class=\"user\">System </span>
		      <span class=\"log text-info\">".get_lang($lang,'ad101')."</span></li>";
	}
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
function get_users($lang,$level) {
    $query = "SELECT * FROM `users`";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		while($user = mysql_fetch_array($result)) {
			if (($user['user_name'] != 'Alex') && ($user['user_name'] != 'alex')) {
			echo "
				<tr>
				    <td width='40px'><img src='image.php?username=".$user['user_name']."' style='width:32px;height:32px;' class='img-polaroid'/></td>
					<td>".$user['user_name']."</td>
					<td>".$user['first_name']."</td>
					<td>".$user['last_name']."</td>
					<td>".$user['email']."</td>
					<td>".$user['level']."</td>";
					if ($user['status'] == "Active") {
						echo "<td><span class='label label-success'>".get_lang($lang, 'ad06')."</span></td>";
					}
					elseif ($user['status'] == "Pending") {
						echo "<td><span class='label label-warning'>".get_lang($lang, 'ad07')."</span></td>";
					}
					elseif ($user['status'] == "Deactivated") {
						echo "<td><span class='label label-important'>".get_lang($lang, 'ad08')."</span></td>";
					}
					else {
						echo "<td>".$user['status']."</td>";
					}
                    if ($user['user_name'] == 'alex') {
					    echo "
			        <td><div class=\"btn-group\">
                      <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad25')."\" onClick=\"document.location.href = 'user_profile.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class='icon-eye-open icon-white'></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad09')."\" onClick=\"document.location.href = 'user_edit.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>
					</div></td>
						";
					}
                    else if ($user['user_name'] == 'Alex') {
					    echo "
			        <td><div class=\"btn-group\">
                      <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad25')."\" onClick=\"document.location.href = 'user_profile.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class='icon-eye-open icon-white'></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad09')."\" onClick=\"document.location.href = 'user_edit.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>
					</div></td>
						";
					}
                    else if ($user['user_name'] == 'Admin') {
					    echo "
			        <td><div class=\"btn-group\">
                      <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad25')."\" onClick=\"document.location.href = 'user_profile.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class='icon-eye-open icon-white'></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad09')."\" onClick=\"document.location.href = 'user_edit.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>";
						  if ($level > 10) {
						  	echo "
					  <button class=\"btn btn-small btn-warning ttLB\" title=\"".get_lang($lang, 'ad58')."\" onClick=\"document.location.href = 'user_reset.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-lock icon-white\"></span></button>";
						}
						echo "</div></td>";
					}
                    else if ($user['user_name'] == 'admin') {
					    echo "
			        <td><div class=\"btn-group\">
                      <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad25')."\" onClick=\"document.location.href = 'user_profile.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class='icon-eye-open icon-white'></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad09')."\" onClick=\"document.location.href = 'user_edit.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>";
						  if ($level > 10) {
						  	echo "
					  <button class=\"btn btn-small btn-warning ttLB\" title=\"".get_lang($lang, 'ad58')."\" onClick=\"document.location.href = 'user_reset.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-lock icon-white\"></span></button>";
						}
						echo "</div></td>";
					}
					else {
					    if ($level >= 50) {
		    echo "
			        <td><div class=\"btn-group\">
                      <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad25')."\" onClick=\"document.location.href = 'user_profile.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-eye-open icon-white\"></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad09')."\" onClick=\"document.location.href = 'user_edit.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>
					  <button class=\"btn btn-small btn-warning ttLB\" title=\"".get_lang($lang, 'ad58')."\" onClick=\"document.location.href = 'user_reset.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-lock icon-white\"></span></button>
                      <button class=\"btn btn-small btn-danger ttLB\" title=\"".get_lang($lang, 'ad10')."\" onClick=\"confirmation('".$user['user_name']."'); return false;\">
					      <span class=\"icon-trash icon-white\"></span></button>
					</div></td>
			";
			            }
					    elseif ($level == 10) {
		    echo "
			        <td><div class=\"btn-group\">
                      <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad25')."\" onClick=\"document.location.href = 'user_profile.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-eye-open icon-white\"></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad09')."\" onClick=\"document.location.href = 'user_edit.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>
					  <button class=\"btn btn-small btn-default ttLB\" title=\"".get_lang($lang, 'ad58')."\" onClick=\"document.location.href = 'user_reset.php?lang=".$lang."&user=".$user['user_name']."'; return false;\" disabled=\"disabled\" disabled>
					      <span class=\"icon-lock icon-white\"></span></button>
                      <button class=\"btn btn-small btn-default ttLB\" title=\"".get_lang($lang, 'ad10')."\" onClick=\"confirmation('".$user['user_name']."'); return false;\" disabled=\"disabled\" disabled>
					      <span class=\"icon-trash icon-white\"></span></button>
					</div></td>
			";
			    }
					    elseif ($level == 5) {
		    echo "
			        <td><div class=\"btn-group\">
                      <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad25')."\" onClick=\"document.location.href = 'user_profile.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-eye-open icon-white\"></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad09')."\" onClick=\"document.location.href = 'user_edit.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>
					  <button class=\"btn btn-small btn-default ttLB\" title=\"".get_lang($lang, 'ad58')."\" onClick=\"document.location.href = 'user_reset.php?lang=".$lang."&user=".$user['user_name']."'; return false;\" disabled=\"disabled\" disabled>
					      <span class=\"icon-lock icon-white\"></span></button>
                      <button class=\"btn btn-small btn-default ttLB\" title=\"".get_lang($lang, 'ad10')."\" onClick=\"confirmation('".$user['user_name']."'); return false;\" disabled=\"disabled\" disabled>
					      <span class=\"icon-trash icon-white\"></span></button>
					</div></td>
			";
			    } 
				else {
		    echo "
			        <td><div class=\"btn-group\">
                      <button class=\"btn btn-small btn-success ttLB\" title=\"".get_lang($lang, 'ad25')."\" onClick=\"document.location.href = 'user_profile.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-eye-open icon-white\"></span></button>
                      <button class=\"btn btn-small btn-info ttLB\" title=\"".get_lang($lang, 'ad09')."\" onClick=\"document.location.href = 'user_edit.php?lang=".$lang."&user=".$user['user_name']."'; return false;\">
					      <span class=\"icon-edit icon-white\"></span></button>
					  <button class=\"btn btn-small btn-default ttLB\" title=\"".get_lang($lang, 'ad58')."\" onClick=\"document.location.href = 'user_reset.php?lang=".$lang."&user=".$user['user_name']."'; return false;\" disabled=\"disabled\" disabled>
					      <span class=\"icon-lock icon-white\"></span></button>
                      <button class=\"btn btn-small btn-default ttLB\" title=\"".get_lang($lang, 'ad10')."\" onClick=\"confirmation('".$user['user_name']."'); return false;\" disabled=\"disabled\" disabled>
					      <span class=\"icon-trash icon-white\"></span></button>
					</div></td>
			";
			    }
			}
                echo "</tr>";
			}
		}
	}
	else {
	    echo "<div class='z100'>";
	    get_error($lang, '1008'); 
	    echo "</div>"; 
	}
	if ($level > 10) {
    echo "
<script type=\"text/javascript\">
function confirmation(username) {
	var answer = confirm(\"".get_lang($lang, 'ad18')." \" + username + \" ".get_lang($lang, 'ad19')."?\");
	if (answer){ userdel(username); }
	else{ alert(\"".get_lang($lang, 'ad20')."\"); }
}
function userdel(username) {
   $.ajax({
   type: \"POST\",
   url: \"user_del.php?u=\"+username,
   success: function(){
	 alert(username + \" ".get_lang($lang, 'ad53')."\");
     var delay = 1000;
     setTimeout(function(){ window.location.href = 'users.php?lang=".$lang."'; }, delay);
   }
 });
    return false;
}
</script>";
    }
}
function redir($url,$seconds) {
    echo "
        <script type='text/javascript' charset='UTF-8'>
            function redirect() { window.location = '" . $url . "'; }
            timer = setTimeout('redirect()', '" . ($seconds*1000) . "')
        </script>\n";
    return true;
}
function show_box($lang) {
	get_box($lang,'1000','ad20');
    echo "
		<script type=\"text/javascript\">
		    $(document).ready(function(){
				$(\"#box\").dialog('open');
			});
		</script>
	";
	return true;
}
function get_box($lang,$title,$msg) {
	$title = get_lang($lang,$title);
	$msg = get_lang($lang,$msg);
    echo "
        <div class=\"dialog\" id=\"box\" style=\"display: none;\" title=\"".$title."\">                                
            <div class=\"block\">
                <p>".$msg."</p>
            </div>
        </div>
	";
}
function check_user_name($username) {
    $query = "SELECT `user_name` FROM `users` WHERE `user_name`='$username'";
    $result = mysql_query($query);
    confirm_query($result);
	$c = mysql_num_rows($result);
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_user_mail($mail) {
    $query = "SELECT `email` FROM `users` WHERE `email`='$mail'";
    $result = mysql_query($query);
    confirm_query($result);
	$c = mysql_num_rows($result);
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_line_name($line) {
    $query = "SELECT `line_name` FROM `lines` WHERE `line_name`='$line'";
    $result = mysql_query($query);
    confirm_query($result);
	$c = mysql_num_rows($result);
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_line_id_and_name($line,$id) {
    $query = "SELECT `id`,`line_name` FROM `lines` WHERE `line_name`='$line' AND `id` NOT LIKE '$id'";
    $result = mysql_query($query);
    confirm_query($result);
    $c = mysql_num_rows($result);
	return $c;
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
function get_user_for_edit($user) {
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
function get_global_settings() {
    global $global_settings;
    $query = "SELECT * FROM `global`";
    $result = mysql_query($query);
    confirm_query($result);
    $global_settings = mysql_fetch_array($result);
    return $global_settings;
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
function multiexplode($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return $launch;
}
function quick($lang) {
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#quick').load('server_quick.php?lang=".$lang."&x=');
            var refreshId = setInterval(function() {
                $('#quick').load('server_quick.php?lang=".$lang."&x='+ Math.random());
                }, 2000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id=\"quick\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function quick_klima($lang) {
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#quick_klima').load('klima_quick.php?lang=".$lang."&x=');
            var refreshId = setInterval(function() {
                $('#quick_klima').load('klima_quick.php?lang=".$lang."&x='+ Math.random());
                }, 2000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id=\"quick_klima\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_controllers_widget($lang) {
    $query = "SELECT * FROM `lines`";
	$query .= " order by `line_name` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
		$rand = rand(1000,9999);
        while ($lines = mysql_fetch_array($result)) {
			$linex[] = $lines['line_name'];
            $controllerx[] = count_controllers($lines['line_name']);
			$valvex[] = count_valves($lines['line_name']);
	    }
		//$s = count($linex)/1.5;
		//$c = number_format($s, 2, '', '');
		$lines = implode("','",$linex);
		$controllers = implode(",",$controllerx);
		$valves = implode(',',$valvex);
		$tc = array_sum($controllerx);
		$tv = array_sum($valvex);		
    echo "<script type=\"text/javascript\" charset=\"UTF-8\">
$(function () {
var chart;
$(document).ready(function() {
   chart = new Highcharts.Chart({
      chart: {
         renderTo: 'chart_$rand',
         defaultSeriesType: 'bar',
		 marginTop: 40,
		 plotShadow: false,
            animation: {
                duration: 2000,
                easing: 'easeOutBounce'
            }
      },
      title: {
         text: '".$tc." ".get_lang($lang, 'td47')."',
            style: {
                fontSize: '12px'
            }
      },
      subtitle: {
         text: '".$tv." ".get_lang($lang, 'td48')."',
            style: {
                fontSize: '12px'
            }
      },
      xAxis: {
         categories: ['".$lines."'],
         title: {
            text: null
         }
      },
      yAxis: {
         min: 0,
		 showLastLabel: false,
         title: {
            text: null,
            align: 'high'
         }
      },
            tooltip: {
                headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
                pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
                    '<td style=\"padding:0\"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
        plotOptions: {
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            },
            dataLabels: {
               enabled: true
            }
        },
        legend: {
            align: 'left',
            verticalAlign: 'bottom',
            y: 15,
			x: -10,
            floating: true,
			borderWidth: 0
        },
      credits: {
         enabled: false
      },
      series: [{
         name: '".get_lang($lang, 'td47')."',
         data: [$controllers]	   		   
      },{
         name: '".get_lang($lang, 'td48')."',
         data: [$valves]	   		   
      }]
   });  });	});	
	</script>
	<div class=\"cc10\"><div id=\"chart_$rand\" style=\"width:100%; height:420px; margin: 0 auto\">
	    <div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div></div>";
	} else {
        //do nothing
	}
}
function get_users_activity($lang) {
	$query = "SELECT `user_name` FROM `users`";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		while($user = mysql_fetch_array($result)) {
            $cnt = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) as cnt FROM `logs` WHERE `user`= '".$user['user_name']."'"));
			if (($cnt['cnt'] != 0) && ($user['user_name'] != 'Alex')) {
				$users[] = $user['user_name'];
				$counters[] = $cnt['cnt'];
			}
	    }
		$rand = rand(1000,9999);
		$all_users = implode("','",$users);
		$actions = implode(",",$counters);
echo "<script type=\"text/javascript\" charset=\"UTF-8\">
$(function () {
	$('#chart_$rand').highcharts({
	    chart: {
	        polar: true,
	        type: 'line',
			borderWidth: 0,
	    },
	    title: {
	        text: null
	    },
	    xAxis: {
	        categories: ['$all_users'],
	        tickmarkPlacement: 'on',
	        lineWidth: 0
	    },
	    yAxis: {
	        gridLineInterpolation: 'polygon',
	        lineWidth: 0,
	        min: 0
	    },
	    tooltip: {
	    	shared: true,
            formatter: function() {
                var s = '<b>'+ this.x +'</b>';
                $.each(this.points, function(i, point) {
                    s += '<br/>'+ point.series.name +': '+point.y;
                });
                return s;
            }
	    },
        credits: {
            enabled: false
        },
	    legend: {
			enabled: false,
	        align: 'right',
	        verticalAlign: 'top',
	        y: 70,
	        layout: 'vertical'
	    },
	    series: [{
	        name: '".get_lang($lang, 'ad293')."',
	        data: [$actions],
	        pointPlacement: 'on'
	    }]
	});
});
	</script>
	<div class=\"cc10\"><div id=\"chart_$rand\" style=\"width:100%; height:428px; margin: 0 auto;\">
	    <div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div></div>";
	} else {
		//do nothing
	}
}
function search_controller($inv) {
    $query = "SELECT inv, main_line FROM `controller`";
	$query .= " WHERE `inv` LIKE '%$inv%' ORDER BY `main_line` ASC, `inv` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		$found = array();
        while($row = mysql_fetch_array($result)) {
            //$found[] = $row['main_line'] . "," . $row['inv'];
            $found[$row['main_line']][] = $row['inv']; 
        }
	} else { $found = NULL; }
	return $found;
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
function get_all_controllers($line) {
    $query = "SELECT `inv` FROM `controller`";
	$query .= " WHERE `main_line`='$line'";
	$query .= " order by `inv` asc";
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
function get_check_server_db($name) {
    $query = "SELECT `name` FROM `servers_info`";
	$query .= " WHERE `name`='$name'";
    $result = mysql_query($query);
    confirm_query($result);
    $name = mysql_fetch_array($result);
	$cname=$name['name'];
    return $cname;
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
function decodeSize($bytes) {
    $types = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    for($i = 0; $bytes >= 1024 && $i < (count($types ) -1 ); $bytes /= 1024, $i++);
    return(round($bytes, 2) . " " . $types[$i]);
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
function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
    }
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    if ($version==null || $version=="") {$version="?";}
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}
function getOS($userAgent) {
	$oses = array (
		'iPhone iOS 4.0' => '(iPhone OS 4.0)',
		'iPhone iOS 4.1' => '(iPhone OS 4.1)',
		'iPhone iOS 4.2' => '(iPhone OS 4.2)',
		'iPhone iOS 4.3' => '(iPhone OS 4.3)',
		'iPhone iOS 5.0' => '(iPhone OS 5.0)',
		'iPhone iOS 5.1' => '(iPhone OS 5.1)',
		'iPhone iOS 6.0' => '(iPhone OS 6.0)',
		'iPhone iOS 6.1' => '(iPhone OS 6.1)',
		'iPhone iOS 6.2' => '(iPhone OS 6.2)',
		'iPhone iOS 7.0' => '(iPhone OS 7.0)',		
		'Android 1.5' => '(Android 1.5)',
		'Android 1.6' => '(Android 1.6)',
		'Android 2.0' => '(Android 2.0)',
		'Android 2.1' => '(Android 2.1)',
		'Android 2.2' => '(Android 2.2)',
		'Android 2.3' => '(Android 2.3)',
		'Android 3.1' => '(Android 3.1)',
		'Android 3.2' => '(Android 3.2)',
		'Android 4.0' => '(Android 4.0)',		
		'Android 4.1' => '(Android 4.1)',
		'Android 4.2' => '(Android 4.2)',
		'Android 4.3' => '(Android 4.3)',
		'Android 5.0' => '(Android 5.0)',
		'Windows 3.11' => 'Win16',
		'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', // Use regular expressions as value to identify operating system
		'Windows 98' => '(Windows 98)|(Win98)',
		'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
		'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
		'Windows 2003' => '(Windows NT 5.2)',
		'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
		'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
		'Windows 8' => '(Windows NT 6.2)|(Windows 8)',		
		'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
		'Windows ME' => 'Windows ME',
		'Open BSD'=>'OpenBSD',
		'Sun OS'=>'SunOS',
		'Linux'=>'(Linux)|(X11)',
		'Safari' => '(Safari)',
		'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
		'QNX'=>'QNX',
		'BeOS'=>'BeOS',
		'OS/2'=>'OS/2',
		'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
	);
	foreach($oses as $os=>$pattern){
		if(preg_match("/".$pattern."/i", $userAgent)) {
			return $os;
		}
	}
	return 'Unknown';
}
function get_servers_status($lang,$level){
    $query = "SELECT * FROM `servers_info`";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		echo "
		    <table cellpadding='0' cellspacing='0' class='table'>
			<thead>
            <tr>                                    
            <th width='20%'>".get_lang($lang, 'Name')."</th>
            <th width='15%'>".get_lang($lang, 'Status')."</th>
            <th width='25%'>".get_lang($lang, 'ad66')."</th>
            <th width='15%'>".get_lang($lang, 'Port')."</th>			
            <th width='20%'>".get_lang($lang, 'Latency')."</th>
			<th width='10%'>&nbsp;</th>                                
            </tr>
			</thead>
			<tbody>
		";
		while($row = mysql_fetch_array($result)) {
			check_server_status($lang,$row['name'],$row['ip_addr'],$row['port'],$level);
		}
		echo "</tbody></table>";
	} else {
	    echo "<div class='z100'>";
	    get_error($lang, '1007'); 
		echo "</div>"; 
	}
							if ($level > 5) {
								echo "
                            <div class=\"footer\">
							    <span class=\"label label-success\">". get_lang($lang, 'ad136').": 10</span>
                            </div>";
							} else {
								echo "
                            <div class=\"footer\">
							    <span class=\"label label-important\">". get_lang($lang, 'ad136').": 10</span>
                            </div>";
							}
}
function check_server_status($lang,$name,$host,$port,$level) {
  $start_time = microtime(TRUE);
  $status = @fsockopen($host,$port,$errno,$errstr,1);
  if (!$status) { 
  echo "
  <tr>
  <td>$name</td>
  <td><span class='label label-important'>".get_lang($lang, 'Offline')."</span></td>
  <td>$host</td>
  <td>$port</td>
  <td>-</td>
  <td>";
  if ($level>4) {
  echo "
  <button class='btn btn-small btn-danger ttLB' title='".get_lang($lang, 'ad67')." ".$name."?' onClick='confirms(\"".$name."\"); return false;'>
  <span class='icon-trash icon-white'></span></button>
  ";
  } else {
  echo "
  <button class='btn btn-small btn-default ttLB' title='".get_lang($lang, 'ad67')." ".$name."?' onClick='confirms(\"".$name."\"); return false;' disabled='disabled' disabled>
  <span class='icon-trash icon-white'></span></button>";
  }
  echo "
  </td>
  </tr>
  ";
  }
  elseif ($status) {
  $end_time = microtime(TRUE);
  $time_taken = $end_time - $start_time;
  $time_taken = round($time_taken,5);
  $time_taken = $time_taken * 1000 / 1;
  $time_taken = number_format($time_taken,2);
  echo "
  <tr>
  <td>$name</td>
  <td><span class='label label-success'>".get_lang($lang, 'Online')."</span></td>
  <td>$host</td>
  <td>$port</td>
  <td>$time_taken <em><small>(".get_lang($lang, 'ms').")</small></em></td>
  <td>";
  if ($level>4) {
  echo "
  <button class='btn btn-small btn-danger ttLB' title='".get_lang($lang, 'ad67')." ".$name."?' onClick='confirms(\"".$name."\"); return false;'>
  <span class='icon-trash icon-white'></span></button>
  ";
  } else {
  echo "
  <button class='btn btn-small btn-default ttLB' title='".get_lang($lang, 'ad67')." ".$name."?' onClick='confirms(\"".$name."\"); return false;' disabled='disabled' disabled>
  <span class='icon-trash icon-white'></span></button>";
  }
  echo "
  </td>
  </tr>
  ";
  } else {
    //do nothing
  }
echo "
<script type=\"text/javascript\">
function confirms(name) {
	var answer = confirm(\"".get_lang($lang, 'ad67')." \" + name + \"?\");
	if (answer){ serverdel(name); }
	else{ alert(name+\" ".get_lang($lang, 'ad68')."\"); }
}
function serverdel(name) {
   $.ajax({
   type: \"POST\",
   url: \"server_del.php?s=\"+name,
   success: function(){
     alert(name + \" ".get_lang($lang, 'ad53')."\");
     var delay = 1000;
     setTimeout(function(){ window.location.href = 'server.php?lang=".$lang."'; }, delay);
   }
 });
    return false;
}
</script>
";
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
?>