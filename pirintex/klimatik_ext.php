<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
include('includes/klimatik_functions.php');
$kline = mysql_prep($_GET['kline']);
$inv = mysql_prep($_GET['inv']);
$kline_options = get_krouter_options($kline);
$datafile = "data/{$kline_options['data_file']}";
$updated = date('H:i:s');
if ($datafile == NULL) { get_error($lang,'1002'); exit; }
if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
include("$datafile");
if (filesize($datafile)<100) { get_error($lang,'1004'); exit; }
$dev = ${'dev' . $inv};
$d = explode(" ", $dev);
$line = "";
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
	<link rel='stylesheet' type='text/css' href='css/klimatik.css' />
    <script type='text/javascript' src='js/knob.js' charset='utf-8'></script>
	<script type='text/javascript' src='js/klimatik.js' charset='utf-8'></script>
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
                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-square fa-1x"></i><span><?php echo get_lang($lang, 'ad275'); ?> \ <?=$kline?> \ <?=$inv?></span>
              <ul class="buttons">
                  <li class="tip_" title="<?php echo get_lang($lang, 'inter05'); ?>">
                      <a href="javascript: history.go(-1)" class="isw-left_circle"></a>
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
	if (($d8 > 12) || ($d8 < 1)) { $d8 = 0; }
	if (($d9 > 3) || ($d9 < 0)) { $d9 = 0; }
	if (($d10 > 3) || ($d10 < 0)) { $d10 = 0; }
	if ($d11 > 35) { $d11 = 'NULL'; }
	if ($d12 > 35) { $d12 = 'NULL'; }
	if (($d8 < 8) && ($d8 > 0)) { $status = 'OFF'; led('off'); $ledt = get_lang($lang, 'Off'); } 
	elseif (($d8 < 13) && ($d8 > 8)) { $status = 'ON'; led('on'); $ledt = get_lang($lang, 'On'); } 
	else { $status = 'ERR'; led('err'); $ledt = get_lang($lang, '1052'); }
	mode($d8);
	get_klimatik($lang,$kline,$inv);
?>
	<table class="kl">
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
		    <td>
			<div class="tip" title="<?php echo get_lang($lang, 'ad280'); ?>" class="tip" style="margin:0 auto;width:140px;">
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
					   data-step="1"
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
					   data-max="4"
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
	</tbody>
	</table>
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