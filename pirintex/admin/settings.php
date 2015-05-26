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
                <div class='row-fluid'>

                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-cog fa-1x"></i><span><?php echo get_lang($lang, 'ad160'); ?></span>
                            <ul class="buttons">
                                <li class="tip-" title="<?php echo get_lang($lang, 'Edit'); ?>">
                                    <a href="settings_edit_basic.php?lang=<?=$lang?>" class="isw-edit"></a>
                                </li>
                            </ul>  
                        </div>
                        <div class="block-fluid">
						    <table cellpadding="0" cellspacing="0" width="100%" class="table">
							    <tbody>       
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad29'); ?>:</td>
                                        <td><?php echo $settings['company_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad30'); ?>:</td>
                                        <td><?php echo $settings['slogan']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad32'); ?>:</td>
                                        <td><?php echo $settings['site_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad159'); ?>:</td>
                                        <td><?php echo $settings['smtp_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad249'); ?>:</td>
                                        <td><?php echo $settings['tele']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad33'); ?>:</td>
                                        <td><?php echo $settings['site_email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad250'); ?>:</td>
                                        <td><?php echo $settings['street']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad251'); ?>:</td>
                                        <td><?php echo $settings['region']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad252'); ?>:</td>
                                        <td><?php echo $settings['postal']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad253'); ?>:</td>
                                        <td><?php echo $settings['city']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad254'); ?>:</td>
                                        <td><?php echo $settings['country']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad241'); ?>:</td>
                                        <td><?php echo $settings['lat']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad242'); ?>:</td>
                                        <td><?php echo $settings['lon']; ?></td>
                                    </tr>
                                </tbody>
                            </table>                       
                        </div>
						<div class="dr"><span></span></div>		
                        <div class="head clearfix">
                            <i class="fa fa-picture-o fa-1x"></i><span><?php echo get_lang($lang, 'ad31'); ?></span>
                        </div>
                        <div class="block-fluid">
					        <div class="row-form clearfix">
							    <div class="span12">				                                  
                                    <img src="logo.php" class="img-polaroid" />
								</div>
