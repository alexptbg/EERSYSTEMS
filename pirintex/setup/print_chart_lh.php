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
$inv = $_GET['inv'];
$id = $_GET['id'];
$line = $_GET['line'];
get_line_options($line);
$datafile = "../data/{$line_options['data_file']}";
include("$datafile");
$dev = ${'dev' . $id};
$d = explode(" ", $dev);
$tr1 = $d[10];
$tr2 = $d[11];
$tr3 = $d[12];
$tr4 = $d[13];
$tr5 = $d[14];
$tr6 = $d[15];
$datafile2 = "../data/{$line_options['line_sname']}/$inv.txt";
include("$datafile2");
$tk1d = explode(" ", $tk1);
$tk2d = explode(" ", $tk2);
$tk3d = explode(" ", $tk3);
$tk4d = explode(" ", $tk4);
$tk5d = explode(" ", $tk5);
$tk6d = explode(" ", $tk6);
$r = explode(":", $range);
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
		<script type="text/javascript" charset="UTF-8">
$(function () {
    var chart2;
    $(document).ready(function() {
        chart2 = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_2',
                type: 'spline',
                marginRight: 70,
				plotShadow: false
            },
            title: {
                text: '<?php echo get_lang($lang, "chart4"); ?> - <?=$inv?>',
                x: -20
            },
            subtitle: {
                text: '<?=$range?> - <?=$today?>',
                x: -20
            },
      xAxis: {
         categories: ['00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '60'],
         title: {
            text: '<?php echo get_lang($lang, "Minutes"); ?>'
         }		 
      },
            yAxis: {
                title: {
                    text: '<?php echo get_lang($lang, "Temperature"); ?> (�C)'
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
                        this.x +': '+ this.y +'�C';
                }
            },
            plotOptions: {
            series: {
                spline: {
                    dataLabels: {
                        enabled: false
                    },
                    enableMouseTracking: true
                }
            }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            exporting: {
                enabled: true,
                buttons: {
                    printButton: {
                        enabled: false
                    },
					exportButton: {
						enabled: true
					}
                },
				filename: '<?=$today?>_<?=$line?>_<?=$inv?>'
            },
      series: [
      <?php if($tk1d[0] != 0) { echo "{
         name: 'TK1',
         data: [$tk1d[0], $tk1d[1], $tk1d[2], $tk1d[3], $tk1d[4], $tk1d[5], $tk1d[6], $tk1d[7], $tk1d[8], $tk1d[9], $tk1d[10], $tk1d[11], $tk1d[12]]
      }"; } ?>
      <?php if($tk2d[0] != 0) { echo ",{
         name: 'TK2',
         data: [$tk2d[0], $tk2d[1], $tk2d[2], $tk2d[3], $tk2d[4], $tk2d[5], $tk2d[6], $tk2d[7], $tk2d[8], $tk2d[9], $tk2d[10], $tk2d[11], $tk2d[12]]
      }"; } ?>
      <?php if($tk3d[0] != 0) { echo ",{
         name: 'TK3',
         data: [$tk3d[0], $tk3d[1], $tk3d[2], $tk3d[3], $tk3d[4], $tk3d[5], $tk3d[6], $tk3d[7], $tk3d[8], $tk3d[9], $tk3d[10], $tk3d[11], $tk3d[12]]
      }"; } ?>
      <?php if($tk4d[0] != 0) { echo ",{
         name: 'TK4',
         data: [$tk4d[0], $tk4d[1], $tk4d[2], $tk4d[3], $tk4d[4], $tk4d[5], $tk4d[6], $tk4d[7], $tk4d[8], $tk4d[9], $tk4d[10], $tk4d[11], $tk4d[12]]
      }"; } ?>
      <?php if($tk5d[0] != 0) { echo ",{
         name: 'TK5',
         data: [$tk5d[0], $tk5d[1], $tk5d[2], $tk5d[3], $tk5d[4], $tk5d[5], $tk5d[6], $tk5d[7], $tk5d[8], $tk5d[9], $tk5d[10], $tk5d[11], $tk5d[12]]
      }"; } ?>
      <?php if($tk6d[0] != 0) { echo ",{
         name: 'TK6',
         data: [$tk6d[0], $tk6d[1], $tk6d[2], $tk6d[3], $tk6d[4], $tk6d[5], $tk6d[6], $tk6d[7], $tk6d[8], $tk6d[9], $tk6d[10], $tk6d[11], $tk6d[12]]
      }"; } ?>
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
                <h1><?php echo get_lang($lang, 'chart5'); ?> - <small><?=$line?> \ <?=$inv?></small></h1>
            </div> 
            <div class="workplace">                
                <div class="row-fluid">
                    <div class="span12">
                        <div class="zone">
<div class="x">
<table cellpadding="0" cellspacing="0" class="table">
<thead>
<tr>
<?php if ($tr1>20) { echo "<th><font color='$c_1'>TR1</font></th>"; } ?>
<?php if ($tr2>20) { echo "<th><font color='$c_2'>TR2</font></th>"; } ?>
<?php if ($tr3>20) { echo "<th><font color='$c_3'>TR3</font></th>"; } ?>
<?php if ($tr4>20) { echo "<th><font color='$c_4'>TR4</font></th>"; } ?>
<?php if ($tr5>20) { echo "<th><font color='$c_5'>TR5</font></th>"; } ?>
<?php if ($tr6>20) { echo "<th><font color='$c_6'>TR6</font></th>"; } ?>
</tr>
</thead>
<tbody>
<tr>
<?php if ($tr1>20) { echo "<td><font color='$c_1'>$tr1</font></td>"; } ?>
<?php if ($tr2>20) { echo "<td><font color='$c_2'>$tr2</font></td>"; } ?>
<?php if ($tr3>20) { echo "<td><font color='$c_3'>$tr3</font></td>"; } ?>
<?php if ($tr4>20) { echo "<td><font color='$c_4'>$tr4</font></td>"; } ?>
<?php if ($tr5>20) { echo "<td><font color='$c_5'>$tr5</font></td>"; } ?>
<?php if ($tr6>20) { echo "<td><font color='$c_6'>$tr6</font></td>"; } ?>
</tr>
</tbody>
</table>
</div>
                            <div id="chart_2" style="width:100%;height:440px;margin:0 auto;"></div>
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