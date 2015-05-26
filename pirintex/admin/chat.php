<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
    mysql_query("SET NAMES 'utf8'");
    $query = "SELECT * FROM `messages` order by `id` DESC";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		while($messages = mysql_fetch_array($result)) {
			echo "<div class=\"item clearfix\">
                      <div class=\"image\">
					      <img src=\"image.php?lang=".$lang."&username=".$messages['user']."\" class=\"img-polaroid\" width=\"50px\" height=\"50px\" /></div>
                      <div class=\"info\">
                          <a href=\"user_profile.php?lang=".$lang."&user=".$messages['user']."\" class=\"name\">".$messages['user']."</a>
                          <p>".$messages['msg']."</p>
                          <span>".$messages['datetime']."</span>
                      </div>
                  </div>";
		}
	} else {
        //do nothing
	}
?>