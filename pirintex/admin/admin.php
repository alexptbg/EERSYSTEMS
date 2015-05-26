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
if ($user_settings['user_name'] != NULL) {
    $updated = "";
    insert_log($lang,$user_settings['user_name'],'info','ad453',$updated);
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
	<script type='text/javascript' src='js/plugins/c/highstock.js'></script>
	<script type='text/javascript' src='js/plugins/c/highcharts-more.js'></script>
	<script type='text/javascript' src='js/plugins/c/highcharts.<?=$lang?>.js'></script>
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
	<?php charts_init(); ?>
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
                <li class="active">
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
                <li>
                    <a href="lines.php?lang=<?=$lang?>">
                        <span class="isw-list"></span><span class="text"><?php echo get_lang($lang, 'ad27'); ?></span>
                    </a>
                </li> 
				<li class="openable">
                    <a href="#">
                        <span class="isw-calendar"></span><span class="text"><?php echo get_lang($lang, 'ad28'); ?></span>
                    </a>
                    <ul><?php get_controllers_for_edit($lang,$line); ?></ul>
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
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'inter38'); ?></span>
                        </div>
                        <div class="block-fluid">
						    <table cellpadding="0" cellspacing="0" width="100%" class="table">
							    <tbody>       
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad227'); ?>:</td>
                                        <td><?php echo $_SERVER['SERVER_ADDR']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad228'); ?>:</td>
                                        <td><?php echo $_SERVER['REMOTE_ADDR']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad229'); ?>:</td>
                                        <td><?php echo $_SERVER['DOCUMENT_ROOT']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?php print_r($_SESSION); ?></td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                    </div>	
					
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-desktop fa-1x"></i><span><?php echo get_lang($lang, 'ad234'); ?></span>
                        </div>
                        <div class="block-fluid">
						    <table cellpadding="0" cellspacing="0" width="100%" class="table">
							    <tbody>
									<tr>
									    <td class="tar"><?php echo get_lang($lang, 'ad233'); ?>:</td>
									    <td>
										    <?php echo getOS($_SERVER['HTTP_USER_AGENT']); ?>
										</td>
				                    </tr>
									<tr>
									    <td class="tar"><?php echo get_lang($lang, 'ad232'); ?>:</td>
									    <td>
										    <?php $ua=getBrowser(); echo $yourbrowser = $ua['name'] . " " . $ua['version']; ?>
										</td>
				                    </tr>
									<tr>
									    <td class="tar"><?php echo get_lang($lang, 'ad231'); ?>:</td>
									    <td>
                                            <script type="text/javascript"> getsize(); </script>
										</td>
				                    </tr>
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
				
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-envelope fa-1x"></i><span><?php echo get_lang($lang, 'ad235'); ?></span>
                            <ul class="buttons">
                                <li class="tip_" title="<?php echo get_lang($lang, 'ad262'); ?>">
                                    <a href="#" class="isw-settings" id="pop_chat"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="block messaging messages scrollBox">                        
                            <div class="scroll" style="height: 280px;">   
                                <div id="chat"></div> 
                            </div>
							<div class="controls">
							  <form id="validation" method="post" action="">
                                <div class="control">
								    <input type="hidden" name="name" id="name" value="<?php echo $user_settings['user_name']; ?>" />
                                    <textarea class="validate[required]" name="message" id="message" MAXLENGTH="256" placeholder="<?php echo get_lang($lang, 'ad259'); ?>"></textarea>
                                </div>
                                <button class="btn" id="submit" value="Submit" disabled="disabled" disabled>
								    <i class="fa fa-mail-forward"></i>&nbsp; <?php echo get_lang($lang, 'ad247'); ?></button>
							  </form>
							</div>
						</div>
                    </div>
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-user fa-1x"></i><span><?php echo get_lang($lang, 'ad294'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_users_activity($lang); ?>
                        </div>
                    </div> 
				</div>
				
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-bar-chart-o fa-1x"></i><span><?php echo get_lang($lang, 'td44'); ?></span>
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
        <div class="dialog" id="chat_pop" style="display: none;" title="<?php echo get_lang($lang, 'ad263'); ?>">
            <div class="block">
							<?php
							if ($user_settings['level']>1) {
								echo "
                                <button class=\"btn btn-warning\" onClick=\"confirma('".$user_settings['user_name']."'); return false;\">
								    <i class=\"fa fa-trash-o\"></i>&nbsp; "
									.get_lang($lang,'ad260')."</button>
									<span class=\"label label-success\">". get_lang($lang, 'ad136').": 2</span>
								";
							} else {
								echo "
                                <button class=\"btn btn-default\" onClick=\"confirma('".$user_settings['user_name']."'); return false;\" disabled=\"disabled\" disabled>
								    <i class=\"fa fa-trash-o\"></i>&nbsp; "
									.get_lang($lang,'ad260')."</button>
									<span class=\"label label-important\">". get_lang($lang, 'ad136').": 2</span>
								";
							}
							if ($user_settings['level']>5) {
								echo "
                                <button class=\"btn btn-danger\" onClick=\"confirmall(); return false;\">
								    <i class=\"fa fa-trash-o\"></i>&nbsp; "
									.get_lang($lang,'ad261')." <small>(".decodeSize(get_table_size('messages')).")</small></button>
									<span class=\"label label-success\">". get_lang($lang, 'ad136').": 10</span>
								";
							} else {
								echo "
                                <button class=\"btn btn-default\" onClick=\"confirmall(); return false;\" disabled=\"disabled\" disabled>
								    <i class=\"fa fa-trash-o\"></i>&nbsp; "
									.get_lang($lang,'ad261')." <small>(".decodeSize(get_table_size('messages')).")</small></button>
									<span class=\"label label-important\">". get_lang($lang, 'ad136').": 10</span>
								";
							}
							?> 
							<br/>
                <div class="footer">
				    <button id="closed" class="fr btn btn-large btn-default" type="button">
				        <i class="fa fa-times"></i>&nbsp; <?php echo get_lang($lang, 'Cancel'); ?></button>
			    </div>
		    </div>				 
		</div>
    </div>
