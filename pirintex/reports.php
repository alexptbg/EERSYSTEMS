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
$global_settings = get_global_settings();
$day_n = date('N');
$yesterday = date('Y-m-d', time() - 60 * 60 * 24);
$twodays = date('Y-m-d', time() - 60 * 60 * 48);
if ($day_n == 1) { $day_e = $twodays; $day_b = date('Y-m-d', time() - 60 * 60 * 24); } else { $day_e = $yesterday; $day_b = date('Y-m-d', time()); }
    $query1 = "SELECT `log_date` FROM `alarms` ORDER BY `log_date` ASC LIMIT 1";
    $result1 = mysql_query($query1);
    confirm_query($result1);
    $row1 = mysql_fetch_array($result1);
	$mindate=$row1['log_date'];
	
    $min = date('Y-m-d',strtotime($mindate));
	$min1 = date('Y-m-d', strtotime($mindate . ' + 1 day'));
$query2 = "SELECT `log_date` FROM `alarms` ORDER BY `log_date` DESC LIMIT 1";
$result2 = mysql_query($query2);
confirm_query($result2);
$row2 = mysql_fetch_array($result2);
$maxdate=$row2['log_date'];

$max = date('Y-m-d',strtotime($maxdate));
$max1 = date('Y-m-d', strtotime($maxdate . ' - 1 day'));
$line = ""; $kline = "";
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
			maxDate: '<?=$max1?>',
			pickerClass: 'noPrevNext'
		});
        $('#to').datepick({
			dateFormat: 'yyyy-mm-dd',
			useMouseWheel: false,
			minDate: '<?=$min1?>',
			maxDate: '<?=$max?>',
			pickerClass: 'noPrevNext'
		});
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
                <li class="active">
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
                            <i class="fa fa-clock-o fa-1x"></i><span><?php echo get_lang($lang, 'ad183'); ?></span>
                        </div>
                        <div class="block-fluid">
    <?php
if (!isset($_POST['submit'])) {
	$dates = $day_e;
	$datex = $day_b;
	$filter = 0.5;
} else {
    $dates = $_POST['from'];
    $datex = $_POST['to'];
    $filter = $_POST['filter'];	
}
                               mysql_query("SET NAMES 'utf8'");
                               $query = "SELECT `line_name` FROM `lines` ORDER BY `line_name` ASC";
                               $result = mysql_query($query);
                               confirm_query($result);
                               $num_rows = mysql_num_rows($result);
                               if ($num_rows != 0) {
							   	   echo "<form action=\"".$_SERVER['PHP_SELF'] . "?lang=".$lang."\" method=\"post\" id=\"validation\">
								           <div class=\"row-form clearfix\">
										     <div class=\"span4 tar\">". get_lang($lang, 'ad180'). ":</div>
											 <div class=\"span8\">
								               <select id=\"linex\" name=\"linex\" class=\"validate[required]\">
											   <option value=\"\"></option>
											   <option value=\"All\">".get_lang($lang, 'ad292')."</option>
										       <option value=\"\"></option>
								   ";
							       while ($lines = mysql_fetch_array($result)) {
									   echo "<option value=\"".$lines['line_name']."\">".$lines['line_name']."</option>";
									   $lines_append[] = $lines['line_name'];
								   }
								   echo "      </select>
								             </div>
								           </div>
                                <div class=\"row-form clearfix\">
                                  <div class=\"span4 tar\">".get_lang($lang, 'ad181')." / ".get_lang($lang, 'ad182').":</div>
                                  <div class=\"span4\">
				                     <input name=\"from\" id=\"from\" type=\"text\" value=\"".$dates."\" readonly=\"readonly\" class=\"validate[custom[date],past[#to]]\" />
								  </div>
                                  <div class=\"span4\">
				                      <input name=\"to\" id=\"to\" type=\"text\" value=\"".$datex."\" readonly=\"readonly\" class=\"validate[custom[date],future[#from]]\" />
								  </div>
                                </div>
                                <div class=\"row-form clearfix\">
                                  <div class=\"span4 tar\">".get_lang($lang, 'Filter').":</div>
                                  <div class=\"span8\">
								       <select id=\"filter\" name=\"filter\" class=\"validate[required]\">
									       <option value=\"".$filter."\">".$filter."</option>
									       <option value=\"\"></option>
									       <option value=\"0.5\">0.5</option>
									       <option value=\"0.7\">0.7</option>
									       <option value=\"0.9\">0.9</option>
									   </select>
								  </div>
                                </div>
                            <div class=\"footer\">
                           <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"btn btn-default\">
		                        <i class=\"fa fa-check\"></i>&nbsp; ".get_lang($lang, 'ad179')."</button>
                           </div></form>";
							   } else {
							       get_error($lang,'1029');
							   }
    echo "
                        </div>
                    </div>				 
                </div>
                <div class=\"dr\"><span></span></div>";
