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
$kline = mysql_prep($_GET['kline']);
$inv = mysql_prep($_GET['inv']);
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
	<script type='text/javascript' src='js/plugins/c/highstock_old.js'></script>
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
<script type="text/javascript">
	Highcharts.setOptions({
		global : {
			useUTC : false
		}
	});
$(function() {
	$.getJSON('klimatik_data.php?lang=<?=$lang?>&kline=<?=$kline?>&inv=<?=$inv?>', function(data) {
		$('#container').highcharts('StockChart', {
		    chart: {
				spacingTop: 10,
				spacingBottom: 10,
				marginBottom: 60,
            animation: {
                duration: 2000,
                easing: 'easeOutBounce'
            }
		    },
rangeSelector: {
            buttons: [{
                type: 'hour',
                count: 4,
                text: '4H'
            }, {
                type: 'hour',
                count: 8,
                text: '8H'
			}, {
                type: 'hour',
                count: 12,
                text: '12H'
            }, {
                type: 'day',
                count: 1,
                text: '1D'
            }, {
                type: 'day',
                count: 3,
                text: '3D'
            }, {
                type: 'day',
                count: 7,
                text: '7D'
            }, {
                type: 'day',
                count: 15,
                text: '15D'
            }, {
                type: 'month',
                count: 1,
                text: '1M'
            }, {
                type: 'month',
                count: 3,
                text: '3M'
            }, {
                type: 'all',
                text: 'All'
            }],
            selected: 2,
			inputEnabled : false
        },
		    title: {
		        text: '<?php echo get_lang($lang, "inter79"); ?> - <?=$kline?> - <?=$inv?>'
		    },		
      xAxis: {
         title: {
            text: null
         }
      },
      yAxis: {
		 showLastLabel: false,
         title: {
            text: '<?php echo get_lang($lang, "Temperature"); ?> (ºC)'
         },
		 offset: 20/*,
		 max:50*/
      },
        plotOptions: {
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            },
			area: {
				fillOpacity: .75,
				lineWidth:0,
				zIndex:0,
				showInLegend:false,
				enableMouseTracking:false
			},
			spline: {
				zIndex:1
			}
        },
      credits: {
         enabled: false
      },
        legend: {
			enabled: true,
            floating: true,
			borderWidth: 0
        },/*
        tooltip: {
            valueDecimals: 1,
            valueSuffix: ' ºC'
        },*/
		    series: data
		});
	});
});
</script>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
        <div class="print pt20">
            <div class="page-header">
                <h1><?php echo get_lang($lang, 'chart3'); ?></h1>
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