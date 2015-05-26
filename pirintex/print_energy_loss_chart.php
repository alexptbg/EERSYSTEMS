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
$day_n = date('N');
$yesterday = date('Y-m-d', time() - 60 * 60 * 24);
$twodays = date('Y-m-d', time() - 60 * 60 * 48);
if ($day_n == 1) { $day_e = $twodays; $day_b = date('Y-m-d', time() - 60 * 60 * 24); } else { $day_e = $yesterday; $day_b = date('Y-m-d', time()); }
$filter = '0.5';
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
    <script type='text/javascript' src='js/plugins/c/highcharts.js'></script>
    <script type='text/javascript' src='js/plugins/c/export.js'></script>
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
	<script type='text/javascript' charset='utf-8'>
	$(function() {
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]
		        ]
		    };
		});
	});
	</script>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
        <div class="print pt20">
            <div class="page-header">
                <h1><?php echo get_lang($lang, 'ad211'); ?></h1>
            </div> 
            <div class="workplace">   
<?php
                               mysql_query("SET NAMES 'utf8'");
                               $query = "SELECT `line_name` FROM `lines` ORDER BY `line_name` ASC";
                               $result = mysql_query($query);
                               confirm_query($result);
                               $num_rows = mysql_num_rows($result);
                               if ($num_rows != 0) {
							       while ($lines = mysql_fetch_array($result)) {
									   $lines_append[] = $lines['line_name'];
								   }
				echo "
                <div class=\"row-fluid\">
				    <div class=\"span12\">
						<div class=\"block-fluid\">
<script type='text/javascript' charset='UTF-8'>
$(function () {
        $('#ene').highcharts({
            chart: {
                type: 'column',
                animation: {
                    duration: 1500,
                    easing: 'easeOutBounce'
                }
            },
            title: {
                text: '".get_lang($lang, 'ad177')."'
            },
            subtitle: {
                text: '".$day_e."'
            },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
            xAxis: {
                categories: [";
				foreach ($lines_append as $line_e) {
					echo "'$line_e',";
				}
             echo "   ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                }
            },
            tooltip: {
                headerFormat: '<span style=\"font-size:11px\">{point.key}</span><table>',
                pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
                    '<td style=\"padding:0\"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
                series: {
                    animation: {
                        duration: 2000,
                        easing: 'easeOutBounce'
                    }
                }
            },
            series: [";
	foreach ($lines_append as $line_e) {
		energo_loss_t($line_e,$day_e,$day_e);
	    mysql_query("SET NAMES 'utf8'");
        $query = "SELECT * FROM `reports` WHERE energy>='$filter' order by `energy` desc";
        $result = mysql_query($query);
        confirm_query($result);
        $e_[] = sum_energy($filter);
	    $m_[] = sum_min($filter);
    }
			$energy_ = implode(',',$e_);
			$minutes_ = implode(',',$m_);			
            echo "{
                name: '".get_lang($lang, 'ad188')."',
                data: [".$energy_."]
    
            },{
                name: '".get_lang($lang, 'ad186')."',
                data: [".$minutes_."]
    
            }]
        });
    });
    </script>
	<div id=\"ene\" style=\"width: 100%; height: 460px; margin: 0 auto;\"></div>
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