if (isset($_POST['submit'])) {
	if ($_POST['linex'] == "All") {
	echo "
                <div class=\"row-fluid\">
                    <div class=\"span12\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-bar-chart-o fa-1x\"></i><span>".get_lang($lang, 'ad211')."</span>
                            <ul class=\"buttons\">
                                <li class=\"tip_\" title=\"".get_lang($lang, 'td41')."\">
                                    <a target=\"_blank\" href=\"print_energy_loss_chart_all.php?linex=".$linex."&dates=".$dates."&datex=".$datex."&filter=".$filter."&lang=".$lang."\" class=\"isw-print\"></a>
                                </li>
                            </ul>
                        </div>
	                    <div class=\"block-fluid\">
<script type=\"text/javascript\" charset=\"UTF-8\">
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
                text: '".$dates ." - ". $datex ."'
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
             echo "]
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
		energo_loss_t_all($line_e,$dates,$datex);
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
	<div id=\"ene\" style=\"width: 100%; height: 400px; margin: 0 auto;\"></div>
						</div>
                    </div>				 
                </div>
				<div class=\"dr\"><span></span></div>
                <div class=\"row-fluid\">
                    <div class=\"span12\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-dedent fa-1x\"></i><span>".get_lang($lang, 'ad178')."</span>
                        </div>
	                    <div class=\"block-fluid\">
	                        <div class='w98 pt10'>
							    <p class='text-info'>".get_lang($lang, 'ad184')."</p>
							</div>
						</div>
                    </div>				 
                </div>";
	} else {
                $linex = $_POST['linex'];
	            $line_options = get_line_options($linex);
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
				</div>
				<div class=\"dr\"><span></span></div>";
	$query = "truncate table reports";
	mysql_query($query);
	$result = mysql_query("SELECT * FROM `alarms` WHERE `log_line`='$linex' AND `log_date` BETWEEN '$dates 00:00:00' AND '$datex 00:00:00' group by `log_device`,`log_channel` ORDER BY `log_id` desc");
	confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
        while($row = mysql_fetch_array($result)) {
			$inv = $row['log_device'];
			$controller_data = get_controller_data($inv,$linex);
			$main_line = $linex;
			$line = $controller_data['line'];
			$group_number = $controller_data['group_number'];
			$group_name = $controller_data['group_name'];
            $channel = $row['log_channel'];
	        $treqt = calc_treqt($inv,$channel,$dates.' 00:00:00',$datex.' 00:00:00');//$row['log_treqt'];
            $temp = calc_temp($inv,$channel,$dates.' 00:00:00',$datex.' 00:00:00');
			$minutes = calc_minutes($inv,$channel,$dates.' 00:00:00',$datex.' 00:00:00');
			$energy = calc_energy_loss($temp,$treqt,$minutes);
			$alarms = calc_alarms($inv,$channel,$dates.' 00:00:00',$datex.' 00:00:00');
            insert_report($main_line,$line,$inv,$group_number,$group_name,$channel,$treqt,$temp,$energy,$minutes,$alarms);
        }
	    mysql_query("SET NAMES 'utf8'");
        $query = "SELECT * FROM `reports` WHERE energy>='$filter' order by `energy` desc";
        $result = mysql_query($query);
        confirm_query($result);
        if (mysql_num_rows($result) != 0 ) {
        echo "          
                <div class=\"row-fluid\">
                    <div class=\"span12\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-dedent fa-1x\"></i><span>".get_lang($lang, 'ad178')."</span>
                            <ul class=\"buttons\">
                                <li class=\"tip_\" title=\"".get_lang($lang, 'td41')."\">
                                    <a target=\"_blank\" href=\"print_energy_loss.php?linex=".$linex."&dates=".$dates."&datex=".$datex."&filter=".$filter."&lang=".$lang."\" class=\"isw-print\"></a>
                                </li>
                            </ul>
                        </div>
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
                                <tbody>";
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
                    <div class=\"span12\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-bar-chart-o fa-1x\"></i><span>".get_lang($lang, 'ad212')."</span>
                            <ul class=\"buttons\">
                                <li class=\"tip_\" title=\"".get_lang($lang, 'td41')."\">
                                    <a target=\"_blank\" href=\"print_energy_loss_chart_bar.php?linex=".$linex."&dates=".$dates."&datex=".$datex."&filter=".$filter."&lang=".$lang."\" class=\"isw-print\"></a>
                                </li>
                            </ul>
                        </div>
	                    <div class=\"block-fluid\">";
	    mysql_query("SET NAMES 'utf8'");
        $query_2 = "SELECT * FROM `reports` WHERE energy>='$filter' group by `inv` order by `energy` desc";
        $result_2 = mysql_query($query_2);
        confirm_query($result_2);
        if (mysql_num_rows($result_2) != 0 ) {
			while($reports_2 = mysql_fetch_array($result_2)) {
				$ob2[] = $reports_2['inv'];
			}
			echo "
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
                text: '".$line."'
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
<div id=\"ener\" style=\"width: 99%; height: 422px; margin: 0 auto;\"></div>";
		}
				  echo "</div>
					</div>
				</div>
				<div class=\"dr\"><span></span></div>
                <div class=\"row-fluid\">
                    <div class=\"span5\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-dashboard fa-1x\"></i><span>".get_lang($lang, 'inter08')."</span>
                        </div>
	                    <div class=\"block-fluid\">
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
							    <tbody>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'ad188').":</td>
                                        <td>".sum_energy($filter)."</td>                                   
                                    </tr>
                                    <tr>                                    
                                        <td class=\"tar\">".get_lang($lang, 'ad230').":</td>
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
					<div class=\"span7\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-dashboard fa-1x\"></i><span>".get_lang($lang, 'ad213')."</span>
                            <ul class=\"buttons\">
                                <li class=\"tip_\" title=\"".get_lang($lang, 'td41')."\">
                                    <a target=\"_blank\" href=\"print_energy_loss_chart_pie.php?linex=".$linex."&dates=".$dates."&datex=".$datex."&filter=".$filter."&lang=".$lang."\" class=\"isw-print\"></a>
                                </li>
                            </ul>
                        </div>
	                    <div class=\"block-fluid\">";
	    mysql_query("SET NAMES 'utf8'");
        $query_ = "SELECT * FROM `reports` WHERE energy>='$filter' group by `inv` order by `energy` desc";
        $result_ = mysql_query($query_);
        confirm_query($result_);
        if (mysql_num_rows($result_) != 0 ) {
			while($reports_ = mysql_fetch_array($result_)) {
				$ob[] = $reports_['inv'];
			}
			echo "
<script type='text/javascript' charset='UTF-8'>
$(function () {
        $('#energ').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
			spacingTop: 5,
			margin: [34, 10, 10, 10],
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
            },
            title: {
                text: '".$line."'
            },
            subtitle: {
                text: '".$dates." - ".$datex."'
            },
        credits: {
            enabled: false
        },
            tooltip: {
formatter: function() {
    return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %';
}
            },
            plotOptions: {
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            },
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.y;
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '".get_lang($lang, 'ad177')."',
				data: [";
		    foreach ($ob as $ind) {
	            mysql_query("SET NAMES 'utf8'");
	            $query3 = "SELECT SUM(energy) FROM reports WHERE energy>='$filter' AND `inv`='$ind' order by `energy` desc";
                $rx3 = mysql_query($query3);
                confirm_query($rx3);
                while($row3 = mysql_fetch_array($rx3)){
	                $r3 = number_format($row3['SUM(energy)'], 2, '.', '');	
	            }
				echo "['".$ind."',".$r3."],";
		    }
				echo "]
            }]
        });
    });
