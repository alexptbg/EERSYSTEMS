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
clear_cron();
get_line_options($line);
$datafile = "../data/{$line_options['data_file']}";
$ala = $line_options['alarm'];
$red = $line_options['red'];
$ex_red = $line_options['ex_red'];
$ex_red = explode(',', $ex_red);
$ex_alarm = $line_options['ex_alarm'];
$ex_alarm = explode(',', $ex_alarm);
$ex_table = $line_options['ex_table'];
$ex_table = explode(',', $ex_table);
$updated = date('H:i:s');
$socket_ip = $line_options['ip_address'];
$socket_port = $line_options['port'];
if ($datafile == NULL) { get_error($lang,'1002'); exit; }
if (file_exists($datafile)) { } else { get_error($lang, '1003'); exit; }
include("$datafile");
include ('../includes/socket.php');
$server = 'r';
$command = "AP";
try {
    $sc = new ClientSocket();
    $sc->open($socket_ip,$socket_port);
    $sc->send("$server $command $id\r\n");
}
catch (Exception $e){ echo $e->getMessage(); }
include ('cron.php');
include ('cron2.php');
$devz = ${'dev' . $id};
$dz = explode(" ", $devz);
$tr1z = $dz[10];
$tr2z = $dz[11];
$tr3z = $dz[12];
$tr4z = $dz[13];
$tr5z = $dz[14];
$tr6z = $dz[15];
if ($user_settings['user_name'] != NULL) {
    $obs = $line." | ".$id." | ".$inv;
    insert_log($lang,$user_settings['user_name'],'info','ad454',$obs);	
}
$datafile2 = "../data/{$line_options['line_sname']}/$inv.txt";
include("$datafile2");
$dev = ${'dev' . $id};
$d = explode(" ", $dev);
$tr1 = $d[10];
$tr2 = $d[11];
$tr3 = $d[12];
$tr4 = $d[13];
$tr5 = $d[14];
$tr6 = $d[15];
$tk1d = explode(" ", $tk1);
$tk2d = explode(" ", $tk2);
$tk3d = explode(" ", $tk3);
$tk4d = explode(" ", $tk4);
$tk5d = explode(" ", $tk5);
$tk6d = explode(" ", $tk6);
$r = explode(":", $range);
$kline = "";
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
    <script type='text/javascript' src='js/jquery-1.7.2.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/jquery-ui.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery.mousewheel.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/cookie/jquery.cookies.2.2.0.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/bootstrap.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/c/highcharts.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/c/export.js' charset='utf-8'></script>	
    <script type='text/javascript' src='js/plugins/select2/select2.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/uniform/uniform.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/languages/jquery.validationEngine-<?=$lang?>.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/jquery.validationEngine.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/cookies.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/actions.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/settings.js' charset='utf-8'></script>
	<script type='text/javascript' src='js/lang.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/alex.js' charset='utf-8'></script>
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
				text: '<?=$line?> | <?=$inv?> | <?=$today?>'
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
                    enabled: false,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            },
                spline: {
                    dataLabels: {
                        enabled: false
                    },
                    enableMouseTracking: true
                }
            },
            legend: {
                enabled:true
            },
        credits: {
            enabled:false
        },
            exporting: {
                enabled: true,
				filename: '<?=$today?>_<?=$line?>_<?=$inv?>'
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
$(function () {
    var chart2;
    $(document).ready(function() {
        chart2 = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_2',
                type: 'spline',
                marginRight: 70,
				plotShadow: false,
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
            },
            title: {
                text: '<?php echo get_lang($lang, "chart4"); ?>',
                x: -20
            },
            subtitle: {
                text: '<?=$line?> | <?=$inv?> | <?=$range?> - <?=$today?>',
                x: -20
            },
      xAxis: {
         categories: ['00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '60'],
         title: {
            text: '<?php echo get_lang($lang, "Minutes"); ?>'
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
                        this.x +': '+ this.y +'°C';
                }
            },
            plotOptions: {
            series: {
                marker: {
                    enabled: false,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                },
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
        credits: {
            enabled: false
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
        <div class="header">
            <a class="logo" href="../table.php?lang=<?=$lang?>&line=<?=$line?>">
			<h2><?=$company_name?> &curren; <?=$company_slogan?></h2></a>
            <ul class="header_menu">
                <li class="list_icon"><a href="#">&nbsp;</a></li>
                <li class="settings_icon">
                    <a href="#" class="link_themeSettings">&nbsp;</a>
                    <div id="themeSettings" class="popup">
                        <div class="head clearfix">
                            <div class="arrow"></div>
                            <span class="isw-settings"></span>
                            <span class="name"><?php echo get_lang($lang, 'Settings'); ?></span>
                        </div>
                        <div class="body settings">
                            <div class="row-fluid">
                                <div class="span3"><strong><?php echo $translation->getTranslation("select_lang"); ?></strong></div>
                                <div class="span9">
		                            <div id="alex_LanguageSwitcher">
			                            <form method="get">
			                                <select id="alex_language-options" name="lang" 
											        onchange="window.location=('?lang='+this.options[this.selectedIndex].value)">
					                        <option id="<?php echo get_lang($lang, 'msg_000'); ?>"
					                                value="<?php echo get_lang($lang, 'msg_000'); ?>"><?php echo get_lang($lang, 'msg_001'); ?></option>
					                        <?php foreach ($translation->getAllLanguages() as $language) : ?>
					                        <option id="<?php echo $language->getShort(); ?>"
					                                value="<?php echo $language->getShort(); ?>"><?php echo $language->getName(); ?></option>
					                        <?php endforeach; ?>
				                            </select>
				                            <noscript><input type="submit" value="Submit"></noscript>
			                            </form>	
		                            </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer">                            
                            <button class="btn link_themeSettings" type="button">
							    <i class="fa fa-times"></i>&nbsp; <?php echo get_lang($lang, 'Close'); ?></button>
                        </div>
                    </div>                    
                </li>                
            </ul>   
        </div>
        <div class="menu">                
            <div class="breadLine">            
                <div class="arrow"></div>
                <div class="adminControl active">
                    <span><?php echo get_lang($lang, 'Hello') . ", " . $user_settings['first_name'] . " " . $user_settings['last_name']; ?></span>
				</div>
            </div>
            <div class="admin">
                <div class="image">
                    <img src="image.php?username=<?php echo $user_settings['user_name']; ?>" class="img-polaroid"/>                
                </div>
                <ul class="control">                
                    <li><span class="icon-user"></span> 
					    <span class="tip" title="<?php echo get_lang($lang, 'ad148'); ?>"><?php echo $user_settings['user_name']; ?></span>
					    <span class="caption green tip" title="<?php echo get_lang($lang, 'inter134'); ?>"><?php echo $user_settings['level']; ?></span></li>
                    <li><span class="icon-cog"></span> <a href="../admin/my_profile.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'ad22'); ?></a></li>
                    <li><span class="icon-share-alt"></span> 
					    <a href="logout.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
						    <?php echo get_lang($lang, 'Logout'); ?></a></li>
                </ul>
                <div class="info">
                    <span><?php echo get_lang($lang, 'inter84') . "!"; ?></span><br/>
					<span><?php echo get_lang($lang, 'inter135').":<br/>".$user_settings['last_login']; ?></span>
                </div>
            </div>
			
            <ul class="navigation">            
                <li class="active">
                    <a href="setup.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-grid"></span><span class="text"><?php echo get_lang($lang, 'home'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="controller_setup.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-calc"></span><span class="text"><?php echo get_lang($lang, 'td1'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="controller_repairs.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-target"></span><span class="text"><?php echo get_lang($lang, 'ad457'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="controller_info.php?lang=<?=$lang?>&line=<?=$line?>&id=<?=$id?>&inv=<?=$inv?>&sys=<?=$sys?>">
                        <span class="isw-list"></span><span class="text"><?php echo get_lang($lang, 'td3'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="../admin/admin.php?lang=<?=$lang?>">
                        <span class="isw-settings"></span><span class="text"><?php echo get_lang($lang, 'inter61'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="../table.php?lang=<?=$lang?>&line=<?=$line?>">
                        <span class="isw-left_circle"></span><span class="text"><?php echo get_lang($lang, 'ad193'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="../diagnostics.php?lang=<?=$lang?>&line=<?=$line?>">
                        <span class="isw-left_circle"></span><span class="text"><?php echo get_lang($lang,'Diagnostics'); ?></span>
                    </a>
                </li>         
            </ul>
        </div>

        <div class="content">
            <div class="breadLine">
                <ul class="breadcrumb">
                    <li><?=$line?> \ <?=$id?> \ <?=$inv?></li>                
                </ul>
                <span class="fr time">
			        <?php echo get_lang($lang, $day). ', ' . date('d') .' '.get_lang($lang, $month). ' '.date('Y').' - '; ?>
				    <span id="ctime"></span>
			    </span>
            </div>

            <div class="workplace">
                <div class="row-fluid">
                    <div class="span5">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'info1'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_c_info($lang,$line,$id,$inv); ?>
                        </div>
                    </div>
                    <div class="span7">
                        <div class="head clearfix">
                            <i class="fa fa-cogs fa-1x"></i><span><?php echo get_lang($lang, 'inter76'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_c_params($lang,$line,$id,$inv); ?>
                        </div>
                    </div>	
                </div>
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="head clearfix">
                            <i class="fa fa-power-off fa-1x"></i><span><?php echo get_lang($lang, 'inter77'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_c_status($lang,$line,$id,$inv); ?>
                        </div>
                    </div>	
                    <div class="span8">
                        <div class="head clearfix">
                            <i class="fa fa-fire fa-1x"></i><span><?php echo get_lang($lang, 'inter79'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_c_temps($lang,$line,$id,$inv); ?>
                        </div>
                    </div>
                </div>
				
                <div class="dr"><span></span></div>

                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-dashboard fa-1x"></i><span><?php echo get_lang($lang, 'inter83'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php get_c_stk($lang,$line,$id,$inv); ?>
                        </div>
                    </div>	
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-terminal fa-1x"></i><span><?php echo get_lang($lang, 'Console'); ?></span>
                        </div>
                        <div class="block">
						    <div class="w98">
                    <?php 
					    if (filesize($datafile)<100) { error_console($lang,'1004'); } else {
					        if(!($sc == NULL)) {
								sys_console($lang,'inter81');
							    echo "<span>".$time_f." </span>";
							    echo "<span class='text-info'><i class='fa fa-angle-right'></i> " .$command . " " . $id . "</span><br/>"; 
							}
                            if(!($sc == NULL)) { 
						        echo "<span>".$time_f." </span>";
							    echo "<span class='text-success'><i class='fa fa-angle-left'></i> " . $sc->recv() . "</span>"; 
						    }
						} 
                    ?>
							</div>
                        </div>
                    </div>	
                </div>
				
                <div class="dr"><span></span></div>
	
                <div class="row-fluid">
                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-bar-chart-o fa-1x"></i><span><?php echo get_lang($lang, 'chart3'); ?></span>
                            <ul class="buttons">
                                <li class="tip_" title="<?php echo get_lang($lang, 'chart2'); ?>">
                                 <a target="_blank" href="print_chart_rt.php?line=<?=$line?>&inv=<?=$inv?>&id=<?=$id?>&lang=<?=$lang?>" class="isw-print"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
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
                            <div id="chart_1" style="width:100%;height:420px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div> 
				
                <div class="row-fluid">
                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-bar-chart-o fa-1x"></i><span><?php echo get_lang($lang, 'chart5'); ?></span>
                            <ul class="buttons">
                                <li class="tip_" title="<?php echo get_lang($lang, 'chart2'); ?>">
                                    <a target="_blank" href="print_chart_lh.php?line=<?=$line?>&inv=<?=$inv?>&id=<?=$id?>&lang=<?=$lang?>" class="isw-print"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
                            <div id="chart_2" style="width:100%;height:420px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div> 
				
                <div class="dr"><span></span></div>
				<!--FOOTER-->
                <div class="row-fluid">
				<div class="footer">
                    <div class="span6">
                        <span class="fl"><?=$copyrights?> <small>&reg; &copy;</small> 2010 - 
						<script type="text/javascript">document.write(new Date().getFullYear())</script></span>
                    </div>
                    <div class="span6">
                        <span class="fr hits"><?php get_hits($lang); ?></span>
                    </div>
                </div>
				</div>
            </div>
        </div>   
    </div>
</body>
</html>