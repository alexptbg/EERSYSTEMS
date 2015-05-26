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
$day_n = date('N');
$today_ = date('Y-m-d', time());
$onemonth = date('Y-m-d', time() - 60 * 60 * 24 * 31);
    $query1 = "SELECT `datetime` FROM `vodomer` ORDER BY `datetime` ASC LIMIT 1";
    $result1 = mysql_query($query1);
    confirm_query($result1);
    $row1 = mysql_fetch_array($result1);
	$mindate=$row1['datetime'];
    $min = date('Y-m-d',strtotime($mindate));
	$min1 = date('Y-m-d', strtotime($mindate . ' + 1 day'));
$query2 = "SELECT `datetime` FROM `vodomer` ORDER BY `datetime` DESC LIMIT 1";
$result2 = mysql_query($query2);
confirm_query($result2);
$row2 = mysql_fetch_array($result2);
$maxdate=$row2['datetime'];
$max = date('Y-m-d',strtotime($maxdate));
$max1 = date('Y-m-d', strtotime($maxdate . ' + 1 day'));
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
	<script type='text/javascript' src='js/easing.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery.mousewheel.min.js'></script>
    <script type='text/javascript' src='js/plugins/cookie/jquery.cookies.2.2.0.min.js'></script>
    <script type='text/javascript' src='js/plugins/bootstrap.min.js'></script>
	<script type='text/javascript' src='js/plugins/c/highstock.js'></script>
	<script type='text/javascript' src='js/plugins/c/highcharts-more.js'></script>
	<script type='text/javascript' src='js/plugins/c/highcharts.<?=$lang?>.js'></script>
	<script type='text/javascript' src='js/plugins/c/export.js'></script>	
	<!--[if lt IE 9]><script type='text/javascript' src='js/plugins/c/excanvas.js'></script><![endif]-->
    <script type='text/javascript' src='js/plugins/fullcalendar/fullcalendar.min.js'></script>
    <script type='text/javascript' src='js/plugins/select2/select2.min.js'></script>
    <script type='text/javascript' src='js/plugins/uniform/uniform.js'></script>
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    <script type='text/javascript' src='js/plugins/validation/languages/jquery.validationEngine-<?=$lang?>.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/jquery.validationEngine.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js'></script>
    <script type='text/javascript' src='js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js'></script>
    <script type='text/javascript' src='js/plugins/cleditor/jquery.cleditor.js'></script>
    <script type='text/javascript' src='js/plugins/dataTables/jquery.dataTables.min.js'></script>    
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js'></script>
	<link rel='stylesheet' type='text/css' href='js/plugins/datepick/jquery.datepick.css' />
	<script type='text/javascript' src='js/plugins/datepick/jquery.datepick.min.js'></script>
	<script type='text/javascript' src='js/plugins/datepick/jquery.datepick-<?=$lang?>.js'></script>
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
	<script type='text/javascript' src='js/lang.js'></script>
	<script type='text/javascript' src='js/alex.js'></script>
	<script type='text/javascript' charset='utf-8'>
	$(function() {
        $('#from').datepick({
			dateFormat: 'yyyy-mm-dd',
			useMouseWheel: false,
			minDate: '<?=$min?>',
			maxDate: '<?=$max?>',
			pickerClass: 'noPrevNext'
		});
        $('#to').datepick({
			dateFormat: 'yyyy-mm-dd',
			useMouseWheel: false,
			minDate: '<?=$min1?>',
			maxDate: '<?=$max1?>',
			pickerClass: 'noPrevNext'
		});
	});
	</script>
    <?php
	charts_init();