</script>
<div id=\"energ\" style=\"width: 100%; height: 300px; margin: 0 auto;\"></div>";
		}
		echo "
						</div>
					</div>
				</div>";
			} else {
				echo "
                <div class=\"row-fluid\">
                    <div class=\"span12\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-dedent fa-1x\"></i><span>".get_lang($lang, 'ad178')."</span>
                        </div>
	                    <div class=\"block-fluid\">
	                        <div class=\"w98 pt10\">
							    <p class=\"text-info\">".get_lang($lang, 'ad210')." <strong>(".$filter.").</strong></p>
							</div>
						</div>
                    </div>				 
                </div>";
			}
    } else {
		echo "
                <div class=\"row-fluid\">
                    <div class=\"span12\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-dedent fa-1x\"></i><span>".get_lang($lang, 'ad178')."</span>
                        </div>
	                    <div class=\"block-fluid\">
	                        <div class=\"w98 pt10\">
							    <p class=\"text-info\">".get_lang($lang, 'ad191')." <strong>".$linex."
								</strong> ".get_lang($lang, 'ad192')." <strong>".$dates." / ".$datex.".</strong></p>
							</div>
						</div>
                    </div>				 
                </div>";
	}
}
} else {
	echo "
                <div class=\"row-fluid\">
                    <div class=\"span12\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-bar-chart-o fa-1x\"></i><span>".get_lang($lang, 'ad211')."</span>
                            <ul class=\"buttons\">
                                <li class=\"tip_\" title=\"".get_lang($lang, 'td41')."\">
                                    <a target=\"_blank\" href=\"print_energy_loss_chart.php?lang=".$lang."\" class=\"isw-print\"></a>
                                </li>
                            </ul>
                        </div>
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
	<div id=\"ene\" style=\"width: 100%; height: 400px; margin: 0 auto;\"></div>
						</div>
                    </div>				 
                </div>
				<div class=\"dr\"><span></span></div>
                <div class=\"row-fluid\">
                    <div class=\"span12\">
                        <div class=\"head clearfix\">
                            <i class=\"fa fa-dedent fa-1x\"></i><span>".get_lang($lang, 'ad178')."</span>
                        </div>
	                    <div class=\"block-fluid\">
	                        <div class='w98 pt10'>
							    <p class='text-info'>".get_lang($lang, 'ad184')."</p>
							</div>
						</div>
                    </div>				 
                </div>";
}
?>
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