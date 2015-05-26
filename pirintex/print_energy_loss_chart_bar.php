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
                <h1><?php echo get_lang($lang, 'ad212'); ?></h1>
            </div> 
            <div class="workplace">   
<?php
	    mysql_query("SET NAMES 'utf8'");
        $query_2 = "SELECT * FROM `reports` WHERE energy>='$filter' group by `inv` order by `energy` desc";
        $result_2 = mysql_query($query_2);
        confirm_query($result_2);
        if (mysql_num_rows($result_2) != 0 ) {
			while($reports_2 = mysql_fetch_array($result_2)) {
				$ob2[] = $reports_2['inv'];
			}
			echo "
                <div class=\"row-fluid\">
				    <div class=\"span12\">
						<div class=\"block-fluid\">
<script type='text/javascript' charset='UTF-8'>
$(function () {
        $('#ener').highcharts({
            chart: {
                type: 'column',
			spacingTop: 5,
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
            },
            title: {
                text: '".$linex."'
            },
            subtitle: {
                text: '".$dates." - ".$datex."'
            },
            xAxis: {
                categories: [";
				foreach ($ob2 as $ind2) {
					echo "'$ind2',";
				}
			echo "],
                labels: {
                    rotation: -90,
                    align: 'right',
					y: 1,
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
        plotOptions: {
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
        },
            yAxis: {
                min: 0,
                title: {
                    text: '".get_lang($lang, 'ad177')."'
                }
            },
        credits: {
            enabled: false
        },
            legend: {
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        '".get_lang($lang, 'ad177').": '+ Highcharts.numberFormat(this.y, 2);
                }
            },
            series: [{";
		    foreach ($ob2 as $ind2) {
	            mysql_query("SET NAMES 'utf8'");
	            $query2 = "SELECT SUM(energy) FROM reports WHERE energy>='$filter' AND `inv`='$ind2'";
                $rx2 = mysql_query($query2);
                confirm_query($rx2);
                while($row2 = mysql_fetch_array($rx2)){
	                $r2[] = number_format($row2['SUM(energy)'], 2, '.', '');	
	            }
		    }
			$tot = implode(',',$r2);
			echo "data: [".$tot."],";
				echo "
                dataLabels: {
                    enabled: true,
                    align: 'center',
                    x: 0,
                    y: 2,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    });
</script>
<div id=\"ener\" style=\"width: 99%; height: 450px; margin: 0 auto;\"></div>
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