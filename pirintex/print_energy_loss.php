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
$linex = mysql_prep($_GET['linex']);
$dates = $_GET['dates'];
$datex = $_GET['datex'];
$filter = $_GET['filter'];	
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
                <h1><?php echo get_lang($lang, 'ad178'); ?></h1>
            </div> 
            <div class="workplace">   
<?php
	$line_options = get_line_options($linex);
				echo "
                <div class=\"row-fluid\">
				    <div class=\"span6\">
						<div class=\"block-fluid\">
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
							    <tbody>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'info4').":</td>
                                        <td>".$linex."</td>                                   
                                    </tr>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'ad187').":</td>
                                        <td>".$dates." - ".$datex."</td>                                   
                                    </tr>
								</tbody>
							</table>
						</div>
					</div>
				    <div class=\"span6\">
						<div class=\"block-fluid\">
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
							    <tbody>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'info19').":</td>
                                        <td>".$line_options['org']."</td>                                   
                                    </tr>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'info20')." / ".get_lang($lang, 'info21').":</td>
                                        <td>".$line_options['plant']." / ".$line_options['floor']."</td>                                   
                                    </tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class=\"dr\"><span></span></div>";

	    mysql_query("SET NAMES 'utf8'");
        $query = "SELECT * FROM `reports` WHERE energy>='$filter' order by `energy` desc";
        $result = mysql_query($query);
        confirm_query($result);
        if (mysql_num_rows($result) != 0 ) {
        echo "          
                <div class=\"row-fluid\">
                    <div class=\"span12\">
						<div class=\"block-fluid table-sorting clearfix\">
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\" id=\"reports_t\">
                                <thead>
                                    <tr>
										<th>".get_lang($lang, 'Inv')."</th>
                                        <th>".get_lang($lang, 'info5')."</th>
										<th>".get_lang($lang, 'info22')."</th>
										<th>".get_lang($lang, 'info32')."</th>
										<th>".get_lang($lang, 'Channel')."</th>
										<th>".get_lang($lang, 'ad185')."</th>
										<th>".get_lang($lang, 'ad177')."</th>
										<th>".get_lang($lang, 'ad230')."</th>                             
                                    </tr>
                                </thead>
                                <tbody>
		";
		        while($reports = mysql_fetch_array($result)) {
			echo "
                                    <tr>
                                        <td>".$reports['inv']."</td>
										<td>".$reports['line']."</td>
										<td>".$reports['group_number']."</td>
										<td>".$reports['group_name']."</td>
										<td>".$reports['channel']."</td>
										<td>".number_format($reports['temp'],1)." <em><small>(".$reports['treq'].")</small></em></td>
										<td>".$reports['energy']."</td>   
										<td>".gmdate("H:i:s", $reports['minutes'])."</td>          
                                    </tr>     
			";
			    }
				echo "
                                </tbody>
                            </table>
						</div>
                    </div>				 
                </div>
				<div class=\"dr\"><span></span></div>
                <div class=\"row-fluid\">
                    <div class=\"span5\">
	                    <div class=\"block-fluid\">
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
							    <tbody>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'ad188').":</td>
                                        <td>".sum_energy($filter)."</td>                                   
                                    </tr>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'ad189').":</td>
                                        <td>"; 
										$s = sum_minutes($filter);
										$d = gmdate("z", $s);
										$t = gmdate("H:i:s", $s);
										if ($d < 2) { $l = get_lang($lang, 'inter20'); } else { $l = get_lang($lang, 'inter21'); }
										echo
										$d." ".$l." ".$t."
										</td>                                 
                                    </tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>";
			}
?>
                <div class="row-fluid">
                    <div class="span12">
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