<script type="text/javascript" charset="utf-8">
$(function() {
    refresh_shoutbox();
    setInterval("refresh_shoutbox()", 2000);
    $("#submit").click(function() {
        var name    = $("#name").val();
        var message = $("#message").val();
        var data            = '?lang=<?php echo $lang; ?>&name='+ name +'&message='+ message;
        $.ajax({
            type: "POST",
            url: "chat_submit.php"+data,
            success: function(){
                $("#message").val("");
          }
        });   
        return false;
    });
$('#message').keyup(function() {
    if($("#message").val().length > 1) {
       $('#submit').removeAttr('disabled');
    } else {
       $('#submit').attr('disabled', true);
    }
});
});
function refresh_shoutbox() {
    var data = 'refresh=1';
    $.ajax({
            type: "POST",
            url: "chat.php",
            data: data,
            success: function(html){
                $("#chat").html(html);
				$(".scroll").mCustomScrollbar("update");
            }
        });
}
</script>
<?php
    echo "
<script type=\"text/javascript\">
function confirma(username) {
	var answer = confirm(\"".get_lang($lang, 'ad267')."?\");
	if (answer){ clear_user_messages(username); }
	else{ alert(\"".get_lang($lang, 'ad265')."\"); }
}
function clear_user_messages(username) {
   $.ajax({
   type: \"POST\",
   url: \"chat_del_user.php?lang=".$lang."&u=\"+username,
   success: function(){
	 alert(\"".get_lang($lang, 'ad266')."\");
   }
 });
    return false;
}
function confirmall() {
	var answer = confirm(\"".get_lang($lang, 'ad261')."?\");
	if (answer){ clear_messages(); }
	else{ alert(\"".get_lang($lang, 'ad265')."\"); }
}
function clear_messages() {
   $.ajax({
   type: \"POST\",
   url: \"chat_del_all.php?lang=".$lang."\",
   success: function(){
	 alert(\"".get_lang($lang, 'ad266')."\");
   }
 });
    return false;
}
</script>";
$track = $global_settings['track_days'];
$del_old = mysql_query("DELETE FROM `messages` WHERE `datetime` < DATE_SUB(NOW(), INTERVAL $track DAY);");
confirm_query($del_old);
?>
</body>
</html>