if (!isset($_POST['submit'])) {
	$dates = $onemonth;
	$datex = $today_;
    echo "
<script type=\"text/javascript\">
	Highcharts.setOptions({
		global : {
			useUTC : false
		}
	});
$(function() {
	$.getJSON('vodomer_data.php?lang=".$lang."&line=".$line."&inv=".$inv."&id=".$id."&v_id=".$v_id."', function(data) {
		$('#container').highcharts('StockChart', {
		    chart: {
		        alignTicks: false,
				
            animation: {
                duration: 2000,
                easing: 'easeOutBounce'
            }
		    },
rangeSelector: {
            buttons: [{
                type: 'month',
                count: 1,
                text: '1M'
            }, {
                type: 'month',
                count: 2,
                text: '2M'
            }, {
                type: 'month',
                count: 3,
                text: '3M'
            }, {
                type: 'all',
                text: 'All'
            }],
            selected: 0,
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
				reversed: false,
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
                    enableMouseTracking: false,
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
} else {
    $dates = $_POST['from'];
    $datex = $_POST['to'];
    echo "
<script type=\"text/javascript\">
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
}
?>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
	<?php include('includes/style.php'); ?>
        <div class="header">
            <a class="logo" href="index.php?lang=<?=$lang?>">
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
                                <div class="span6">
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
                    <span>&nbsp;</span>                
				</div>
            </div>
            <div class="logox">
                <img src="logo.php" />
            </div>
            <div class="admin">
                <?php echo get_lang($lang, 'Welcome'); ?>
            </div>

            <ul class="navigation">            
                <li>
                    <a href="index.php">
                        <span class="isw-grid"></span><span class="text"><?php echo get_lang($lang, 'home'); ?></span>
                    </a>
                </li>
                <?php get_lines($lang,$line); ?>
                <li>
                    <a href="egi.php?lang=<?=$lang?>" class="ttRC" title="<?php echo get_lang($lang, 'egi01'); ?>">
                        <span class="isw-archive"></span><span class="text"><?php echo get_lang($lang, 'egi'); ?></span>                 
                    </a>
                </li> 
				<li class="openable">
                    <a href="#">
                        <span class="isw-calendar"></span><span class="text"><?php echo get_lang($lang, 'ad28'); ?></span>
                    </a>
                    <ul> <?php get_controllers_for_edit($lang,$line); ?></ul>
				</li>
				<?php get_klines($lang,$kline); ?>
				<li class="openable">
                    <a href="#">
                        <span class="isw-documents"></span><span class="text"><?php echo get_lang($lang, 'Diagnostics'); ?></span>
                    </a>
                    <ul>
                    <?php get_diagnostics($lang,$line); ?>
				    </ul>
				</li>
                <li>
                    <a href="repairs.php?lang=<?=$lang?>">
                        <span class="isw-ok"></span><span class="text"><?php echo get_lang($lang,'ad457'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="klima.php?lang=<?=$lang?>">
                        <span class="isw-calc"></span><span class="text"><?php echo get_lang($lang, 'ad275'); ?></span>                 
                    </a>
                </li> 	
                <li>
                    <a href="reports.php?lang=<?=$lang?>">
                        <span class="isw-text_document"></span><span class="text"><?php echo get_lang($lang, 'ad177'); ?></span>                 
                    </a>
                </li> 
                <li>
                    <a href="server.php?lang=<?=$lang?>">
                        <span class="isw-target"></span><span class="text"><?php echo get_lang($lang, 'inter06'); ?></span>                 
                    </a>
                </li>                                                        
                <li>
                    <a href="utils.php?lang=<?=$lang?>">
                        <span class="isw-favorite"></span><span class="text"><?php echo get_lang($lang, 'inter50'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="faq.php?lang=<?=$lang?>">
                        <span class="isw-tag"></span><span class="text"><?php echo get_lang($lang, 'FAQ'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="demo.php?lang=<?=$lang?>">
                        <span class="isw-bookmark"></span><span class="text"><?php echo get_lang($lang, 'ad237'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="contact.php?lang=<?=$lang?>">
                        <span class="isw-mail"></span><span class="text"><?php echo get_lang($lang, 'ad238'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="admin/admin.php?lang=<?=$lang?>">
                        <span class="isw-settings"></span><span class="text"><?php echo get_lang($lang, 'inter61'); ?></span>                 
                    </a>
                </li>   
            </ul>
            <div class="qrcode">
                <img src="qrcode.php" />
            </div>
            <div class="widget">
                <div class="w95 pb20 pt20">
				    <?php cron_side($lang,'10'); ?>
				</div>
            </div>
        </div>

        <div class="content">
            <div class="breadLine">
                <ul class="breadcrumb">
                    <li><?=$site_name?></li>                
                </ul>
                <span class="fr time">
			        <?php echo get_lang($lang, $day). ', ' . date('d') .' '.get_lang($lang, $month). ' '.date('Y').' - '; ?>
				    <span id="ctime"></span>
			    </span>
            </div>
            <div class="workplace">
			
                <div class="row-fluid">
                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-clock-o fa-1x"></i><span><?php echo get_lang($lang, 'ad187'); ?></span>
                        </div>
                        <div class="block-fluid">
<?php
echo "
                            <form action=\"".$_SERVER['PHP_SELF'] . "?lang=".$lang."&line=".$line."&inv=".$inv."&id=".$id."&v_id=".$v_id."\" method=\"post\" id=\"validation\">
                                <div class=\"row-form clearfix\">
                                  <div class=\"span4 tar\">".get_lang($lang, 'ad181')." / ".get_lang($lang, 'ad182').":</div>
                                  <div class=\"span4\">
				                     <input name=\"from\" id=\"from\" type=\"text\" value=\"".$dates."\" readonly=\"readonly\" class=\"validate[custom[date],past[#to]]\" />
								  </div>
                                  <div class=\"span4\">
				                      <input name=\"to\" id=\"to\" type=\"text\" value=\"".$datex."\" readonly=\"readonly\" class=\"validate[custom[date],future[#from]]\" />
								  </div>
                                </div>
                            <div class=\"footer\">
                           <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"btn btn-default\">
		                        <i class=\"fa fa-check\"></i>&nbsp; ".get_lang($lang, 'ad179')."</button>
                           </div>
							</form>
";
?>
                        </div>
                    </div>   
				</div>
                <div class="dr"><span></span></div>
                <?php
                $line_options = get_line_options($line);
				if (!isset($_POST['submit'])) {
				echo "
                <div class=\"row-fluid\">
				    <div class=\"span6\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-calendar fa-1x\"></i><span>".get_lang($lang, 'info5')."</span>
                        </div>
						<div class=\"block-fluid\">
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
							    <tbody>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'info4').":</td>
                                        <td>".$line."</td>                                   
                                    </tr>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'ad282')." ".get_lang($lang, 'inter71').":</td>
                                        <td>".$inv."-".$v_id."</td>                                   
                                    </tr>
								</tbody>
							</table>
						</div>
					</div>
				    <div class=\"span6\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-tag fa-1x\"></i><span>".get_lang($lang, 'info19')."</span>
                        </div>
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
				</div>";
				} else {
				echo "
                <div class=\"row-fluid\">
				    <div class=\"span6\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-calendar fa-1x\"></i><span>".get_lang($lang, 'ad183')."</span>
                        </div>
						<div class=\"block-fluid\">
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
							    <tbody>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'info4').":</td>
                                        <td>".$line."</td>                                   
                                    </tr>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'ad187').":</td>
                                        <td>".$dates." - ".$datex."</td>                                   
                                    </tr>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'ad282')." ".get_lang($lang, 'inter71').":</td>
                                        <td>".$inv."-".$v_id."</td>                                   
                                    </tr>
								</tbody>
							</table>
						</div>
					</div>
				    <div class=\"span6\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-tag fa-1x\"></i><span>".get_lang($lang, 'info19')."</span>
                        </div>
						<div class=\"block-fluid\">
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
							    <tbody>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'info19').":</td>
                                        <td>".$line_options['org']."</td>                                   
                                    </tr>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'info20').":</td>
                                        <td>".$line_options['plant']."</td>                                   
                                    </tr>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'info21').":</td>
                                        <td>".$line_options['floor']."</td>                                   
                                    </tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>";
				}
				echo "<div class=\"dr\"><span></span></div>";
				?>
				<div class="row-fluid">
                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-money fa-1x"></i><span><?php echo get_lang($lang, 'ad289'); ?></span>
                            <ul class="buttons">
                                <li class="tip_" title="<?php echo get_lang($lang, 'inter05'); ?>">
                                    <a href="javascript: history.go(-1);" class="isw-left_circle"></a>
                                </li>
                                <li class="tip_" title="<?php echo get_lang($lang, 'chart2'); ?>">
								<?php
					            if (!isset($_POST['submit'])) {
									echo "<a target=\"_blank\" href=\"print_vodomer_table.php?lang=".$lang."&line=".$line."&inv=".$inv."&id=".$id."&v_id=".$v_id."\" class=\"isw-print\"></a>"; } else {
									echo "<a target=\"_blank\" href=\"print_vodomer_table_dated.php?lang=".$lang."&line=".$line."&inv=".$inv."&id=".$id."&v_id=".$v_id."&from=".$dates."&to=".$datex."\" class=\"isw-print\"></a>";	
									}
								?>
                                </li>
                            </ul>
                        </div>
						<div class="block-fluid table-sorting clearfix">
                        <?php
					if (!isset($_POST['submit'])) {
				        mysql_query("SET NAMES 'utf8'");
                        $query = "SELECT * FROM `vodomer` WHERE `line`='$line' AND `inv`='$inv' AND `v_id`='$v_id' order by `timestamp` asc"; 
                        $result = mysql_query($query);
                        confirm_query($result);
                        if (mysql_num_rows($result) != 0 ) {
						    echo "
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\" id=\"vodomer_t\">
                                <thead>
                                    <tr>
										<th>".get_lang($lang, 'info6')."</th>
                                        <th>".get_lang($lang, 'ad289')." (м&sup3;)</th>                            
                                    </tr>
                                </thead>
                                <tbody>";
		                        while($row = mysql_fetch_array($result)) {
									$vk = $row['v_k']/1000;
			                        echo "
                                    <tr>
                                        <td>".$row['day']."</td>
										<td>".$vk."</td>         
                                    </tr>";
			                    }
				                echo "</tbody></table>";
							}
							$t = count_m3('Bukovo','69','0','1');
							$vt = $t/1000;
							echo "
						    <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
							    <tbody>       
                                    <tr>
                                        <td class=\"tar\">". get_lang($lang, 'ad291').":</td>
                                        <td>".$vt." м&sup3;</td>
                                    </tr>
                                </tbody>
                            </table>";
						} else {
				        mysql_query("SET NAMES 'utf8'");
                        $query = "SELECT * FROM `vodomer` WHERE `line`='$line' AND `inv`='$inv' AND `v_id`='$v_id' AND `datetime` BETWEEN '$dates 00:00:00' AND '$datex 00:00:00' order by `timestamp` asc"; 
                        $result = mysql_query($query);
                        confirm_query($result);
                        if (mysql_num_rows($result) != 0 ) {
						    echo "
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\" id=\"vodomer_t\">
                                <thead>
                                    <tr>
										<th>".get_lang($lang, 'info6')."</th>
                                        <th>".get_lang($lang, 'ad289')." (м&sup3;)</th>                            
                                    </tr>
                                </thead>
                                <tbody>";
		                        while($row = mysql_fetch_array($result)) {
									$vk = $row['v_k']/1000;
			                        echo "
                                    <tr>
                                        <td>".$row['day']."</td>
										<td>".$vk."</td>         
                                    </tr>";
			                    }
				                echo "</tbody></table>";
							}
							$t = count_m3_dated('Bukovo','69','0','1',$dates,$datex);
							$vt = $t/1000;
							echo "
						    <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
							    <tbody>       
                                    <tr>
                                        <td class=\"tar\">". get_lang($lang, 'ad291').":</td>
                                        <td>".$vt." м&sup3;</td>
                                    </tr>
                                </tbody>
                            </table>";
						}
					?>
                        </div>
                    </div>   
				</div>
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-money fa-1x"></i><span><?php echo get_lang($lang, 'ad289'); ?></span>
                            <ul class="buttons">
                                <li class="tip_" title="<?php echo get_lang($lang, 'inter05'); ?>">
                                    <a href="javascript: history.go(-1);" class="isw-left_circle"></a>
                                </li>
                                <li class="tip_" title="<?php echo get_lang($lang, 'chart2'); ?>">
								<?php
					            if (!isset($_POST['submit'])) {
									echo "<a target=\"_blank\" href=\"print_vodomer_chart.php?lang=".$lang."&line=".$line."&inv=".$inv."&id=".$id."&v_id=".$v_id."\" class=\"isw-print\"></a>"; } else {
									echo "<a target=\"_blank\" href=\"print_vodomer_chart_dated.php?lang=".$lang."&line=".$line."&inv=".$inv."&id=".$id."&v_id=".$v_id."&from=".$dates."&to=".$datex."\" class=\"isw-print\"></a>";	
									}
								?>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
						    <?php
                            if (!isset($_POST['submit'])) {
                                echo "<div id=\"container\" style=\"height: 500px; width:100%; min-width: 500px;\"></div>";
							} else {
								if (isset($_POST['submit'])) {
									echo "<div id=\"container\" style=\"height: 500px; width:100%; min-width: 500px;\"></div>";
								}
							}
							?>
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