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
$line_options = get_line_options($line);
$img_dir = "../img/controllers/".$line_options['line_sname']."/";
$new_name = $inv.".jpg";
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
                            <i class="fa fa-picture-o fa-1x"></i><span><?php echo get_lang($lang, 'ad200')." ".$line." \ ".$inv; ?></span>
                            <ul class="buttons">
                                <li class="tip_" title="<?php echo get_lang($lang, 'Back'); ?>">
                                    <a href="javascript: history.go(-1);" class="isw-left_circle"></a>
                                </li>
                            </ul>  
                        </div>
<?php
if(isset($_POST['Submit'])) {
	echo "<div class=\"block-fluid\">";
	$size = 150;
	$prefix = 'th_';
	$maxfile = '2000000';
	$mode = '0666';
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$userfile_size = $_FILES['image']['size'];
	$userfile_type = $_FILES['image']['type'];
	if (isset($_FILES['image']['name'])) {
	  if (($userfile_type == "image/jpeg") || ($userfile_type == "image/jpg")) {
		$prod_img = $img_dir.$new_name;
		$prod_img_thumb = $img_dir.$prefix.$new_name;
		move_uploaded_file($userfile_tmp, $prod_img);
		$sizes = getimagesize($prod_img);
		$aspect_ratio = $sizes[1]/$sizes[0]; 
		if ($sizes[1] <= $size) {
			$new_width = $sizes[0];
			$new_height = $sizes[1];
		} else {
			$new_height = $size;
			$new_width = abs($new_height/$aspect_ratio);
		}
		$destimg=ImageCreateTrueColor($new_width,$new_height) or die('Problem In Creating image');
		$srcimg=ImageCreateFromJPEG($prod_img) or die('Problem In opening Source Image');
		if (function_exists('imagecopyresampled')) {
			imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg)) or die('Problem In resizing');
		} else {
			Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg)) or die('Problem In resizing');
		}
		ImageJPEG($destimg,$prod_img_thumb,85) or die('Problem In saving');
		imagedestroy($destimg);
	    echo "<div class='w94 pt10'>";
	    get_success($lang,'2018');
	    echo "<br/></div>";
	    $url = "controllers.php?lang=".$lang."&line=".$line."&inv=".$inv;
	    redir($url,'2');
	  } else {
	echo "<div class='w94 pt10'>";
	get_error($lang,'1040');
	echo "</div><div class='footer'><button class='btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		  <i class='fa fa-arrow-left'></i>&nbsp; ". get_lang($lang, 'Back')."</button></div>";
	  }
	}
} 
else {
	$photo = $img_dir.$inv.".jpg";
    $thumb = $img_dir."th_".$inv.".jpg";
	echo "<div class=\"block\">";
    if (file_exists($photo)) {
        echo "<a class='fancybox' rel='group' href='".$photo."'>
				  <img src='".$thumb."' class='img-polaroid' /></a><p></p>";
    } else {
        echo "<a class='fancybox' rel='group' href='../img/controllers/noimage.png'>
				  <img src='../img/controllers/noimage.png' style='width:100px;height:100px;' class='img-polaroid' /></a><p></p>";
    }      
	echo "
	<form method=\"POST\" action=\"".$self_path."?lang=".$lang."&line=".$line."&inv=".$inv."\" enctype=\"multipart/form-data\">
	    <p><input type=\"file\" name=\"image\" id=\"img\" /></p>";
    if ($user_settings['level'] < 4) {
		echo "
			<span class=\"label label-important\">". get_lang($lang, 'ad136').": 4</span>
            <button type=\"submit\" name=\"Submit\" class=\"btn btn-default\" value=\"Submit\" disabled=\"disabled\" disabled>
			    <i class=\"fa fa-check\"></i>&nbsp; ". get_lang($lang, 'ad138')."</button>";
        if (file_exists($photo)) {
		    echo "
            <button class=\"btn btn-danger\" onClick=\"confirmd('".$line."','".$inv."'); return false;\" disabled=\"disabled\" disabled>
				<span class='icon-trash icon-white'></span>&nbsp;&nbsp;". get_lang($lang, 'ad198')."</button>";
        }
	} else {
		echo "
			<span class=\"label label-success\">". get_lang($lang, 'ad136').": 4</span>
            <button id=\"save_img\" type=\"submit\" name=\"Submit\" class=\"btn btn-default\" value=\"Submit\" disabled=\"disabled\" disabled>
			    <i class=\"fa fa-check\"></i>&nbsp; ". get_lang($lang, 'ad138')."</button>";
        if (file_exists($photo)) {
		    echo "
            <button class=\"btn btn-danger\" onClick=\"confirmd('".$line."','".$inv."'); return false;\">
				<span class='icon-trash icon-white'></span>&nbsp;&nbsp;". get_lang($lang, 'ad198')."</button>";
        }
	}
	echo "</form>";
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
	<script type="text/javascript" charset="utf-8">
function confirmd(line,inv) {
	var answer = confirm('<?php echo get_lang($lang, "ad198"); ?>?');
	if (answer){ photodel(line,inv); }
	else{ alert('<?php echo get_lang($lang, "ad203"); ?>'); }
}
function photodel(line,inv) {
   $.ajax({
   type: "POST",
   url: "controller_photo_del.php?l="+line+"&i="+inv,
   success: function(){
     alert('<?php echo get_lang($lang, "ad204"); ?>');
     var delay = 1000;
     setTimeout(function(){ 
	   window.location.href = 'controller_photo_update.php?lang=<?php echo $lang; ?>&line=<?php echo $line; ?>&inv=<?php echo $inv; ?>'; }, delay);
   }
 });
    return false;
}
$(function() {
$('#img').change(function() {
    if($("#img").val().length > 0) {
       $('#save_img').removeAttr('disabled');
    } else {
       $('#save_img').attr('disabled', true);
    }
});
});
	</script>
</body>
</html>