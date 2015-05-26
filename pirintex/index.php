<!DOCTYPE html>
<html lang="en">
<?php
//error_reporting(0);
define('start',TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
include('includes/widgets.php');
$global_settings = get_global_settings();
$track = $global_settings['track_days'];
$m3 = count_m3('Bukovo','69','0','1'); $v_m3 = $m3/1000;
$line = ""; 
$kline = "";
?>
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
	<script type='text/javascript' src='js/easing.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery.mousewheel.min.js'></script>
    <script type='text/javascript' src='js/plugins/cookie/jquery.cookies.2.2.0.min.js'></script>
    <script type='text/javascript' src='js/plugins/bootstrap.min.js'></script>
	<script type='text/javascript' src='js/plugins/c/highstock.js'></script>
	<script type='text/javascript' src='js/plugins/c/highcharts-more.js'></script>
	<script type='text/javascript' src='js/plugins/c/highcharts.<?=$lang?>.js'></script>
	<script type='text/javascript' src='js/plugins/c/export.js'></script>	
	<!--[if lt IE 9]><script type='text/javascript' src='js/plugins/c/excanvas.js'></script><![endif]-->
	<script type='text/javascript' src='js/plugins/c/f.js'></script>
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
	<script type='text/javascript' src='js/plugins/c/odometer.js'></script>
        <script type="text/javascript">
            var y = <?php echo $v_m3; ?>;
            var n = 0;
            var odo;
            function run() {
                var ctx = document.getElementById('odoCanvas').getContext('2d');
                odo = new odometer(ctx, {
                                    height: 42,
                                    digits: 6,
                                    decimals: 3,
                                    value: n,
                                    wobbleFactor: 0.07
                                    });
                update();
            }
            //val = myOdometer.getValue();
			//odo.setValue(n);
            function update() {
	    setInterval(function () {
			$.ajax({
				url: 'live_total_m3.php?lang=<?=$lang?>&line=Bukovo&inv=69&id=0&v_id=1', 
				success: function(data) {
		            n = data[1]; 
					odo.setValue(n);
			    },
				cache: false
			});
	    }, 1000);
            }  
        </script>
		<?php charts_init(); ?>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
	<?php include('includes/style.php'); include('includes/system.php'); ?>
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
                                <div class="span6">
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
                <li class="active">
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
                    <ul><?php get_controllers_for_edit($lang,$line); ?></ul>
				</li>
				<?php get_klines($lang,$kline); ?>
				<li class="openable">
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
                    <div class="col-md-12">
                        <div class="widgetButtons">                        
                            <button class="btn btn-large btn-success" type="button" onclick="location.href='diagnostics.php?line=Boss1&lang=bg'">Boss 1</button>  
                            <button class="btn btn-large btn-danger" type="button" onclick="location.href='diagnostics.php?line=Boss2&lang=bg'">Boss 2</button>  
                            <button class="btn btn-large btn-info" type="button" onclick="location.href='diagnostics.php?line=Strellson/Joop1&lang=bg'">Strellson 1</button>
                            <button class="btn btn-large btn-warning" type="button" onclick="location.href='diagnostics.php?line=Strellson/Joop2&lang=bg'">Strellson 2</button>
                            <button class="btn btn-large btn-primary" type="button" onclick="location.href='diagnostics.php?line=Bukovo&lang=bg'">Bukovo</button>
                        </div>
                    </div>
                    <br/>
                </div>
                
                <div class="row-fluid">
                    <div class="span3">
                        <div class="head clearfix">
                            <i class="fa fa-clock-o fa-1x"></i><span><?php echo get_lang($lang, 'Clock'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_analog_clock(); ?>
                        </div>
                    </div>             
                    <div class="span5">
                        <div class="head clearfix">
                            <i class="fa fa-cloud fa-1x"></i><span><?php echo get_lang($lang, 'Weather'); ?></span>
                            <ul class="buttons">
                                <li class="tip-" title="<?php echo get_lang($lang, 'td2'); ?>">
                                    <a href="termodata.php?lang=<?=$lang?>" class="isw-graph"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="block">
						    <div class="weather">
						        <h3 style="text-align: center;"><?php echo get_lang($lang,'Gotse_delchev'); ?></h3>
								<?php get_temp_outside($lang,'Strellson/Joop1','0','tk1'); ?>
								<h4></h4>
                                <?php get_weather($lang,'BUXX0015'); ?>
							</div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="head clearfix">
                            <i class="fa fa-sun-o fa-1x"></i><span><?php echo get_lang($lang, 'ad285'); ?></span>
                            <ul class="buttons">
                                <li class="tip-" title="<?php echo get_lang($lang, 'td2'); ?>">
                                    <a href="termodata.php?lang=<?=$lang?>" class="isw-graph"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
						    <table cellpadding="0" cellspacing="0" width="100%" class="table weather">
							    <tbody>
                                    <tr>
                                        <td class="tar"><strong>Boss1:</strong></td>
                                        <td><strong><?php get_temp_inside($lang,'Boss2','3','tk1','5.5'); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><strong>Boss2:</strong></td>
                                        <td><strong><?php get_temp_inside($lang,'Boss2','3','tk2','3'); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><strong>Strellson/Joop1:</strong></td>
                                        <td><strong><?php get_temp_inside($lang,'Strellson/Joop2','5','tk1','2'); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><strong>Strellson/Joop2:</strong></td>
                                        <td><strong><?php get_temp_inside($lang,'Strellson/Joop2','5','tk2','2'); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><strong>Bukovo:</strong></td>
                                        <td><strong><?php get_temp_outside2($lang,'Bukovo','0','tk6'); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>            

                <div class="dr"><span></span></div>              

                <div class="row-fluid">                               
                    <div class="span4">
                        <div class="head clearfix">
                            <i class="fa fa-circle fa-1x"></i><span><?php echo get_lang($lang, 'ad288')." Буково"; ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_tank($lang,'Bukovo','0'); ?>
                        </div>
                    </div> 
					
                    <div class="span4">
                        <div class="head clearfix">
                            <i class="fa fa-circle fa-1x"></i><span><?php echo get_lang($lang, 'ad288')." Буково"; ?></span>
                            <ul class="buttons">
                                <li class="tip-" title="<?php echo get_lang($lang, 'td2'); ?>">
                                    <a href="vodomer.php?lang=<?=$lang?>&line=Bukovo&inv=69&id=0&v_id=1" class="isw-graph"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
                            <?php get_voda($lang,'Bukovo','0'); ?>
							<table cellpadding="0" cellspacing="0" width="100%" class="table vodomer">
			                <thead>
							<tr><th style="text-align: center;"><?php echo get_lang($lang, 'ad282')." ".get_lang($lang, 'inter71'); ?> 69-1</th></tr>
							</thead>
                            <tbody><tr><td>
							<div id="canvas-container">
							<canvas id="odoCanvas" height="55" width="100%">No canvas support!</canvas>
							</div>
						    </td></tr></tbody></table>
						</div>
                    </div>
					
                    <div class="span4">
                        <div class="head clearfix">
                            <i class="fa fa-list-ul fa-1x"></i><span>Bukovo</span>
                            <ul class="buttons">
                                <li class="tip-" title="<?php echo get_lang($lang, 'td2'); ?>">
                                    <a href="pressuredata.php?lang=<?=$lang?>&line=Bukovo&inv=69" class="isw-graph"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
                            <?php get_t_bu($lang,'Bukovo','0'); ?>
                        </div>
                    </div> 
					
                </div>
                <div class="dr"><span></span></div>
				
                <div class="row-fluid">                               
					
                    <div class="span4">
                        <div class="head clearfix">
                            <i class="fa fa-user fa-1x"></i><span><?php echo get_lang($lang, 'ad294'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_users_activity($lang); ?>
                        </div>
                    </div> 
					
                    <div class="span4">
                        <div class="head clearfix">
                            <i class="fa fa-level-down fa-1x"></i><span><?php echo get_lang($lang, 'ad205'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_gauge_temp_c_160($lang,'Boss1','3','tk1'); ?>
                        </div>
                    </div> 
					
                    <div class="span4">
                        <div class="head clearfix">
                            <i class="fa fa-level-up fa-1x"></i><span><?php echo get_lang($lang, 'ad206'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_gauge_temp_c_160($lang,'Boss1','3','tk2'); ?>
                        </div>
                    </div>
					
                </div>
                <div class="dr"><span></span></div>            
                <div class="row-fluid">                               
                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-code-fork fa-1x"></i><span><?php echo get_lang($lang, 'td44'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_controllers_widget($lang); ?>
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
        <script type="text/javascript">
        run();             
        </script>
</body>
</html>
<?php
$del_old = mysql_query("DELETE FROM `temp` WHERE `datetime` < DATE_SUB(NOW(), INTERVAL $track DAY);");
confirm_query($del_old);
$del_old2 = mysql_query("DELETE FROM `klima` WHERE `datetime` < DATE_SUB(NOW(), INTERVAL $track DAY);");
confirm_query($del_old2);
$del_old3 = mysql_query("DELETE FROM `vodomer` WHERE `datetime` < DATE_SUB(NOW(), INTERVAL $track DAY);");
confirm_query($del_old3);
$del_old4 = mysql_query("DELETE FROM `alarms` WHERE `log_date` < DATE_SUB(NOW(), INTERVAL 60 DAY);");
confirm_query($del_old4);
$del_old5 = mysql_query("DELETE FROM `pressure` WHERE `datetime` < DATE_SUB(NOW(), INTERVAL $track DAY);");
confirm_query($del_old5);
$del_old6 = mysql_query("DELETE FROM `klima_temp` WHERE `date_time` < DATE_SUB(NOW(), INTERVAL $track DAY);");
confirm_query($del_old6);
?>