<?php
$max_width = 219;
$max_height = 164;
$max_size = 65530;
$max_size_upload = 512000;
$msg = get_lang($lang, 'ad139').": ".decodeSize($max_size)." | ".$max_width."x".$max_height."px";
$style = "info";
$idx = $settings['id'];
if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
$dest = "tmp/".$usr.".jpg";
$dst_dir = $dest;
$quality = 90;
$allowedExts = array("gif", "jpeg", "jpg", "png");
$filename = stripslashes($_FILES['image']['name']);
$tmpName = $_FILES['image']['tmp_name'];
$fileType = $_FILES['image']['type'];
$source_file = $tmpName;
$extension = end(explode(".", $_FILES["image"]["name"]));
if ((($fileType == "image/gif") || ($fileType == "image/jpeg") || ($fileType == "image/jpg") || ($fileType == "image/png")) 
    && ($_FILES["image"]["size"] < $max_size_upload) && in_array($extension, $allowedExts)) {
    if ($_FILES["image"]["error"] > 0) { echo "Error: " . $_FILES["image"]["error"] . "<br>"; }
    else {
    $imgsize = getimagesize($source_file);
    $width = $imgsize[0];
    $height = $imgsize[1];
    $mime = $imgsize['mime'];
    switch($mime) {
        case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;
        case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;
        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            break;
        case 'image/jpg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            break;
        default:
            return false;
            break;
    }
    $dst_img = imagecreatetruecolor($max_width, $max_height);
    $src_img = $image_create($source_file);
    $width_new = $height * $max_width / $max_height;
    $height_new = $width * $max_height / $max_width;
    if($width_new > $width){
        $h_point = (($height - $height_new) / 2);
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
    } else {
        $w_point = (($width - $width_new) / 2);
        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
    }
    $image($dst_img, $dst_dir, $quality);
    if($dst_img)imagedestroy($dst_img);
    if($src_img)imagedestroy($src_img);
    $fp = fopen($dest, 'r');
    $data = fread($fp, filesize($dest));
    $data = addslashes($data);
    fclose($fp);
		
		$query = "UPDATE `settings` SET `logo`='$data', `logo_ext`='$fileType' WHERE `id`='$idx'";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
            $msg = get_lang($lang, 'ad140'). " ".decodeSize(filesize($dest));
			insert_log($lang,$user_settings['user_name'],'info','ad143',decodeSize(filesize($dest)));
			$style = "success";
			unlink($dest);
    } else {
        $msg = get_lang($lang, '1033');
		$style = "error";
    }
    }
}
else {
	$msg = get_lang($lang, '1033');
	$style = "error";
}
}
?>

							</div>
							<form method="post" action="<?php echo $self_path."?lang=".$lang; ?>" enctype="multipart/form-data">
							<div class="row-form clearfix">
                                <div class="span6">
                                    <p><input type="file" name="image" id="img_logo" /></p>
								    <p class="text-<?php echo $style; ?>"><?php echo $msg; ?></p>
								</div>
								<div class="span6">
								<?php
								if ($user_settings['level'] < 50) { 
									echo "
									<p class=\"fr label label-important\">". get_lang($lang, 'ad136').": 50</p>
                                <button type=\"submit\" name=\"submit\" class=\"fr btn btn-default\" value=\"save_img\" disabled=\"disabled\" disabled>
								    <i class=\"fa fa-refresh\"></i>&nbsp; ".get_lang($lang, 'ad171')."</button>";	
								} else {
									echo "
									<p class=\"fr label label-success\">". get_lang($lang, 'ad136').": 50</p>
                                <button id=\"save_img\" type=\"submit\" name=\"submit\" class=\"fr btn btn-default\" value=\"save_img\" disabled=\"disabled\" disabled>
								    <i class=\"fa fa-refresh\"></i>&nbsp; ".get_lang($lang, 'ad171')."</button>";	
								}
								?>
                                </div>
							</div>
							</form>
						</div>
					</div>	
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'ad161'); ?></span>
                        </div>
                        <div class="block-fluid">
						    <table cellpadding="0" cellspacing="0" width="100%" class="table">
							    <tbody>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad167'); ?>:</td>
                                        <td><?php echo $settings['installed']; ?></td>
                                    </tr>
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
						<div class="dr"><span></span></div>
                        <div class="head clearfix">
                            <i class="fa fa-cogs fa-1x"></i><span><?php echo get_lang($lang, 'ad161'); ?></span>
                            <ul class="buttons">
                                <li class="tip-" title="<?php echo get_lang($lang, 'Edit'); ?>">
                                    <a href="settings_edit_advanced.php?lang=<?=$lang?>" class="isw-edit"></a>
                                </li>
                            </ul>  
                        </div>
                        <div class="block-fluid">
						    <table cellpadding="0" cellspacing="0" width="100%" class="table">
							    <tbody>       
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad162'); ?>:</td>
                                        <td><?php echo $settings['base']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad163'); ?>:</td>
                                        <td><?php echo $settings['sub_dir']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad164'); ?>:</td>
										<td><?php echo get_lang($settings['init_lang'], 'msg_001'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad165'); ?>:</td>
                                        <td><?php echo ucfirst($settings['site_theme']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad166'); ?>:</td>
                                        <td><?php echo $settings['status']; ?></td>
                                    </tr>
                                </tbody>
                            </table>                       
                        </div>
						<div class="dr"><span></span></div>
                        <div class="head clearfix">
                            <i class="fa fa-envelope fa-1x"></i><span><?php echo get_lang($lang, 'ad168'); ?></span>
                            <ul class="buttons">
                                <li class="tip-" title="<?php echo get_lang($lang, 'Edit'); ?>">
                                    <a href="settings_edit_smtp.php?lang=<?=$lang?>" class="isw-edit"></a>
                                </li>
                            </ul>  
                        </div>
                        <div class="block-fluid">
						    <table cellpadding="0" cellspacing="0" width="100%" class="table">
							    <tbody>       
                                    <tr>
                                        <td class="tar">SMTP <?php echo get_lang($lang, 'inter67'); ?>:</td>
                                        <td><?php echo $settings['smtp_mail']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar">SMTP <?php echo get_lang($lang, 'Username'); ?>:</td>
                                        <td><?php echo $settings['smtp_username']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar">SMTP <?php echo get_lang($lang, 'Password'); ?>:</td>
										<td>&curren;&curren;&curren;&curren;&curren;&curren;&curren;&curren;&curren;&curren;&curren;</td>
                                    </tr>
                                    <tr>
                                        <td class="tar">SMTP <?php echo get_lang($lang, 'inter93'); ?>:</td>
                                        <td><?php echo $settings['smtp_server']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="tar">SMTP <?php echo get_lang($lang, 'Port'); ?>:</td>
                                        <td><?php echo $settings['smtp_port']; ?></td>
                                    </tr>
                                </tbody>
                            </table>                       
                        </div>
						<div class="dr"><span></span></div>		
                        <div class="head clearfix">
                            <i class="fa fa-asterisk fa-1x"></i><span><?php echo get_lang($lang, 'ad194'); ?></span>
                            <ul class="buttons">
                                <li class="tip-" title="<?php echo get_lang($lang, 'Edit'); ?>">
                                    <a href="settings_edit_global.php?lang=<?=$lang?>" class="isw-edit"></a>
                                </li>
                            </ul>  
                        </div>
                        <div class="block-fluid">
						    <table cellpadding="0" cellspacing="0" width="100%" class="table">
							    <tbody>
                                    <tr>
                                        <td class="tar"><?php echo get_lang($lang, 'ad195'); ?>:</td>
                                        <td>
										    <?php echo $global_settings['work_s_h'].":".$global_settings['work_s_m']." - ".
											           $global_settings['work_e_h'].":".$global_settings['work_e_m']; ?>
										</td>
                                    </tr>
									<tr>
									    <td class="tar"><?php echo get_lang($lang, 'ad224'); ?>:</td>
                                        <td>
										    <?php echo $global_settings['system_addresses']; ?>
										</td>
									</tr>
									<tr>
									    <td class="tar"><?php echo get_lang($lang, 'ad236'); ?>:</td>
                                        <td>
										    <?php echo $global_settings['track_days']; ?>
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
	<script type="text/javascript" charset="utf-8">
$(function() {
$('#img_logo').change(function() {
    if($("#img_logo").val().length > 0) {
       $('#save_img').removeAttr('disabled');
    } else {
       $('#save_img').attr('disabled', true);
    }
});
});
	</script>
</body>
</html>
