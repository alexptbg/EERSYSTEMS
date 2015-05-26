<?php
include ('data/e.php');
$dev0d = explode(" ", $dev0);
$s = ($dev0d[24]*256+$dev0d[25])/61;
$z = (220-$s)*45.4/1000;
$z = number_format($z,2);
$s = number_format($s,2);
echo "
<style type='text/css'>
body {
    background-color:#161616;
}
.t {
	width:60%;
    margin:0 auto;
	padding:0;	
}
h1 {
	font-family:Impact, Charcoal, sans-serif;
	letter-spacing:15px;
	font-size:100px;
	font-weight:900;
	text-align:center;
	color:#1d7cfe;
	-moz-text-shadow: 2px 2px 2px #17e600; 
	-webkit-text-shadow: 2px 2px 2px #17e600; 
	text-shadow: 2px 2px 2px #17e600;
}
h1.r {
	color:#02cbfd;
}
h2 {
	font-family:Impact, Charcoal, sans-serif;
	letter-spacing:15px;
	font-size:80px;
	font-weight:900;
	text-align:center;
	color:#fe1ded;
	-moz-text-shadow: 2px 2px 2px #17e600; 
	-webkit-text-shadow: 2px 2px 2px #17e600; 
	text-shadow: 2px 2px 2px #17e600;
}
h3.on {
	font-family:Impact, Charcoal, sans-serif;
	letter-spacing:15px;
	font-size:60px;
	font-weight:900;
	text-align:center;
	color:#68ef0e;
	-moz-text-shadow: 2px 2px 2px #17e600; 
	-webkit-text-shadow: 2px 2px 2px #17e600; 
	text-shadow: 2px 2px 2px #17e600;
}
h3.ex {
	font-family:Impact, Charcoal, sans-serif;
	letter-spacing:15px;
	font-size:60px;
	font-weight:900;
	text-align:center;
	color:#00ccff;
	-moz-text-shadow: 2px 2px 2px #17e600; 
	-webkit-text-shadow: 2px 2px 2px #17e600; 
	text-shadow: 2px 2px 2px #17e600;
}
h3.off {
	font-family:Impact, Charcoal, sans-serif;
	letter-spacing:15px;
	font-size:60px;
	font-weight:900;
	text-align:center;
	color:#ff0000;
	-moz-text-shadow: 2px 2px 2px #17e600; 
	-webkit-text-shadow: 2px 2px 2px #17e600; 
	text-shadow: 2px 2px 2px #17e600;
}
</style>
<div class='t'>
<h1 class='r'>".$z."</h1>
<h1>".$s."</h1>
</div>
<div class='t'>
<h2>".$dev0d[24]." - ".$dev0d[25]."</h2>";
if ($dev0d[6] == '0') {
	echo "<h3 class='off'>OFF</h3>";
} 
else if ($dev0d[6] == '3') {
	echo "<h3 class='ex'>&oplus;</h3>";
}
else {
	echo "<h3 class='on'>ON</h3>";
}
echo "<h3 class='ex'>".$dev0d[26]."</h3>
</div>
";
?>