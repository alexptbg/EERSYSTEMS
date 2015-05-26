<!DOCTYPE html>
<html lang="en">
<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/setup_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$line,$id,$inv,$web_dir);
$line = $_GET['l'];
$inv = $_GET['i'];
if ($user_settings['level']>3) {
$line_options = get_line_options($line);
$img_dir = "../img/controllers/".$line_options['line_sname']."/";
$photo = $img_dir.$inv.".jpg";
$thumb = $img_dir."th_".$inv.".jpg";
unlink($photo);
unlink($thumb);
} else {
    exit;
}
?>