<?php
//error_reporting(0);
defined('start') or die('Direct access not allowed.');
$today = date('d-m-Y');
$today_e = date('Y-m-d');
//init
get_settings();
$initlang = $settings['init_lang']; 
//required files
require_once "includes/lang/DataBase.php";
require_once "includes/lang/Language.php";
require_once "includes/lang/Result.php";
require_once "includes/lang/Translation.php";
require_once "includes/lang/Translate.php";
$core = "includes/core.php";
//web settings
$web_base = $settings['base'];
$web_dir = $settings['sub_dir'];
$web_path = $web_base . "/" . $web_dir;
$index_path = "http://".$web_dir.".".$web_base;
$real_path = "http://".$web_base."/".$web_dir;
$self_path = $_SERVER['PHP_SELF'];
define('HOST',$web_dir.".".$web_base,TRUE);
//base settings
$company_name = $settings['company_name'];
$company_slogan = $settings['slogan'];
$site_name = $settings['site_name'];
$site_logo = $settings['logo'];
$site_logo_ext = $settings['logo_ext'];
$site_email = $settings['site_email'];
$site_theme = $settings['site_theme'];
//email settings
$smtp_name = $settings['smtp_name'];
$smtp_mail = $settings['smtp_mail'];
$smtp_username = $settings['smtp_username'];
$smtp_server = $settings['smtp_server'];
$smtp_port = $settings['smtp_port'];
$smtp_password = $settings['smtp_password'];
$powered = $settings['EES_powered'];
$version = $settings['EES_version'];
$created = $settings['installed'];
$copyrights = $settings['copyrights'];
$engine = $settings['status'];
$installed = strtotime($settings['installed']);
$path = curPageURL();
//engine control
if($engine != 'Online'){ echo "Engine is offline.<br/><br/>Please, contact the server administrator."; die; }
?>