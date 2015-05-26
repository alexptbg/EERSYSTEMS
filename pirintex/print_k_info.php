<!DOCTYPE html>
<html lang="en">
<?php
//error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$inv = mysql_prep($_GET['inv']);
$krouter = mysql_prep($_GET['kline']);
$krouter_options = get_krouter_options($krouter);
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
    <link rel='stylesheet' type='text/css' href='css/fullcalendar.print.css' media='print' />
    <script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
    <script type='text/javascript' src='js/jquery-ui.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery.mousewheel.min.js'></script>
    <script type='text/javascript' src='js/plugins/cookie/jquery.cookies.2.2.0.min.js'></script>
    <script type='text/javascript' src='js/plugins/bootstrap.min.js'></script>
    <script type='text/javascript' src='js/plugins/sparklines/jquery.sparkline.min.js'></script>
    <script type='text/javascript' src='js/plugins/fullcalendar/fullcalendar.min.js'></script>
    <script type='text/javascript' src='js/plugins/select2/select2.min.js'></script>
    <script type='text/javascript' src='js/plugins/uniform/uniform.js'></script>
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    <script type='text/javascript' src='js/plugins/validation/languages/jquery.validationEngine-en.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/jquery.validationEngine.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js'></script>
    <script type='text/javascript' src='js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js'></script>
    <script type='text/javascript' src='js/plugins/cleditor/jquery.cleditor.js'></script>
    <script type='text/javascript' src='js/plugins/dataTables/jquery.dataTables.min.js'></script>    
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js'></script>
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
	<script type='text/javascript' src='js/print.js'></script>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
        <div class="print pt20">
            <div class="page-header">
                <h1><?php echo get_lang($lang, 'ad322'); ?></h1>
            </div> 
            <div class="workplace">     
                <div class="row-fluid">
                    <div class="span12">
                        <div class="zone">
    <?php
    $klima_data = get_klima_data($inv,$krouter);
    echo "
	<table cellpadding='0' cellspacing='0' class='table'>
      <tr><th style='text-align:center;' colspan='2'>".$krouter." \ ".$klima_data['inv']."</th></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info3').":</td><td class='x70'>".$klima_data['inv']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'ad302').":</td><td class='x70'>".$klima_data['router']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info4').":</td><td class='x70'>".$klima_data['main_line']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info5').":</td><td class='x70'>".$klima_data['line']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info6').":</td><td class='x70'>".$klima_data['date']."</td></tr>
	  <tr><td class='x30 tar b'>RTU:</td><td class='x70'>".$klima_data['rtu']."</td></tr>
	  <tr><td class='x30 tar b'>ADDR:</td><td class='x70'>".$klima_data['addr']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'ad314').":</td><td class='x70'>".$klima_data['where']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'Name').":</td><td class='x70'>".$klima_data['name']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info9').":</td><td class='x70'>".$klima_data['desc']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info19').":</td><td class='x70'>".$klima_data['org']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info20').":</td><td class='x70'>".$klima_data['plant']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info21').":</td><td class='x70'>".$klima_data['floor']."</td></tr>
	</table>";
	?>
                        </div>
						<div class="fr">
						    <button id="print" class="btn btn-large" type="button">
							    <i class="fa fa-print"></i> <?php echo get_lang($lang, 'Print'); ?>
							</button>
							<button id="close" class="btn btn-large" type="button">
							    <i class="fa fa-times"></i> <?php echo get_lang($lang, 'Close'); ?>
							</button>
						</div>
                    </div>
				</div>
            </div>
		</div>
	</div>
</body>
</html>