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
$myusername=base64_encode(mysql_prep($_POST['username']));
$myemail=base64_encode(mysql_prep($_POST['email']));
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
	<script type='text/javascript' src='js/easing.js' charset='utf-8'></script>
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
</head>
<body>          
    <div class="loginBlock" id="login" style="display: block;">
        <h1><?=$company_name?> &curren; <?=$company_slogan?></h1>
		<h2><?php echo get_lang($lang, 'inter61'); ?></h2>
        <div class="dr"><span></span></div>
		<h2><?php echo get_lang($lang, 'inter127'); ?></h2>
		<div class="dr"><span></span></div>
        <div class="loginForm">
		    <div class="row-fluid">
			    <div class="span12">
				    <div class="w94">
<?php
if (($myusername != NULL) && ($myemail != NULL)){
  $user_settings = check_user_settings($myusername);
  if (($user_settings['status'] == 'Active') && $user_settings['level']>1) {
  	$e = base64_decode($myemail);
	if (($e == $user_settings['email']) || ($e == $user_settings['s_email'])) {
	    $name = $user_settings['first_name']. " " .$user_settings['last_name'];
	    $username = $user_settings['user_name'];
	    $random_pass = update_random_password($lang,$username);
        if ($random_pass != FALSE) {
            $from=$smtp_mail;
            $namefrom=$smtp_name;
            $to = $e;
            $nameto = $name;
            $subject = get_lang($lang,'inter127');
            $message = "
            <h2><font color='red'>".$company_name." &curren; ". $company_slogan."</font></h2>
		    <h3><font color='red'>".$site_name."</font></h3>
            <h4>". get_lang($lang, 'Hello').", ".$name.".</h4>
            <p>". get_lang($lang, 'inter137').":</p>
            <p>". get_lang($lang, 'inter133').":</p>
            <p>". get_lang($lang, 'Username').": <strong>".$user_settings['user_name']."</strong></p>
            <p>". get_lang($lang, 'Password').": <strong>".$random_pass."</strong></p>
            <p>". get_lang($lang, 'Status').": ".$user_settings['status']."</p>
            <p>". get_lang($lang, 'inter134').": ".$user_settings['level']."</p>
            <p>". get_lang($lang, 'inter135').": ".$user_settings['last_login']."</p>
            <p>". get_lang($lang, 'inter138').".</p>
            ";
	        echo "<h5>". get_lang($lang, 'Hello').", ".$name."</h5>";
            if (authgMail($lang,$from,$namefrom,$to,$nameto,$subject,$message,$smtp_server,$smtp_port,$smtp_username,$smtp_password)) {
		        echo "<h5><strong><span class='text-success'>".get_lang($lang,'inter131')."</span></strong></h5>
			          <h5><strong><span class='text-info'>".get_lang($lang,'2004')."</span></strong></h5>
		              <p><span class='text-info'>".get_lang($lang,'inter132')."</span></p>";
				      $url = "login.php?lang=".$lang;
				      redir($url,'3');
            } else {
  	            echo "<h5><strong><span class='text-error'>".get_lang($lang,'1016')."</span></strong></h5>";
  	            echo "<h5><strong><span class='text-warning'>".get_lang($lang,'inter136')."</span></strong></h5>";	
			}		
        } else {
            echo "<h5><strong><span class='text-error'>".get_lang($lang,'1018')."</span></strong></h5>"; //error generating random password
		    echo "<h5><strong><span class='text-warning'>".get_lang($lang,'inter136')."</span></strong></h5>";
		}
    } else {
        echo "<h5><strong><span class='text-error'>".get_lang($lang,'1017')."</span></strong></h5>"; //email doesnt exists
	}
  } else {
	echo "<h5><strong><span class='text-error'>".get_lang($lang,'1050')." ".get_lang($lang,'1051')."</span></strong></h5>"; //level not permitted
  }
} else {
    echo "<h5><strong><span class='text-error'>".get_lang($lang,'1000')."</span></strong></h5>";//error submiting
}
?>
                    </div>
                </div>
            </div>
            <div class="dr"><span></span></div>
            <div class="controls">
                <div class="row-fluid">                    
                    <div class="span12">
						<button class="fl btn btn-default" type="button" onClick="javascript: history.go(-1); return false;">
							<i class="fa fa-arrow-left"></i>&nbsp; <?php echo get_lang($lang, 'Back'); ?>
						</button>
						<button id="close" class="fr btn btn-default" type="button" onClick="window.close(); return false;">
							<i class="fa fa-times"></i>&nbsp; <?php echo get_lang($lang, 'Close'); ?>
						</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>