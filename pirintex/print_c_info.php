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
$id = mysql_prep($_GET['id']);
$line = mysql_prep($_GET['line']);
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
                <h1><?php echo get_lang($lang, 'info1'); ?></h1>
            </div> 
            <div class="workplace">     
                <div class="row-fluid">
                    <div class="span12">
                        <div class="zone">
<?php
get_controller($lang,$inv,$line);
$i_inv = $controller_data['inv'];
$i_main_line = $controller_data['main_line'];
$i_line = $controller_data['line'];
$i_date = $controller_data['date'];
$i_mark = $controller_data['mark'];
$i_type = $controller_data['type'];
$i_desc = $controller_data['desc'];
$i_machine = $controller_data['machine'];
$i_serial = $controller_data['serial'];
$i_cmode = $controller_data['cmode'];
$i_t1 = $controller_data['t1'];
$i_t2 = $controller_data['t2'];
$i_t3 = $controller_data['t3'];
$i_t4 = $controller_data['t4'];
$i_t5 = $controller_data['t5'];
$i_t6 = $controller_data['t6'];
$i_org = $controller_data['org'];
$i_plant = $controller_data['plant'];
$i_floor = $controller_data['floor'];
$i_group_number = $controller_data['group_number'];
$i_group_name = $controller_data['group_name'];
$i_oper = $controller_data['oper'];
$i_tl1 = $controller_data['tl1'];
$i_tl2 = $controller_data['tl2'];
$i_tl3 = $controller_data['tl3'];
$i_tl4 = $controller_data['tl4'];
$i_tl5 = $controller_data['tl5'];
$i_tl6 = $controller_data['tl6'];
$i_vizor = $controller_data['vizor'];
$i_mobile = $controller_data['mobile'];
echo "<table cellpadding='0' cellspacing='0' class='table'>
      <tr><th style='text-align:center;' colspan='2'>".$i_main_line." \ ".get_lang($lang, 'Controller')." ". $i_inv . "</th></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info3').":</td><td class='x70'>".$i_inv."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info4').":</td><td class='x70'>".$i_main_line."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info5').":</td><td class='x70'>".$i_line."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info6').":</td><td class='x70'>".$i_date."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info7').":</td><td class='x70'>".$i_mark."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info8').":</td><td class='x70'>".$i_type."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info9').":</td><td class='x70'>".$i_desc."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info10').":</td><td class='x70'>".$i_machine."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info11').":</td><td class='x70'>".$i_serial."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info12').":</td><td class='x70'>".$i_cmode."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info13').":</td><td class='x70'>".$i_t1."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info14').":</td><td class='x70'>".$i_t2."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info15').":</td><td class='x70'>".$i_t3."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info16').":</td><td class='x70'>".$i_t4."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info17').":</td><td class='x70'>".$i_t5."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info18').":</td><td class='x70'>".$i_t6."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info24').":</td><td class='x70'>".$i_tl1."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info25').":</td><td class='x70'>".$i_tl2."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info26').":</td><td class='x70'>".$i_tl3."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info27').":</td><td class='x70'>".$i_tl4."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info28').":</td><td class='x70'>".$i_tl5."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info29').":</td><td class='x70'>".$i_tl6."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info19').":</td><td class='x70'>".$i_org."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info20').":</td><td class='x70'>".$i_plant."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info21').":</td><td class='x70'>".$i_floor."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info22').":</td><td class='x70'>".$i_group_number."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info32').":</td><td class='x70'>".$i_group_name."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info23').":</td><td class='x70'>".$i_oper."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info30').":</td><td class='x70'>".$i_vizor."</td></tr>
	  <tr class='i'><td class='x30' style='text-align:right;font-weight:700;'>".get_lang($lang, 'info31').":</td><td class='x70'>".$i_mobile."</td></tr>
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