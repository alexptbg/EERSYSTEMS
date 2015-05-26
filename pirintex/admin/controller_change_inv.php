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
$inv = mysql_prep($_GET['inv']);
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
                <li>
                    <a href="lines.php?lang=<?=$lang?>">
                        <span class="isw-list"></span><span class="text"><?php echo get_lang($lang, 'ad27'); ?></span>
                    </a>
                </li> 
				<li class="openable active">
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

                    <div class="span12">                    
                        <div class="head clearfix">
                            <i class="fa fa-inbox fa-1x"></i><span><?php echo get_lang($lang, 'ad134'); ?></span>
                        </div>
                        <div class="block-fluid">
<?php
if(isset($_POST['submit'])) {
    $inv = mysql_prep($_POST['inv']);
    $date = mysql_prep($_POST['from']);
    $mark = mysql_prep($_POST['mark']);
    $type = mysql_prep($_POST['type']);
    $desc = mysql_prep($_POST['desc']);
    $machine = mysql_prep($_POST['machine']);
    $serial = mysql_prep($_POST['serial']);
    $cmode = mysql_prep($_POST['cmode']);
    $t1 = mysql_prep($_POST['t1']);
    $t2 = mysql_prep($_POST['t2']);
    $t3 = mysql_prep($_POST['t3']);
    $t4 = mysql_prep($_POST['t4']);
    $t5 = mysql_prep($_POST['t5']);
    $t6 = mysql_prep($_POST['t6']);
    $org = mysql_prep($_POST['org']);
    $plant = mysql_prep($_POST['plant']);
    $floor = mysql_prep($_POST['floor']);
    $main_line = mysql_prep($_POST['main_line']);
    $linex = mysql_prep($_POST['linex']); //line name without confict
    $group_number = mysql_prep($_POST['group_number']);
    $group_name = mysql_prep($_POST['group_name']);
    $oper = mysql_prep($_POST['oper']);
    $tl1 = mysql_prep($_POST['tl1']);
    $tl2 = mysql_prep($_POST['tl2']);
    $tl3 = mysql_prep($_POST['tl3']);
    $tl4 = mysql_prep($_POST['tl4']);
    $tl5 = mysql_prep($_POST['tl5']);
    $tl6 = mysql_prep($_POST['tl6']);
    $vizor = mysql_prep($_POST['vizor']);
    $mobile = mysql_prep($_POST['mobile']);
    $id = mysql_prep($_POST['id']);	
    $del = $_POST['delete'];
	mysql_query("SET NAMES utf8");
	if ($inv == mysql_prep($_POST['inv'])) {
        if ($del == 'yes') {
		    $check_inv = get_check_controller_db($main_line,$inv);
		    if ($check_inv == NULL) {
	    $query = "UPDATE `controller` SET `inv`='$inv', `date`='$date', `mark`='$mark', `type`='$type', `desc`='$desc', `machine`='$machine', `serial`='$serial', `cmode`='$cmode', `t1`='$t1', `t2`='$t2', `t3`='$t3', `t4`='$t4', `t5`='$t5', `t6`='$t6', `org`='$org', `plant`='$plant', `floor`='$floor', `main_line`='$main_line', `line`='$linex', `group_number`='$group_number', `group_name`='$group_name', `oper`='$oper', `tl1`='$tl1', `tl2`='$tl2', `tl3`='$tl3', `tl4`='$tl4', `tl5`='$tl5', `tl6`='$tl6', `vizor`='$vizor', `mobile`='$mobile' WHERE `id`='$id'";
            $result = mysql_query($query);
            confirm_query($result);
            if ($result) {
		        echo "<div class='w94 pt10'>";
		        get_success($lang,'2013');
		        echo "<br/></div>";
				$obs = $main_line . "(".$inv.")";
				insert_log($lang,$user_settings['user_name'],'error','ad153',$obs);
				$url = "controllers.php?lang=".$lang."&line=".$main_line."&inv=".$inv;
				redir($url,'3');
	        } else {
	            echo "<div class='w94 pt10'>";
	            get_error($lang,'1034');
	            echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		                                        <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
	        }
		} else {
	            echo "<div class='w94 pt10'>";
	            get_error($lang,'1014');
	            echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		                                        <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
		}
	    } else {
		    $check_inv = get_check_controller_db($main_line,$inv);
		    if ($check_inv == NULL) {
                $query = "INSERT INTO `controller` (`inv`, `date`, `mark`, `type`, `desc`, `machine`, `serial`, `cmode`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `org`, `plant`, `floor`, `main_line`, `line`, `group_number`, `group_name`, `oper`, `tl1`, `tl2`, `tl3`, `tl4`, `tl5`, `tl6`, `vizor`, `mobile`) 
		                  VALUES ('$inv', '$date', '$mark', '$type', '$desc', '$machine', '$serial', '$cmode', '$t1', '$t2', '$t3', '$t4', '$t5', '$t6', '$org', '$plant', '$floor', '$main_line', '$linex', '$group_number', '$group_name', '$oper', '$tl1', '$tl2', '$tl3', '$tl4', '$tl5', '$tl6', '$vizor', '$mobile')";
                $result = mysql_query($query);
                confirm_query($result);
                if ($result) {
		            echo "<div class='w94 pt10'>";
		            get_success($lang,'2012')." ".$main_line;
		            echo "<br/></div>";
				    $obs = $main_line . "(".$inv.")";
				    insert_log($lang,$user_settings['user_name'],'error','ad152',$obs);
				    $url = "controllers.php?lang=".$lang."&line=".$main_line."&inv=".$inv;
				    redir($url,'3');
                } else {
	                echo "<div class='w94 pt10'>";
	                get_error($lang,'1035');
	                echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		                                            <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
		        }
	        } else {
	            echo "<div class='w94 pt10'>";
	            get_error($lang,'1014');
	            echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		                                        <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
            } 
		}
	} else {
	     echo "<div class='w94 pt10'>";
	     get_error($lang,'1000');
	     echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		                                 <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
	}
} else {
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
