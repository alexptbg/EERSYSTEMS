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
$line = $_GET['line'];
$id = $_GET['id'];
$inv = $_GET['inv'];
$sys = $_GET['sys'];
check_login($lang,$line,$id,$inv,$web_dir,$sys);
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
            <a class="logo" href="setup.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>">
			<h2><?php echo get_lang($lang, 'inter61'); ?></h2>
			</a>
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
                <li>
                    <a href="controller_setup.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-calc"></span><span class="text"><?php echo get_lang($lang, 'td1'); ?></span>
                    </a>
                </li>
                <li class="active">
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

                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'ad134'); ?></span>
                        </div>
						<div class="block">
<?php
if(isset($_POST['submit'])) {
    $inventory = mysql_prep($_POST['inventory']);
    $problem = mysql_prep($_POST['problem']);
    $obs = mysql_prep($_POST['obs']);
    if(isset($_POST['parts_1'])) {
        $parts[] = mysql_prep($_POST['parts_1']);
        $quant[] = mysql_prep($_POST['quant_1']);	
	}
    if(isset($_POST['parts_2'])) {
        $parts[] = mysql_prep($_POST['parts_2']);
        $quant[] = mysql_prep($_POST['quant_2']);	
	}
    if(isset($_POST['parts_3'])) {
        $parts[] = mysql_prep($_POST['parts_3']);
        $quant[] = mysql_prep($_POST['quant_3']);	
	}
    if(isset($_POST['parts_4'])) {
        $parts[] = mysql_prep($_POST['parts_4']);
        $quant[] = mysql_prep($_POST['quant_4']);	
	}
    if(isset($_POST['parts_5'])) {
        $parts[] = mysql_prep($_POST['parts_5']);
        $quant[] = mysql_prep($_POST['quant_5']);	
	}
    if(isset($_POST['parts_6'])) {
        $parts[] = mysql_prep($_POST['parts_6']);
        $quant[] = mysql_prep($_POST['quant_6']);	
	}
    if(isset($_POST['parts_7'])) {
        $parts[] = mysql_prep($_POST['parts_7']);
        $quant[] = mysql_prep($_POST['quant_7']);	
	}
    if(isset($_POST['parts_8'])) {
        $parts[] = mysql_prep($_POST['parts_8']);
        $quant[] = mysql_prep($_POST['quant_8']);	
	}
    if(isset($_POST['parts_9'])) {
        $parts[] = mysql_prep($_POST['parts_9']);
        $quant[] = mysql_prep($_POST['quant_9']);	
	}
    if(isset($_POST['parts_10'])) {
        $parts[] = mysql_prep($_POST['parts_10']);
        $quant[] = mysql_prep($_POST['quant_10']);	
	}
    if(isset($_POST['parts_11'])) {
        $parts[] = mysql_prep($_POST['parts_11']);
        $quant[] = mysql_prep($_POST['quant_11']);	
	}
    $mec = mysql_prep($_POST['mec']);
    $when = date("Y-m-d H:i:s");
    $time = mysql_prep($_POST['time']);
    
    $all_parts = implode(", ",$parts);
    $all_quant = implode(", ",$quant);
    
    if (empty($all_parts)) { $all_parts = '0'; }
    if (empty($all_quant)) { $all_quant = '0'; }
    
    if ($inv != NULL) {
    	
	    $query = "INSERT INTO `tasks` (`line`,`inv`,`problem`,`parts`,`quant`,`obs`,`mec`,`added`,`time`) 
		          VALUES ('$line','$inventory','$problem','$all_parts','$all_quant','$obs','$mec','$when','$time')";
            $result = mysql_query($query);
            confirm_query($result);
            if ($result) {
		        echo "<div class='w94 pt10'>";
		        get_success($lang,'2024');
		        echo "</div>";
                $master = array_combine($parts,$quant);
                foreach($master as $u => $v) {
					if ($v != 0) {
		                $query1 = "INSERT INTO `tasks_parts_total` (`added`,`line`,`problem`,`parts`,`quant`) 
		                           VALUES ('$when','$line','$problem','$u','$v')";
		                $result1 = mysql_query($query1);
                        confirm_query($result1);
					}
				}
                //$_SESSION[$web_dir] = NULL;
                //unset($_COOKIE['EESYSTEMS']);
                $url = "../diagnostics.php?lang=".$lang."&line=".$line;
				//$url = "controller_repairs.php?lang=".$lang."&line=".$line."&inv=".$inv."&sys=".$sys."&id=".$id;
				redir($url,'1');
            } else {
	echo "<div class='w94 pt10'>";
	get_error($lang,'1053');
	echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		  <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
            }
	}
}
else {
	echo "<div class='w94 pt10'>";
	get_error($lang,'1000');
	echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		  <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
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