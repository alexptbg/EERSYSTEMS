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
$global_settings = get_global_settings();
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
                <li class="active">
                    <a href="settings.php?lang=<?=$lang?>">
                        <span class="isw-settings"></span><span class="text"><?php echo get_lang($lang, 'ad26'); ?></span>
                    </a>
                </li> 
                <li>
                    <a href="users.php?lang=<?=$lang?>">
                        <span class="isw-users"></span><span class="text"><?php echo get_lang($lang, 'ad01'); ?></span>
                    </a>
                </li>
                <li>
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
                            <i class="fa fa-asterisk fa-1x"></i><span><?php echo get_lang($lang, 'ad196'); ?></span>
                            <?php
							if(!isset($_POST['submit'])) {
								echo "
                            <ul class=\"buttons\">
                                <li class=\"tip_\" title=\"".get_lang($lang, 'Back')."\">
                                    <a href=\"javascript: history.go(-1);\" class=\"isw-left_circle\"></a>
                                </li>
                            </ul>  
								";
							}
							?>
                        </div>
                        <div class="block-fluid">
<?php
if(isset($_POST['submit'])) {
	$e_work_s_h = mysql_prep($_POST['work_s_h']);
	$e_work_s_m = mysql_prep($_POST['work_s_m']);
	$e_work_e_h = mysql_prep($_POST['work_e_h']);
	$e_work_e_m = mysql_prep($_POST['work_e_m']);
	$e_system_addresses = mysql_prep($_POST['system_addresses']);
    $e_track_days = $_POST['track_days'];
	$idx = $global_settings['id'];
	if ($user_settings['level'] > 10) {
	    mysql_query("SET NAMES utf8");
	    $query = "UPDATE `global` SET `work_s_h`='$e_work_s_h', `work_s_m`='$e_work_s_m', `work_e_h`='$e_work_e_h', `work_e_m`='$e_work_e_m', `system_addresses`='$e_system_addresses', `track_days`='$e_track_days' WHERE `id`='$idx'";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
		    echo "<div class='w94 pt10'>";
		    get_success($lang,'2017');
		    echo "<br/></div>";
			$obs = "";
		    insert_log($lang,$user_settings['user_name'],'error','ad197',$obs);
			$url = "settings.php?lang=".$lang;
			redir($url,'2');
        } else {
		    echo "<div class='w94 pt10'>";
		    get_error($lang,'1039');
		    echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		          <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
        }
	}
} else {
    echo "
                          <form action=\"".$self_path."?lang=".$lang."\" method=\"post\" id=\"validation\">
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">" . get_lang($lang, 'ad195').":</div>
								<div class=\"span1\">
								    " . get_lang($lang, 'From')."
								</div>
                                <div class=\"span1\">
                                    <select id=\"work_s_h\" name=\"work_s_h\" class=\"validate[required]\">
									    <option value=\"".$global_settings['work_s_h']."\">".$global_settings['work_s_h']."</option>
									    <option value=\"\"></option>
                                        <option value=\"04\">04</option>
                                        <option value=\"05\">05</option>
                                        <option value=\"06\">06</option>
                                        <option value=\"07\">07</option>
                                        <option value=\"08\">08</option>
                                        <option value=\"09\">09</option>
                                        <option value=\"10\">10</option>
                                        <option value=\"11\">11</option>
                                        <option value=\"12\">12</option>
                                        <option value=\"13\">13</option>
                                        <option value=\"14\">14</option>
                                        <option value=\"15\">15</option>
                                        <option value=\"16\">16</option>
                                        <option value=\"17\">17</option>
                                        <option value=\"18\">18</option>
                                        <option value=\"19\">19</option>
                                        <option value=\"20\">20</option>
                                        <option value=\"21\">21</option>
                                        <option value=\"22\">22</option>
                                        <option value=\"23\">23</option>
                                    </select>
								</div>
								<div class=\"span1\">
                                    <select id=\"work_s_m\" name=\"work_s_m\" class=\"validate[required]\">
									    <option value=\"".$global_settings['work_s_m']."\">".$global_settings['work_s_m']."</option>
									    <option value=\"\"></option>
                                        <option value=\"00\">00</option>
                                        <option value=\"15\">15</option>
                                        <option value=\"30\">30</option>
                                        <option value=\"45\">45</option>
                                    </select>
								</div>
								<div class=\"span1\">
								    " . get_lang($lang, 'To')."
								</div>
                                <div class=\"span1\">
                                    <select id=\"work_e_h\" name=\"work_e_h\" class=\"validate[required]\">
									    <option value=\"".$global_settings['work_e_h']."\">".$global_settings['work_e_h']."</option>
									    <option value=\"\"></option>
                                        <option value=\"04\">04</option>
                                        <option value=\"05\">05</option>
                                        <option value=\"06\">06</option>
                                        <option value=\"07\">07</option>
                                        <option value=\"08\">08</option>
                                        <option value=\"09\">09</option>
                                        <option value=\"10\">10</option>
                                        <option value=\"11\">11</option>
                                        <option value=\"12\">12</option>
                                        <option value=\"13\">13</option>
                                        <option value=\"14\">14</option>
                                        <option value=\"15\">15</option>
                                        <option value=\"16\">16</option>
                                        <option value=\"17\">17</option>
                                        <option value=\"18\">18</option>
                                        <option value=\"19\">19</option>
                                        <option value=\"20\">20</option>
                                        <option value=\"21\">21</option>
                                        <option value=\"22\">22</option>
                                        <option value=\"23\">23</option>
                                    </select>
								</div>
								<div class=\"span1\">
                                    <select id=\"work_e_m\" name=\"work_e_m\" class=\"validate[required]\">
									    <option value=\"".$global_settings['work_e_m']."\">".$global_settings['work_e_m']."</option>
									    <option value=\"\"></option>
                                        <option value=\"00\">00</option>
                                        <option value=\"15\">15</option>
                                        <option value=\"30\">30</option>
                                        <option value=\"45\">45</option>
                                    </select>
								</div>
                            </div>							
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'ad224').":</div>
                                <div class=\"span8\">
								  <input name=\"system_addresses\" type=\"text\" class=\"validate[required]\" value=\"".$global_settings['system_addresses']."\" />
								  <span>".get_lang($lang, 'ad223').".</span>
								</div>
                            </div>
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'ad236').":</div>
                                <div class=\"span8\">
                                    <select name=\"track_days\" class=\"validate[required]\">
									    <option value=\"".$global_settings['track_days']."\">".$global_settings['track_days']."</option>
									    <option value=\"\"></option>
                                        <option value=\"30\">30</option>
                                        <option value=\"60\">60</option>
                                        <option value=\"90\">90</option>
                                        <option value=\"180\">180</option>
                                        <option value=\"365\">365</option>										
                                    </select>
								  </div>
                            </div>
                            <div class=\"footer\">
							    <button class=\"fl btn btn-default\" type=\"button\" onClick=\"javascript: history.go(-1); return false;\">
		                            <i class=\"fa fa-times\"></i>&nbsp; ".get_lang($lang, 'Cancel')."</button>";
						    if ($user_settings['level'] < 50) {
								echo "<span class=\"label label-important\">". get_lang($lang, 'ad136').": 50</span>
                                <button class=\"btn btn-default\" type=\"submit\" name=\"submit\" disabled=\"disabled\" disabled>
		                            <i class=\"fa fa-save\"></i>&nbsp; ".get_lang($lang, 'inter126')."</button>
							    ";
							} else {
								echo "<span class=\"label label-success\">". get_lang($lang, 'ad136').": 50</span>
                                <button class=\"btn btn-default\" type=\"submit\" name=\"submit\">
		                            <i class=\"fa fa-save\"></i>&nbsp; ".get_lang($lang, 'inter126')."</button>
								";
							}
                            echo "</div></form>";
}
?>
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
