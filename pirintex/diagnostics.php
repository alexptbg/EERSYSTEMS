<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
include('includes/diagnostics_functions.php');
$line = mysql_prep($_GET['line']);
$filter = mysql_prep($_GET['filter']);
if ($filter == "") { $filter = '4'; }
$page = htmlentities($_SERVER['PHP_SELF'])."?lang=".$lang."&line=".$line;
get_line_options($line);
$ala = $line_options['alarm'];
$red = $line_options['red']+5;
$ex_red = $line_options['ex_red'];
$ex_red = explode(',', $ex_red);
$ex_alarm = $line_options['ex_alarm'];
$ex_alarm = explode(',', $ex_alarm);
$ex_table = $line_options['ex_table'];
$ex_table = explode(',', $ex_table);
$datafile = "data/{$line_options['data_file']}";
if ($datafile == NULL) { get_error($lang,'1002'); exit; }
if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
include("$datafile");
if (filesize($datafile)<100) { get_error($lang,'1004'); exit; }
$kline = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?=$f?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <link rel='stylesheet' type='text/css' href='css/fullcalendar.print.css' media='print' />
    <script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
    <script type='text/javascript' src='js/jquery-ui.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery.mousewheel.min.js'></script>
    <script type='text/javascript' src='js/plugins/cookie/jquery.cookies.2.2.0.min.js'></script>
    <script type='text/javascript' src='js/plugins/bootstrap.min.js'></script>
    <script type='text/javascript' src='js/plugins/fullcalendar/fullcalendar.min.js'></script>
    <script type='text/javascript' src='js/plugins/select2/select2.min.js'></script>
    <script type='text/javascript' src='js/plugins/uniform/uniform.js'></script>
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    <script type='text/javascript' src='js/plugins/validation/languages/jquery.validationEngine-<?=$lang?>.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/jquery.validationEngine.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js'></script>
    <script type='text/javascript' src='js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js'></script>
    <script type='text/javascript' src='js/plugins/cleditor/jquery.cleditor.js'></script>
    <script type='text/javascript' src='js/plugins/dataTables/jquery.dataTables.min.js'></script>    
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js'></script>
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
	<script type='text/javascript' src='js/lang.js'></script>
	<script type='text/javascript' src='js/alex.js'></script>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
	<?php include('includes/style.php'); ?>
        <div class="header">
            <a class="logo" href="index.php?lang=<?=$lang?>">
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
                    <span>&nbsp;</span>                
				</div>
            </div>
            <div class="logox">
                <img src="logo.php" />
            </div>
            <div class="admin">
                <?php echo get_lang($lang, 'Welcome'); ?>
            </div>

            <ul class="navigation">            
                <li>
                    <a href="index.php">
                        <span class="isw-grid"></span><span class="text"><?php echo get_lang($lang, 'home'); ?></span>
                    </a>
                </li>
                <?php get_lines($lang,$line); ?>
                <li>
                    <a href="egi.php?lang=<?=$lang?>" class="ttRC" title="<?php echo get_lang($lang, 'egi01'); ?>">
                        <span class="isw-archive"></span><span class="text"><?php echo get_lang($lang, 'egi'); ?></span>                 
                    </a>
                </li> 
				<li class="openable">
                    <a href="#">
                        <span class="isw-calendar"></span><span class="text"><?php echo get_lang($lang, 'ad28'); ?></span>
                    </a>
                    <ul> <?php get_controllers_for_edit($lang,$line); ?></ul>
				</li>
				<?php get_klines($lang,$kline); ?>
				<li class="openable active">
                    <a href="#">
                        <span class="isw-documents"></span><span class="text"><?php echo get_lang($lang, 'Diagnostics'); ?></span>
                    </a>
                    <ul>
                    <?php get_diagnostics($lang,$line); ?>
				    </ul>
				</li>
                <li>
                    <a href="repairs.php?lang=<?=$lang?>">
                        <span class="isw-ok"></span><span class="text"><?php echo get_lang($lang,'ad457'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="klima.php?lang=<?=$lang?>">
                        <span class="isw-calc"></span><span class="text"><?php echo get_lang($lang, 'ad275'); ?></span>                 
                    </a>
                </li> 	
                <li>
                    <a href="reports.php?lang=<?=$lang?>">
                        <span class="isw-text_document"></span><span class="text"><?php echo get_lang($lang, 'ad177'); ?></span>                 
                    </a>
                </li>                                                
                <li>
                    <a href="server.php?lang=<?=$lang?>">
                        <span class="isw-target"></span><span class="text"><?php echo get_lang($lang, 'inter06'); ?></span>                 
                    </a>
                </li>                                                        
                <li>
                    <a href="utils.php?lang=<?=$lang?>">
                        <span class="isw-favorite"></span><span class="text"><?php echo get_lang($lang, 'inter50'); ?></span>                 
                    </a>
                </li>   
                <li>
                    <a href="faq.php?lang=<?=$lang?>">
                        <span class="isw-tag"></span><span class="text"><?php echo get_lang($lang, 'FAQ'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="demo.php?lang=<?=$lang?>">
                        <span class="isw-bookmark"></span><span class="text"><?php echo get_lang($lang, 'ad237'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="contact.php?lang=<?=$lang?>">
                        <span class="isw-mail"></span><span class="text"><?php echo get_lang($lang, 'ad238'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="admin/admin.php?lang=<?=$lang?>">
                        <span class="isw-settings"></span><span class="text"><?php echo get_lang($lang, 'inter61'); ?></span>                 
                    </a>
                </li>                        
            </ul>
            <div class="qrcode">
                <img src="qrcode.php" />
            </div>
            <div class="widget">
                <div class="w95 pb20 pt20">
				    <?php cron_side($lang,'10'); ?>
				</div>
            </div>
        </div>

        <div class="content">
            <div class="breadLine">
                <ul class="breadcrumb">
                    <li><?=$site_name?></li>                
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
                            <i class="fa fa-warning fa-1x"></i><span><?php echo get_lang($lang, 'Diagnostics'); ?> \ <?=$line?></span>
                        </div>
                        <div class="block">
	<?php				

    if ($filter == '3') {
		$n = get_lang($lang, 'diag04');
        echo "<a href='".$page."&filter=3' class='btn btn-large btn-primary'>".get_lang($lang, 'diag04')."</a>\n";
    } else {
	    echo "<a href='".$page."&filter=3' class='btn btn-large btn-default'>".get_lang($lang, 'diag04')."</a>\n";
    }
    if ($filter == '4') {
		$n = get_lang($lang, 'diag05');
        echo "<a href='".$page."&filter=4' class='btn btn-large btn-primary'>".get_lang($lang, 'diag05')."</a>\n";
    } else {
	    echo "<a href='".$page."&filter=4' class='btn btn-large btn-default'>".get_lang($lang, 'diag05')."</a>\n";
    }
    if ($filter == '5') {
		$n = get_lang($lang, 'diag06');
        echo "<a href='".$page."&filter=5' class='btn btn-large btn-primary'>".get_lang($lang, 'diag06')."</a>\n";
    } else {
	    echo "<a href='".$page."&filter=5' class='btn btn-large btn-default'>".get_lang($lang, 'diag06')."</a>\n";
    }
    if ($filter == '6') {
		$n = get_lang($lang, 'diag07');
        echo "<a href='".$page."&filter=6' class='btn btn-large btn-primary'>".get_lang($lang, 'diag07')."</a>\n";
    } else {
	    echo "<a href='".$page."&filter=6' class='btn btn-large btn-default'>".get_lang($lang, 'diag07')."</a>\n";
    }
    if ($filter == '7') {
		$n = get_lang($lang, 'diag08');
        echo "<a href='".$page."&filter=7' class='btn btn-large btn-primary'>".get_lang($lang, 'diag08')."</a>\n";
    } else {
	    echo "<a href='".$page."&filter=7' class='btn btn-large btn-default'>".get_lang($lang, 'diag08')."</a>\n";
    }
    if ($filter == '8') {
		$n = get_lang($lang, 'diag09');
        echo "<a href='".$page."&filter=8' class='btn btn-large btn-primary'>".get_lang($lang, 'diag09')."</a>\n";
    } else {
	    echo "<a href='".$page."&filter=8' class='btn btn-large btn-default'>".get_lang($lang, 'diag09')."</a>\n";
    }
    if ($filter == '10') {
		$n = get_lang($lang, 'diag10');
        echo "<a href='".$page."&filter=10' class='btn btn-large btn-primary'>".get_lang($lang, 'diag10')."</a>\n";
    } else {
	    echo "<a href='".$page."&filter=10' class='btn btn-large btn-default'>".get_lang($lang, 'diag10')."</a>\n";
    }
    if ($filter == '1') {
		$n = get_lang($lang, 'diag01');
        echo "<a href='".$page."&filter=1' class='btn btn-large btn-primary'>".get_lang($lang, 'diag01')."</a>\n";
    } else {
	    echo "<a href='".$page."&filter=1' class='btn btn-large btn-default'>".get_lang($lang, 'diag01')."</a>\n";
    }
    if ($filter == '9') {
		$n = get_lang($lang, 'diag02');
        echo "<a href='".$page."&filter=9' class='btn btn-large btn-primary'>".get_lang($lang, 'diag02')."</a>\n";
    } else {
	    echo "<a href='".$page."&filter=9' class='btn btn-large btn-default'>".get_lang($lang, 'diag02')."</a>\n";
    }
    if ($filter == '2') {
		$n = get_lang($lang, 'diag03');
        echo "<a href='".$page."&filter=2' class='btn btn-large btn-primary'>".get_lang($lang, 'diag03')."</a>\n";
    } else {
	    echo "<a href='".$page."&filter=2' class='btn btn-large btn-default'>".get_lang($lang, 'diag03')."</a>\n";
    }
	?>
                        </div>
                    </div>                
                </div> 

                <div class="dr"><span></span></div>
				
                <div class="row-fluid">
                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-warning fa-1x"></i><span><?=$line?> \ <?=$n?></span>
                        </div>
                        <div class="block">
				<?php
			    if ($filter == '1') {
				  drawoffth($lang,$line,$site_theme);
				  if(!($dev0 == NULL)) { $i='d'; off($dev0,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev1 == NULL)) { $i='l'; off($dev1,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev2 == NULL)) { $i='d'; off($dev2,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev3 == NULL)) { $i='l'; off($dev3,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev4 == NULL)) { $i='d'; off($dev4,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev5 == NULL)) { $i='l'; off($dev5,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev6 == NULL)) { $i='d'; off($dev6,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev7 == NULL)) { $i='l'; off($dev7,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev8 == NULL)) { $i='d'; off($dev8,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev9 == NULL)) { $i='l'; off($dev9,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev10 == NULL)) { $i='d'; off($dev10,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev11 == NULL)) { $i='l'; off($dev11,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev12 == NULL)) { $i='d'; off($dev12,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev13 == NULL)) { $i='l'; off($dev13,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev14 == NULL)) { $i='d'; off($dev14,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev15 == NULL)) { $i='l'; off($dev15,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev16 == NULL)) { $i='d'; off($dev16,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev17 == NULL)) { $i='l'; off($dev17,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev18 == NULL)) { $i='d'; off($dev18,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev19 == NULL)) { $i='l'; off($dev19,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev20 == NULL)) { $i='d'; off($dev20,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev21 == NULL)) { $i='l'; off($dev21,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev22 == NULL)) { $i='d'; off($dev22,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev23 == NULL)) { $i='l'; off($dev23,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev24 == NULL)) { $i='d'; off($dev24,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev25 == NULL)) { $i='l'; off($dev25,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev26 == NULL)) { $i='d'; off($dev26,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev27 == NULL)) { $i='l'; off($dev27,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev28 == NULL)) { $i='d'; off($dev28,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev29 == NULL)) { $i='l'; off($dev29,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev30 == NULL)) { $i='d'; off($dev30,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev31 == NULL)) { $i='l'; off($dev31,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev32 == NULL)) { $i='d'; off($dev32,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev33 == NULL)) { $i='l'; off($dev33,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev34 == NULL)) { $i='d'; off($dev34,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev35 == NULL)) { $i='l'; off($dev35,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev36 == NULL)) { $i='d'; off($dev36,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev37 == NULL)) { $i='l'; off($dev37,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev38 == NULL)) { $i='d'; off($dev38,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev39 == NULL)) { $i='l'; off($dev39,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev40 == NULL)) { $i='d'; off($dev40,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev41 == NULL)) { $i='l'; off($dev41,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev42 == NULL)) { $i='d'; off($dev42,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev43 == NULL)) { $i='l'; off($dev43,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev44 == NULL)) { $i='d'; off($dev44,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev45 == NULL)) { $i='l'; off($dev45,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev46 == NULL)) { $i='d'; off($dev46,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev47 == NULL)) { $i='l'; off($dev47,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev48 == NULL)) { $i='d'; off($dev48,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev49 == NULL)) { $i='l'; off($dev49,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev50 == NULL)) { $i='d'; off($dev50,$line,$lang,$i,$red,$ex_red); }
				  drawtend();
				}
				if ($filter == '2') {
				    drawoffth($lang,$line,$site_theme);
					if(!($dev0 == NULL)) { $i='d'; lt($dev0,$line,$lang,$i,$red,$ex_red); }
					if(!($dev1 == NULL)) { $i='l'; lt($dev1,$line,$lang,$i,$red,$ex_red); }
					if(!($dev2 == NULL)) { $i='d'; lt($dev2,$line,$lang,$i,$red,$ex_red); }
					if(!($dev3 == NULL)) { $i='l'; lt($dev3,$line,$lang,$i,$red,$ex_red); }
					if(!($dev4 == NULL)) { $i='d'; lt($dev4,$line,$lang,$i,$red,$ex_red); }
					if(!($dev5 == NULL)) { $i='l'; lt($dev5,$line,$lang,$i,$red,$ex_red); }
					if(!($dev6 == NULL)) { $i='d'; lt($dev6,$line,$lang,$i,$red,$ex_red); }
					if(!($dev7 == NULL)) { $i='l'; lt($dev7,$line,$lang,$i,$red,$ex_red); }
					if(!($dev8 == NULL)) { $i='d'; lt($dev8,$line,$lang,$i,$red,$ex_red); }
					if(!($dev9 == NULL)) { $i='l'; lt($dev9,$line,$lang,$i,$red,$ex_red); }
					if(!($dev10 == NULL)) { $i='d'; lt($dev10,$line,$lang,$i,$red,$ex_red); }
					if(!($dev11 == NULL)) { $i='l'; lt($dev11,$line,$lang,$i,$red,$ex_red); }
					if(!($dev12 == NULL)) { $i='d'; lt($dev12,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev13 == NULL)) { $i='l'; lt($dev13,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev14 == NULL)) { $i='d'; lt($dev14,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev15 == NULL)) { $i='l'; lt($dev15,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev16 == NULL)) { $i='d'; lt($dev16,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev17 == NULL)) { $i='l'; lt($dev17,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev18 == NULL)) { $i='d'; lt($dev18,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev19 == NULL)) { $i='l'; lt($dev19,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev20 == NULL)) { $i='d'; lt($dev20,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev21 == NULL)) { $i='l'; lt($dev21,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev22 == NULL)) { $i='d'; lt($dev22,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev23 == NULL)) { $i='l'; lt($dev23,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev24 == NULL)) { $i='d'; lt($dev24,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev25 == NULL)) { $i='l'; lt($dev25,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev26 == NULL)) { $i='d'; lt($dev26,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev27 == NULL)) { $i='l'; lt($dev27,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev28 == NULL)) { $i='d'; lt($dev28,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev29 == NULL)) { $i='l'; lt($dev29,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev30 == NULL)) { $i='d'; lt($dev30,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev31 == NULL)) { $i='l'; lt($dev31,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev32 == NULL)) { $i='d'; lt($dev32,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev33 == NULL)) { $i='l'; lt($dev33,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev34 == NULL)) { $i='d'; lt($dev34,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev35 == NULL)) { $i='l'; lt($dev35,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev36 == NULL)) { $i='d'; lt($dev36,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev37 == NULL)) { $i='l'; lt($dev37,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev38 == NULL)) { $i='d'; lt($dev38,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev39 == NULL)) { $i='l'; lt($dev39,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev40 == NULL)) { $i='d'; lt($dev40,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev41 == NULL)) { $i='l'; lt($dev41,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev42 == NULL)) { $i='d'; lt($dev42,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev43 == NULL)) { $i='l'; lt($dev43,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev44 == NULL)) { $i='d'; lt($dev44,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev45 == NULL)) { $i='l'; lt($dev45,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev46 == NULL)) { $i='d'; lt($dev46,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev47 == NULL)) { $i='l'; lt($dev47,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev48 == NULL)) { $i='d'; lt($dev48,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev49 == NULL)) { $i='l'; lt($dev49,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev50 == NULL)) { $i='d'; lt($dev50,$line,$lang,$i,$red,$ex_red); }
					drawtend();
				}
				if ($filter == '3') {
				    drawoffth($lang,$line,$site_theme);
					if(!($dev0 == NULL)) { $i='d'; mode0($dev0,$line,$lang,$i,$red,$ex_red); }
					if(!($dev1 == NULL)) { $i='l'; mode0($dev1,$line,$lang,$i,$red,$ex_red); }
					if(!($dev2 == NULL)) { $i='d'; mode0($dev2,$line,$lang,$i,$red,$ex_red); }
					if(!($dev3 == NULL)) { $i='l'; mode0($dev3,$line,$lang,$i,$red,$ex_red); }
					if(!($dev4 == NULL)) { $i='d'; mode0($dev4,$line,$lang,$i,$red,$ex_red); }
					if(!($dev5 == NULL)) { $i='l'; mode0($dev5,$line,$lang,$i,$red,$ex_red); }
					if(!($dev6 == NULL)) { $i='d'; mode0($dev6,$line,$lang,$i,$red,$ex_red); }
					if(!($dev7 == NULL)) { $i='l'; mode0($dev7,$line,$lang,$i,$red,$ex_red); }
					if(!($dev8 == NULL)) { $i='d'; mode0($dev8,$line,$lang,$i,$red,$ex_red); }
					if(!($dev9 == NULL)) { $i='l'; mode0($dev9,$line,$lang,$i,$red,$ex_red); }
					if(!($dev10 == NULL)) { $i='d'; mode0($dev10,$line,$lang,$i,$red,$ex_red); }
					if(!($dev11 == NULL)) { $i='l'; mode0($dev11,$line,$lang,$i,$red,$ex_red); }
					if(!($dev12 == NULL)) { $i='d'; mode0($dev12,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev13 == NULL)) { $i='l'; mode0($dev13,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev14 == NULL)) { $i='d'; mode0($dev14,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev15 == NULL)) { $i='l'; mode0($dev15,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev16 == NULL)) { $i='d'; mode0($dev16,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev17 == NULL)) { $i='l'; mode0($dev17,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev18 == NULL)) { $i='d'; mode0($dev18,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev19 == NULL)) { $i='l'; mode0($dev19,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev20 == NULL)) { $i='d'; mode0($dev20,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev21 == NULL)) { $i='l'; mode0($dev21,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev22 == NULL)) { $i='d'; mode0($dev22,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev23 == NULL)) { $i='l'; mode0($dev23,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev24 == NULL)) { $i='d'; mode0($dev24,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev25 == NULL)) { $i='l'; mode0($dev25,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev26 == NULL)) { $i='d'; mode0($dev26,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev27 == NULL)) { $i='l'; mode0($dev27,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev28 == NULL)) { $i='d'; mode0($dev28,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev29 == NULL)) { $i='l'; mode0($dev29,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev30 == NULL)) { $i='d'; mode0($dev30,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev31 == NULL)) { $i='l'; mode0($dev31,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev32 == NULL)) { $i='d'; mode0($dev32,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev33 == NULL)) { $i='l'; mode0($dev33,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev34 == NULL)) { $i='d'; mode0($dev34,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev35 == NULL)) { $i='l'; mode0($dev35,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev36 == NULL)) { $i='d'; mode0($dev36,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev37 == NULL)) { $i='l'; mode0($dev37,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev38 == NULL)) { $i='d'; mode0($dev38,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev39 == NULL)) { $i='l'; mode0($dev39,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev40 == NULL)) { $i='d'; mode0($dev40,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev41 == NULL)) { $i='l'; mode0($dev41,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev42 == NULL)) { $i='d'; mode0($dev42,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev43 == NULL)) { $i='l'; mode0($dev43,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev44 == NULL)) { $i='d'; mode0($dev44,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev45 == NULL)) { $i='l'; mode0($dev45,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev46 == NULL)) { $i='d'; mode0($dev46,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev47 == NULL)) { $i='l'; mode0($dev47,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev48 == NULL)) { $i='d'; mode0($dev48,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev49 == NULL)) { $i='l'; mode0($dev49,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev50 == NULL)) { $i='d'; mode0($dev50,$line,$lang,$i,$red,$ex_red); }
					drawtend();
				}
				if ($filter == '4') {
				    drawoffth($lang,$line,$site_theme);
					if(!($dev0 == NULL)) { $i='d'; ht($dev0,$line,$lang,$i,$red,$ex_red); }
					if(!($dev1 == NULL)) { $i='l'; ht($dev1,$line,$lang,$i,$red,$ex_red); }
					if(!($dev2 == NULL)) { $i='d'; ht($dev2,$line,$lang,$i,$red,$ex_red); }
					if(!($dev3 == NULL)) { $i='l'; ht($dev3,$line,$lang,$i,$red,$ex_red); }
					if(!($dev4 == NULL)) { $i='d'; ht($dev4,$line,$lang,$i,$red,$ex_red); }
					if(!($dev5 == NULL)) { $i='l'; ht($dev5,$line,$lang,$i,$red,$ex_red); }
					if(!($dev6 == NULL)) { $i='d'; ht($dev6,$line,$lang,$i,$red,$ex_red); }
					if(!($dev7 == NULL)) { $i='l'; ht($dev7,$line,$lang,$i,$red,$ex_red); }
					if(!($dev8 == NULL)) { $i='d'; ht($dev8,$line,$lang,$i,$red,$ex_red); }
					if(!($dev9 == NULL)) { $i='l'; ht($dev9,$line,$lang,$i,$red,$ex_red); }
					if(!($dev10 == NULL)) { $i='d'; ht($dev10,$line,$lang,$i,$red,$ex_red); }
					if(!($dev11 == NULL)) { $i='l'; ht($dev11,$line,$lang,$i,$red,$ex_red); }
					if(!($dev12 == NULL)) { $i='d'; ht($dev12,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev13 == NULL)) { $i='l'; ht($dev13,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev14 == NULL)) { $i='d'; ht($dev14,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev15 == NULL)) { $i='l'; ht($dev15,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev16 == NULL)) { $i='d'; ht($dev16,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev17 == NULL)) { $i='l'; ht($dev17,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev18 == NULL)) { $i='d'; ht($dev18,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev19 == NULL)) { $i='l'; ht($dev19,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev20 == NULL)) { $i='d'; ht($dev20,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev21 == NULL)) { $i='l'; ht($dev21,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev22 == NULL)) { $i='d'; ht($dev22,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev23 == NULL)) { $i='l'; ht($dev23,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev24 == NULL)) { $i='d'; ht($dev24,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev25 == NULL)) { $i='l'; ht($dev25,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev26 == NULL)) { $i='d'; ht($dev26,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev27 == NULL)) { $i='l'; ht($dev27,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev28 == NULL)) { $i='d'; ht($dev28,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev29 == NULL)) { $i='l'; ht($dev29,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev30 == NULL)) { $i='d'; ht($dev30,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev31 == NULL)) { $i='l'; ht($dev31,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev32 == NULL)) { $i='d'; ht($dev32,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev33 == NULL)) { $i='l'; ht($dev33,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev34 == NULL)) { $i='d'; ht($dev34,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev35 == NULL)) { $i='l'; ht($dev35,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev36 == NULL)) { $i='d'; ht($dev36,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev37 == NULL)) { $i='l'; ht($dev37,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev38 == NULL)) { $i='d'; ht($dev38,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev39 == NULL)) { $i='l'; ht($dev39,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev40 == NULL)) { $i='d'; ht($dev40,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev41 == NULL)) { $i='l'; ht($dev41,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev42 == NULL)) { $i='d'; ht($dev42,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev43 == NULL)) { $i='l'; ht($dev43,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev44 == NULL)) { $i='d'; ht($dev44,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev45 == NULL)) { $i='l'; ht($dev45,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev46 == NULL)) { $i='d'; ht($dev46,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev47 == NULL)) { $i='l'; ht($dev47,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev48 == NULL)) { $i='d'; ht($dev48,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev49 == NULL)) { $i='l'; ht($dev49,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev50 == NULL)) { $i='d'; ht($dev50,$line,$lang,$i,$red,$ex_red); }
					drawtend();
				}
			    if ($filter == '5') {
				  drawoffth($lang,$line,$site_theme);
				  if(!($dev0 == NULL)) { $i='d'; tkoff($dev0,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev1 == NULL)) { $i='l'; tkoff($dev1,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev2 == NULL)) { $i='d'; tkoff($dev2,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev3 == NULL)) { $i='l'; tkoff($dev3,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev4 == NULL)) { $i='d'; tkoff($dev4,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev5 == NULL)) { $i='l'; tkoff($dev5,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev6 == NULL)) { $i='d'; tkoff($dev6,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev7 == NULL)) { $i='l'; tkoff($dev7,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev8 == NULL)) { $i='d'; tkoff($dev8,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev9 == NULL)) { $i='l'; tkoff($dev9,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev10 == NULL)) { $i='d'; tkoff($dev10,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev11 == NULL)) { $i='l'; tkoff($dev11,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev12 == NULL)) { $i='d'; tkoff($dev12,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev13 == NULL)) { $i='l'; tkoff($dev13,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev14 == NULL)) { $i='d'; tkoff($dev14,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev15 == NULL)) { $i='l'; tkoff($dev15,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev16 == NULL)) { $i='d'; tkoff($dev16,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev17 == NULL)) { $i='l'; tkoff($dev17,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev18 == NULL)) { $i='d'; tkoff($dev18,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev19 == NULL)) { $i='l'; tkoff($dev19,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev20 == NULL)) { $i='d'; tkoff($dev20,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev21 == NULL)) { $i='l'; tkoff($dev21,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev22 == NULL)) { $i='d'; tkoff($dev22,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev23 == NULL)) { $i='l'; tkoff($dev23,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev24 == NULL)) { $i='d'; tkoff($dev24,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev25 == NULL)) { $i='l'; tkoff($dev25,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev26 == NULL)) { $i='d'; tkoff($dev26,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev27 == NULL)) { $i='l'; tkoff($dev27,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev28 == NULL)) { $i='d'; tkoff($dev28,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev29 == NULL)) { $i='l'; tkoff($dev29,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev30 == NULL)) { $i='d'; tkoff($dev30,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev31 == NULL)) { $i='l'; tkoff($dev31,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev32 == NULL)) { $i='d'; tkoff($dev32,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev33 == NULL)) { $i='l'; tkoff($dev33,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev34 == NULL)) { $i='d'; tkoff($dev34,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev35 == NULL)) { $i='l'; tkoff($dev35,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev36 == NULL)) { $i='d'; tkoff($dev36,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev37 == NULL)) { $i='l'; tkoff($dev37,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev38 == NULL)) { $i='d'; tkoff($dev38,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev39 == NULL)) { $i='l'; tkoff($dev39,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev40 == NULL)) { $i='d'; tkoff($dev40,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev41 == NULL)) { $i='l'; tkoff($dev41,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev42 == NULL)) { $i='d'; tkoff($dev42,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev43 == NULL)) { $i='l'; tkoff($dev43,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev44 == NULL)) { $i='d'; tkoff($dev44,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev45 == NULL)) { $i='l'; tkoff($dev45,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev46 == NULL)) { $i='d'; tkoff($dev46,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev47 == NULL)) { $i='l'; tkoff($dev47,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev48 == NULL)) { $i='d'; tkoff($dev48,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev49 == NULL)) { $i='l'; tkoff($dev49,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev50 == NULL)) { $i='d'; tkoff($dev50,$line,$lang,$i,$red,$ex_red); }
				  drawtend();
				}
			    if ($filter == '6') {
				  drawoffth($lang,$line,$site_theme);
				  if(!($dev0 == NULL)) { $i='d'; poff($dev0,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev1 == NULL)) { $i='l'; poff($dev1,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev2 == NULL)) { $i='d'; poff($dev2,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev3 == NULL)) { $i='l'; poff($dev3,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev4 == NULL)) { $i='d'; poff($dev4,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev5 == NULL)) { $i='l'; poff($dev5,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev6 == NULL)) { $i='d'; poff($dev6,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev7 == NULL)) { $i='l'; poff($dev7,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev8 == NULL)) { $i='d'; poff($dev8,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev9 == NULL)) { $i='l'; poff($dev9,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev10 == NULL)) { $i='d'; poff($dev10,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev11 == NULL)) { $i='l'; poff($dev11,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev12 == NULL)) { $i='d'; poff($dev12,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev13 == NULL)) { $i='l'; poff($dev13,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev14 == NULL)) { $i='d'; poff($dev14,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev15 == NULL)) { $i='l'; poff($dev15,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev16 == NULL)) { $i='d'; poff($dev16,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev17 == NULL)) { $i='l'; poff($dev17,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev18 == NULL)) { $i='d'; poff($dev18,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev19 == NULL)) { $i='l'; poff($dev19,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev20 == NULL)) { $i='d'; poff($dev20,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev21 == NULL)) { $i='l'; poff($dev21,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev22 == NULL)) { $i='d'; poff($dev22,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev23 == NULL)) { $i='l'; poff($dev23,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev24 == NULL)) { $i='d'; poff($dev24,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev25 == NULL)) { $i='l'; poff($dev25,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev26 == NULL)) { $i='d'; poff($dev26,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev27 == NULL)) { $i='l'; poff($dev27,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev28 == NULL)) { $i='d'; poff($dev28,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev29 == NULL)) { $i='l'; poff($dev29,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev30 == NULL)) { $i='d'; poff($dev30,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev31 == NULL)) { $i='l'; poff($dev31,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev32 == NULL)) { $i='d'; poff($dev32,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev33 == NULL)) { $i='l'; poff($dev33,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev34 == NULL)) { $i='d'; poff($dev34,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev35 == NULL)) { $i='l'; poff($dev35,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev36 == NULL)) { $i='d'; poff($dev36,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev37 == NULL)) { $i='l'; poff($dev37,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev38 == NULL)) { $i='d'; poff($dev38,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev39 == NULL)) { $i='l'; poff($dev39,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev40 == NULL)) { $i='d'; poff($dev40,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev41 == NULL)) { $i='l'; poff($dev41,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev42 == NULL)) { $i='d'; poff($dev42,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev43 == NULL)) { $i='l'; poff($dev43,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev44 == NULL)) { $i='d'; poff($dev44,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev45 == NULL)) { $i='l'; poff($dev45,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev46 == NULL)) { $i='d'; poff($dev46,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev47 == NULL)) { $i='l'; poff($dev47,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev48 == NULL)) { $i='d'; poff($dev48,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev49 == NULL)) { $i='l'; poff($dev49,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev50 == NULL)) { $i='d'; poff($dev50,$line,$lang,$i,$red,$ex_red); }
				  drawtend();
				}
			    if ($filter == '7') {
				  drawoffth($lang,$line,$site_theme);
				  if(!($dev0 == NULL)) { $i='d'; soff($dev0,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev1 == NULL)) { $i='l'; soff($dev1,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev2 == NULL)) { $i='d'; soff($dev2,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev3 == NULL)) { $i='l'; soff($dev3,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev4 == NULL)) { $i='d'; soff($dev4,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev5 == NULL)) { $i='l'; soff($dev5,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev6 == NULL)) { $i='d'; soff($dev6,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev7 == NULL)) { $i='l'; soff($dev7,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev8 == NULL)) { $i='d'; soff($dev8,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev9 == NULL)) { $i='l'; soff($dev9,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev10 == NULL)) { $i='d'; soff($dev10,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev11 == NULL)) { $i='l'; soff($dev11,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev12 == NULL)) { $i='d'; soff($dev12,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev13 == NULL)) { $i='l'; soff($dev13,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev14 == NULL)) { $i='d'; soff($dev14,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev15 == NULL)) { $i='l'; soff($dev15,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev16 == NULL)) { $i='d'; soff($dev16,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev17 == NULL)) { $i='l'; soff($dev17,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev18 == NULL)) { $i='d'; soff($dev18,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev19 == NULL)) { $i='l'; soff($dev19,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev20 == NULL)) { $i='d'; soff($dev20,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev21 == NULL)) { $i='l'; soff($dev21,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev22 == NULL)) { $i='d'; soff($dev22,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev23 == NULL)) { $i='l'; soff($dev23,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev24 == NULL)) { $i='d'; soff($dev24,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev25 == NULL)) { $i='l'; soff($dev25,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev26 == NULL)) { $i='d'; soff($dev26,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev27 == NULL)) { $i='l'; soff($dev27,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev28 == NULL)) { $i='d'; soff($dev28,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev29 == NULL)) { $i='l'; soff($dev29,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev30 == NULL)) { $i='d'; soff($dev30,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev31 == NULL)) { $i='l'; soff($dev31,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev32 == NULL)) { $i='d'; soff($dev32,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev33 == NULL)) { $i='l'; soff($dev33,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev34 == NULL)) { $i='d'; soff($dev34,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev35 == NULL)) { $i='l'; soff($dev35,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev36 == NULL)) { $i='d'; soff($dev36,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev37 == NULL)) { $i='l'; soff($dev37,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev38 == NULL)) { $i='d'; soff($dev38,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev39 == NULL)) { $i='l'; soff($dev39,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev40 == NULL)) { $i='d'; soff($dev40,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev41 == NULL)) { $i='l'; soff($dev41,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev42 == NULL)) { $i='d'; soff($dev42,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev43 == NULL)) { $i='l'; soff($dev43,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev44 == NULL)) { $i='d'; soff($dev44,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev45 == NULL)) { $i='l'; soff($dev45,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev46 == NULL)) { $i='d'; soff($dev46,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev47 == NULL)) { $i='l'; soff($dev47,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev48 == NULL)) { $i='d'; soff($dev48,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev49 == NULL)) { $i='l'; soff($dev49,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev50 == NULL)) { $i='d'; soff($dev50,$line,$lang,$i,$red,$ex_red); }
				  drawtend();
				}
			    if ($filter == '8') {
				  drawoffth($lang,$line,$site_theme);
				  if(!($dev0 == NULL)) { $i='d'; coff($dev0,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev1 == NULL)) { $i='l'; coff($dev1,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev2 == NULL)) { $i='d'; coff($dev2,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev3 == NULL)) { $i='l'; coff($dev3,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev4 == NULL)) { $i='d'; coff($dev4,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev5 == NULL)) { $i='l'; coff($dev5,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev6 == NULL)) { $i='d'; coff($dev6,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev7 == NULL)) { $i='l'; coff($dev7,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev8 == NULL)) { $i='d'; coff($dev8,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev9 == NULL)) { $i='l'; coff($dev9,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev10 == NULL)) { $i='d'; coff($dev10,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev11 == NULL)) { $i='l'; coff($dev11,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev12 == NULL)) { $i='d'; coff($dev12,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev13 == NULL)) { $i='l'; coff($dev13,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev14 == NULL)) { $i='d'; coff($dev14,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev15 == NULL)) { $i='l'; coff($dev15,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev16 == NULL)) { $i='d'; coff($dev16,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev17 == NULL)) { $i='l'; coff($dev17,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev18 == NULL)) { $i='d'; coff($dev18,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev19 == NULL)) { $i='l'; coff($dev19,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev20 == NULL)) { $i='d'; coff($dev20,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev21 == NULL)) { $i='l'; coff($dev21,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev22 == NULL)) { $i='d'; coff($dev22,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev23 == NULL)) { $i='l'; coff($dev23,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev24 == NULL)) { $i='d'; coff($dev24,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev25 == NULL)) { $i='l'; coff($dev25,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev26 == NULL)) { $i='d'; coff($dev26,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev27 == NULL)) { $i='l'; coff($dev27,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev28 == NULL)) { $i='d'; coff($dev28,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev29 == NULL)) { $i='l'; coff($dev29,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev30 == NULL)) { $i='d'; coff($dev30,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev31 == NULL)) { $i='l'; coff($dev31,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev32 == NULL)) { $i='d'; coff($dev32,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev33 == NULL)) { $i='l'; coff($dev33,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev34 == NULL)) { $i='d'; coff($dev34,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev35 == NULL)) { $i='l'; coff($dev35,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev36 == NULL)) { $i='d'; coff($dev36,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev37 == NULL)) { $i='l'; coff($dev37,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev38 == NULL)) { $i='d'; coff($dev38,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev39 == NULL)) { $i='l'; coff($dev39,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev40 == NULL)) { $i='d'; coff($dev40,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev41 == NULL)) { $i='l'; coff($dev41,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev42 == NULL)) { $i='d'; coff($dev42,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev43 == NULL)) { $i='l'; coff($dev43,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev44 == NULL)) { $i='d'; coff($dev44,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev45 == NULL)) { $i='l'; coff($dev45,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev46 == NULL)) { $i='d'; coff($dev46,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev47 == NULL)) { $i='l'; coff($dev47,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev48 == NULL)) { $i='d'; coff($dev48,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev49 == NULL)) { $i='l'; coff($dev49,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev50 == NULL)) { $i='d'; coff($dev50,$line,$lang,$i,$red,$ex_red); }
				  drawtend();
				}
			    if ($filter == '9') {
				  drawoffth($lang,$line,$site_theme);
				  if(!($dev0 == NULL)) { $i='d'; stb($dev0,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev1 == NULL)) { $i='l'; stb($dev1,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev2 == NULL)) { $i='d'; stb($dev2,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev3 == NULL)) { $i='l'; stb($dev3,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev4 == NULL)) { $i='d'; stb($dev4,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev5 == NULL)) { $i='l'; stb($dev5,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev6 == NULL)) { $i='d'; stb($dev6,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev7 == NULL)) { $i='l'; stb($dev7,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev8 == NULL)) { $i='d'; stb($dev8,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev9 == NULL)) { $i='l'; stb($dev9,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev10 == NULL)) { $i='d'; stb($dev10,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev11 == NULL)) { $i='l'; stb($dev11,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev12 == NULL)) { $i='d'; stb($dev12,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev13 == NULL)) { $i='l'; stb($dev13,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev14 == NULL)) { $i='d'; stb($dev14,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev15 == NULL)) { $i='l'; stb($dev15,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev16 == NULL)) { $i='d'; stb($dev16,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev17 == NULL)) { $i='l'; stb($dev17,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev18 == NULL)) { $i='d'; stb($dev18,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev19 == NULL)) { $i='l'; stb($dev19,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev20 == NULL)) { $i='d'; stb($dev20,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev21 == NULL)) { $i='l'; stb($dev21,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev22 == NULL)) { $i='d'; stb($dev22,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev23 == NULL)) { $i='l'; stb($dev23,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev24 == NULL)) { $i='d'; stb($dev24,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev25 == NULL)) { $i='l'; stb($dev25,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev26 == NULL)) { $i='d'; stb($dev26,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev27 == NULL)) { $i='l'; stb($dev27,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev28 == NULL)) { $i='d'; stb($dev28,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev29 == NULL)) { $i='l'; stb($dev29,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev30 == NULL)) { $i='d'; stb($dev30,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev31 == NULL)) { $i='l'; stb($dev31,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev32 == NULL)) { $i='d'; stb($dev32,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev33 == NULL)) { $i='l'; stb($dev33,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev34 == NULL)) { $i='d'; stb($dev34,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev35 == NULL)) { $i='l'; stb($dev35,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev36 == NULL)) { $i='d'; stb($dev36,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev37 == NULL)) { $i='l'; stb($dev37,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev38 == NULL)) { $i='d'; stb($dev38,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev39 == NULL)) { $i='l'; stb($dev39,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev40 == NULL)) { $i='d'; stb($dev40,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev41 == NULL)) { $i='l'; stb($dev41,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev42 == NULL)) { $i='d'; stb($dev42,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev43 == NULL)) { $i='l'; stb($dev43,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev44 == NULL)) { $i='d'; stb($dev44,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev45 == NULL)) { $i='l'; stb($dev45,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev46 == NULL)) { $i='d'; stb($dev46,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev47 == NULL)) { $i='l'; stb($dev47,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev48 == NULL)) { $i='d'; stb($dev48,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev49 == NULL)) { $i='l'; stb($dev49,$line,$lang,$i,$red,$ex_red); }
				  if(!($dev50 == NULL)) { $i='d'; stb($dev50,$line,$lang,$i,$red,$ex_red); }
				  drawtend();
				}
				if ($filter == '10') {
					echo "<style type='text/css'>span.label.label-important a { color:#FFFFFF; }</style>";
                    $to = get_controller_list($lang,$line);
                    $on = array();
                    if(!($dev0 == NULL)) { $dev0d = explode(" ", $dev0); $on = array_insert($on,0,$dev0d[1]); }
                    if(!($dev1 == NULL)) { $dev1d = explode(" ", $dev1); $on = array_insert($on,1,$dev1d[1]); }
                    if(!($dev2 == NULL)) { $dev2d = explode(" ", $dev2); $on = array_insert($on,2,$dev2d[1]); }
                    if(!($dev3 == NULL)) { $dev3d = explode(" ", $dev3); $on = array_insert($on,3,$dev3d[1]); }
                    if(!($dev4 == NULL)) { $dev4d = explode(" ", $dev4); $on = array_insert($on,4,$dev4d[1]); }
                    if(!($dev5 == NULL)) { $dev5d = explode(" ", $dev5); $on = array_insert($on,5,$dev5d[1]); }
                    if(!($dev6 == NULL)) { $dev6d = explode(" ", $dev6); $on = array_insert($on,6,$dev6d[1]); }
                    if(!($dev7 == NULL)) { $dev7d = explode(" ", $dev7); $on = array_insert($on,7,$dev7d[1]); }
                    if(!($dev8 == NULL)) { $dev8d = explode(" ", $dev8); $on = array_insert($on,8,$dev8d[1]); }
                    if(!($dev9 == NULL)) { $dev9d = explode(" ", $dev9); $on = array_insert($on,9,$dev9d[1]); }
                    if(!($dev10 == NULL)) { $dev10d = explode(" ", $dev10); $on = array_insert($on,10,$dev10d[1]); }
                    if(!($dev11 == NULL)) { $dev11d = explode(" ", $dev11); $on = array_insert($on,11,$dev11d[1]); }
                    if(!($dev12 == NULL)) { $dev12d = explode(" ", $dev12); $on = array_insert($on,12,$dev12d[1]); }
					if(!($dev13 == NULL)) { $dev13d = explode(" ", $dev13); $on = array_insert($on,13,$dev13d[1]); }
                    if(!($dev14 == NULL)) { $dev14d = explode(" ", $dev14); $on = array_insert($on,14,$dev14d[1]); }
                    if(!($dev15 == NULL)) { $dev15d = explode(" ", $dev15); $on = array_insert($on,15,$dev15d[1]); }
                    if(!($dev16 == NULL)) { $dev16d = explode(" ", $dev16); $on = array_insert($on,16,$dev16d[1]); }
                    if(!($dev17 == NULL)) { $dev17d = explode(" ", $dev17); $on = array_insert($on,17,$dev17d[1]); }
                    if(!($dev18 == NULL)) { $dev18d = explode(" ", $dev18); $on = array_insert($on,18,$dev18d[1]); }
                    if(!($dev19 == NULL)) { $dev19d = explode(" ", $dev19); $on = array_insert($on,19,$dev19d[1]); }
                    if(!($dev20 == NULL)) { $dev20d = explode(" ", $dev20); $on = array_insert($on,20,$dev20d[1]); }
                    if(!($dev21 == NULL)) { $dev21d = explode(" ", $dev21); $on = array_insert($on,21,$dev21d[1]); }
                    if(!($dev22 == NULL)) { $dev22d = explode(" ", $dev22); $on = array_insert($on,22,$dev22d[1]); }
                    if(!($dev23 == NULL)) { $dev23d = explode(" ", $dev23); $on = array_insert($on,23,$dev23d[1]); }
                    if(!($dev24 == NULL)) { $dev24d = explode(" ", $dev24); $on = array_insert($on,24,$dev24d[1]); }
                    if(!($dev25 == NULL)) { $dev25d = explode(" ", $dev25); $on = array_insert($on,25,$dev25d[1]); }
                    if(!($dev26 == NULL)) { $dev26d = explode(" ", $dev26); $on = array_insert($on,26,$dev26d[1]); }
                    if(!($dev27 == NULL)) { $dev27d = explode(" ", $dev27); $on = array_insert($on,27,$dev27d[1]); }
                    if(!($dev28 == NULL)) { $dev28d = explode(" ", $dev28); $on = array_insert($on,28,$dev28d[1]); }
                    if(!($dev29 == NULL)) { $dev29d = explode(" ", $dev29); $on = array_insert($on,29,$dev29d[1]); }
                    if(!($dev30 == NULL)) { $dev30d = explode(" ", $dev30); $on = array_insert($on,30,$dev30d[1]); }
                    if(!($dev31 == NULL)) { $dev31d = explode(" ", $dev31); $on = array_insert($on,31,$dev31d[1]); }
                    if(!($dev32 == NULL)) { $dev32d = explode(" ", $dev32); $on = array_insert($on,32,$dev32d[1]); }
                    if(!($dev33 == NULL)) { $dev33d = explode(" ", $dev33); $on = array_insert($on,33,$dev33d[1]); }
                    if(!($dev34 == NULL)) { $dev34d = explode(" ", $dev34); $on = array_insert($on,34,$dev34d[1]); }
                    if(!($dev35 == NULL)) { $dev35d = explode(" ", $dev35); $on = array_insert($on,35,$dev35d[1]); }
                    if(!($dev36 == NULL)) { $dev36d = explode(" ", $dev36); $on = array_insert($on,36,$dev36d[1]); }
                    if(!($dev37 == NULL)) { $dev37d = explode(" ", $dev37); $on = array_insert($on,37,$dev37d[1]); }
                    if(!($dev38 == NULL)) { $dev38d = explode(" ", $dev38); $on = array_insert($on,38,$dev38d[1]); }
                    if(!($dev39 == NULL)) { $dev39d = explode(" ", $dev39); $on = array_insert($on,39,$dev39d[1]); }
                    if(!($dev40 == NULL)) { $dev40d = explode(" ", $dev40); $on = array_insert($on,40,$dev40d[1]); }
                    if(!($dev41 == NULL)) { $dev41d = explode(" ", $dev41); $on = array_insert($on,41,$dev41d[1]); }
                    if(!($dev42 == NULL)) { $dev42d = explode(" ", $dev42); $on = array_insert($on,42,$dev42d[1]); }
                    if(!($dev43 == NULL)) { $dev43d = explode(" ", $dev43); $on = array_insert($on,43,$dev43d[1]); }
                    if(!($dev44 == NULL)) { $dev44d = explode(" ", $dev44); $on = array_insert($on,44,$dev44d[1]); }
                    if(!($dev45 == NULL)) { $dev45d = explode(" ", $dev45); $on = array_insert($on,45,$dev45d[1]); }
                    if(!($dev46 == NULL)) { $dev46d = explode(" ", $dev46); $on = array_insert($on,46,$dev46d[1]); }
                    if(!($dev47 == NULL)) { $dev47d = explode(" ", $dev47); $on = array_insert($on,47,$dev47d[1]); }
                    if(!($dev48 == NULL)) { $dev48d = explode(" ", $dev48); $on = array_insert($on,48,$dev48d[1]); }
                    if(!($dev49 == NULL)) { $dev49d = explode(" ", $dev49); $on = array_insert($on,49,$dev49d[1]); }
                    if(!($dev50 == NULL)) { $dev50d = explode(" ", $dev50); $on = array_insert($on,50,$dev50d[1]); }
                    if(!empty($to)) {
                        sort($on); 
                        sort($to);
                        $result = array_diff($to, $on);
                        if (($on == NULL) || (filesize($datafile) == 0)) {
                            //do noting
                        } 
                        if(empty($result)) {
                            get_success($lang, '2001');
                        }
                        else {//disconnected controllers
                            foreach ( $result AS $diff ) {
                                echo "<span class='label label-important'><a href='info.php?inv=$diff&lang=$lang&line=$line'>". $diff ."</a></span>&nbsp;";
                            }
                        }
                    } else {
	                    echo $to;
                    }
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