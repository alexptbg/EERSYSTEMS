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
include ('../includes/socket.php');
if(isset($_POST['submit'])) {
    if (($_POST['command'] != null) && ($user_settings['level']>5)) { 
        $command = $_POST['command']; 
	    $line = $_POST['terminal'];
	    get_line_options($line);
        $socket_ip = $line_options['ip_address'];
        $socket_port = $line_options['port'];
	    if ($_POST["addr"] != null) { $addr = $_POST["addr"]; }
	    if ($_POST["port"] != null) { $port = $_POST["port"]; }
        try {
            if(!($command == NULL)) {
		        if ($command == "zita -o") {
    	            $sc = new ClientSocket();
    	            $sc->open($socket_ip,$socket_port);
			        if (($addr != null) && ($port != null)) {
				        $sc->send("server $command $addr $port\r\n");
						insert_log($lang,$user_settings['user_name'],'error','ad115',$line);
			        }		
			    } else {
    	            $sc = new ClientSocket();
    	            $sc->open($socket_ip,$socket_port);
				    $sc->send("server $command\r\n");
					$obs = $line." | ".$command;
					insert_log($lang,$user_settings['user_name'],'error','ad116',$obs);
			    }
		    }
	    }
        catch (Exception $e){ echo $e->getMessage(); }
    }
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
	<link rel='stylesheet' type='text/css' href='js/plugins/switch/jquery.switch.css' />
    <script type='text/javascript' src='js/plugins/switch/jquery.switch.min.js' charset='utf-8'></script>
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
                <li class="active">
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
                    <div class="span3">
                        <div class="head clearfix">
                            <i class="fa fa-arrow-right fa-1x"></i><span><?php echo get_lang($lang, 'ad74'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php quick($lang); ?>
                        </div>
                        <div class="head clearfix">
                            <i class="fa fa-arrow-right fa-1x"></i><span><?php echo get_lang($lang, 'ad310'); ?> <?php echo get_lang($lang, 'ad74'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php quick_klima($lang); ?>
                        </div>
                    </div>
                    <div class="span9">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'inter07'); ?></span>
                            <ul class="buttons">
                                <li class="tip_" title="<?php echo get_lang($lang, 'ad64'); ?>">
                                    <a href="#" class="isw-plus" id="pop_adserver"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
                            <?php get_servers_status($lang,$user_settings['level']); ?>
                        </div>
                    </div>
                </div>
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-exchange fa-1x"></i><span><?php echo get_lang($lang, 'inter107'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php
                               mysql_query("SET NAMES 'utf8'");
                               $query = "SELECT `line_name`,`ip_address`,`port` FROM `lines`";
                               $result = mysql_query($query);
                               confirm_query($result);
                               $num_rows = mysql_num_rows($result);
                               if ($num_rows != 0) {
							   	   echo "<form action='".$_SERVER['PHP_SELF'] . "?lang=".$lang."' method='post' class='term'>
								           <div class='row-form clearfix'>
										     <div class='span4 tar'>". get_lang($lang, 'ad69'). ":</div>
											 <div class='span8'>
								               <select id='terminal' name='terminal' class='validate[required]'>
										       <option value=''></option>
								   ";
							       while ($lines = mysql_fetch_array($result)) {
									   echo "<option value='".$lines['line_name']."'>".$lines['line_name']."</option>";
								   }
								   echo "      </select>
								             </div>
								           </div>";
								    echo "
                                <div class='row-form clearfix'>
                                    <div class='span4 tar'>". get_lang($lang, 'ad70'). ":</div>
                                    <div class='span8'>
                                        <select id='command' name='command' class='validate[required]'>
											<option value=''></option>
                                            <option value='cmd sort'>". get_lang($lang, 'inter110'). "</option>
                                            <option value='cmd table'>". get_lang($lang, 'inter111'). "</option>
                                            <option value='zita -1'>". get_lang($lang, 'inter112'). "</option>
                                            <option value='zita -c'>". get_lang($lang, 'inter113'). "</option>
                                            <option value='cmd cordi'>". get_lang($lang, 'inter114'). "</option>
                                            <option value=''></option>
                                            <option value='cmd restart'>". get_lang($lang, 'ad71'). "</option>
                                            <option value=''></option>
                                            <option value='cmd exit'>". get_lang($lang, 'ad72'). "</option>
                                            <option value=''></option>
                                            <option value='zita -o'>".get_lang($lang, 'inter94')." IP ".get_lang($lang, 'ad66')." / ".get_lang($lang, 'Port')."</option>									
                                        </select>
                                    </div>
                                </div>
                                <div class='row-form clearfix'>
                                  <div class='span4 tar'>IP ".get_lang($lang, 'ad66')." / ".get_lang($lang, 'Port').":</div>
                                  <div class='span5'>
				                    <input name='addr' type='text' value='' MAXLENGTH='15' />
								  </div>
                                  <div class='span3'>
				                    <input name='port' type='text' value='' MAXLENGTH='5' />
								  </div>
                                </div>
                            <div class='footer'>";
							if ($user_settings['level']>5) {
								echo "
								<span class=\"fl label label-success\">". get_lang($lang, 'ad136').": 10</span>
                           <button type='submit' name='submit' value='submit' class='btn btn-warning' id='send' disabled='disabled' disabled>
		                        <i class='fa fa-legal'></i>&nbsp; ".get_lang($lang, 'inter108')."</button>
                            ";
							} else {
								echo "
								<span class=\"fl label label-important\">". get_lang($lang, 'ad136').": 10</span>
                           <button type='submit' name='submit' value='submit' class='btn btn-default' disabled='disabled' disabled>
		                        <i class='fa fa-legal'></i>&nbsp; ".get_lang($lang, 'inter108')."</button>
								";
							}
							echo "</div></form>";
							   } else {
							       get_error($lang,'1029');
							   }
							?>
                        </div>
                    </div>
					
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-terminal fa-1x"></i><span><?php echo get_lang($lang, 'Console'); ?></span>
                        </div>
                        <div class="block">
						    <div class="w98">
                        <?php 
					        sys_console($lang,'ad73');
					        if(!($sc == NULL)) {
							    echo "<span>".$time_f." </span>";
							    echo "<span class='text-info'><i class='fa fa-angle-right'></i> " .$command . " " . $id . "</span><br/>"; 
							}
                            if(!($sc == NULL)) { 
						        echo "<span>".$time_f." </span>";
							    echo "<span class='text-success'><i class='fa fa-angle-left'></i> " . $sc->recv() . "</span>"; 
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
        <div class="dialog" id="add_server" style="display: none;" title="<?php echo get_lang($lang, 'ad64'); ?>">
            <div class="block">
			  <form id="validation" action="#" method="post" class="form">
              <div class="row-form">
                <span><?php echo get_lang($lang, 'Name'); ?>:</span>
                <p><input type="text" id="name" name="name" value="" class="validate[required]" MAXLENGTH="32" placeholder="<?php echo get_lang($lang, 'Example'); ?> http" /><span id="status" class="fr"></span></p>
                <span><?php echo get_lang($lang, 'ad65'); ?>:</span>
                <p><input type="text" id="ip" name="ip" value="" class="validate[required,custom[ipv4]]" MAXLENGTH="15" placeholder="<?php echo get_lang($lang, 'Example'); ?> 192.168.169.69" /></p>
                <span><?php echo get_lang($lang, 'Port'); ?>:</span>
                <p><input type="text" id="port" name="port" value="" class="validate[required,custom[onlyNumberSp]]" MAXLENGTH="5" placeholder="<?php echo get_lang($lang, 'Example'); ?> 80" /></p>
				</div>
                <div class="footer">
				  <button id="closes" class="fl btn btn-large btn-default" type="button">
				    <i class="fa fa-times"></i>&nbsp; <?php echo get_lang($lang, 'Cancel'); ?></button>
							<?php
						    if ($user_settings['level'] < 10) {
								echo "
				  <button id=\"add\" type=\"submit\" name=\"submit\" class=\"btn btn-large btn-default\" disabled=\"disabled\" disabled>
				  	<i class=\"fa fa-plus\"></i>&nbsp; ".get_lang($lang, 'ad17')."</button>
							    <span class=\"label label-important\">". get_lang($lang, 'ad136').": 10</span>";
							} else {
								echo "
				  <button id=\"add\" type=\"submit\" name=\"submit\" class=\"btn btn-large btn-default\">
				  	<i class=\"fa fa-plus\"></i>&nbsp; ".get_lang($lang, 'ad17')."</button>
								<span class=\"label label-success\">". get_lang($lang, 'ad136').": 10</span>";
							}
							?> 

                </div>
			  </form>
			  <div id="added" style="display: none;"></div>			  
            </div>
        </div>  
    </div>
	<script type="text/javascript" charset="utf-8">
$(function() {
    $("#add").click(function() {  
	  var name = $("input#name").val();
	  if (name == "") { $("input#name").focus(); return false; }
	  var ip = $("input#ip").val();
	  if (ip == "") { $("input#ip").focus(); return false; }
	  var port = $("input#port").val();
	  if (port == "") { $("input#port").focus(); return false; }
	  var dataString = '?name='+ name + '&ip=' + ip + '&port=' + port;
	$.ajax({
      type: "POST",
      url: "server_add.php"+dataString,
      success: function() {
	  	$(".form").hide();
		$("#added").append("<span class='text-success'>"+name+" <strong>"+ip+":"+port+"</strong> <?php echo get_lang($lang, '2011'); ?></span>");
		$("#added").show('slow');
        var delay = 2000;
        setTimeout(function(){ window.location.href = 'server.php?lang=<?php echo $lang; ?>'; }, delay);
      }
     });
    return false;
    });
$('select').change(function() {
    if($("#terminal").val().length > 0 && $("#command").val().length > 0) {
       $('#send').removeAttr('disabled');
    } else {
       $('#send').attr('disabled', true);
    }
});
});
$(document).ready(function(){
$("input#name").keyup(function() { 
var sname = $("input#name").val();
if (sname != null) {
$("input#name").html('<img src="img/loaders/s_loader_bw.gif" />');
			$.ajax({
				url: 'server_check.php?name='+sname,
				type: 'POST',
				success: function(data) {
			$('span#status').html(data);
			},
				cache: false
			});
return false;
}
});
$("input#name").change(function() { 
var sname = $("input#name").val();
if (sname != null) {
$("input#name").html('<img src="img/loaders/s_loader_bw.gif" />');
			$.ajax({
				url: 'server_check.php?name='+sname,
				type: 'POST',
				success: function(data) {
			$('span#status').html(data);
			},
				cache: false
			});
return false;
}
});
});
	</script>
</body>
</html>
