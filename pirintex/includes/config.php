<?php
//error_reporting(0);
defined('start') or die('Direct access not allowed.');
session_start();  
if (isset($_GET["lang"])) {
	if(isset($_SESSION['language'])) { unset($_SESSION['language']); } 
	$lang = isset($_GET["lang"]) ? $_GET["lang"] : $initlang;
	$_SESSION['language'] = $lang;
    $translation = Translate::getInstance();
    if (!$translation->languageExist($lang)) {
		session_start(); 
        if(isset($_SESSION['language'])) { unset($_SESSION['language']); } 
		$lang = "en";
		$_SESSION['language'] = 'en';
	}
    $translation->setLanguage($lang);
    $result = mysql_query("SELECT * FROM languages where short='$lang'");
    $f_rows = mysql_num_rows($result);
    if ($f_rows != 0) { 
        while($format = mysql_fetch_array($result)) {
            $f = $format['format'];
		    $ln = $format['name']; 
        }
    }
} else {
    if(isset($_SESSION['language'])) {
	    $lang = $_SESSION['language'];
        $translation = Translate::getInstance();
        if (!$translation->languageExist($lang)) {
			session_start(); 
            if(isset($_SESSION['language'])) { unset($_SESSION['language']); } 
		    $lang = "en";
		    $_SESSION['language'] = 'en';
	    }
        $translation->setLanguage($lang);
        $result = mysql_query("SELECT * FROM languages where short='$lang'");
        $f_rows = mysql_num_rows($result);
        if ($f_rows != 0) { 
            while($format = mysql_fetch_array($result)) {
                $f = $format['format'];
		        $ln = $format['name']; 
            }
        }
    } else {
		$lang = /*isset($_GET["lang"]) ? $_GET["lang"] :*/ $initlang;
		$_SESSION['language'] = $lang;
        $translation = Translate::getInstance();
        if (!$translation->languageExist($lang)) {
			session_start(); 
            if(isset($_SESSION['language'])) { unset($_SESSION['language']); } 
		    $lang = "en";
		    $_SESSION['language'] = 'en';
	    }
        $translation->setLanguage($lang);
        $result = mysql_query("SELECT * FROM languages where short='$lang'");
        $f_rows = mysql_num_rows($result);
        if ($f_rows != 0) { 
            while($format = mysql_fetch_array($result)) {
                $f = $format['format'];
		        $ln = $format['name']; 
            }
        }
    }
}
$cache = 1;
header("Content-Type: text/html; $f");
header('Expires: '.gmdate('D, d M Y H:i:s',time() + (60 * 60 * 24 * $cache)).' GMT');
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
$chars = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
$len = 16;
$output = '';
for ($x = 0; $x < $len; $x++)
$output .= $chars[array_rand($chars)];
$hash = $output;
$date_f = date('d-m-Y');
$time_f = date('H:i:s');
$day = date('l');
$month = date('F');
$c_1 = '#0055aa';
$c_2 = '#e67300';
$c_3 = '#74e800';
$c_4 = '#ff0080';
$c_5 = '#ff0000';
$c_6 = '#800080';
?>