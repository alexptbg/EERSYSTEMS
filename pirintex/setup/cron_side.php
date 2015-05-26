<?php
error_reporting(0);
$charx = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
$leng = 24;
$out = '';
for ($x = 0; $x < $leng; $x++)
$out .= $charx[array_rand($charx)];
$cron = $out;
echo "<p>".$cron."</p>";
?>