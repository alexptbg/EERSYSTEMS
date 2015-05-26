<!DOCTYPE html>
<html lang="en">
<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
$line = mysql_prep($_GET['line']);
$lines = get_line_options($line);
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
    <script type='text/javascript' src='js/plugins/sparklines/jquery.sparkline.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/select2/select2.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/uniform/uniform.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/languages/jquery.validationEngine-<?=$lang?>.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/jquery.validationEngine.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/cleditor/jquery.cleditor.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/dataTables/jquery.dataTables.min.js' charset='utf-8'></script>    
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
	<script type='text/javascript' src='js/lang.js'></script>
    <script type='text/javascript' src='js/alex.js'></script>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
        <div class="header">
            <a class="logo" href="../index.php?lang=<?=$lang?>">
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
                    <li><span class="icon-cog"></span> <a href="my_profile.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'ad22'); ?></a></li>
                    <li><span class="icon-share-alt"></span> 
					    <a href="logout.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'Logout'); ?></a></li>
                </ul>
                <div class="info">
                    <span><?php echo get_lang($lang, 'inter84') . "!"; ?></span><br/>
					<span><?php echo get_lang($lang, 'inter135').":<br/>".$user_settings['last_login']; ?></span>
                </div>
            </div>
			
            <ul class="navigation">            
                <li>
                    <a href="admin.php?lang=<?=$lang?>">
                        <span class="isw-grid"></span><span class="text"><?php echo get_lang($lang, 'home'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="settings.php?lang=<?=$lang?>">
                        <span class="isw-settings"></span><span class="text"><?php echo get_lang($lang, 'ad26'); ?></span>
                    </a>
                </li> 
                <li>
                    <a href="users.php?lang=<?=$lang?>">
                        <span class="isw-users"></span><span class="text"><?php echo get_lang($lang, 'ad01'); ?></span>
                    </a>
                </li>
                <li class="active">
                    <a href="lines.php?lang=<?=$lang?>">
                        <span class="isw-list"></span><span class="text"><?php echo get_lang($lang, 'ad27'); ?></span>
                    </a>
                </li>   
				<li class="openable">
                    <a href="#">
                        <span class="isw-calendar"></span><span class="text"><?php echo get_lang($lang, 'ad28'); ?></span>
                    </a>
                    <ul> <?php get_controllers_for_edit($lang,$line); ?></ul>
				</li>
                <li>
                    <a href="klima_routers.php?lang=<?=$lang?>">
                        <span class="isw-bookmark"></span><span class="text"><?php echo get_lang($lang, 'ad300'); ?></span>
                    </a>
                </li>
				<li class="openable">
                    <a href="#">
                        <span class="isw-archive"></span><span class="text"><?php echo get_lang($lang, 'ad310'); ?></span>
                    </a>
                    <ul><?php get_klimas($lang,$krouter); ?></ul>
				</li>
                <li>
                    <a href="server.php?lang=<?=$lang?>">
                        <span class="isw-target"></span><span class="text"><?php echo get_lang($lang, 'inter93'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="logs.php?lang=<?=$lang?>">
                        <span class="isw-text_document"></span><span class="text"><?php echo get_lang($lang, 'ad120'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="license.php?lang=<?=$lang?>">
                        <span class="isw-unlock"></span><span class="text"><?php echo get_lang($lang, 'License'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="faq.php?lang=<?=$lang?>">
                        <span class="isw-tag"></span><span class="text"><?php echo get_lang($lang, 'FAQ'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="../index.php?lang=<?=$lang?>">
                        <span class="isw-left_circle"></span><span class="text"><?php echo get_lang($lang, 'ad193'); ?></span>
                    </a>
                </li>
            </ul>

        </div>

        <div class="content">
            <div class="breadLine">
                <ul class="breadcrumb">
                    <li><?php echo get_lang($lang, 'inter61'); ?></li>
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
                            <i class="fa fa-list-ul fa-1x"></i><span><?php echo get_lang($lang, 'ad49'); ?></span>
                            <ul class="buttons">
                                <li class="tip_" title="<?php echo get_lang($lang, 'Back'); ?>">
                                    <a href="javascript: history.go(-1);" class="isw-left_circle"></a>
                                </li>
                            </ul>  
                        </div>
                        <div class="block-fluid">                     
                          <form action="line_update.php?lang=<?=$lang?>" method="post" id="validation">
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'inter71'); ?>:</div>
                                <div class="span8">
								  <input id="line_id" name="id" type="text" class="validate[required]" readonly="readonly" value="<?php echo $lines['id']; ?>" /></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'ad35'); ?>:</div>
                                <div class="span7">
								  <input id="line_name" name="line_name" type="text" class="validate[required,minSize[4]]" value="<?php echo $lines['line_name']; ?>" MAXLENGTH="32" /><span><?php echo get_lang($lang, 'ad42'); ?></span></div>
								  <div class="span1"><span id="status"></span></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'ad36'); ?>:</div>
                                <div class="span8">
								  <input id="lsn" name="line_sname" type="text" class="validate[required,maxSize[8]]" oninput="document.getElementById('echo').value=this.value+'.php';" value="<?php echo $lines['line_sname']; ?>" MAXLENGTH="8" />
								  <span><?php echo get_lang($lang, 'ad48'); ?></span></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'ad37'); ?>:</div>
                                <div class="span8">
								  <input id="echo" name="data_file" type="text" class="validate[required]" value="<?php echo $lines['line_sname'].".php"; ?>" readonly="readonly" /></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'ad38'); ?>:</div>
                                <div class="span8">
								 <input name="ip_address" type="text" class="validate[required,custom[ipv4]]" value="<?php echo $lines['ip_address']; ?>" MAXLENGTH="15" />
								 <span><?php echo get_lang($lang, 'ad48'); ?></span></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'ad39'); ?>:</div>
                                <div class="span8">
								  <input name="port" type="text" class="validate[required,custom[number]]" value="<?php echo $lines['port']; ?>" MAXLENGTH="5" />
								  <span><?php echo get_lang($lang, 'ad48'); ?></span></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'ad40'); ?>: +</div>
                                <div class="span8">
								  <input name="alarm" type="text" class="validate[required]" value="<?php echo $lines['alarm']; ?>" MAXLENGTH="2" />
								  <span><?php echo get_lang($lang, 'ad47'); ?></span></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'ad41'); ?>: +</div>
                                <div class="span8">
								  <input name="red" type="text" class="validate[required]" value="<?php echo $lines['red']; ?>" MAXLENGTH="2" />
								  <span><?php echo get_lang($lang, 'ad47'); ?></span></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'ad43'); ?>:</div>
                                <div class="span8">
								  <input name="ex_alarm" type="text" value="<?php echo $lines['ex_alarm']; ?>" />
								  <span><?php echo get_lang($lang, 'ad46'); ?></span></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'ad44'); ?>:</div>
                                <div class="span8">
								  <input name="ex_red" type="text" value="<?php echo $lines['ex_red']; ?>" />
								  <span><?php echo get_lang($lang, 'ad46'); ?></span></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'ad45'); ?>:</div>
                                <div class="span8">
								  <input name="ex_table" type="text" value="<?php echo $lines['ex_table']; ?>" />
								  <span><?php echo get_lang($lang, 'ad46'); ?></span></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'info19'); ?>:</div>
                                <div class="span8">
								  <input name="org" type="text" value="<?php echo $lines['org']; ?>" />
								  </div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'info20'); ?>:</div>
                                <div class="span8">
                                    <select name='plant'>
									    <option value="<?php echo $lines['plant']; ?>"><?php echo $lines['plant']; ?></option>
									    <option value=""></option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
										<option value="9">9</option>
                                    </select>
								  </div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4 tar"><?php echo get_lang($lang, 'info21'); ?>:</div>
                                <div class="span8">
                                    <select name='floor'>
									    <option value="<?php echo $lines['floor']; ?>"><?php echo $lines['floor']; ?></option>
									    <option value=""></option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
										<option value="9">9</option>
                                    </select>
								  </div>
                            </div>
							
                            <div class="row-form clearfix">
                                <div class="span3 tar"><?php echo get_lang($lang, 'ad154'); ?>: &nbsp;
								<?php
								if ($lines['lt_s'] == '1') {
									echo "<input type=\"checkbox\" name=\"lt_s\" checked=\"checked\" />";
								} else {
									echo "<input type=\"checkbox\" name=\"lt_s\" />";
								}
								?>
								</div>
                                <div class="span2 tar"><span><?php echo get_lang($lang, 'ad157'); ?></span></div>
                                <div class="span2">
                                    <select id="lt_start" name="lt_start" class="validate[required]">
									    <option value="<?php echo $lines['lt_start']; ?>"><?php echo $lines['lt_start']; ?>:00</option>
									    <option value=""></option>
                                        <option value="05">05:00</option>
                                        <option value="06">06:00</option>
                                        <option value="07">07:00</option>
                                        <option value="08">08:00</option>
                                        <option value="09">09:00</option>
                                        <option value="10">10:00</option>
                                        <option value="11">11:00</option>
                                        <option value="12">12:00</option>
                                        <option value="13">13:00</option>
                                        <option value="14">14:00</option>
                                        <option value="15">15:00</option>
                                        <option value="16">16:00</option>
                                        <option value="17">17:00</option>
                                        <option value="18">18:00</option>
                                        <option value="19">19:00</option>
                                        <option value="20">20:00</option>
                                        <option value="21">21:00</option>
                                        <option value="22">22:00</option>
                                        <option value="23">23:00</option>
                                    </select>
								</div>
								<div class="span2 tar"><span><?php echo get_lang($lang, 'ad158'); ?></span></div>
                                <div class="span2">
                                    <select id="lt_stop" name="lt_stop" class="validate[required]">
									    <option value="<?php echo $lines['lt_stop']; ?>"><?php echo $lines['lt_stop']; ?>:00</option>
									    <option value=""></option>
                                        <option value="05">05:00</option>
                                        <option value="06">06:00</option>
                                        <option value="07">07:00</option>
                                        <option value="08">08:00</option>
                                        <option value="09">09:00</option>
                                        <option value="10">10:00</option>
                                        <option value="11">11:00</option>
                                        <option value="12">12:00</option>
                                        <option value="13">13:00</option>
                                        <option value="14">14:00</option>
                                        <option value="15">15:00</option>
                                        <option value="16">16:00</option>
                                        <option value="17">17:00</option>
                                        <option value="18">18:00</option>
                                        <option value="19">19:00</option>
                                        <option value="20">20:00</option>
                                        <option value="21">21:00</option>
                                        <option value="22">22:00</option>
                                        <option value="23">23:00</option>
                                    </select>
								</div>
								<div class="span1"><span id="lt_status"></span></div>
                            </div>
							
                            <div class="row-form clearfix">
                                <div class="span3 tar"><?php echo get_lang($lang, 'ad155'); ?>: &nbsp;
								<?php
								if ($lines['mod_s'] == '1') {
									echo "<input type=\"checkbox\" name=\"mod_s\" checked=\"checked\" />";
								} else {
									echo "<input type=\"checkbox\" name=\"mod_s\" />";
								}
								?>
								</div>
                                <div class="span2 tar"><span><?php echo get_lang($lang, 'ad157'); ?></span></div>
                                <div class="span2">
                                    <select id="mod_start" name="mod_start" class="validate[required]">
									    <option value="<?php echo $lines['mod_start']; ?>"><?php echo $lines['mod_start']; ?>:00</option>
									    <option value=""></option>
                                        <option value="05">05:00</option>
                                        <option value="06">06:00</option>
                                        <option value="07">07:00</option>
                                        <option value="08">08:00</option>
                                        <option value="09">09:00</option>
                                        <option value="10">10:00</option>
                                        <option value="11">11:00</option>
                                        <option value="12">12:00</option>
                                        <option value="13">13:00</option>
                                        <option value="14">14:00</option>
                                        <option value="15">15:00</option>
                                        <option value="16">16:00</option>
                                        <option value="17">17:00</option>
                                        <option value="18">18:00</option>
                                        <option value="19">19:00</option>
                                        <option value="20">20:00</option>
                                        <option value="21">21:00</option>
                                        <option value="22">22:00</option>
                                        <option value="23">23:00</option>
                                    </select>
								</div>
								<div class="span2 tar"><span><?php echo get_lang($lang, 'ad158'); ?></span></div>
                                <div class="span2">
                                    <select id="mod_stop" name="mod_stop" class="validate[required]">
									    <option value="<?php echo $lines['mod_stop']; ?>"><?php echo $lines['mod_stop']; ?>:00</option>
									    <option value=""></option>
                                        <option value="05">05:00</option>
                                        <option value="06">06:00</option>
                                        <option value="07">07:00</option>
                                        <option value="08">08:00</option>
                                        <option value="09">09:00</option>
                                        <option value="10">10:00</option>
                                        <option value="11">11:00</option>
                                        <option value="12">12:00</option>
                                        <option value="13">13:00</option>
                                        <option value="14">14:00</option>
                                        <option value="15">15:00</option>
                                        <option value="16">16:00</option>
                                        <option value="17">17:00</option>
                                        <option value="18">18:00</option>
                                        <option value="19">19:00</option>
                                        <option value="20">20:00</option>
                                        <option value="21">21:00</option>
                                        <option value="22">22:00</option>
                                        <option value="23">23:00</option>
                                    </select>
								</div>
								<div class="span1"><span id="mod_status"></span></div>
                            </div>

                            <div class="row-form clearfix">
                                <div class="span3 tar"><?php echo get_lang($lang, 'ad156'); ?>: &nbsp;
								<?php
								if ($lines['time_s'] == '1') {
									echo "<input type=\"checkbox\" name=\"time_s\" checked=\"checked\" />";
								} else {
									echo "<input type=\"checkbox\" name=\"time_s\" />";
								}
								?>
								</div>
                                <div class="span2 tar"><span><?php echo get_lang($lang, 'ad157'); ?></span></div>
                                <div class="span2">
                                    <select id="time_start" name="time_start" class="validate[required]">
									    <option value="<?php echo $lines['time_start']; ?>"><?php echo $lines['time_start']; ?>:00</option>
									    <option value=""></option>
                                        <option value="05">05:00</option>
                                        <option value="06">06:00</option>
                                        <option value="07">07:00</option>
                                        <option value="08">08:00</option>
                                        <option value="09">09:00</option>
                                        <option value="10">10:00</option>
                                        <option value="11">11:00</option>
                                        <option value="12">12:00</option>
                                        <option value="13">13:00</option>
                                        <option value="14">14:00</option>
                                        <option value="15">15:00</option>
                                        <option value="16">16:00</option>
                                        <option value="17">17:00</option>
                                        <option value="18">18:00</option>
                                        <option value="19">19:00</option>
                                        <option value="20">20:00</option>
                                        <option value="21">21:00</option>
                                        <option value="22">22:00</option>
                                        <option value="23">23:00</option>
                                    </select>
								</div>
								<div class="span2 tar"><span><?php echo get_lang($lang, 'ad158'); ?></span></div>
                                <div class="span2">
                                    <select id="time_stop" name="time_stop" class="validate[required]">
									    <option value="<?php echo $lines['time_stop']; ?>"><?php echo $lines['time_stop']; ?>:00</option>
									    <option value=""></option>
                                        <option value="05">05:00</option>
                                        <option value="06">06:00</option>
                                        <option value="07">07:00</option>
                                        <option value="08">08:00</option>
                                        <option value="09">09:00</option>
                                        <option value="10">10:00</option>
                                        <option value="11">11:00</option>
                                        <option value="12">12:00</option>
                                        <option value="13">13:00</option>
                                        <option value="14">14:00</option>
                                        <option value="15">15:00</option>
                                        <option value="16">16:00</option>
                                        <option value="17">17:00</option>
                                        <option value="18">18:00</option>
                                        <option value="19">19:00</option>
                                        <option value="20">20:00</option>
                                        <option value="21">21:00</option>
                                        <option value="22">22:00</option>
                                        <option value="23">23:00</option>
                                    </select>
								</div>
								<div class="span1"><span id="time_status"></span></div>
                            </div>

                            <div class="footer">
							    <button class="fl btn btn-default" type="button" onClick="javascript: history.go(-1); return false;">
		                            <i class="fa fa-times"></i>&nbsp; <?php echo get_lang($lang, 'Cancel'); ?></button>
								<?php
						    if ($user_settings['level'] < 5) {
								echo "<span class=\"label label-important\">". get_lang($lang, 'ad136').": 5</span>
                                <button class=\"btn btn-default\" type=\"submit\" name=\"submit\" disabled=\"disabled\" disabled>
		                            <i class=\"fa fa-save\"></i>&nbsp; ".get_lang($lang, 'inter126')."</button>
							    ";
							} else {
								echo "<span class=\"label label-success\">". get_lang($lang, 'ad136').": 5</span>
                                <button class=\"btn btn-default\" type=\"submit\" name=\"submit\">
		                            <i class=\"fa fa-save\"></i>&nbsp; ".get_lang($lang, 'inter126')."</button>
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
$(document).ready(function(){
$("#line_name").keyup(function() { 
var lineid = $("#line_id").val();
var linename = $("#line_name").val();
if (linename != null) {
$("#line_name").html('<img src="img/loaders/s_loader_bw.gif" />');
			$.ajax({
				url: 'line_check2.php?lineid='+lineid+'&linename='+linename,
				type: 'POST',
				success: function(data) {
			$('span#status').html(data);
			},
				cache: false
			});
return false;
}
});
$("#line_name").change(function() { 
var lineid = $("#line_id").val();
var linename = $("#line_name").val();
if (linename != null) {
$("#line_name").html('<img src="img/loaders/s_loader_bw.gif" />');
			$.ajax({
				url: 'line_check2.php?lineid='+lineid+'&linename='+linename,
				type: 'POST',
				success: function(data) {
			$('span#status').html(data);
			},
				cache: false
			});
return false;
}
});
$("#lt_start").change(function() { 
	var lt_start = $('#lt_start').val();
	var lt_stop = $('#lt_stop').val();	
    if (lt_stop > lt_start) {
        $('span#lt_status').html("<font color='green'><?php echo get_lang($lang,'ad82'); ?></font>");
    } else {
		$('span#lt_status').html("<font color='red'><?php echo get_lang($lang,'ad83'); ?></font>");
	}
});
$("#lt_stop").change(function() { 
	var lt_start = $('#lt_start').val();
	var lt_stop = $('#lt_stop').val();	
    if (lt_stop > lt_start) {
        $('span#lt_status').html("<font color='green'><?php echo get_lang($lang,'ad82'); ?></font>");
    } else {
		$('span#lt_status').html("<font color='red'><?php echo get_lang($lang,'ad83'); ?></font>");
	}
});
$("#mod_start").change(function() { 
	var mod_start = $('#mod_start').val();
	var mod_stop = $('#mod_stop').val();	
    if (mod_stop > mod_start) {
        $('span#mod_status').html("<font color='green'><?php echo get_lang($lang,'ad82'); ?></font>");
    } else {
		$('span#mod_status').html("<font color='red'><?php echo get_lang($lang,'ad83'); ?></font>");
	}
});
$("#mod_stop").change(function() { 
	var mod_start = $('#mod_start').val();
	var mod_stop = $('#mod_stop').val();	
    if (mod_stop > mod_start) {
        $('span#mod_status').html("<font color='green'><?php echo get_lang($lang,'ad82'); ?></font>");
    } else {
		$('span#mod_status').html("<font color='red'><?php echo get_lang($lang,'ad83'); ?></font>");
	}
});
$("#time_start").change(function() { 
	var time_start = $('#time_start').val();
	var time_stop = $('#time_stop').val();	
    if (time_stop > time_start) {
        $('span#time_status').html("<font color='green'><?php echo get_lang($lang,'ad82'); ?></font>");
    } else {
		$('span#time_status').html("<font color='red'><?php echo get_lang($lang,'ad83'); ?></font>");
	}
});
$("#time_stop").change(function() { 
	var time_start = $('#time_start').val();
	var time_stop = $('#time_stop').val();	
    if (time_stop > time_start) {
        $('span#time_status').html("<font color='green'><?php echo get_lang($lang,'ad82'); ?></font>");
    } else {
		$('span#time_status').html("<font color='red'><?php echo get_lang($lang,'ad83'); ?></font>");
	}
});
});
</script>
</body>
</html>