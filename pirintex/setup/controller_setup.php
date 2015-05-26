<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(0);
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
get_line_options($line);
$datafile = "../data/{$line_options['data_file']}";
$ala = $line_options['alarm'];
$red = $line_options['red'];
$ex_red = $line_options['ex_red'];
$ex_red = explode(',', $ex_red);
$ex_alarm = $line_options['ex_alarm'];
$ex_alarm = explode(',', $ex_alarm);
$ex_table = $line_options['ex_table'];
$ex_table = explode(',', $ex_table);
$updated = date('H:i:s');
$socket_ip = $line_options['ip_address'];
$socket_port = $line_options['port'];
if ($datafile == NULL) { get_error($lang,'1002'); exit; }
if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
include("$datafile");
include ('cron.php'); include ('cron2.php'); 
$dat = explode(' ', $ep); 
$par = explode(' ', $ap);
include('../includes/socket.php');
$command = "";
$command = $_GET['command'];
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
	    if ($command == 'ST') {
		    $dayl = date('N');
            $w = '0';
            if (isset($_POST['w'])) { $w = '1'; } else { $w = '0'; }
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$server $command $id $dayl $w\r\n");
			$obs = $line."|".$inv;
			insert_log($lang,$user_settings['user_name'],'warning','ad128',$obs);
		}
		if ($command == 'PT') {
            $treg1 = $_POST["treg1"]; $treg2 = $_POST["treg2"]; $t_is = $_POST["t_is"]; $t_ok = $_POST["t_ok"];
            $treg3 = $_POST["treg3"]; $treg4 = $_POST["treg4"]; $tmde = $_POST["tmde"]; $tkon = $_POST["tkon"];
            $treg5 = $_POST["treg5"]; $treg6 = $_POST["treg6"];
	        $sc = new ClientSocket();
	        $sc->open($socket_ip,$socket_port);
	        $sc->send("$server $command $id $treg1 $treg2 $treg3 $treg4 $treg5 $treg6 $t_is $t_ok $tmde $tkon\r\n");
			$obs = $line."|".$inv;
			insert_log($lang,$user_settings['user_name'],'warning','ad129',$obs);
		}
		if ($command == 'SN') {		
            $in1 = $_POST["inv1"]; $mr1 = $_POST["mrk1"]; $ty1 = $_POST["typ1"]; $us1 = $_POST["usr1"]; $pl1 = $_POST["plc1"];
            $in2 = $_POST["inv2"]; $mr2 = $_POST["mrk2"]; $ty2 = $_POST["typ2"]; $us2 = $_POST["usr2"]; $pl2 = $_POST["plc2"];
            $in3 = $_POST["inv3"]; $mr3 = $_POST["mrk3"]; $ty3 = $_POST["typ3"]; $us3 = $_POST["usr3"]; $pl3 = $_POST["plc3"];
	        $sc = new ClientSocket();
	        $sc->open($socket_ip,$socket_port);
	        $sc->send("$server $command $id $in3 $in2 $in1 $mr3 $mr2 $mr1 $ty3 $ty2 $ty1 $us3 $us2 $us1 $pl3 $pl2 $pl1\r\n");
			$obs = $line."|".$inv;
			insert_log($lang,$user_settings['user_name'],'warning','ad130',$obs);
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
	    if ($command == 'BY') {
            $stby = '0';
            if (isset($_POST['stby'])) { $stby = '1'; } else { $stby = '0'; }
			$stb1 = $_POST["stb1"];
			$stb2 = $_POST["stb2"];
			$heat = $_POST["heat"];
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$server $command $id $heat $stby $stb1 $stb2\r\n");
			$obs = $line."|".$inv;
			insert_log($lang,$user_settings['user_name'],'warning','ad132',$obs);
		}		
	    if ($command == 'Server') {
            $com = $_POST["com"];
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$command $com\r\n");
			$obs = $line." | ".$com;
			insert_log($lang,$user_settings['user_name'],'error','ad116',$obs);
		}
	    if ($command == 'DR') {
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$server $command $id\r\n");
			$obs = $line."|".$inv;
			insert_log($lang,$user_settings['user_name'],'warning','ad133',$obs);
		}								
	}
}
catch (Exception $e){
	echo $e->getMessage();
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
            <a class="logo" href="../table.php?lang=<?=$lang?>&line=<?=$line?>">
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
                <li>
                    <a href="setup.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-grid"></span><span class="text"><?php echo get_lang($lang, 'home'); ?></span>
                    </a>
                </li>
                <li class="active">
                    <a href="controller_setup.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-calc"></span><span class="text"><?php echo get_lang($lang, 'td1'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="controller_repairs.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-target"></span><span class="text"><?php echo get_lang($lang, 'ad457'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="controller_info.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-list"></span><span class="text"><?php echo get_lang($lang, 'td3'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="../admin/admin.php?lang=<?=$lang?>">
                        <span class="isw-settings"></span><span class="text"><?php echo get_lang($lang, 'inter61'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="../table.php?lang=<?=$lang?>&line=<?=$line?>">
                        <span class="isw-left_circle"></span><span class="text"><?php echo get_lang($lang, 'ad193'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="../diagnostics.php?lang=<?=$lang?>&line=<?=$line?>">
                        <span class="isw-left_circle"></span><span class="text"><?php echo get_lang($lang,'Diagnostics'); ?></span>
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
                <div class='row-fluid'>

                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-clock-o fa-1x"></i><span><?php echo get_lang($lang, 'inter88'); ?></span>
                        </div>
                        <div class="block-fluid">
    <table cellpadding='0' cellspacing='0' class='table'>
	    <caption><?php echo get_lang($lang, 'Controller'); ?></caption>
		<thead>
            <tr>                                    
            <th width='20%'><?php echo get_lang($lang, 'inter72'); ?></th>
            <th width='20%'><?php echo get_lang($lang, 'info6'); ?></th>
            <th width='30%'><?php echo get_lang($lang, 'inter20'); ?></th>
            <th width='30%'><?php echo get_lang($lang, 'inter92'); ?></th>                                    
            </tr>
		</thead>
		<tbody>
            <tr>
                <td><?php setup_ti($lang,$line,$id); ?></td>
                <td><?php setup_di($lang,$line,$id); ?></td>
                <td><?php setup_day($lang); ?></td>
				<td><?php setup_wt(); ?></td>
			</tr>
        </tbody>
	</table>
	<form action="<?php echo $_SERVER['PHP_SELF'] . '?lang='.$lang.'&line='.$line.'&inv='.$inv.'&sys='.$sys.'&id='.$id.'&command=ST'; ?>" method="post">
	<table cellpadding='0' cellspacing='0' class='table'>
    <caption><?php echo get_lang($lang, 'inter93'); ?></caption>
		<thead>
            <tr>                                    
            <th width='20%'><?php echo get_lang($lang, 'inter72'); ?></th>
            <th width='20%'><?php echo get_lang($lang, 'info6'); ?></th>
            <th width='30%'><?php echo get_lang($lang, 'inter20'); ?></th>
            <th width='30%'><?php echo get_lang($lang, 'inter92'); ?></th>                                    
            </tr>
		</thead>
		<tbody>
            <tr>
                <td><?php server_time(); ?></td>
                <td><?php server_date(); ?></td>
                <td>
                <?php 
                    $dr = date('N');
                    if ($dr == '1') { $d = ucfirst(get_lang($lang, 'Monday')); }
                    if ($dr == '2') { $d = ucfirst(get_lang($lang, 'Tuesday')); }
                    if ($dr == '3') { $d = ucfirst(get_lang($lang, 'Wednesday')); }
                    if ($dr == '4') { $d = ucfirst(get_lang($lang, 'Thursday')); }
                    if ($dr == '5') { $d = ucfirst(get_lang($lang, 'Friday')); }
                    if ($dr == '6') { $d = ucfirst(get_lang($lang, 'Saturday')); }
                    if ($dr == '7') { $d = ucfirst(get_lang($lang, 'Sunday')); }
                    echo $d .' ('.$dr.')';
                ?>
                </td>
                <td>
                <?php setup_lv(); ?>
                </td>
			</tr>
        </tbody>
	</table>
	<div class='footer'>
	<?php
	if ($user_settings['level'] < 3) {
		echo "
		<span class=\"fl label label-important\">". get_lang($lang, 'ad136').": 3</span>
        <button type='submit' name='submit' value='submit' class='btn btn-default' disabled='disabled' disabled>
		    <i class='fa fa-gavel'></i>&nbsp; ".get_lang($lang, 'inter94')."</button>
		";
	} else {
		echo "
		<span class=\"fl label label-success\">". get_lang($lang, 'ad136').": 3</span>
        <button type='submit' name='submit' value='submit' class='btn btn-default'>
		    <i class='fa fa-gavel'></i>&nbsp; ".get_lang($lang, 'inter94')."</button>
		";
	}
	?>
	</div>
    </form>
                        </div>
                    </div>	
					
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-gavel fa-1x"></i><span><?php echo get_lang($lang, 'Controls'); ?></span>
                        </div>
                        <div class="block">
						    <div class="controls" style="display: block;">
	<?php
	if ($user_settings['level'] < 3) {
		echo "
        <button class=\"btn btn-danger\" onClick=\"document.location.href = 'controller_setup.php?lang=".$lang."&line=".$line."&inv=".$inv.'&sys='.$sys."&id=".$id."&command=DR'; return false;\" disabled=\"disabled\" disabled>
		<i class=\"fa fa-warning\"></i>&nbsp; ".get_lang($lang, 'inter90')."</button>
		<button class=\"btn btn-default\" onClick=\"document.location.href = 'controller_setup.php?lang=".$lang."&line=".$line."&inv=".$inv.'&sys='.$sys."&id=".$id."&command=AP'; return false;\" disabled=\"disabled\" disabled>
		<i class=\"fa fa-retweet\"></i>&nbsp; ".get_lang($lang, 'inter91')."</button>
		<button class=\"btn btn-default\" onClick=\"document.location.href = 'controller_setup.php?lang=".$lang."&line=".$line."&inv=".$inv.'&sys='.$sys."&id=".$id."'; return false;\">
		<i class=\"fa fa-refresh\"></i>&nbsp; ".get_lang($lang, 'inter89')."</button>
		<span class=\"label label-important\">". get_lang($lang, 'ad136').": 3</span>
		";
	} else {
		echo "
        <button class=\"btn btn-danger\" onClick=\"document.location.href = 'controller_setup.php?lang=".$lang."&line=".$line."&inv=".$inv.'&sys='.$sys."&id=".$id."&command=DR'; return false;\">
		<i class=\"fa fa-warning\"></i>&nbsp; ".get_lang($lang, 'inter90')."</button>
		<button class=\"btn btn-warning\" onClick=\"document.location.href = 'controller_setup.php?lang=".$lang."&line=".$line."&inv=".$inv.'&sys='.$sys."&id=".$id."&command=AP'; return false;\">
		<i class=\"fa fa-retweet\"></i>&nbsp; ".get_lang($lang, 'inter91')."</button>
		<button class=\"btn btn-default\" onClick=\"document.location.href = 'controller_setup.php?lang=".$lang."&line=".$line."&inv=".$inv.'&sys='.$sys."&id=".$id."'; return false;\">
		<i class=\"fa fa-refresh\"></i>&nbsp; ".get_lang($lang, 'inter89')."</button>
		<span class=\"label label-success\">". get_lang($lang, 'ad136').": 3</span>
		";
	}
	?>
	                        </div>
                        </div>
						
                        <div class="dr"><span></span></div>
                        <div class="head clearfix">
                            <i class="fa fa-arrow-right fa-1x"></i><span><?php echo get_lang($lang, 'ad74'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php quick_switch($lang,$line,$id,$inv,$sys); ?>
                        </div>
                    </div>	
		
                </div>
				
                <div class="dr"><span></span></div>

                <div class="row-fluid">
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
						<div class="dr"><span></span></div>
                        <div class="head clearfix">
                            <i class="fa fa-random fa-1x"></i><span><?php echo get_lang($lang, 'inter105'); ?> \ <?php echo get_lang($lang, 'td8'); ?></span>
                        </div>
                        <div class="block-fluid">
						<?php setup_stp(); ?>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?lang='.$lang.'&line='.$line.'&inv='.$inv.'&sys='.$sys.'&id='.$id.'&command=BY'; ?>" method="post">
<table cellpadding='0' cellspacing='0' class='table' width="100%">
		<tbody>
<tr>
<td class="tar"><div class="setup"><?php echo get_lang($lang, 'td8'); ?> (<?php echo get_lang($lang, 'inter23'); ?>)</div></td>
<td><div class="setup"><input id="stp1" type="text" class="input-m30nm stp" MAXLENGTH="2" name="heat" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup"><?php echo get_lang($lang, 'inter105'); ?> <?php echo get_lang($lang, 'inter106'); ?></div></td>
<td>
<div class="setup">
<?php setup_stb(); ?>
</div>
</td>
</tr>
<tr>
<td class="tar"><div class="setup">T1 STBY (<?php echo get_lang($lang, 'inter23'); ?>):</div></td>
<td><div class="setup"><input id="stp2" type="text" class="input-m30nm stp" MAXLENGTH="2" name="stb1" class="s36" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup">T2 STBY (<?php echo get_lang($lang, 'inter23'); ?>):</div></td>
<td><div class="setup"><input id="stp3" type="text" class="input-m30nm stp" MAXLENGTH="2" name="stb2" class="s36" value=""/></div></td>
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
						<div class="dr"><span></span></div>
                        <div class="head clearfix">
                            <i class="fa fa-exchange fa-1x"></i><span><?php echo get_lang($lang, 'inter107'); ?></span>
                        </div>
                        <div class="block-fluid">
<form action="<?php echo $_SERVER['PHP_SELF'] . '?lang='.$lang.'&line='.$line.'&inv='.$inv.'&sys='.$sys.'&id='.$id.'&command=Server'; ?>" method="post">
<table cellpadding='0' cellspacing='0' class='table' width="100%">
		<tbody>
<tr>
<td>
<div class="setup">
<label class="checkbox inline">
	<?php
	if ($user_settings['level'] < 50) {
		echo "<input id=\"radio1\" type=\"radio\" name=\"com\" value=\"cmd mi ".$id."\" disabled=\"disabled\" disabled /> ".get_lang($lang, 'inter109');
		echo "<p class='fr label label-important'>". get_lang($lang, 'ad136').": 50</p>";
	} else {
		echo "<input id=\"radio1\" type=\"radio\" name=\"com\" value=\"cmd mi ".$id."\"/> ".get_lang($lang, 'inter109');
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<p class='fr label label-success'>". get_lang($lang, 'ad136').": 50</p>";
	}
	?>
</label>
</div>			
</td>
</tr>
<tr>
<td>
<div class="setup">
<label class="checkbox inline">
<input id="radio2" type="radio" name="com" value="cmd sort"/> <?php echo get_lang($lang, 'inter110'); ?>
</label>
</div>
</td>
</tr>
<tr>
<td>
<div class="setup">
<label class="checkbox inline">
<input id="radio3" type="radio" name="com" value="cmd table"/> <?php echo get_lang($lang, 'inter111'); ?>
</label>
</div>
</td>
</tr>
<tr>
<td>
<div class="setup">
<label class="checkbox inline">
<input id="radio4" type="radio" name="com" value="zita -1"/> <?php echo get_lang($lang, 'inter112'); ?>
</label>
</div>
</td>
</tr>
<tr>
<td>
<div class="setup">
<label class="checkbox inline">
<input id="radio5" type="radio" name="com" value="zita -c"/> <?php echo get_lang($lang, 'inter113'); ?>
</label>
</div>
</td>
</tr>
<tr>
<td>
<div class="setup">
<label class="checkbox inline">
<input id="radio6" type="radio" name="com" value="cmd cordi"/> <?php echo get_lang($lang, 'inter114'); ?>
</label>
</div>
</td>
</tr>
</tbody>
</table>
	<div class='footer'>
	<?php
	if ($user_settings['level'] < 10) {
		echo "
		<span class='fl label label-important'>". get_lang($lang, 'ad136').": 10</span>
        <button type='submit' name='submit' value='submit' class='btn btn-default' disabled='disabled' disabled>
		    <i class='fa fa-legal'></i>&nbsp; ".get_lang($lang, 'inter94')."</button>
		";
	} else {
		echo "
		<span class='fl label label-success'>". get_lang($lang, 'ad136').": 10</span>
        <button type='submit' name='submit' value='submit' class='btn btn-warning'>
		    <i class='fa fa-legal'></i>&nbsp; ".get_lang($lang, 'inter94')."</button>
		";
	}
	?>
	</div>
</form>
                        </div>
                    </div>	

                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'inter98'); ?></span>
                        </div>
                        <div class="block-fluid">
						<?php setup_numbers(); ?>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?lang='.$lang.'&line='.$line.'&inv='.$inv.'&sys='.$sys.'&id='.$id.'&command=SN'; ?>" method="post">
<table cellpadding='0' cellspacing='0' class='table' width="100%">
		<tbody>
            <tr>
<td class="tar">
<div class="setup">
<?php echo get_lang($lang, 'td4'); ?>:
</div>
</td>
<td>
<div class="setup">
<input id="nu1" type="text" MAXLENGTH="2" name="inv3" class="input-m30nm numb" value=""/>
<input id="nu2" type="text" MAXLENGTH="2" name="inv2" class="input-m30nm numb" value=""/>
<input id="nu3" type="text" MAXLENGTH="2" name="inv1" class="input-m30nm numb" value=""/>
</div>
</td>
</tr>
<tr>
<td class="tar">
<div class="setup">
<?php echo get_lang($lang, 'inter99'); ?>:
</div>
</td>
<td>
<div class="setup">
<input id="nu4" type="text" MAXLENGTH="2" name="mrk3" class="input-m30nm numb" value="<?php echo $mrk3; ?>"/>
<input id="nu5" type="text" MAXLENGTH="2" name="mrk2" class="input-m30nm numb" value="<?php echo $mrk2; ?>"/>
<input id="nu6" type="text" MAXLENGTH="2" name="mrk1" class="input-m30nm numb" value="<?php echo $mrk1; ?>"/>
</div>
</td>
</tr>
<tr>
<td class="tar">
<div class="setup">
<?php echo get_lang($lang, 'inter100'); ?>:
</div>
</td>
<td>
<div class="setup">
<input id="nu7" type="text" MAXLENGTH="2" name="typ3" class="input-m30nm numb" value="<?php echo $typ3; ?>"/>
<input id="nu8" type="text" MAXLENGTH="2" name="typ2" class="input-m30nm numb" value="<?php echo $typ2; ?>"/>
<input id="nu9" type="text" MAXLENGTH="2" name="typ1" class="input-m30nm numb" value="<?php echo $typ1; ?>"/>
</div>
</td>
</tr>
<tr>
<td class="tar">
<div class="setup">
<?php echo get_lang($lang, 'inter101'); ?>:
</div>
</td>
<td>
<div class="setup">
<input id="nu10" type="text" MAXLENGTH="2" name="usr3" class="input-m30nm numb" value="<?php echo $usr3; ?>"/>
<input id="nu11" type="text" MAXLENGTH="2" name="usr2" class="input-m30nm numb" value="<?php echo $usr2; ?>"/>
<input id="nu12" type="text" MAXLENGTH="2" name="usr1" class="input-m30nm numb" value="<?php echo $usr1; ?>"/>
</div>
</td>
</tr>
<tr>
<td class="tar">
<div class="setup">
<?php echo get_lang($lang, 'inter102'); ?>:
</div>
</td>
<td>
<div class="setup">
<input id="nu13" type="text" MAXLENGTH="2" name="plc3" class="input-m30nm numb" value="<?php echo $plc3; ?>"/>
<input id="nu14" type="text" MAXLENGTH="2" name="plc2" class="input-m30nm numb" value="<?php echo $plc2; ?>"/>
<input id="nu15" type="text" MAXLENGTH="2" name="plc1" class="input-m30nm numb" value="<?php echo $plc1; ?>"/>
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
						<div class="dr"><span></span></div>
                        <div class="head clearfix">
                            <i class="fa fa-fire fa-1x"></i><span><?php echo get_lang($lang, 'inter103'); ?></span>
                        </div>
                        <div class="block-fluid">
						<?php setup_tempx(); ?>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?lang='.$lang.'&line='.$line.'&inv='.$inv.'&sys='.$sys.'&id='.$id.'&command=PT'; ?>" method="post">
<table cellpadding='0' cellspacing='0' class='table' width="100%">
		<tbody>
<tr>
<td class="tar"><div class="setup">TR1:</div></td>
<td><div class="setup"><input id="te1" class="input-m36nm tempx" MAXLENGTH="3" type="text" name="treg1" title="treg1" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup">TR2:</div></td>
<td><div class="setup"><input id="te2" class="input-m36nm tempx" MAXLENGTH="3" type="text" name="treg2" title="treg2" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup">TR3:</div></td>
<td><div class="setup"><input id="te3" class="input-m36nm tempx" MAXLENGTH="3" type="text" name="treg3" title="treg3" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup">TR4:</div></td>
<td><div class="setup"><input id="te4" class="input-m36nm tempx" MAXLENGTH="3" type="text" name="treg4" title="treg4" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup">TR5:</div></td>
<td><div class="setup"><input id="te5" class="input-m36nm tempx" MAXLENGTH="3" type="text" name="treg5" title="treg5" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup">TR6:</div></td>
<td><div class="setup"><input id="te6" class="input-m36nm tempx" MAXLENGTH="3" type="text" name="treg6" title="treg6" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup"><?php echo get_lang($lang, 'td17'); ?>:</div></td>
<td><div class="setup"><input id="te7" class="input-m36nm tempx" MAXLENGTH="2" type="text" name="tmde" title="tmde" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup"><?php echo get_lang($lang, 'td15'); ?>:</div></td>
<td><div class="setup"><input id="te8" class="input-m36nm tempx" MAXLENGTH="2" type="text" name="t_is" title="t_is" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup"><?php echo get_lang($lang, 'td16'); ?>:</div></td>
<td><div class="setup"><input id="te9" class="input-m36nm tempx" MAXLENGTH="3" type="text" name="t_ok" title="t_ok" value=""/></div></td>
</tr>
<tr>
<td class="tar"><div class="setup"><?php echo get_lang($lang, 'inter104'); ?>:</div></td>
<td><div class="setup"><input id="te10" class="input-m36nm tempx" MAXLENGTH="3" type="text" name="tkon" title="tkon" value=""/></div></td>
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
                        <div class="dr"><span></span></div>
                        <div class="head clearfix">
                            <i class="fa fa-terminal fa-1x"></i><span><?php echo get_lang($lang, 'Console'); ?></span>
                        </div>
                        <div class="block">
						    <div class="w98">
                    <?php
						sys_console($lang,'inter81');
					    if(!($sc == NULL) && ($command != 'Server')) {
							echo "<span>".$time_f." </span>";
						    echo "<span class='text-info'><i class='fa fa-angle-right'></i> " .$command . " " . $id . "</span><br/>";
						}
					    elseif(!($sc == NULL) && ($command == 'Server') && ($com == 'zita -c')) {
							echo "<span>".$time_f." </span>";
						    echo "<span class='text-info'><i class='fa fa-angle-right'></i> " .$command . " " . $com . "</span><br/>";
							error_console($lang,'1004');
							clear_cron();
						}
					    elseif(!($sc == NULL) && ($command == 'Server') && ($com == 'zita -1')) {
							echo "<span>".$time_f." </span>";
						    echo "<span class='text-info'><i class='fa fa-angle-right'></i> " .$command . " " . $com . "</span><br/>";
							read_parameters($socket_ip,$socket_port,$id);
						}
                        if(!($sc == NULL)) { 
						    echo "<span>".$time_f." </span>";
							echo "<span class='text-success'><i class='fa fa-angle-left'></i> " . $sc->recv() . "</span>";
							if ($command != 'Server') {
								read_parameters($socket_ip,$socket_port,$id);
							}
						}
                    ?>
							</div>
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