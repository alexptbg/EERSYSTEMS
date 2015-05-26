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
$lines = get_line_options($line);
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
    <script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
    <script type='text/javascript' src='js/jquery-ui.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery.mousewheel.min.js'></script>
    <script type='text/javascript' src='js/plugins/cookie/jquery.cookies.2.2.0.min.js'></script>
    <script type='text/javascript' src='js/plugins/bootstrap.min.js'></script>
    <script type='text/javascript' src='js/plugins/sparklines/jquery.sparkline.min.js'></script>
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
                <h1><?php echo get_lang($lang, 'info5') ." ". $line; ?></h1>
            </div> 
            <div class="workplace">     
                <div class="row-fluid">
                    <div class="span12">
                        <div class="zone">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table lines">
							    <tbody>
                                    <tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'inter71'); ?>:</td>
                                        <td class="x60"><?php echo $lines['id']; ?>&nbsp;</td>
									</tr>
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad35'); ?>:</td>
                                        <td class="x60"><?php echo $lines['line_name']; ?>&nbsp;</td>
									</tr>
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad36'); ?>:</td>
                                        <td class="x60"><?php echo $lines['line_sname']; ?>&nbsp;</td>
									</tr>
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad37'); ?>:</td>
                                        <td class="x60"><?php echo $lines['data_file']; ?>&nbsp;</td>
									</tr>
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad38'); ?>:</td>
                                        <td class="x60"><?php echo $lines['ip_address']; ?>&nbsp;</td>
									</tr>
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad39'); ?>:</td>
                                        <td class="x60"><?php echo $lines['port']; ?>&nbsp;</td>
									</tr>
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad40'); ?>:</td>
                                        <td class="x60">TR + <?php echo $lines['alarm']; ?> ºC</td>
									</tr>
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad41'); ?>:</td>
                                        <td class="x60">TR + <?php echo $lines['red']; ?> ºC</td>
                                    </tr>                                
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad43'); ?>:</td>
                                        <td class="x60"><?php echo $lines['ex_alarm']; ?>&nbsp;</td>
                                    </tr>                                
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad44'); ?>:</td>
                                        <td class="x60"><?php echo $lines['ex_red']; ?>&nbsp;</td>
                                    </tr>                                
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad45'); ?>:</td>
                                        <td class="x60"><?php echo $lines['ex_table']; ?>&nbsp;</td>
                                    </tr>                                
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'info19'); ?>:</td>
                                        <td class="x60"><?php echo $lines['org']; ?>&nbsp;</td>
                                    </tr>                                
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'info20'); ?>:</td>
                                        <td class="x60"><?php echo $lines['plant']; ?>&nbsp;</td>
                                    </tr>                                
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'info21'); ?>:</td>
                                        <td class="x60"><?php echo $lines['floor']; ?>&nbsp;</td>
                                    </tr>
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad154'); ?>:</td>
                                        <td class="x60">
										<?php
										    if ($lines['lt_s'] == '1') { echo "<span class=\"label label-success\">".get_lang($lang, 'ad06')."</span>"; }
										    else { echo "<span class=\"label label-warning\">".get_lang($lang, 'ad08')."</span>"; }
										?>
										&nbsp;</td>
                                    </tr>
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad155'); ?>:</td>
                                        <td class="x60">
										<?php
										    if ($lines['mod_s'] == '1') { echo "<span class=\"label label-success\">".get_lang($lang, 'ad06')."</span>"; }
										    else { echo "<span class=\"label label-warning\">".get_lang($lang, 'ad08')."</span>"; }
										?>
										&nbsp;</td>
                                    </tr>
									<tr>
                                        <td class="x40" style="text-align:right;font-weight:700;"><?php echo get_lang($lang, 'ad156'); ?>:</td>
                                        <td class="x60">
										<?php
										    if ($lines['time_s'] == '1') { echo "<span class=\"label label-success\">".get_lang($lang, 'ad06')."</span>"; }
										    else { echo "<span class=\"label label-warning\">".get_lang($lang, 'ad08')."</span>"; }
										?>
										&nbsp;</td>
                                    </tr>
								</tbody>                    
                            </table>
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