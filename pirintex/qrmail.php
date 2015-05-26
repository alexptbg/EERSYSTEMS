<?php
//error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$subject = $company_name." - ".$company_slogan;
$msg = get_lang($lang, 'hello');
$qr = new BarcodeQR();
$qr->email($site_email, $subject, $msg); 
$qr->draw();
?>