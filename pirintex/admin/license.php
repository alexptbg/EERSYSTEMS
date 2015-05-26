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
    <script type='text/javascript' src='js/md5.js' charset='utf-8'></script>	
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
                <li class="active">
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
                <div class='row-fluid'>

                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-unlock fa-1x"></i><span><?php echo get_lang($lang, 'ad80'); ?></span>
                        </div>
                        <div class="block-fluid">
<?php
if (isset($_POST['submit'])) {
	$h = $_POST['hash'];
	$c = $_POST['code'];
	$k = $_POST['serial'];
	if (($h != NULL) && ($c != NULL) && ($k != NULL)) {
		if ($user_settings['level']>10) {
			$_x = $settings['salt'];
			$_k = decrypt($k,$_x);
			$_d = constant('HOST');
			if ($_k == $_d) {
			    $query = "UPDATE settings SET hash = '{$h}', code = '{$c}', lkey = '{$k}' LIMIT 1";
                $result = mysql_query($query);
                confirm_query($result);
                if ($result) {
					$obs = decrypt($c,$_x);
			        echo "<div class='w98 pt10'><p class='text-success'>";
					echo get_lang($lang, 'ad79')." ".$obs;
					echo "</p></div>";
					insert_log($lang,$user_settings['user_name'],'success','ad119',$obs);
				    $url = $self_path."?lang=".$lang;
				    redir($url,'3');
                } else {
			        //do nothing
			    }
			} else { 
			    echo "<div class='w98 pt10'><p class='text-error'>";
			    echo get_lang($lang, '1031');
				echo "</p></div>";
				$url = $self_path."?lang=".$lang;
				redir($url,'3');
			}
		} else {
	echo "<div class='w94 pt10'>";
	get_error($lang,'1032');
	echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		  <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
		}
    } else {
	echo "<div class='w94 pt10'>";
	get_error($lang,'1000');
	echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		  <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
	}
} else {
	echo "
                          <form action=\"".$self_path."?lang=".$lang."\" method=\"post\" id=\"validation\">
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'inter28').":</div>
                                <div class=\"span8\">
								  <input name=\"domain\" type=\"text\" class=\"validate[required]\" value=\"".HOST."\" readonly=\"readonly\" /></div>
                            </div>
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'ad78').":</div>
                                <div class=\"span8\">
								  <input name=\"hash\" type=\"text\" class=\"validate[required]\" value=\"".$settings['hash']."\" MAXLENGTH=\"16\" /></div>
                            </div>
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'ad76').":</div>
                                <div class=\"span8\">
								  <input name=\"code\" type=\"text\" class=\"validate[required]\" value=\"".$settings['code']."\" MAXLENGTH=\"16\" /></div>
                            </div>
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'ad77').":</div>
                                <div class=\"span8\">
								<input name=\"serial\" type=\"text\" class=\"validate[required]\" value=\"".$settings['lkey']."\" MAXLENGTH=\"48\" /></div>
                            </div>";
							if ($user_settings['level'] > 10) {
								echo "
                            <div class=\"footer\">
							    <span class=\"fl label label-success\">". get_lang($lang, 'ad136').": 50</span>
								<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"btn btn-danger\">
		                        <i class=\"fa fa-warning\"></i>&nbsp; ".get_lang($lang, 'inter126')."</button>
                            </div>";
							} else {
								echo "
                            <div class=\"footer\">
							    <span class=\"fl label label-important\">". get_lang($lang, 'ad136').": 50</span>
								<button type=\"submit\" name=\"submit\" value=\"submit\" class=\"btn btn-default\" disabled=\"disabled\" disabled>
		                        <i class=\"fa fa-warning\"></i>&nbsp; ".get_lang($lang, 'inter126')."</button>
                            </div>";
							}
						    echo "</form>";
}
?>
                        </div>
                    </div>	
					
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-key fa-1x"></i><span><?php echo get_lang($lang, 'ad75'); ?></span>
                        </div>
                        <div class="block-fluid">
						    <table cellpadding="0" cellspacing="0" width="100%" class="table">
							    <tbody>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad167'); ?>:</td>
                                        <td><?php echo $settings['installed']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'Version'); ?>:</td>
                                        <td><?php echo $settings['EES_version']; ?></td>
                                    </tr>
