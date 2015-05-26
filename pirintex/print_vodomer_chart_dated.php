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
$line = $_GET['line'];
$inv = $_GET['inv'];
$id = $_GET['id'];
$v_id = $_GET['v_id'];
$dates = $_GET['from'];
$datex = $_GET['to'];
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
	<script type='text/javascript' src='js/plugins/c/highstock.js'></script>
	<script type='text/javascript' src='js/plugins/c/highcharts-more.js'></script>
	<script type='text/javascript' src='js/plugins/c/highcharts.<?=$lang?>.js'></script>
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
<?php
    echo "
<script type=\"text/javascript\">
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
	Highcharts.setOptions({
		global : {
			useUTC : false
		}
	});
$(function() {
	$.getJSON('vodomer_data_dated.php?lang=".$lang."&line=".$line."&inv=".$inv."&id=".$id."&v_id=".$v_id."&from=".$dates."&to=".$datex."', function(data) {
		$('#container').highcharts('StockChart', {
		    chart: {
		        alignTicks: false,
            animation: {
                duration: 2000,
                easing: 'easeOutBounce'
            }
		    },
rangeSelector: {
            enabled : false,
			inputEnabled : false
        },
		    title: {
		        text: '".get_lang($lang, "ad289")."'
		    },
			subtitle: {
				text: '".$line." | ".$inv."-".$v_id."'
			},
            yAxis: {
				labels: {
					format: '{value} м3'
				},
				offset: 50
			},
        plotOptions: {
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                },
	    		marker: {
	    			enabled: true,
					radius: 5
	    		}
            },
                spline: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
        },
        credits: {
            enabled: false
        },
		    series: [{
		        type: 'column',
		        name: '". get_lang($lang, "ad290")."',
				pointInterval: 24 * 3600 * 1000,
		        data: data,
		        dataGrouping: {
					units: [[
						'day',
						[1]
					], [
						'month',
						[1, 2, 3, 4, 6]
					]]
		        }
		    }, {
				type: 'spline',
                data: data,
                color: Highcharts.getOptions().colors[8]
            }]
		});
	});
});	  
</script>";
?>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
        <div class="print pt20">
            <div class="page-header">
                <h1><?php echo get_lang($lang, 'ad289'); ?></h1>
            </div> 
            <div class="workplace">                
                <div class="row-fluid">
                    <div class="span12">
                        <div class="zone">
                            <div id="container" style="width:100%;height:460px;margin:0 auto;"></div>
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