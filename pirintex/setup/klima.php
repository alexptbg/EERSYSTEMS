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
$line = $_GET['line'];
$id = $_GET['id'];
$inv = $_GET['inv'];
$sys = $_GET['sys'];
check_login($lang,$line,$id,$inv,$web_dir,$sys);
clear_cron();
function c($x) { $c = ($x-371)/13.07; return $c; }
get_line_options($line);
$datafile = "../data/{$line_options['data_file']}";
$socket_ip = $line_options['ip_address'];
$socket_port = $line_options['port'];
include("$datafile");
include ('cron.php'); include ('cron2.php'); 
$dat = explode(' ', $ep); $par = explode(' ', $ap);
include('../includes/socket.php');
read_parameters($socket_ip,$socket_port,$id);
$command = "";
$command = $_GET['command'];
$dev = ${'dev' . $id};
$d = explode(" ", $dev);
$s1 = $d[10];
$s2 = $d[12];
$sl1 = $d[10];
$sl2 = $d[12];
$st1 = $d[10]+1;
$st2 = $d[12]+1;
$t1 = c($d[24]); 
$t2 = c($d[26]);
if (($s1 < 0) || ($s1 == NULL)) { $d[9] = 'OFF'; $s1 = ""; } else { $s1 = "<span class=\"label label-info\"><h4>".$s1."ºC</h4></span>"; }
if (($s2 < 0) || ($s2 == NULL)) { $d[9] = 'OFF'; $s2 = ""; } else { $s2 = "<span class=\"label label-info\"><h4>".$s2."ºC</h4></span>"; }
if (($sl1 < 0) || ($sl1 == NULL)) { $d[9] = 'OFF'; $sl1 = ""; } else { $sl1 = "<span class=\"label label-warning\"><h5>".$sl1."ºC</h5></span>"; }
if (($sl2 < 0) || ($sl2 == NULL)) { $d[9] = 'OFF'; $sl2 = ""; } else { $sl2 = "<span class=\"label label-warning\"><h5>".$sl2."ºC</h5></span>"; }
if ($t1 < 0) { $t1 = get_lang($lang, 'Error'); $d[9] = '=='; $d[5] = '0'; } else { $t1 = number_format($t1,2); $k1 = "ºC"; }
if ($t2 < 0) { $t2 = get_lang($lang, 'Error'); $d[9] = '=='; $d[5] = '0'; } else { $t2 = number_format($t2,2); }
if ($t1<$st1) {
    $temp1 = "<span class=\"label label-warning\"><h2><span id=\"stk1\">".$t1."".$k1."</span></h2></span>";
} elseif ($t1>$st1) {
	$temp1 = "<span class=\"label label-success\"><h2><span id=\"stk1\">".$t1."".$k1."</span></h2></span>";
} else {
	$temp1 = "<span class=\"label label-important\"><h2><span id=\"stk1\">".$t1."".$k1."</span></h2></span>";
}
if ($t2<$st2) {
	$temp2 = "<span class=\"label label-warning\"><h2><span id=\"stk2\">".$t2."".$k1."</h2></span>";
} elseif ($t2>$st2) {
	$temp2 = "<span class=\"label label-success\"><h2><span id=\"stk2\">".$t2."".$k1."</span></h2></span>";
} else {
	$temp2 = "<span class=\"label label-important\"><h2><span id=\"stk2\">".$t2."".$k1."</h2></span>";
}
if ($d[9] == 'ON') { $status = "<span class=\"label label-success\"><h4>".$d[9]."</h4></span>"; }
elseif ($d[9] == 'OFF') { $status = "<span class=\"label label-important\"><h4>".$d[9]."</h4></span>"; }
elseif ($d[9] == '==') { $status = "<span class=\"label label-warning\"><h4>".$d[9]."</h4></span>"; }
if ($d[8] == 'A') { $reg = "<span class='label label-success'><h4>".$d[8]."</h4></span>"; }
elseif ($d[8] == 'M') { $reg = "<span class='label label-warning'><h4>".$d[8]."</h4></span>"; }
if ($d[5] == '0'||$d[5] == '12') {
    $v1 = "<img src=\"img/s.gif\" />"; 
} else {
    $v1 = "<img src=\"img/l.gif\" />";
}
if ($d[5] == '0'||$d[5] == '3') {
    $v2 = "<img src=\"img/s.gif\" />";
} else {
    $v2 = "<img src=\"img/r.gif\" />"; 
}
include('includes/klima_functions.php');
if ($inv == '35') { $name = "BOSS1_SYSTEM_3/4"; }
if ($inv == '36') { $name = "BOSS1_COOLING_SYSTEM"; }
if ($inv == '45') { $name = "BOSS2_COOLING_SYSTEM"; }
try {
    if(!($command == NULL)) {
		$server = 'r';
	    if ($command == 'AP') {
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$server $command $id\r\n");
			$obs = $line."|".$inv;
			insert_log($lang,$user_settings['user_name'],'warning','ad127',$obs);
		}	
		if ($command == 'SS') {
            $hon1 = $_POST["hon1"]; $hof1 = $_POST["hof1"];
            $hon2 = $_POST["hon2"]; $hof2 = $_POST["hof2"];
            $hon3 = $_POST["hon3"]; $hof3 = $_POST["hof3"];
            $hon4 = $_POST["hon4"]; $hof4 = $_POST["hof4"];
            $hon5 = $_POST["hon5"]; $hof5 = $_POST["hof5"];
            $hon6 = $_POST["hon6"]; $hof6 = $_POST["hof6"];
            $hon7 = $_POST["hon7"]; $hof7 = $_POST["hof7"];
            $hon8 = $_POST["hon8"]; $hof8 = $_POST["hof8"];
            $mon1 = $_POST["mon1"]; $mof1 = $_POST["mof1"];
            $mon2 = $_POST["mon2"]; $mof2 = $_POST["mof2"];
            $mon3 = $_POST["mon3"]; $mof3 = $_POST["mof3"];
            $mon4 = $_POST["mon4"]; $mof4 = $_POST["mof4"];
            $mon5 = $_POST["mon5"]; $mof5 = $_POST["mof5"];
            $mon6 = $_POST["mon6"]; $mof6 = $_POST["mof6"];
            $mon7 = $_POST["mon7"]; $mof7 = $_POST["mof7"];
            $mon8 = $_POST["mon8"]; $mof8 = $_POST["mof8"];
	        $sc = new ClientSocket();
	        $sc->open($socket_ip,$socket_port);
	        $sc->send("$server $command $id $hon1 $hon2 $hon3 $hon4 $hon5 $hon6 $hon7 $hon8 $mon1 $mon2 $mon3 $mon4 $mon5 $mon6 $mon7 $mon8 $hof1 $hof2 $hof3 $hof4 $hof5 $hof6 $hof7 $hof8 $mof1 $mof2 $mof3 $mof4 $mof5 $mof6 $mof7 $mof8\r\n");
			$obs = $line."|".$inv;
			insert_log($lang,$user_settings['user_name'],'warning','ad131',$obs);
		}
	}
}
catch (Exception $e){
	echo $e->getMessage();
}
function get_meter_r($lang,$value) {
	$rand = rand(1000,9999);
	echo "
<script type=\"text/javascript\" charset=\"UTF-8\">
    var meter_$rand;
    function init_$rand() {
        meter_$rand = new steelseries.DisplayMulti('canvas_$rand', {
                            width: 200,
                            height: 80,
                            unitString: \" ºC\",
                            unitStringVisible: true,
                            headerString: \"ON\",
                            headerStringVisible: true,
                            detailString: \"detail: \",
                            detailStringVisible: false,
                            linkOldValue: false,
                            oldValue: 99.9
                            });
		setInterval(function(){ setRandomValue2(meter_$rand, $value); }, 2000);
    }
    function setRandomValue2(gauge, range) {
        gauge.setValue(Math.random()/2 + range);
    }
    $(function () {
		init_$rand();
	});
</script>
    <canvas id=\"canvas_$rand\" height=\"80\"></canvas>
";
}
?>
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=<?=$f?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="description" content="<?=$company_name?> - <?=$company_slogan?> | <?=$site_name?>" />
    <meta name="keywords" content="<?=$company?> - <?=$company_slogan?> | <?=$site_name?>" />
    <meta name="Powered" content="<?=$powered?>" />	
    <meta name="Email" content="<?=$site_email?>" />	
    <meta name="Created" content="<?=$created?>" />
    <meta name="Version" content="<?=$version?>" />
    <meta name="Hash" content="<?=$hash?>" />		
    <title><?=$company_name?> &curren; <?=$company_slogan?></title>
    <!--[if gt IE 8]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
    <link rel="icon" type="image/ico" href="favicon.ico" />
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css" />  
    <!--[if lt IE 8]><link href="css/ie7.css" rel="stylesheet" type="text/css" /><![endif]-->            
    <script type='text/javascript' src='js/jquery-1.7.2.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/jquery-ui.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery.mousewheel.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/cookie/jquery.cookies.2.2.0.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/bootstrap.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/select2/select2.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/uniform/uniform.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/languages/jquery.validationEngine-<?=$lang?>.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/jquery.validationEngine.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js' charset='utf-8'></script>
	<link rel='stylesheet' type='text/css' href='js/plugins/switch/jquery.switch.css' />
    <script type='text/javascript' src='js/plugins/switch/jquery.switch.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/cookies.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/actions.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/settings.js' charset='utf-8'></script>
	<script type='text/javascript' src='js/lang.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/alex.js' charset='utf-8'></script>	
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
        <div class="header">
            <a class="logo" href="../klima.php?lang=<?=$lang?>">
			<h2><?=$company_name?> &curren; <?=$company_slogan?></h2></a>
            <ul class="header_menu">
                <li class="list_icon"><a href="#">&nbsp;</a></li>
                <li class="settings_icon">
                    <a href="#" class="link_themeSettings">&nbsp;</a>
                    <div id="themeSettings" class="popup">
                        <div class="head clearfix">
                            <div class="arrow"></div>
                            <span class="isw-settings"></span>
                            <span class="name"><?php echo get_lang($lang, 'Settings'); ?></span>
                        </div>
                        <div class="body settings">
                            <div class="row-fluid">
                                <div class="span3"><strong><?php echo $translation->getTranslation("select_lang"); ?></strong></div>
                                <div class="span9">
		                            <div id="alex_LanguageSwitcher">
			                            <form method="get">
			                                <select id="alex_language-options" name="lang" 
											        onchange="window.location=('?lang='+this.options[this.selectedIndex].value)">
					                        <option id="<?php echo get_lang($lang, 'msg_000'); ?>"
					                                value="<?php echo get_lang($lang, 'msg_000'); ?>"><?php echo get_lang($lang, 'msg_001'); ?></option>
					                        <?php foreach ($translation->getAllLanguages() as $language) : ?>
					                        <option id="<?php echo $language->getShort(); ?>"
					                                value="<?php echo $language->getShort(); ?>"><?php echo $language->getName(); ?></option>
					                        <?php endforeach; ?>
				                            </select>
				                            <noscript><input type="submit" value="Submit"></noscript>
			                            </form>	
		                            </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer">                            
                            <button class="btn link_themeSettings" type="button">
							    <i class="fa fa-times"></i>&nbsp; <?php echo get_lang($lang, 'Close'); ?></button>
                        </div>
                    </div>                    
                </li>                
            </ul>   
        </div>
        <div class="menu">                
            <div class="breadLine">            
                <div class="arrow"></div>
                <div class="adminControl active">
                    <span><?php echo get_lang($lang, 'Hello') . ", " . $user_settings['first_name'] . " " . $user_settings['last_name']; ?></span>
				</div>
            </div>
            <div class="admin">
                <div class="image">
                    <img src="image.php?username=<?php echo $user_settings['user_name']; ?>" class="img-polaroid"/>                
                </div>
                <ul class="control">                
                    <li><span class="icon-user"></span> 
					    <span class="tip" title="<?php echo get_lang($lang, 'ad148'); ?>"><?php echo $user_settings['user_name']; ?></span>
					    <span class="caption green tip" title="<?php echo get_lang($lang, 'inter134'); ?>"><?php echo $user_settings['level']; ?></span></li>
                    <li><span class="icon-cog"></span> <a href="../admin/my_profile.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'ad22'); ?></a></li>
                    <li><span class="icon-share-alt"></span> 
					    <a href="logout.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
						    <?php echo get_lang($lang, 'Logout'); ?></a></li>
                </ul>
                <div class="info">
                    <span><?php echo get_lang($lang, 'inter84') . "!"; ?></span><br/>
					<span><?php echo get_lang($lang, 'inter135').":<br/>".$user_settings['last_login']; ?></span>
                </div>
            </div>
			
            <ul class="navigation">            
                <li class="active">
                    <a href="klima.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-grid"></span><span class="text"><?php echo get_lang($lang, 'home'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="../admin/admin.php?lang=<?=$lang?>">
                        <span class="isw-settings"></span><span class="text"><?php echo get_lang($lang, 'inter61'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="../klima.php?lang=<?=$lang?>">
                        <span class="isw-left_circle"></span><span class="text"><?php echo get_lang($lang, 'ad193'); ?></span>
                    </a>
                </li>                        
            </ul>
        </div>

        <div class="content">
            <div class="breadLine">
                <ul class="breadcrumb">
                    <li><?=$line?> \ <?=$id?> \ <?=$inv?></li>                
                </ul>
                <span class="fr time">
			        <?php echo get_lang($lang, $day). ', ' . date('d') .' '.get_lang($lang, $month). ' '.date('Y').' - '; ?>
				    <span id="ctime"></span>
			    </span>
            </div>

            <div class="workplace">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-square fa-1x"></i><span><?php echo get_lang($lang, 'ad275'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php
echo "                      <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table klima\">
							    <caption>".$name."</caption>
							    <thead>
								    <tr>
									    <th style=\"text-align:right;\">".get_lang($lang, 'ad276')."</th>
										<th>".get_lang($lang, 'Controls')."</th>
									    <th>".get_lang($lang, 'Temperature')."</th>
									    <th>".get_lang($lang, 'Status')."</th>										
									</tr>
								</thead>
								<tbody>
                                    <tr width=\"100%\">
                                        <td width=\"25%\" style=\"background-color:#333333;text-align:right;vertical-align:middle;border:none;\">";
										echo "<span id=\"status\">".$status."</span> ";
										echo "<span id=\"tr1\">".$s1."</span>";
										echo "</td>
										<td width=\"15%\" style=\"background-color:#333333;text-align:right;vertical-align:middle;border:none;\">
										    <div class=\"amount\" id=\"slider_1_amount\"><span id=\"s1\">".$sl1."</span></div>
											<div id=\"slider_1\" style=\"height: 100px;\"></div>
										</td>
                                        <td width=\"35%\" style=\"background-color:#333333;text-align:left;vertical-align:middle;border:none;\">";
                                        echo "<span id=\"stk1\">".$temp1."</span>";
											echo "
										</td>
                                        <td width=\"25%\" style=\"background-color:#111111;border:none;\">
				                        <span id=\"v1\">".$v1."</span>";
										echo "</td>
                                    </tr>
                                    <tr width=\"100%\">
                                        <td width=\"25%\" style=\"background-color:#333333;text-align:right;vertical-align:middle;border:none;\">";
										echo "<span id=\"r\">".$reg."</span> ";
										echo "<span id=\"tr2\">".$s2."</span>";
										echo "</td>
										<td width=\"15%\" style=\"background-color:#333333;text-align:right;vertical-align:middle;border:none;\"> 
										    <div class=\"amount\" id=\"slider_2_amount\"><span id=\"s2\">".$sl2."</span></div>
											<div id=\"slider_2\" style=\"height: 100px;\"></div>
										</td>
                                        <td width=\"35%\" style=\"background-color:#333333;text-align:left;vertical-align:middle;border:none;\">";
										echo "<span id=\"stk2\">".$temp2."</span>";
											echo "
										</td>
                                        <td width=\"25%\" style=\"background-color:#111111;border:none;\">
                                        <span id=\"v2\">".$v2."</span>";
										echo "</td>
                                    </tr>
                                </tbody><tfooter style=\"border:none;\"><tr style=\"border:none;\">
								<th style=\"border:none;\"></th><th style=\"border:none;\"></th><th colspan\"2\" style=\"border:none;\">";
	if ($user_settings['level'] < 4) {
		echo "<span class=\"fl label label-important\">". get_lang($lang, 'ad136').": 4</span>";
	} else {
		echo "<span class=\"fl label label-success\">". get_lang($lang, 'ad136').": 4</span>";
	}
								echo "</th></tr></tfooter></table>";
							?>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-tasks fa-1x"></i><span><?php echo get_lang($lang, 'inter95'); ?></span>
                        </div>
                        <div class="block-fluid">
						<?php setup_work_schedule(); ?>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?lang='.$lang.'&line='.$line.'&inv='.$inv.'&sys='.$sys.'&id='.$id.'&command=SS'; ?>" method="post" id="schedule">
<table cellpadding='0' cellspacing='0' class='table' width='100%'>
		<thead>
            <tr> 
<th width='6%'><i class="fa fa-retweet fa-1x"></i></th>
<th width='47%'><?php echo get_lang($lang, 'inter96'); ?></th>
<th width='47%'><?php echo get_lang($lang, 'inter97'); ?></th>
            </tr>
		</thead>
		<tbody>
            <tr>
<td>
<div class="setup">
<span class="label label-info">1</span>
</div>
</td>
<td>
<div class="setup">
<input id="x1" type="text" MAXLENGTH="2" class="input-m30 temp" name="hon1" value=""/>
<span>:</span>
<input id="x2" type="text" MAXLENGTH="2" class="input-m30 temp" name="mon1" value=""/>
</div> 
</td>
<td>
<div class="setup">
<input id="x3" type="text" MAXLENGTH="2" class="input-m30 temp" name="hof1" value=""/>
<span>:</span>
<input id="x4" type="text" MAXLENGTH="2" class="input-m30 temp" name="mof1" value=""/>
</div>
</td>
</tr>
<tr>
<td>
<div class="setup">
<span class="label label-info">2</span>
</div>
</td>
<td>
<div class="setup">
<input id="x5" type="text" MAXLENGTH="2" class="input-m30 temp" name="hon2" value=""/>
<span>:</span>
<input id="x6" type="text" MAXLENGTH="2" class="input-m30 temp" name="mon2" value=""/>
</div> 
</td>
<td>
<div class="setup">
<input id="x7" type="text" MAXLENGTH="2" class="input-m30 temp" name="hof2" value=""/>
<span>:</span>
<input id="x8" type="text" MAXLENGTH="2" class="input-m30 temp" name="mof2" value=""/>
</div> 
</td>
</tr>
<tr>
<td>
<div class="setup">
<span class="label label-success">3</span>
</div>
</td>
<td>
<div class="setup">
<input id="x9" type="text" MAXLENGTH="2" class="input-m30 temp" name="hon3" value=""/>
<span>:</span>
<input id="x10" type="text" MAXLENGTH="2" class="input-m30 temp" name="mon3" value=""/>
</div> 
</td>
<td>
<div class="setup">
<input id="x11" type="text" MAXLENGTH="2" class="input-m30 temp" name="hof3" value=""/>
<span>:</span>
<input id="x12" type="text" MAXLENGTH="2" class="input-m30 temp" name="mof3" value=""/>
</div> 
</td>
</tr>
<tr>
<td>
<div class="setup">
<span class="label label-success">4</span>
</div>
</td>
<td>
<div class="setup">
<input id="x13" type="text" MAXLENGTH="2" class="input-m30 temp" name="hon4" value=""/>
<span>:</span>
<input id="x14" type="text" MAXLENGTH="2" class="input-m30 temp" name="mon4" value=""/>
</div> 
</td>
<td>
<div class="setup">
<input id="x15" type="text" MAXLENGTH="2" class="input-m30 temp" name="hof4" value=""/>
<span>:</span>
<input id="x16" type="text" MAXLENGTH="2" class="input-m30 temp" name="mof4" value=""/>
</div> 
</td>
</tr>
<tr>
<td>
<div class="setup">
<span class="label label-warning">5</span>
</div>
</td>
<td>
<div class="setup">
<input id="x17" type="text" MAXLENGTH="2" class="input-m30 temp" name="hon5" value=""/>
<span>:</span>
<input id="x18" type="text" MAXLENGTH="2" class="input-m30 temp" name="mon5" value=""/>
</div> 
</td>
<td>
<div class="setup">
<input id="x19" type="text" MAXLENGTH="2" class="input-m30 temp" name="hof5" value=""/>
<span>:</span>
<input id="x20" type="text" MAXLENGTH="2" class="input-m30 temp" name="mof5" value=""/>
</div> 
</td>
</tr>
<tr>
<td>
<div class="setup">
<span class="label label-warning">6</span>
</div>
</td>
<td>
<div class="setup">
<input id="x21" type="text" MAXLENGTH="2" class="input-m30 temp" name="hon6" value=""/>
<span>:</span>
<input id="x22" type="text" MAXLENGTH="2" class="input-m30 temp" name="mon6" value=""/>
</div> 
</td>
<td>
<div class="setup">
<input id="x23" type="text" MAXLENGTH="2" class="input-m30 temp" name="hof6" value=""/>
<span>:</span>
<input id="x24" type="text" MAXLENGTH="2" class="input-m30 temp" name="mof6" value=""/>
</div> 
</td>
</tr>
<tr>
<td>
<div class="setup">
<span class="label label-important">7</span>
</div>
</td>
<td>
<div class="setup">
<input id="x25" type="text" MAXLENGTH="2" class="input-m30 temp" name="hon7" value=""/>
<span>:</span>
<input id="x26" type="text" MAXLENGTH="2" class="input-m30 temp" name="mon7" value=""/>
</div> 
</td>
<td>
<div class="setup">
<input id="x27" type="text" MAXLENGTH="2" class="input-m30 temp" name="hof7" value=""/>
<span>:</span>
<input id="x28" type="text" MAXLENGTH="2" class="input-m30 temp" name="mof7" value=""/>
</div> 
</td>
</tr>
<tr>
<td>
<div class="setup">
<span class="label label-important">8</span>
</div>
</td>
<td>
<div class="setup">
<input id="x29" type="text" MAXLENGTH="2" class="input-m30 temp" name="hon8" value=""/>
<span>:</span>
<input id="x30" type="text" MAXLENGTH="2" class="input-m30 temp" name="mon8" value=""/>
</div> 
</td>
<td>
<div class="setup">
<input id="x31" type="text" MAXLENGTH="2" class="input-m30 temp" name="hof8" value=""/>
<span>:</span>
<input id="x32" type="text" MAXLENGTH="2" class="input-m30 temp" name="mof8" value=""/>
</div> 
</td>
</tr>
        </tbody>
	</table>
	<div class='footer'>
	<?php
	if ($user_settings['level'] < 3) {
		echo "
		<span class='fl label label-important'>". get_lang($lang, 'ad136').": 3</span>
        <button type='submit' name='submit' value='submit' class='btn btn-default' disabled='disabled' disabled>
		    <i class='fa fa-legal'></i>&nbsp; ".get_lang($lang, 'inter94')."</button>
		";
	} else {
		echo "
		<span class='fl label label-success'>". get_lang($lang, 'ad136').": 3</span>
        <button type='submit' name='submit' value='submit' class='btn btn-default'>
		    <i class='fa fa-legal'></i>&nbsp; ".get_lang($lang, 'inter94')."</button>
		";
	}
	?>
	</div>
</form>
                        </div>
					</div>
                </div>
                <div class="dr"><span></span></div>
				<!--FOOTER-->
                <div class="row-fluid">
				<div class="footer">
                    <div class="span6">
                        <span class="fl"><?=$copyrights?> <small>&reg; &copy;</small> 2010 - 
						<script type="text/javascript">document.write(new Date().getFullYear())</script></span>
                    </div>
                    <div class="span6">
                        <span class="fr hits"><?php get_hits($lang); ?></span>
                    </div>
                </div>
				</div>
            </div>
        </div>   
    </div>
	<script type="text/javascript" charset="utf-8">
    function get_live_klima() {
	    setInterval(function () {
			$.ajax({
				url: 'live_klima.php?lang=<?php echo $lang; ?>&line=<?php echo $line; ?>&id=<?php echo $id; ?>', 
				success: function(point) {
		    y = eval(point);
			$('span#tr1').html(y[1]);
			$('span#tr2').html(y[2]);
			$('span#stk1').html(y[3]);
			$('span#stk2').html(y[4]);
			$('span#status').html(y[5]);
			$('span#s1').html(y[6]);
			$('span#s2').html(y[7]);
			$('span#v1').html(y[8]);
			$('span#v2').html(y[9]);
			$('span#r').html(y[10]);													
			},
				cache: false
			});
	    }, 5000);
	}
    $(function () { get_live_klima(); });
    $(document).ready(function(){
        $("#slider_1").slider({
            orientation: "vertical",
            range: "min",
            min: 15,
            max: 40,
            value: <?php echo $d[10]; ?>,
            slide: function( event, ui ) {
                $("#slider_1_amount").html('<span class="label label-warning"><h5>'+ui.value+' ºC</h5></span>');
            }            
        });
		$("#slider_1").on( "slidestop", function( event, ui ) { 
		var lang = "<?php echo $lang; ?>";
		if (lang == "") { return false; }
		var line = "<?php echo $line; ?>";
		if (line == "") { return false; }
		var id = "<?php echo $id; ?>";
		if (id == "") { return false; }
		var treg1 = ui.value;
		if (treg1 == "") { return false; }
		var treg2 = $("#slider_2").slider("value");
		if (treg2 == "") { return false; }
		var treg3 = "<?php echo $d[12]; ?>";
		if (treg3 == "") { return false; }
		var treg4 = "<?php echo $d[13]; ?>";
		if (treg4 == "") { return false; }
		var treg5 = "<?php echo $d[14]; ?>";
		if (treg5 == "") { return false; }
		var treg6 = "<?php echo $d[15]; ?>";
		if (treg6 == "") { return false; }
		var t_is = "<?php echo $d[4]; ?>";
		if (t_is == "") { return false; }
		var t_ok = "<?php echo $d[5]; ?>";
		if (t_ok == "") { return false; }
		var tmde = "4";
		if (tmde == "") { return false; }
		var tkon = "2";
		if (tkon == "") { return false; }
	var dataString = 'lang='+ lang + '&line='+ line + '&id=' + id + 
	                 '&treg1=' + treg1 + '&treg2=' + treg2 + '&treg3=' + treg3 + '&treg4=' + treg4 + '&treg5=' + treg5 + '&treg6=' + treg6 + 
					 '&t_is=' + t_is + '&t_ok=' + t_ok + '&tmde=' + tmde + '&tkon=' + tkon;
    $.ajax({  
      type: "POST",  
      url: "klima_process.php",  
      data: dataString,  
      success: function() {  
        alert("<?php echo get_lang($lang, 'ad279'); ?>");
      }  
    });  
    return false;
		});
        $("#slider_2").slider({
            orientation: "vertical",
            range: "min",
            min: 15,
            max: 40,
            value: <?php echo $d[12]; ?>,
            slide: function( event, ui ) {
                $("#slider_2_amount").html('<span class="label label-warning"><h5>'+ui.value+' ºC</h5></span>');
            }            
        });
		$("#slider_2").on( "slidestop", function( event, ui ) { 
		var lang = "<?php echo $lang; ?>";
		if (lang == "") { return false; }
		var line = "<?php echo $line; ?>";
		if (line == "") { return false; }
		var id = "<?php echo $id; ?>";
		if (id == "") { return false; }
		var treg1 = $("#slider_1").slider("value");
		if (treg1 == "") { return false; }
		var treg2 = "<?php echo $d[11]; ?>";
		if (treg2 == "") { return false; }
		var treg3 = ui.value;
		if (treg3 == "") { return false; }
		var treg4 = "<?php echo $d[13]; ?>";
		if (treg4 == "") { return false; }
		var treg5 = "<?php echo $d[14]; ?>";
		if (treg5 == "") { return false; }
		var treg6 = "<?php echo $d[15]; ?>";
		if (treg6 == "") { return false; }
		var t_is = "<?php echo $d[4]; ?>";
		if (t_is == "") { return false; }
		var t_ok = "<?php echo $d[5]; ?>";
		if (t_ok == "") { return false; }
		var tmde = "4";
		if (tmde == "") { return false; }
		var tkon = "2";
		if (tkon == "") { return false; }
	var dataString = 'lang='+ lang + '&line='+ line + '&id=' + id + 
	                 '&treg1=' + treg1 + '&treg2=' + treg2 + '&treg3=' + treg3 + '&treg4=' + treg4 + '&treg5=' + treg5 + '&treg6=' + treg6 + 
					 '&t_is=' + t_is + '&t_ok=' + t_ok + '&tmde=' + tmde + '&tkon=' + tkon;
    $.ajax({  
      type: "POST",  
      url: "klima_process.php",  
      data: dataString,  
      success: function() {  
        alert("<?php echo get_lang($lang, 'ad279'); ?>");
      }  
    });  
    return false;
		});
	});
	</script>
<?php
if ($user_settings['level'] < 4) {
    echo "
	<script type=\"text/javascript\" charset=\"utf-8\">
	$(document).ready(function(){
	    $(\"#slider_1\").slider(\"disable\");
	    $(\"#slider_2\").slider(\"disable\");
	});
	</script>";
}
?>
</body>
</html>