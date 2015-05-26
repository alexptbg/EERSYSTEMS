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
<?php
$max_width = 180;
$max_height = 180;
$max_size = 65530;
$max_size_upload = 512000;
$msg = get_lang($lang, 'ad139').": ".decodeSize($max_size)." | ".$max_width."x".$max_height."px";
$style = "info";
if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
$usr = $user_settings['user_name'];
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
		
    mysql_query("SET NAMES utf8");
    $length = mysql_query("SELECT OCTET_LENGTH(img) FROM `profile_img` WHERE `user`='$usr'");
    $found = mysql_fetch_array($length);

    if ($found > 0) {
		$query = "UPDATE `profile_img` SET `user`='$usr', `img`='$data', `type`='$fileType' WHERE `user`='$usr'";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
            $msg = get_lang($lang, 'ad140'). " ".decodeSize(filesize($dest));
			insert_log($lang,$user_settings['user_name'],'info','ad143',decodeSize(filesize($dest)));
			$style = "success";
			unlink($dest);
				//$url = "my_profile.php?lang=".$lang;
				//redir($url,'2');
    } else {
        $msg = get_lang($lang, '1033');
		$style = "error";
    }
    } else {
        $query = "INSERT INTO `profile_img` (`user`, `img`, `type`) VALUES ('$usr', '$data', '$fileType')";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
		    $msg = get_lang($lang, 'ad141'). " ".decodeSize(filesize($dest));
			insert_log($lang,$user_settings['user_name'],'info','ad144',decodeSize(filesize($dest)));
			$style = "success";
			unlink($dest);
				//$url = "my_profile.php?lang=".$lang;
				//redir($url,'2');
        } else {
	        $msg = get_lang($lang, '1033');
			$style = "error";
		}
}
    }
}
else {
	$msg = get_lang($lang, '1033');
	$style = "error";
}
}
if(isset($_POST['submit_u'])) {
    $e_user_name = mysql_prep($_POST['user_name']);
    $e_first_name = mysql_prep($_POST['first_name']);
    $e_last_name = mysql_prep($_POST['last_name']);
    $e_email = mysql_prep($_POST['email']);
    $e_s_email = mysql_prep($_POST['s_email']);
    $e_phone = mysql_prep($_POST['phone']);
    $e_info = mysql_prep($_POST['info']);	
		if ($e_user_name == mysql_prep($_POST['user_name'])) {
			mysql_query("SET NAMES utf8");
			$query = "UPDATE `users` SET `user_name`='$e_user_name', `first_name`='$e_first_name', `last_name`='$e_last_name', `email`='$e_email', `s_email`='$e_s_email', `phone`='$e_phone', `info`='$e_info' WHERE `user_name`='$e_user_name'";
            $result = mysql_query($query);
            confirm_query($result);
            if ($result) {
				insert_log($lang,$user_settings['user_name'],'info','ad145',$e_user_name);
				$msg2 = get_lang($lang, 'ad146');
				$style2 = "success";
				//$url = "my_edit.php?lang=".$lang;
				//redir($url,'2');
            } else {
				$msg2 = get_lang($lang, 'ad147');
                $style2 = "error";
            }
		} 
		else {
			$msg2 = get_lang($lang, '1000');
            $style2 = "error";
		}
}
                echo "
                    <div class=\"span5\">
                        <div class=\"ushort clearfix\">
                            <h2>".$user_settings['user_name']."</h2>
                            <div class=\"image\">
                                <img src=\"image.php?username=".$user_settings['user_name']."\" class=\"img-polaroid\" />                        
                            </div>
							<form method=\"post\" action=\"".$self_path."?lang=".$lang."\" enctype=\"multipart/form-data\">
                                <p><input type=\"file\" name=\"image\" /></p>";
						if ($user_settings['level'] < 2) {
							echo "<span class=\"fl label label-important\">". get_lang($lang, 'ad136').": 2</span>
                      <button class=\"btn btn-danger\" onClick=\"confirmd('".$user_settings['user_name']."'); return false;\" disabled=\"disabled\" disabled>
					      <span class=\"icon-trash icon-white\"></span>&nbsp;&nbsp;". get_lang($lang, 'ad198')."</button>
                      <button id=\"save_img\" type=\"submit\" name=\"submit\" class=\"btn btn-default\" value=\"save_img\" disabled=\"disabled\" disabled>
						  <i class=\"fa fa-check\"></i>&nbsp; ". get_lang($lang, 'ad138')."</button>";
						} else {
							echo "<span class=\"fl label label-success\">". get_lang($lang, 'ad136').": 2</span>
                      <button class=\"btn btn-danger\" onClick=\"confirmd('".$user_settings['user_name']."'); return false;\">
					      <span class=\"icon-trash icon-white\"></span>&nbsp;&nbsp;". get_lang($lang, 'ad198')."</button>
                      <button id=\"save_img\" type=\"submit\" name=\"submit\" class=\"btn btn-default\" value=\"save_img\">
						  <i class=\"fa fa-check\"></i>&nbsp; ". get_lang($lang, 'ad138')."</button>";
						}
						echo "<p class=\"text-".$style."\">".$msg."</p></form>";
                        echo "</div>
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-key fa-1x\"></i><span> ".get_lang($lang, 'ad55')."</span>
                        </div>
						<div class=\"block-fluid\">
						  <form action=\"#\" method=\"post\" id=\"validation\">                          
                            <div class=\"row-form clearfix\">
                                <div class=\"span4\">". get_lang($lang, 'Password')."</div>
                                <div class=\"span8\">
								    <input id=\"password\" type=\"password\" name=\"password\" class=\"validate[required,minSize[4]]\" value=\"\" /></div>
                            </div>
                            <div class=\"row-form clearfix\">
                                <div class=\"span4\">". get_lang($lang, 'ad12')."</div>
                                <div class=\"span8\">
								    <input id=\"repassword\" type=\"password\" name=\"repassword\" class=\"validate[required,equals[password]]\" value=\"\" /></div>
                            </div>                        
                            <div class=\"toolbar clear clearfix\">";
								if ($user_settings['level'] < 2) {
									echo "<span class=\"fl label label-important\">". get_lang($lang, 'ad136').": 2</span>";
								} else {
                                    echo "<span class=\"fl label label-success\">". get_lang($lang, 'ad136').": 2</span>";
								}
								echo "<div class=\"right\">";
								if ($user_settings['level'] < 2) {
									echo "
                             <button id=\"update\" type=\"submit\" name=\"submit\" class=\"btn btn-warning\" value=\"submit\" disabled=\"disabled\" disabled>
								        <i class=\"fa fa-check\"></i>&nbsp; ". get_lang($lang, 'inter126')."</button>";
								} else {
									echo "
                                    <button id=\"update\" type=\"submit\" name=\"submit\" class=\"btn btn-warning\" value=\"submit\">
								        <i class=\"fa fa-check\"></i>&nbsp; ". get_lang($lang, 'inter126')."</button>";
								}
								echo "</div>
                            </div> 
						  </form>                        
                        </div>
                    </div>
                  <div class=\"span7\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-edit fa-1x\"></i><span> ".get_lang($lang, 'ad142')."</span>
                        </div>
						<div class=\"block-fluid\">                              
             <form action=\"".$self_path."?lang=".$lang."\" method=\"post\" id=\"validation2\">";
			echo "
               <div class=\"row-form clearfix\">
                 <div class=\"span4 tar\">". get_lang($lang, 'Username').":</div>
                 <div class=\"span8\">
				 <input name=\"user_name\" type=\"text\" readonly=\"readonly\" value=\"".$user_settings['user_name']."\" /></div>
               </div>";
	    echo "
               <div class=\"row-form clearfix\">
                 <div class=\"span4 tar\">". get_lang($lang, 'ad03').":</div>
                 <div class=\"span8\">
				 <input name=\"first_name\" type=\"text\" class=\"validate[required]\" value=\"".$user_settings['first_name']."\" MAXLENGTH=\"32\" /></div>
               </div>
               <div class=\"row-form clearfix\">
                 <div class=\"span4 tar\">".get_lang($lang, 'ad04').":</div>
                 <div class=\"span8\">
				 <input name=\"last_name\" type=\"text\" class=\"validate[required]\" value=\"".$user_settings['last_name']."\" MAXLENGTH=\"32\" /></div>
               </div>
               <div class=\"row-form clearfix\">
                 <div class=\"span4 tar\">".get_lang($lang, 'ad13').":</div>
                 <div class=\"span8\">
				 <input name=\"email\" type=\"text\" class=\"validate[required,custom[email]]\" value=\"".$user_settings['email']."\" MAXLENGTH=\"64\" /></div>
               </div>
               <div class=\"row-form clearfix\">
                 <div class=\"span4 tar\">".get_lang($lang, 'ad14').":</div>
                 <div class=\"span8\"><input name=\"s_email\" type=\"text\" value=\"".$user_settings['s_email']."\" MAXLENGTH=\"64\" /></div>
               </div>
               <div class=\"row-form clearfix\">
                 <div class=\"span4 tar\">".get_lang($lang, 'ad23').":</div>
                 <div class=\"span8\">
				 <input name=\"phone\" type=\"text\" value=\"".$user_settings['phone']."\" MAXLENGTH=\"32\" /></div>
               </div>
               <div class=\"row-form clearfix\">
                 <div class=\"span4 tar\">".get_lang($lang, 'ad24').":</div>
                 <div class=\"span8\">
				 <input name=\"info\" type=\"text\" value=\"".$user_settings['info']."\" MAXLENGTH=\"64\" /></div>
               </div>
               <div class=\"footer\">
			   <p class=\"fl text-".$style2."\">".$msg2."</p>";
			   if ($user_settings['level'] < 2) {
				   echo "<span class=\"fl label label-important\">". get_lang($lang, 'ad136').": 2</span>
				   <button class=\"btn btn-default\" type=\"submit\" name=\"submit_u\" disabled=\"disabled\" disabled>
		                            <i class=\"fa fa-check\"></i>&nbsp; ".get_lang($lang, 'inter126')."</button>";
			   } else {
			       echo "<span class=\"fl label label-success\">". get_lang($lang, 'ad136').": 2</span>
				   <button class=\"btn btn-default\" type=\"submit\" name=\"submit_u\">
		                            <i class=\"fa fa-check\"></i>&nbsp; ".get_lang($lang, 'inter126')."</button>";
			   }
              echo "</div></form></div>";
              ?>
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
function confirmd(username) {
	var answer = confirm('<?php echo get_lang($lang, "ad198"); ?>?');
	if (answer){ photodel(username); }
	else{ alert('<?php echo get_lang($lang, "ad203"); ?>'); }
}
function photodel(username) {
   $.ajax({
   type: "POST",
   url: "my_photo_del.php?u="+username,
   success: function(){
     alert('<?php echo get_lang($lang, "ad204"); ?>');
     var delay = 1000;
     setTimeout(function(){ window.location.href = 'my_edit.php'; }, delay);
   }
 });
    return false;
}
$(function() {
    $("#update").click(function() {
	  var password = $("input#password").val();
	  if (password == "") { $("input#password").focus(); return false; }
	  var repassword = $("input#repassword").val();
	  if (repassword == "") { $("input#repassword").focus(); return false; }
	  if (password == repassword) {
	  var dataString = '?p1='+ password + '&p2=' + repassword;
	$.ajax({
      type: "POST",
      url: "my_password.php"+dataString,
      success: function() {
	  	$('#update').removeClass('btn-warning');
		$('#update').addClass('btn-default');
		$('#update').attr('disabled', true);
		$("input#password").val('');
		$("input#repassword").val('');
        alert('<?php echo get_lang($lang, '2010'); ?>');
      }
     });
    return false;
	  } else {
	      return false;	
	  }
    });
});
	</script>
</body>
</html>
