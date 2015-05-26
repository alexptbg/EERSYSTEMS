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
include('includes/klimatik_functions.php');
include('../includes/socket.php');
$kline = mysql_prep($_GET['line']);
$inv = mysql_prep($_GET['inv']);
$sys = $_GET['sys'];
$id = "";
check_login($lang,$kline,$id,$inv,$web_dir,$sys);
clear_cronk();
$kline_options = get_krouter_options($kline);
$datafile = "../data/{$kline_options['data_file']}";
$updated = date('H:i:s');
if ($datafile == NULL) { get_error($lang,'1002'); exit; }
if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
include("$datafile");
if (filesize($datafile)<100) { get_error($lang,'1004'); exit; }
$dev = ${'dev' . $inv};
$d = explode(" ", $dev);
$socket_ip = $kline_options['ip_address'];
$socket_port = $kline_options['port'];
$klimatik_options = get_klima_data($inv,$kline);
$rtu = $klimatik_options['rtu'];
$addr = $klimatik_options['addr'];
if ($user_settings['user_name'] != NULL) {
    $obs = $kline." | ".$inv;
    insert_log($lang,$user_settings['user_name'],'info','ad455',$obs);
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
	<link rel='stylesheet' type='text/css' href='css/klimatik.css' />
    <script type='text/javascript' src='js/knob.js' charset='utf-8'></script>
	<script type='text/javascript' src='js/klimatik.js' charset='utf-8'></script>
	<link rel='stylesheet' type='text/css' href='js/plugins/switch/jquery.switch.css' />
    <script type='text/javascript' src='js/plugins/switch/jquery.switch.min.js' charset='utf-8'></script>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
        <div class="header">
            <a class="logo" href="../klimatik.php?lang=<?=$lang?>&kline=<?=$kline?>">
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
					    <a href="logout.php?lang=<?=$lang?>&line=<?=$kline?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
						    <?php echo get_lang($lang, 'Logout'); ?></a></li>
                </ul>
                <div class="info">
                    <span><?php echo get_lang($lang, 'inter84') . "!"; ?></span><br/>
					<span><?php echo get_lang($lang, 'inter135').":<br/>".$user_settings['last_login']; ?></span>
                </div>
            </div>
			
            <ul class="navigation">            
                <li class="active">
                    <a href="klimatik_setup.php?lang=<?=$lang?>&line=<?=$kline?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-grid"></span><span class="text"><?php echo get_lang($lang, 'home'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="../admin/admin.php?lang=<?=$lang?>">
                        <span class="isw-settings"></span><span class="text"><?php echo get_lang($lang, 'inter61'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="../klimatik.php?lang=<?=$lang?>&kline=<?=$kline?>">
                        <span class="isw-left_circle"></span><span class="text"><?php echo get_lang($lang, 'ad193'); ?></span>
                    </a>
                </li>                        
            </ul>
        </div>

        <div class="content">
            <div class="breadLine">
                <ul class="breadcrumb">
                    <li><?=$kline?> \ <?=$inv?></li>                
                </ul>
                <span class="fr time">
			        <?php echo get_lang($lang, $day). ', ' . date('d') .' '.get_lang($lang, $month). ' '.date('Y').' - '; ?>
				    <span id="ctime"></span>
			    </span>
            </div>

            <div class="workplace">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-square fa-1x"></i><span><?php echo get_lang($lang, 'ad299'); ?> \ <?=$kline?> \ <?=$inv?></span>
                            <ul class="buttons">
							    <li class="s_loader tip-" title="<?php echo get_lang($lang, 'td58'); ?>"><img src="img/loaders/s_loader_bw.gif" /></li>
                                <li class="tip-" title="Отпечатване на таблицата">
                                    <a href="#" id="refresh" class="isw-refresh"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="block" style="background:#333333 url('img/backgrounds/metal.jpg') center center no-repeat;">
<?php
	$d0 = $d[0];//id//inv
	$d1 = $d[1];//date
	$d2 = $d[2];//time
    $d3 = ($d[3]*256+$d[4])/10;//outside temp
    $d4 = ($d[5]*256+$d[6])/10;//inside temp
    $d5 = ($d[7]*256+$d[8])/10;//set point temp
    $d6 = ($d[9]*256+$d[10])/10;///entrance temp
    $d7 = ($d[11]*256+$d[12])/10;//outrance temp
    $d8 = $d[13]*256+$d[14];//mode
    $d9 = $d[15]*256+$d[16];//set of the ventilation
    $d10 = $d[17]*256+$d[18];//step
    $d11 = ($d[19]*256+$d[20])/10;//set point energy saving cold
    $d12 = ($d[21]*256+$d[22])/10;//set point energy saving hot
	if ($d3 > 35) { $d3 = 'NULL'; }
	if ($d4 > 35) { $d4 = 'NULL'; }
	if ($d5 > 35) { $d5 = 'NULL'; }
	if ($d6 > 35) { $d6 = 'NULL'; }
	if ($d7 > 35) { $d7 = 'NULL'; }
	if ($d8 > 35) { $d8 = 0; }
	if ($d9 > 35) { $d9 = 0; }
	if ($d10 > 35) { $d10 = 0; }
	if ($d11 > 35) { $d11 = 'NULL'; }
	if ($d12 > 35) { $d12 = 'NULL'; }
	//led	
    if (($d8 < 8) && ($d8 > 0)) { $status = 'OFF'; led('off'); $ledt = get_lang($lang, 'Off'); } 
	elseif (($d8 < 13) && ($d8 > 8)) { $status = 'ON'; led('on'); $ledt = get_lang($lang, 'On'); } 
	else { $status = 'ERR'; led('err'); $ledt = get_lang($lang, '1052'); }
	mode($d8);
	get_klimatik($lang,$kline,$inv);
	get_crons();
	get_cronr();	
echo "
  <table class='std' width='100%'>
  <thead><tr>
  <th class='tip' title='".get_lang($lang, 'td4')."'>INV</th>
  <th class='tip' title='".get_lang($lang, 'info6')."'>DATE</th>
  <th class='tip' title='".get_lang($lang, 'inter72')."'>TIME</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad452')."'>OUT U T</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad324')."'>TEMP</th>
  <th class='th1 tip' title='".get_lang($lang, 'ad280')."'>SET POINT</th>
  <th class='th2 tip' title='".get_lang($lang, 'ad336')."'>-> TEMP</th>
  <th class='th4 tip' title='".get_lang($lang, 'ad337')."'>&lt;- TEMP</th>
  <th class='tip' title='".get_lang($lang, 'inter78')."'>MODE</th>
  <th class='tip' title='".get_lang($lang, 'ad446')."'>STEP</th>
  <th class='tip_' title='".get_lang($lang, 'ad325')."'>VENT</th>  
  <th class='tip_' title='".get_lang($lang, 'ad326')." ".get_lang($lang, 'ad335')."'>E COLD</th>
  <th class='tip_' title='".get_lang($lang, 'ad326')." ".get_lang($lang, 'ad334')."'>E HOT</th>
  </tr></thead><tbody><tr>\n";
    echo "<td>".$d0."</td>";
    echo "<td>".$d1."</td>";
    echo "<td><span id='d2'>".$d2."</span></td>";
    echo "<td><span id='d3'>".$d3."</span></td>";
    echo "<td><span id='d4'>".$d4."</span></td>";
    echo "<td><span id='d5'>".$d5."</span></td>";
    echo "<td><span id='d6'>".$d6."</span></td>";
    echo "<td><span id='d7'>".$d7."</span></td>";
    echo "<td><span id='d8'>".$d8."</span></td>";
    echo "<td><span id='d9'>".$d9."</span></td>";
    echo "<td><span id='d10'>".$d10."</span></td>";
    echo "<td><span id='d11'>".$d11."</span></td>";
    echo "<td><span id='d12'>".$d12."</span></td>";
	echo "</tr></tbody><tfoot>
	<tr><td colspan='6'><span id='cronr' class='tal'>0</span></td>
	    <td><i class=\"fa fa-exchange\"></i></td>
		<td colspan='6'><span id='crons' class='tar'>0</span></td>
	</tr></tfoot></table>";
?>
	<table class="kl" width="100%">
  <thead>
    <tr>
      <th colspan="3" class="caption"><?php echo get_lang($lang, 'Updated_at') . " <span id=\"d13\">" . $updated ."</span>"; ?></th>
    </tr>
  </thead>
	<tbody>
	    <tr>
		    <td colspan="3" class="l"><div class="lamp tip_" title="<?php echo $ledt; ?>"><span class="off"></span></div></td>
		</tr>
		<tr>
		<td colspan="3" class="c">
    <div class="led">
	    <div class="span5 mleft">
		    <span class="sp"><span id="d5" class="tip" title="<?php echo get_lang($lang, 'ad280'); ?>"><?=$d5?></span> ºC</span>
	        <p><span id="d1" class="tip" title="<?php echo get_lang($lang, 'info6'); ?>"><?=$d1?></span></p>
	        <p><span id="d2" class="tip" title="<?php echo get_lang($lang, 'inter72'); ?>"><?=$d2?></span></p>
			<div class="hr"></div>
			<h2 class="tip" title="<?php echo get_lang($lang, 'ad324'); ?>"><span id="d4"><?=$d4?></span> ºC</h2>
	    </div>
	    <div class="span7 mright">
	        <p><span class="tip" title="<?php echo get_lang($lang, 'Status'); ?>"><i class="fa fa-power-off active"></i> <span id="d14"><?=$status?></span></span>
			<span class="r tip_" title="<?php echo get_lang($lang, 'ad280')." ".get_lang($lang, 'ad334'); ?>"><i class="fa fa-flash active"></i> <span id="d12"><?=$d12?></span></span></p>
	        <p><span class="tip" title="<?php echo get_lang($lang, 'ad325'); ?>"><i class="fa fa-spinner active"></i> <span id="d10"><?=$d10?></span></span>
			<span class="r tip_" title="<?php echo get_lang($lang, 'ad326')." ".get_lang($lang, 'ad335'); ?>"><i class="fa fa-flash active"></i> <span id="d11"><?=$d11?></span></span></p>
				<div class="hr"></div>
			<h3>
			    <i id="off" class="fa fa-power-off tip" title="<?php echo get_lang($lang, 'ad327'); ?>"></i>
				<i id="cold" class="fa fa-asterisk tip" title="<?php echo get_lang($lang, 'ad330'); ?>"></i>
				<i id="det" class="fa fa-flask tip" title="<?php echo get_lang($lang, 'ad328'); ?>"></i>
				<i id="vent" class="fa fa-spinner tip" title="<?php echo get_lang($lang, 'ad331'); ?>"></i>
				<i id="hot" class="fa fa-sun-o tip" title="<?php echo get_lang($lang, 'ad329'); ?>"></i> 
				<i id="auto" class="tip" title="<?php echo get_lang($lang, 'ad332'); ?>"><?php echo get_lang($lang, 'ad440'); ?></i>				
			</h3>
	    </div>
	</div>
			</td>
		</tr>
		<tr>
			<td class="c tip" title="<?php echo get_lang($lang, 'Status'); ?>">
			    <?php
	                if ($user_settings['level'] < 4) {
                        if ($status == 'ON') {
							echo "
                <select id=\"ex\" disabled=\"disabled\">
                    <option value=\"1\" selected=\"selected\">".get_lang($lang, 'On')."</option>
                    <option value=\"0\">".get_lang($lang, 'Off')."</option>
                </select>";
						} else {
							echo "
                <select id=\"ex\" disabled=\"disabled\">
                    <option value=\"1\">".get_lang($lang, 'On')."</option>
                    <option value=\"0\" selected=\"selected\">".get_lang($lang, 'Off')."</option>
                </select>";
						}
	                } else {
                        if ($status == 'ON') {
							echo "
                <select id=\"ex\">
                    <option value=\"1\" selected=\"selected\">".get_lang($lang, 'On')."</option>
                    <option value=\"0\">".get_lang($lang, 'Off')."</option>
                </select>";
						} else {
							echo "
                <select id=\"ex\">
                    <option value=\"1\">".get_lang($lang, 'On')."</option>
                    <option value=\"0\" selected=\"selected\">".get_lang($lang, 'Off')."</option>
                </select>";
						}
	                }
				?>
			</td>
			<td class="c tip" title="<?php echo get_lang($lang, 'ad444'); ?>">
<script type="text/javascript">
$(function() {
    $('#refresh').click(function() {
        location.reload();
    });
	var count = <?=$d9?>;
    if (count === 1) {
		$("#step").removeClass("btn-default");//disabled
	  	$("#step").removeClass("btn-inverse");//0
	  	$("#step").removeClass("btn-success");//1
	  	$("#step").removeClass("btn-warning");//2
	  	$("#step").removeClass("btn-danger");//3
		$("#step").addClass("btn-success");//1
		$("#step").html('<i class=\"fa fa-spinner\"></i> <?php echo get_lang($lang, "ad441"); ?>');
		var $v = $(".vent");
		$v.val(count).trigger("change");
    } else if(count === 2){
		$("#step").removeClass("btn-default");//disabled
	  	$("#step").removeClass("btn-inverse");//0
	  	$("#step").removeClass("btn-success");//1
	  	$("#step").removeClass("btn-warning");//2
	  	$("#step").removeClass("btn-danger");//3
		$("#step").addClass("btn-warning");//2
		$("#step").html('<i class=\"fa fa-spinner\"></i> <?php echo get_lang($lang, "ad442"); ?>');
		var $v = $(".vent");
		$v.val(count).trigger("change");
    } else if(count === 3){
		$("#step").removeClass("btn-default");//disabled
	  	$("#step").removeClass("btn-inverse");//0
	  	$("#step").removeClass("btn-success");//1
	  	$("#step").removeClass("btn-warning");//2
	  	$("#step").removeClass("btn-danger");//3
		$("#step").addClass("btn-danger");//3
		$("#step").html('<i class=\"fa fa-spinner\"></i> <?php echo get_lang($lang, "ad443"); ?>');
		var $v = $(".vent");
		$v.val(count).trigger("change");
    } else {
		count = 1;
		$("#step").removeClass("btn-default");//disabled
	  	$("#step").removeClass("btn-inverse");//0
	  	$("#step").removeClass("btn-success");//1
	  	$("#step").removeClass("btn-warning");//2
	  	$("#step").removeClass("btn-danger");//3
		$("#step").addClass("btn-success");//1
		$("#step").html('<i class=\"fa fa-spinner\"></i> <?php echo get_lang($lang, "ad441"); ?>');
		var $v = $(".vent");
		$v.val(count).trigger("change");
    }
    $("#step").each(function() {
        $(this).click(function(){
        count++;
    if (count === 1) {
		$("#step").removeClass("btn-default");//disabled
	  	$("#step").removeClass("btn-inverse");//0
	  	$("#step").removeClass("btn-success");//1
	  	$("#step").removeClass("btn-warning");//2
	  	$("#step").removeClass("btn-danger");//3
		$("#step").addClass("btn-success");//1
		$("#step").html('<i class=\"fa fa-spinner\"></i> <?php echo get_lang($lang, "ad441"); ?>');
        var postData = { 'action' : 'ST', 'kline' : '<?=$kline?>', 'inv' : '<?=$inv?>', 'step' : count }; 
        $.ajax({
            url: 'klimatik_handle_step.php',
            type: 'post',
            data: postData,
            success: function(result){ 
		        var $v = $(".vent");
		        $v.val(count).trigger("change");
			}
        });
    } else if(count === 2){
		$("#step").removeClass("btn-default");//disabled
	  	$("#step").removeClass("btn-inverse");//0
	  	$("#step").removeClass("btn-success");//1
	  	$("#step").removeClass("btn-warning");//2
	  	$("#step").removeClass("btn-danger");//3
		$("#step").addClass("btn-warning");//2
		$("#step").html('<i class=\"fa fa-spinner\"></i> <?php echo get_lang($lang, "ad442"); ?>');
        var postData = { 'action' : 'ST', 'kline' : '<?=$kline?>', 'inv' : '<?=$inv?>', 'step' : count }; 
        $.ajax({
            url: 'klimatik_handle_step.php',
            type: 'post',
            data: postData,
            success: function(result){ 
		        var $v = $(".vent");
		        $v.val(count).trigger("change");
			}
        });
    } else if(count === 3){
		$("#step").removeClass("btn-default");//disabled
	  	$("#step").removeClass("btn-inverse");//0
	  	$("#step").removeClass("btn-success");//1
	  	$("#step").removeClass("btn-warning");//2
	  	$("#step").removeClass("btn-danger");//3
		$("#step").addClass("btn-danger");//3
		$("#step").html('<i class=\"fa fa-spinner\"></i> <?php echo get_lang($lang, "ad443"); ?>');
        var postData = { 'action' : 'ST', 'kline' : '<?=$kline?>', 'inv' : '<?=$inv?>', 'step' : count }; 
        $.ajax({
            url: 'klimatik_handle_step.php',
            type: 'post',
            data: postData,
            success: function(result){ 
		        var $v = $(".vent");
		        $v.val(count).trigger("change");
			}
        });
    } else {
		count = 1;
		$("#step").removeClass("btn-default");//disabled
	  	$("#step").removeClass("btn-inverse");//0
	  	$("#step").removeClass("btn-success");//1
	  	$("#step").removeClass("btn-warning");//2
	  	$("#step").removeClass("btn-danger");//3
		$("#step").addClass("btn-success");//1
		$("#step").html('<i class=\"fa fa-spinner\"></i> <?php echo get_lang($lang, "ad441"); ?>');
        var postData = { 'action' : 'ST', 'kline' : '<?=$kline?>', 'inv' : '<?=$inv?>', 'step' : count }; 
        $.ajax({
            url: 'klimatik_handle_step.php',
            type: 'post',
            data: postData,
            success: function(result){ 
		        var $v = $(".vent");
		        $v.val(count).trigger("change");
			}
        });
    }
        });
    });
	var counter = <?=$d8?>;
	if (counter < 9) { counter += 8 };
        if (counter === 9) {
		$("#mo").removeClass("btn-inverse");//auto
	  	$("#mo").removeClass("btn-primary");//cold
	  	$("#mo").removeClass("btn-info");//humidity
	  	$("#mo").removeClass("btn-success");//ventilation
		$("#mo").removeClass("btn-danger");//hot
		$("#mo").addClass("btn-primary");//cold
		$("#mo").html('<i class=\"fa fa-retweet\"></i> <?php echo get_lang($lang, "ad330"); ?>');
		var $e = $(".ener");
		$e.val(counter).trigger("change");
        } else if(counter === 10){
		$("#mo").removeClass("btn-inverse");//auto
	  	$("#mo").removeClass("btn-primary");//cold
	  	$("#mo").removeClass("btn-info");//humidity
	  	$("#mo").removeClass("btn-success");//ventilation
		$("#mo").removeClass("btn-danger");//hot
		$("#mo").addClass("btn-info");//humidity
		$("#mo").html('<i class=\"fa fa-retweet\"></i> <?php echo get_lang($lang, "ad328"); ?>');
		var $e = $(".ener");
		$e.val(counter).trigger("change");
        } else if(counter === 11){
		$("#mo").removeClass("btn-inverse");//auto
	  	$("#mo").removeClass("btn-primary");//cold
	  	$("#mo").removeClass("btn-info");//humidity
	  	$("#mo").removeClass("btn-success");//ventilation
		$("#mo").removeClass("btn-danger");//hot
		$("#mo").addClass("btn-success");//ventilation
		$("#mo").html('<i class=\"fa fa-retweet\"></i> <?php echo get_lang($lang, "ad331"); ?>');
		var $e = $(".ener");
		$e.val(counter).trigger("change");
        } else if(counter === 12){
		$("#mo").removeClass("btn-inverse");//auto
	  	$("#mo").removeClass("btn-primary");//cold
	  	$("#mo").removeClass("btn-info");//humidity
	  	$("#mo").removeClass("btn-success");//ventilation
		$("#mo").removeClass("btn-danger");//hot
		$("#mo").addClass("btn-danger");//hot
		$("#mo").html('<i class=\"fa fa-retweet\"></i> <?php echo get_lang($lang, "ad329"); ?>');
		var $e = $(".ener");
		$e.val(counter).trigger("change");
        } else {
		counter = 9;
		$("#mo").removeClass("btn-inverse");//auto
	  	$("#mo").removeClass("btn-primary");//cold
	  	$("#mo").removeClass("btn-info");//humidity
	  	$("#mo").removeClass("btn-success");//ventilation
		$("#mo").removeClass("btn-danger");//hot
		$("#mo").addClass("btn-primary");//cold
		$("#mo").html('<i class=\"fa fa-retweet\"></i> <?php echo get_lang($lang, "ad330"); ?>');
		var $e = $(".ener");
		$e.val(counter).trigger("change");
        }
    $("#mo").each(function() {
        $(this).click(function(){
        counter++;
        if (counter === 9) {
		$("#mo").removeClass("btn-inverse");//auto
	  	$("#mo").removeClass("btn-primary");//cold
	  	$("#mo").removeClass("btn-info");//humidity
	  	$("#mo").removeClass("btn-success");//ventilation
		$("#mo").removeClass("btn-danger");//hot
		$("#mo").addClass("btn-primary");//cold
		$("#mo").html('<i class=\"fa fa-retweet\"></i> <?php echo get_lang($lang, "ad330"); ?>');
        var postData = { 'action' : 'MD', 'kline' : '<?=$kline?>', 'inv' : '<?=$inv?>', 'mode' : counter }; 
        $.ajax({
            url: 'klimatik_handle_mode.php',
            type: 'post',
            data: postData,
            success: function(result){ 
		        var $e = $(".ener");
		        $e.val(counter).trigger("change");
			}
        });
        } else if(counter === 10){
		$("#mo").removeClass("btn-inverse");//auto
	  	$("#mo").removeClass("btn-primary");//cold
	  	$("#mo").removeClass("btn-info");//humidity
	  	$("#mo").removeClass("btn-success");//ventilation
		$("#mo").removeClass("btn-danger");//hot
		$("#mo").addClass("btn-info");//humidity
		$("#mo").html('<i class=\"fa fa-retweet\"></i> <?php echo get_lang($lang, "ad328"); ?>');
        var postData = { 'action' : 'MD', 'kline' : '<?=$kline?>', 'inv' : '<?=$inv?>', 'mode' : counter }; 
        $.ajax({
            url: 'klimatik_handle_mode.php',
            type: 'post',
            data: postData,
            success: function(result){ 
		        var $e = $(".ener");
		        $e.val(counter).trigger("change");
			}
        });
        } else if(counter === 11){
		$("#mo").removeClass("btn-inverse");//auto
	  	$("#mo").removeClass("btn-primary");//cold
	  	$("#mo").removeClass("btn-info");//humidity
	  	$("#mo").removeClass("btn-success");//ventilation
		$("#mo").removeClass("btn-danger");//hot
		$("#mo").addClass("btn-success");//ventilation
		$("#mo").html('<i class=\"fa fa-retweet\"></i> <?php echo get_lang($lang, "ad331"); ?>');
        var postData = { 'action' : 'MD', 'kline' : '<?=$kline?>', 'inv' : '<?=$inv?>', 'mode' : counter }; 
        $.ajax({
            url: 'klimatik_handle_mode.php',
            type: 'post',
            data: postData,
            success: function(result){ 
		        var $e = $(".ener");
		        $e.val(counter).trigger("change");
			}
        });
        } else if(counter === 12){
		$("#mo").removeClass("btn-inverse");//auto
	  	$("#mo").removeClass("btn-primary");//cold
	  	$("#mo").removeClass("btn-info");//humidity
	  	$("#mo").removeClass("btn-success");//ventilation
		$("#mo").removeClass("btn-danger");//hot
		$("#mo").addClass("btn-danger");//hot
		$("#mo").html('<i class=\"fa fa-retweet\"></i> <?php echo get_lang($lang, "ad329"); ?>');
        var postData = { 'action' : 'MD', 'kline' : '<?=$kline?>', 'inv' : '<?=$inv?>', 'mode' : counter }; 
        $.ajax({
            url: 'klimatik_handle_mode.php',
            type: 'post',
            data: postData,
            success: function(result){ 
		        var $e = $(".ener");
		        $e.val(counter).trigger("change");
			}
        });
        } else {
		counter = 9;
		$("#mo").removeClass("btn-inverse");//auto
	  	$("#mo").removeClass("btn-primary");//cold
	  	$("#mo").removeClass("btn-info");//humidity
	  	$("#mo").removeClass("btn-success");//ventilation
		$("#mo").removeClass("btn-danger");//hot
		$("#mo").addClass("btn-primary");//cold
		$("#mo").html('<i class=\"fa fa-retweet\"></i> <?php echo get_lang($lang, "ad330"); ?>');
        var postData = { 'action' : 'MD', 'kline' : '<?=$kline?>', 'inv' : '<?=$inv?>', 'mode' : counter }; 
        $.ajax({
            url: 'klimatik_handle_mode.php',
            type: 'post',
            data: postData,
            success: function(result){ 
		        var $e = $(".ener");
		        $e.val(counter).trigger("change");
			}
        });
        }
        });
    });
});
</script>
			    <?php
	if ($user_settings['level'] < 4) {
		    echo "<button id=\"step\" class=\"btn btn-default btn-large\" disabled=\"disabled\" disabled>
			      <i class=\"fa fa-spinner\"></i> ".get_lang($lang, 'ad444')."</button>";
	} else {
        if ($status == 'ON') {
            echo "<button id=\"step\" class=\"btn btn-inverse btn-large\">
			      <i class=\"fa fa-spinner\"></i> ".get_lang($lang, 'ad444')."</button>";
        } else {
		    echo "<button id=\"step\" class=\"btn btn-inverse btn-large\" disabled=\"disabled\" disabled>
			      <i class=\"fa fa-spinner\"></i> ".get_lang($lang, 'ad444')."</button>";
        }
	}
				?>
			</td>
			<td class="c tip" title="<?php echo get_lang($lang, 'inter78'); ?>">
			    <?php
	if ($user_settings['level'] < 10) {
		    echo "<button id=\"mo\" class=\"btn btn-default btn-large\" disabled=\"disabled\" disabled>
			      <i class=\"fa fa-refresh\"></i> ".get_lang($lang, 'inter78')."</button>";
	} else {
        if ($status == 'ON') {
            echo "<button id=\"mo\" class=\"btn btn-inverse btn-large\">
			      <i class=\"fa fa-refresh\"></i> ".get_lang($lang, 'inter78')."</button>";
        } else {
		    echo "<button id=\"mo\" class=\"btn btn-inverse btn-large\" disabled=\"disabled\" disabled>
			      <i class=\"fa fa-refresh\"></i> ".get_lang($lang, 'inter78')."</button>";
        }
	}
				?>
			</td>			
		</tr>
		<tr>
		    <td>
			<div class="tip" title="<?php echo get_lang($lang, 'ad280'); ?>" style="margin:0 auto;width:140px;">
                <input class="dial" 
				       data-width="140" 
					   data-height="140"
					   data-font-size="22"
					   data-skin="tron"
					   data-min="16"
					   data-max="30"
					   value="<?=$d5?>"
					   data-cursor="false"
					   data-thickness=".2"
					   data-font-color="#232A34"
                       data-fgColor="#232A34"
                       data-bgColor="#20b056"
					   data-step="0.5"
					   data-displayPrevious="false"
					   data-readOnly="true"
		        />
			</div> 
			</td>
		    <td>
			<div class="tip" title="<?php echo get_lang($lang, 'ad446'); ?>" style="margin:0 auto;width:140px;">
                <input class="vent" 
				       data-width="140" 
					   data-height="140"
					   data-font-size="32"
					   data-skin="tron"
					   data-min="0"
					   data-max="3"
					   value="<?=$d9?>"
					   data-cursor="false"
					   data-thickness=".1"
					   data-font-color="#232A34"
                       data-fgColor="#232A34"
                       data-bgColor="#288295"
					   data-step="1"
					   data-displayPrevious="false"
					   data-readOnly="true"
			    />
			</div>
			</td>
		    <td>
			<div class="tip_" title="<?php echo get_lang($lang, 'inter78'); ?>" style="margin:0 auto;width:140px;">
                <input class="ener" 
				       data-width="140" 
					   data-height="140"
					   data-font-size="22"
					   data-skin="tron"
					   data-min="8"
					   data-max="12"
					   value="<?=$d8?>"
					   data-cursor="false"
					   data-thickness=".1"
					   data-font-color="#232A34"
                       data-fgColor="#232A34"
                       data-bgColor="#ce1149"
					   data-step="1"
					   data-displayPrevious="false"
					   data-readOnly="true"
			    />
			</div>
			</td>
		</tr>
		<tr>
			<td class="c">
			    <?php
	if ($user_settings['level'] < 4) {
        echo "
                <button id=\"minus\" class=\"btn btn-inverse btn-large\" disabled=\"disabled\" disabled><i class=\"fa fa-minus\"></i></button>
				<span id=\"output\" class=\"cd\">".$d5."</span>
                <button id=\"plus\" class=\"btn btn-inverse btn-large\" disabled=\"disabled\" disabled><i class=\"fa fa-plus\"></i></button>
				<button id=\"send\" class=\"btn btn-danger btn-large\" disabled=\"disabled\" disabled>OK</button>";
	} else {
        if ($status == 'ON') {
        echo "
                <button id=\"minus\" class=\"btn btn-inverse btn-large\"><i class=\"fa fa-minus\"></i></button>
				<span id=\"output\" class=\"cd\">".$d5."</span>
                <button id=\"plus\" class=\"btn btn-inverse btn-large\"><i class=\"fa fa-plus\"></i></button>
				<button id=\"send\" class=\"btn btn-danger btn-large\">OK</button>";
		} else {
        echo "
                <button id=\"minus\" class=\"btn btn-inverse btn-large\" disabled=\"disabled\" disabled><i class=\"fa fa-minus\"></i></button>
				<span id=\"output\" class=\"cd\">".$d5."</span>
                <button id=\"plus\" class=\"btn btn-inverse btn-large\" disabled=\"disabled\" disabled><i class=\"fa fa-plus\"></i></button>
				<button id=\"send\" class=\"btn btn-danger btn-large\" disabled=\"disabled\" disabled>OK</button>";
		}
	}
				?>
    <script type="text/javascript">
    $(function() {
        $("#minus").click(function() {
            $('#output').html(function(i, val) {
				if (val < 18) {
			        $("#minus").attr("disabled", true);
					$("#plus").removeAttr("disabled");
					val = 16;
				} else {
					$("#minus").removeAttr("disabled");
					$("#plus").removeAttr("disabled");
					val = +val-1;
				}
				var $s = $(".dial");
				$s.val(val).trigger("change");
				return val.toFixed(1);
			});
        });
        $("#plus").click(function() {
            $('#output').html(function(i, val) { 
				if (val > 28) {
			        $("#plus").attr("disabled", true);
					$("#minus").removeAttr("disabled");
					val = 30;
				} else {
					$("#minus").removeAttr("disabled");
					val = +val+1;
				}
				var $s = $(".dial");
				$s.val(val).trigger("change");
				return val.toFixed(1);
			});
        });
		$("#send").click(function() {
			$('#output').html(function(i, val) {
			    var td = val*10;
				var th = parseInt(td/256); //first frame
				var t = td-(th*256);//second frame
                var postData = { 'action' : 'SP', 'kline' : '<?=$kline?>', 'inv' : '<?=$inv?>', 'first' : th , 'second' : t }; 
                $.ajax({
                    url: 'klimatik_handle_setp.php',
                    type: 'post',
                    data: postData,
                    success: function(result) { 
					    //do nothing
					}
                });
			});
		});
	});
    </script>
			</td>
			<td class="c">
				
			</td>
			<td class="c">
				
			</td>			
		</tr>
		<tr>
			<td class="c">
			    <?php
	if ($user_settings['level'] < 4) {
		echo "<span class=\"label label-important\">". get_lang($lang, 'ad136').": 4</span>";
	} else {
		echo "<span class=\"label label-success\">". get_lang($lang, 'ad136').": 4</span>";
	}
				?>
			</td>
			<td class="c">
			    <?php
	if ($user_settings['level'] < 4) {
		echo "<span class=\"label label-important\">". get_lang($lang, 'ad136').": 4</span>";
	} else {
		echo "<span class=\"label label-success\">". get_lang($lang, 'ad136').": 4</span>";
	}
				?>
			</td>
			<td class="c">
			    <?php
	if ($user_settings['level'] < 10) {
		echo "<span class=\"label label-important\">". get_lang($lang, 'ad136').": 10</span>";
	} else {
		echo "<span class=\"label label-success\">". get_lang($lang, 'ad136').": 10</span>";
	}
				?>
			</td>			
		</tr>
	</tbody>
	</table>
    <?php
	if ($user_settings['level'] < 4) {
        echo "
<script type='text/javascript' charset='UTF-8'>
    $(function() {
                      $('select#ex').switchify().data('switch').bind('switch:slide', function(e, type) {
                          if (type == 'on') {
          
	                      } else {

	                      }
                      });
	});
</script>";
	} else {
        echo "
<script type='text/javascript' charset='UTF-8'>
    $(function() {
                      $('select#ex').switchify().data('switch').bind('switch:slide', function(e, type) {
                          if (type == 'on') {
                              var postData = { 'action' : 'on', 'kline' : '".$kline."', 'inv' : '".$inv."', 'mode' : '".$d8."' }; 
                              $.ajax({
                                  url: 'klimatik_handle_status.php',
                                  type: 'post',
                                  data: postData,
                                  success: function(result){
								  	  var interval = null;
								      interval = setInterval(update_buttons,10000);
								  }
                              });
	                      } else {
                              var postData = { 'action' : 'off', 'kline' : '".$kline."', 'inv' : '".$inv."', 'mode' : '".$d8."' };
                                  $.ajax({
                                      url: 'klimatik_handle_status.php',
                                      type: 'post',
                                      data: postData,
                                      success: function(result){ 
									      $('#step').attr('disabled', true); 
										  $('#mo').attr('disabled', true);
										  $('#minus').attr('disabled', true);
										  $('#plus').attr('disabled', true);
										  $('#send').attr('disabled', true);
										  clearInterval(interval);										   
								      }
                                  });
	                          }
                          });
	});
function update_buttons(){
		$('span#d14').html(function(i, val) {
			if (val == 'ON') {
			    $(\"#step\").removeAttr(\"disabled\");";
				if ($user_settings['level'] > 5) { echo "$(\"#mo\").removeAttr(\"disabled\");"; }
				echo "
			    $(\"#send\").removeAttr(\"disabled\");	
			} else {
				$('#step').attr('disabled', true);";
				if ($user_settings['level'] > 5) { echo "$('#mo').attr('disabled', true);"; }
				echo "
				clearInterval(interval);
			}		
		});
}
var interval = null;
$(document).ready(function() {
    interval = setInterval(update_buttons,10000);
	/*setTimeout(\"ReloadPage()\", 90000);*/
});
function ReloadPage() { 
   location.reload();
};
</script>";
	}
				?>
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
</body>
</html>