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
</head>
<body>
    <div class="loginBlock" id="login" style="display: block;">
        <a href="../index.php?lang=<?=$lang?>"><h1><?=$company_name?> &curren; <?=$company_slogan?></h1></a>
		<h2><?php echo get_lang($lang, 'inter61'); ?></h2>
        <div class="dr"><span></span></div>
		<h2><?php echo get_lang($lang, 'inter69'); ?></h2>
		<div class="dr"><span></span></div>
        <div class="loginForm">
            <form class="form-horizontal" action="check.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>" method="POST" id="validation">
                <div class="control-group">
                    <div class="input-prepend">
                      <span class="add-on tipl" title="<?php echo get_lang($lang, 'inter62'); ?>"><span class="icon-user"></span></span>
                      <input name="username" type="text" id="inputUser" placeholder="<?php echo get_lang($lang, 'Username'); ?>" class="validate[required]"/>
                    </div>
                </div>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on tipl" title="<?php echo get_lang($lang, 'inter63'); ?>"><span class="icon-lock"></span></span>
                        <input name="password" type="password" id="inputPassword" placeholder="<?php echo get_lang($lang, 'Password'); ?>" class="validate[required]"/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span8">
                        <div class="control-group">
                            <label class="checkbox"><input type="checkbox"> <?php echo get_lang($lang, 'inter64'); ?></label>
                        </div>                    
                    </div>
                    <div class="span4">
                        <button type="submit" class="btn btn-block"><i class="fa fa-unlock"></i>&nbsp; <?php echo get_lang($lang, 'inter66'); ?></button>
                    </div>
                </div>
            </form>  
            <div class="dr"><span></span></div>
            <div class="controls">
                <div class="row-fluid">
                    <div class="span6">
                        <button class="btn btn-link btn-block" onClick="loginBlock('#forgot');"><?php echo get_lang($lang, 'inter65'); ?>?</button>
                    </div>
                    <div class="span2"></div>
                    <div class="span4"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="loginBlock" id="forgot">
        <a href="../index.php?lang=<?=$lang?>"><h1><?=$company_name?> &curren; <?=$company_slogan?></h1></a>
		<h2><?php echo get_lang($lang, 'inter61'); ?></h2>
        <div class="dr"><span></span></div>
		<h2><?php echo get_lang($lang, 'inter65'); ?>?</h2>
		<div class="dr"><span></span></div>
        <div class="loginForm">
         <form class="form-horizontal" action="request_password.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>" method="POST" id="validation2">
              <p><?php echo get_lang($lang, 'inter68'); ?>.</p>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on tipl" title="<?php echo get_lang($lang, 'inter62'); ?>"><span class="icon-user"></span></span>
                        <input name="username" type="text" id="inputUser" placeholder="<?php echo get_lang($lang, 'Username'); ?>" class="validate[required]"/>
                    </div>                
                </div>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on tipl" title="<?php echo get_lang($lang, 'ad135'); ?>"><span class="icon-envelope"></span></span>
                        <input type="text" name="email" id="email" placeholder="<?php echo get_lang($lang, 'inter67'); ?>" class="validate[required,custom[email]]"/>
                    </div>                
                </div>                
                <div class="row-fluid">
                    <div class="span8"></div>
                    <div class="span4">
                        <button type="submit" class="btn btn-block"><i class="fa fa-share"></i>&nbsp; <?php echo get_lang($lang, 'inter70'); ?></button>
                    </div>
                </div>
            </form>  
            <div class="dr"><span></span></div>
            <div class="controls">
                <div class="row-fluid">                    
                    <div class="span12">
                        <button class="btn btn-link" onClick="loginBlock('#login');">&laquo; <?php echo get_lang($lang, 'Back'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>