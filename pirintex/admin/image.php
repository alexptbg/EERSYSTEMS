<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
$username = $_GET['username'];
if(!empty($username)) {
	mysql_query("SET NAMES 'utf8'");
	$query = "SELECT `img`, `type` from `profile_img` WHERE `user`='$username'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
	if ($check==1) {
        $rowImg = mysql_fetch_array($result);
	    mysql_free_result($result);
	    ob_clean();
	    header('Content-type: '.$rowImg[1]);
	    echo $rowImg[0];
	}
    else {
        $img = imagecreatefrompng('img/no_img.png');
        header("Content-type: image/png");
        imagepng($img);
    }
} else {
    $img = imagecreatefrompng('img/no_img.png');
    header("Content-type: image/png");
    imagepng($img);
}
?>