<?php
defined('start') or die('Direct access not allowed.');
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
if (file_exists($core)) { include($core); } else { echo "System files are corrupted.<br/><br/>Please, contact the server administrator."; die; }
?>