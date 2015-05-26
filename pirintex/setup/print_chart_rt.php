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
check_login($lang,$line,$id,$inv,$web_dir,$sys);
get_line_options($line);
$datafile = "../data/{$line_options['data_file']}";
include("$datafile");
$devz = ${'dev' . $id};
$dz = explode(" ", $devz);
$tr1z = $dz[10];
$tr2z = $dz[11];
$tr3z = $dz[12];
$tr4z = $dz[13];
$tr5z = $dz[14];
$tr6z = $dz[15];
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
    <script type='text/javascript' src='js/plugins/c/highcharts.js'></script>
	<script type='text/javascript' src='js/plugins/c/export.js'></script>
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
	<script type="text/javascript">
		var chart;
		function requestData() {
			$.ajax({
				url: '../live.php?line=<?=$line?>&id=<?=$id?>', 
				success: function(point) {
				    y = eval(point);
                    <?php if($dz[16] != 0) { echo "{
					var series = chart.series[0], shift = series.data.length > 300; }"; } ?>
                    <?php if($dz[17] != 0) { echo "{
					var series = chart.series[1], shift = series.data.length > 300; }"; } ?>
                    <?php if($dz[18] != 0) { echo "{
					var series = chart.series[2], shift = series.data.length > 300; }"; } ?>
                    <?php if($dz[19] != 0) { echo "{
					var series = chart.series[3], shift = series.data.length > 300; }"; } ?>
                    <?php if($dz[20] != 0) { echo "{
					var series = chart.series[4], shift = series.data.length > 300; }"; } ?>
                    <?php if($dz[21] != 0) { echo "{
					var series = chart.series[5], shift = series.data.length > 300; }"; } ?>
                    <?php if($dz[16] != 0) { echo "{
                    chart.series[0].addPoint([y[0], y[1]], true, shift); }"; } ?>
                    <?php if($dz[17] != 0) { echo "{
                    chart.series[1].addPoint([y[0], y[2]], true, shift); }"; } ?>
                    <?php if($dz[18] != 0) { echo "{
                    chart.series[2].addPoint([y[0], y[3]], true, shift); }"; } ?>
                    <?php if($dz[19] != 0) { echo "{
                    chart.series[3].addPoint([y[0], y[4]], true, shift); }"; } ?>
                    <?php if($dz[20] != 0) { echo "{
                    chart.series[4].addPoint([y[0], y[5]], true, shift); }"; } ?>
                    <?php if($dz[21] != 0) { echo "{
                    chart.series[5].addPoint([y[0], y[6]], true, shift); }"; } ?>
					setTimeout(requestData, 1000); },
				cache: false
			});
		}
$(function () {
    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_1',
                type: 'spline',
                marginRight: 20,
                events: {
                    load: function() {
                        requestData()
                    }
                },
				plotShadow: false
            },
            title: {
                text: '<?php echo get_lang($lang, "chart1"); ?>'
            },
			subtitle: {
				text: '<?=$inv?> / <?=$today?>'
			},
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            yAxis: {
                title: {
                    text: '<?php echo get_lang($lang, "Temperature"); ?> (ºC)'
                },
				    min: 0,
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b><?=$inv?> '+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/><?php echo get_lang($lang, "Temperature"); ?> '+
                        Highcharts.numberFormat(this.y, 0) + ' (ºC)';
                }
            },
            plotOptions: {
            series: {
                marker: {
                    enabled: true,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            },
                spline: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            legend: {
                enabled:true
            },
        credits: {
            enabled:true
        },
            exporting: {
                enabled: false
            },
				series: [
                    <?php if($dz[16] != 0) { echo "{ name: 'TK1', step: true, data: [] }"; } ?>
                    <?php if($dz[17] != 0) { echo ",{ name: 'TK2', step: true, data: [] }"; } ?>
                    <?php if($dz[18] != 0) { echo ",{ name: 'TK3', step: true, data: [] }"; } ?>
                    <?php if($dz[19] != 0) { echo ",{ name: 'TK4', step: true, data: [] }"; } ?>
                    <?php if($dz[20] != 0) { echo ",{ name: 'TK5', step: true, data: [] }"; } ?>
                    <?php if($dz[21] != 0) { echo ",{ name: 'TK6', step: true, data: [] }"; } ?>					
				]
        });
    });
});
</script>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
        <div class="print pt20">
            <div class="page-header">
                <h1><?php echo get_lang($lang, 'chart3'); ?> - <small><?=$line?> \ <?=$inv?></small></h1>
            </div> 
            <div class="workplace">                
                <div class="row-fluid">
                    <div class="span12">
                        <div class="zone">
<div id="x">
<table cellpadding="0" cellspacing="0" class="table">
<thead>
<tr>
<?php if ($tr1z>20) { echo "<th><font color='$c_1'>TR1</font></th>"; } ?>
<?php if ($tr2z>20) { echo "<th><font color='$c_2'>TR2</font></th>"; } ?>
<?php if ($tr3z>20) { echo "<th><font color='$c_3'>TR3</font></th>"; } ?>
<?php if ($tr4z>20) { echo "<th><font color='$c_4'>TR4</font></th>"; } ?>
<?php if ($tr5z>20) { echo "<th><font color='$c_5'>TR5</font></th>"; } ?>
<?php if ($tr6z>20) { echo "<th><font color='$c_6'>TR6</font></th>"; } ?>
</tr>
</thead>
<tbody>
<tr>
<?php if ($tr1z>20) { echo "<td><font color='$c_1'>$tr1z</font></td>"; } ?>
<?php if ($tr2z>20) { echo "<td><font color='$c_2'>$tr2z</font></td>"; } ?>
<?php if ($tr3z>20) { echo "<td><font color='$c_3'>$tr3z</font></td>"; } ?>
<?php if ($tr4z>20) { echo "<td><font color='$c_4'>$tr4z</font></td>"; } ?>
<?php if ($tr5z>20) { echo "<td><font color='$c_5'>$tr5z</font></td>"; } ?>
<?php if ($tr6z>20) { echo "<td><font color='$c_6'>$tr6z</font></td>"; } ?>
</tr>
</tbody>
</table>
</div>
                            <div id="chart_1" style="width:100%;height:440px;margin:0 auto;"></div>
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