<?php
$_x = $settings['salt'];
$_s = strtotime(decrypt($settings['hash'],$_x));
$_e = strtotime(decrypt($settings['code'],$_x));
$_k = decrypt($settings['lkey'],$_x);
$_n = date('Y-m-d');
$_n = strtotime($_n);
$_d = constant('HOST');
$_c = get_domain($_d);
$_v = date('Y-m-d', $_s);
$_t = date('Y-m-d', $_e);
if ($installed>$_s) {
	$_z = date('Y-m-d', $installed);
    $end = date('Y-m-d', strtotime("$_z +30 days") );
	$_ex = strtotime($end);
    $now = strtotime(date('Y-m-d'));
    $datediff = $_ex - $now;
    $days = floor($datediff/(60*60*24));
	$stop = strtotime($end);
	$_z = date('Y-m-d', $end);
	if ($_c != $_k) {
	    if (($days<30) && ($days>0)) {
            echo "<tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad81')."</td>
                      <td><span class='text-error'>".get_lang($lang, 'ad97')."<span></td>                                   
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      ".get_lang($lang, 'ad95')." <strong>".$days." </strong>".get_lang($lang, 'ad96')."<span></td>
                  </tr>";
	    } else {
            echo "<tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad81')."</td>
                      <td><span class='text-error'>".get_lang($lang, 'ad93')."<span></td>                                   
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      ".get_lang($lang, 'ad91')." <strong>".$end." </strong><span></td>
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      ".get_lang($lang, 'ad92')."<span></td>
                  </tr>";
	    }
	}
} else {
    if ($_c == $_k) {
        if (($_n>$_s) and ($_n<$_e)) {
	        $end = $_e;
	        $now = strtotime(date('Y-m-d'));
	        $datediff = $end - $now;
            $days = floor($datediff/(60*60*24));
            echo "<tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad81').":</td>
                      <td><span class='text-success'>".get_lang($lang, 'ad82')."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad169').":</td>
                      <td><span class='text-success'>".$_v."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad84').":</td>
                      <td><span class='text-success'>".$_t."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad85').":</td>";
					if ($days<30){
						echo "<td><span class='text-error'>".$days."<span></td>";
					} else {
						echo "<td><span class='text-success'>".$days."<span></td> ";
					}                      
              echo "</tr>";
	    } 
		else {
			$_z = date('Y-m-d', $installed);
	        $now = strtotime(date('Y-m-d'));
			$_i = strtotime(date('Y-m-d',$installed));
	        $datediff = $now - $_i;
            $days = floor($datediff/(60*60*24));
            $stop = date('Y-m-d', strtotime("$_z +30 days") );
			if (($days<30) && ($days>0)) {
            echo "<tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad81').":</td>
                      <td><span class=\"text-error\">".get_lang($lang, 'ad86')."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad87').":</td>
                      <td><span class=\"text-error\">".$_z."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad88').":</td>
					  <td><span class=\"text-error\">".$days."<span></td>
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      EERS ".get_lang($lang, 'ad89')." <strong>".$stop."</strong><span></td>
                  </tr>";
		    } else {
            echo "<tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad81').":</td>
                      <td><span class=\"text-error\">".get_lang($lang, 'ad86')."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad87').":</td>
                      <td><span class=\"text-error\">".$_z."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad88').":</td>
					  <td><span class=\"text-error\">".$days."<span></td>
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      EERS ".get_lang($lang, 'ad98')." <strong>".$stop."</strong><span></td>
                  </tr>";
			}
	    }
    } 
	else {
            echo "<tr>                                    
                      <td class=\"tar\">".get_lang($lang, 'ad81').":</td>
                      <td><span class='text-error'>".get_lang($lang, 'ad83')."<span></td>                                   
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      EERS ".get_lang($lang, 'ad90')." <span></td>
                  </tr>";
    }
}
						?>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
										<strong><?php echo $settings['company_name']; ?> - <?php echo $settings['slogan']; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
										<strong><?php echo $settings['site_name']; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
										<strong><?php echo $settings['copyrights']; ?></strong></td>
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
