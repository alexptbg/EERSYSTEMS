<!DOCTYPE html>
<html lang="en">
<?php
//error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = ""; $kline = "";
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
    <script type="text/javascript" src="js/plugins/elfinder/elfinder.min.js"></script>
    <script type='text/javascript' src='js/plugins/highlight/jquery.highlight-4.js'></script>
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
	<script type='text/javascript' src='js/lang.js'></script>
    <script type='text/javascript' src='js/alex.js'></script>
	<script type='text/javascript' src='js/faq.js'></script>
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
                <li class="active">
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
                    <div class="span8">
                        <div class="head clearfix">
                            <i class="fa fa-question fa-1x"></i><span><?php echo get_lang($lang, 'FAQ'); ?></span>
                        </div>    
                        <div class="headInfo">
                            <div class="input-append">
                                <input type="text" name="text" placeholder="<?php echo get_lang($lang, 'Keyword'); ?>..." id="widgetInputMessage" class="faqSearchKeyword"/><button class="btn btn-success" id="faqSearch" type="button"><?php echo get_lang($lang, 'Search'); ?></button>
                            </div>                                           
                            <div class="arrow_down"></div>
                        </div>
                        <div class="block-fluid">
                            <div class="toolbar clearfix">
                                <div class="left">
                                    <div id="faqSearchResult" class="note"></div>
                                </div>
                                <div class="right">
                                    <div class="btn-group">
                                        <button class="btn btn-small tip" id="faqOpenAll" title="<?php echo get_lang($lang, 'ad218'); ?>">
										    <span class="icon-chevron-down icon-white"></span></button>
                                        <button class="btn btn-small tip" id="faqCloseAll" title="<?php echo get_lang($lang, 'ad219'); ?>">
										    <span class="icon-chevron-up icon-white"></span></button>
                                        <button class="btn btn-small tip" id="faqRemoveHighlights" title="<?php echo get_lang($lang, 'ad220'); ?>">
										    <span class="icon-remove icon-white"></span></button>
                                    </div>
                                </div>
                            </div>                                                        
                            <div class="faq">
                                <div class="item" id="faq-1">
                                    <div class="title"><?php echo get_lang($lang, 'faq01'); ?></div>
                                    <div class="text">
									    <h5><?php echo get_lang($lang, 'faq07'); ?>:</h5>
										<p>Windows XP+ / Mac OS X 10+ / Linux OS 10+ / Android 3+ / iOS 4+</p>
										<p><strong><?php echo get_lang($lang, 'faq03'); ?></strong>:</p>
										<p>Windows 7|8 / Linux Mint 14 / Ubuntu 13 / Mac OS X 10.7+ / Android 4 / iOs 6</p>
										<div class="dr"><span></span></div>
									    <h5><?php echo get_lang($lang, 'faq04'); ?>:</h5>
										<p>Google Chrome 3.0+ / Firefox 16.0+ / Internet Explorer 9+ / Safari 5.0+ / Opera 11.0+</p>
										<p><strong><?php echo get_lang($lang, 'faq03'); ?></strong>:</p>
										<p>Firefox 20.0+</p>
										<div class="dr"><span></span></div>
										<h5><?php echo get_lang($lang, 'faq08'); ?>:</h5>
										<p><?php echo get_lang($lang, 'faq05'); ?> / <?php echo get_lang($lang, 'faq02'); ?> / <?php echo get_lang($lang, 'faq09'); ?> 500+ KBS</p>
									</div>
								</div>
								<div class="item" id="faq-2">
                                    <div class="title"><?php echo get_lang($lang, 'faq26'); ?></div>
                                    <div class="text">
									    <p><?php echo get_lang($lang, 'faq27'); ?></p>
										<p><strong><?php echo get_lang($lang, 'Username'); ?></strong>: User</p>
										<p><strong><?php echo get_lang($lang, 'Password'); ?></strong>: 0000</p>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="head clearfix">
                            <i class="fa fa-download fa-1x"></i><span><?php echo get_lang($lang, 'Downloads'); ?></span>
                        </div>
                        <div class="block-fluid">
						    <table cellpadding="0" cellspacing="0" width="100%" class="table">
							    <tbody>       
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'faq04'); ?>:</td>
                                        <td>
										<?php 
                                            if ($lang == 'bg') { echo "<a target=\"_blank\" href=\"http://www.mozilla.org/bg/firefox/fx/\">Firefox</a>"; }
											else { echo "<a target=\"_blank\" href=\"http://www.mozilla.org/en-US/firefox/new/\">Firefox</a>"; }
										?>
										</td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'faq05'); ?>:</td>
                                        <td>
										<?php 
                                            if ($lang == 'bg') { echo "<a target=\"_blank\" href=\"http://get2.adobe.com/flashplayer/\">Adobe ".get_lang($lang, 'faq05')."</a>"; }
											else { echo "<a target=\"_blank\" href=\"http://get2.adobe.com/flashplayer/\">Adobe ".get_lang($lang, 'faq05')."</a>"; }
										?>
										</td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'faq06'); ?>:</td>
                                        <td>
										<?php 
                                            echo "<a target=\"_blank\" href=\"http://get.adobe.com/uk/reader/\">Adobe reader</a>";
										?>
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