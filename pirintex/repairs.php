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
$line = ""; $kline = "";
$day_n = date('N');
$yesterday = date('Y-m-d', time() - 60 * 60 * 24);
$twodays = date('Y-m-d', time() - 60 * 60 * 48);
//dates
if ($day_n == 1) { $day_e = $twodays; $day_b = date('Y-m-d', time() - 60 * 60 * 24); } else { $day_e = $yesterday; $day_b = date('Y-m-d', time()); }
    $query1 = "SELECT `added` FROM `tasks` ORDER BY `id` ASC LIMIT 1";
    $result1 = mysql_query($query1);
    confirm_query($result1);
    $row1 = mysql_fetch_array($result1);
	$mindate=$row1['added'];
    $min = date('Y-m-d',strtotime($mindate));
	$min1 = date('Y-m-d', strtotime($mindate . ' + 1 day'));
$query2 = "SELECT `added` FROM `tasks` ORDER BY `id` DESC LIMIT 1";
$result2 = mysql_query($query2);
confirm_query($result2);
$row2 = mysql_fetch_array($result2);
$maxdate=$row2['added'];
$max = date('Y-m-d',strtotime($maxdate));
$max1 = date('Y-m-d', strtotime($maxdate . ' - 1 day'));
$start = date('Y-m-d', strtotime('today - 30 days'));
if (!isset($_POST['submit'])) {
	$dates = $day_e;
	$datex = $day_b;
} else {
    $line = $_POST['line'];
    $mec = $_POST['mec'];
    $inv = $_POST['inv'];
    $prob = $_POST['problem'];
    $dates = $_POST['from'];
    $datex = $_POST['to'];
}
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
    <script type="text/javascript" src="js/plugins/elfinder/elfinder.min.js"></script>
    <script type='text/javascript' src='js/plugins/highlight/jquery.highlight-4.js'></script>
	<link rel='stylesheet' type='text/css' href='js/plugins/datepick/jquery.datepick.css' />
	<script type='text/javascript' src='js/plugins/datepick/jquery.datepick.min.js'></script>
	<script type='text/javascript' src='js/plugins/datepick/jquery.datepick-<?=$lang?>.js'></script>
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
	<script type='text/javascript' src='js/lang.js'></script>
    <script type='text/javascript' src='js/alex.js'></script>
	<script type='text/javascript'>
	$(function() {
        jQuery("select[name='line']").change(function(){	
            //var line=$(this).val();
            var line = $("select[name='line']").val();
            var dataString = 'line='+line;
            $('select[name="mec"]').attr('disabled','disabled');
            $('button[name="submit"]').attr('disabled','disabled');
            //mecs
            jQuery.ajax({
                type: "POST",
                url: "repairs_mec.php",
                data: dataString,
                success: function(html){
                    jQuery("#mec").html(html);
                    $('select[name="mec"]').removeAttr('disabled');
                    $('button[name="submit"]').removeAttr('disabled');
                }
            });
            //invs
            jQuery.ajax({
                type: "POST",
                url: "repairs_inv.php",
                data: dataString,
                success: function(html){
                    jQuery("#inv").html(html);
                }
            });
        });
        jQuery("select[name='mec']").change(function(){
            var line = $("select[name='line']").val();
            var dataString = 'line='+line;
            /*
            jQuery.ajax({
                type: "POST",
                url: "repairs_lines.php",
                success: function(html){
                    jQuery("#line").html(html);
                }
            });*/
            //invs
            jQuery.ajax({
                type: "POST",
                url: "repairs_inv.php",
                data: dataString,
                success: function(html){
                    jQuery("#inv").html(html);
                }
            });
        });
        jQuery("select[name='inv']").change(function(){	
            var line = $("select[name='line']").val();
            var dataString = 'line='+line;
            $('select[name="mec"]').attr('disabled','disabled');
            $('button[name="submit"]').attr('disabled','disabled');
            //mecs
            jQuery.ajax({
                type: "POST",
                url: "repairs_mec.php",
                data: dataString,
                success: function(html){
                    jQuery("#mec").html(html);
                    $('select[name="mec"]').removeAttr('disabled');
                    $('button[name="submit"]').removeAttr('disabled');
                }
            });
        });
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
                <li class="active">
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
                            <i class="fa fa-search fa-1x"></i><span><?php echo get_lang($lang,'Filter'); ?></span>
                        </div>
                        <div class="block-fluid">
                          <form action="" method="post" id="validation">
                            <div class="row-form clearfix">
                                <div class="span5 tar"><?php echo get_lang($lang,'ad180'); ?>:</div>
                                <div class="span7">
                                    <select name="line" id="line" class="validate[required]">
                                        <?php if((isset($_POST['submit'])) && ($line != "ALL")): ?>
                                        <option value="<?=$line?>"><?=$line?></option>
                                        <option></option>
                                        <?php endif; ?>
                                        <option value="ALL"><?php echo get_lang($lang,'ad469'); ?></option>
                                        <?php
                                        $query = "SELECT `line_name` FROM `lines` ORDER BY `line_name` ASC";
                                        $result = mysql_query($query);
                                        confirm_query($result);
                                        if (mysql_num_rows($result) != 0) {
                                        	echo "<option></option>";
                                            while($lines = mysql_fetch_array($result)) {
                                                echo "
                                                <option value=\"".$lines['line_name']."\">".$lines['line_name']."</option>";
	                                        }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row-form clearfix">
                                <div class="span5 tar"><?php echo get_lang($lang,'tu01'); ?>:</div>
                                <div class="span7">
                                    <select name="mec" id="mec" class="validate[required]">
                                        <?php if((isset($_POST['submit'])) && ($mec != "ALL")): ?>
                                        <option value="<?=$mec?>"><?php echo get_name_from($mec); ?></option>
                                        <option></option>
                                        <?php endif; ?>
                                        <option value="ALL"><?php echo get_lang($lang,'ad469'); ?></option>
                                        <?php
                                        $query = "SELECT `mec` FROM `tasks` GROUP BY `mec` ORDER BY `mec` ASC";
                                        $result = mysql_query($query);
                                        confirm_query($result);
                                        if (mysql_num_rows($result) != 0) {
                                        	echo "<option></option>";
                                            while($mecs = mysql_fetch_array($result)) {
                                                echo "
                                                <option value=\"".$mecs['mec']."\">".get_name_from($mecs['mec'])."</option>";
	                                        }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row-form clearfix">
                                <div class="span5 tar"><?php echo get_lang($lang,'info3'); ?>:</div>
                                <div class="span7">
                                    <select name="inv" id="inv">
                                        <?php if((isset($_POST['submit'])) && ($inv != "ALL")): ?>
                                        <option value="<?=$inv?>"><?php echo $inv; ?></option>
                                        <option></option>
                                        <?php endif; ?>
                                        <option value="ALL"><?php echo get_lang($lang,'ad469'); ?></option>
                                        <?php
                                        if (isset($_POST['submit'])) {
                                            if (line == "ALL") {
											    $query = "SELECT `inv` FROM `tasks` GROUP BY `inv` ORDER BY `inv` ASC";
										    } else {
											    $query = "SELECT `inv` FROM `tasks` WHERE `line`='".$line."' GROUP BY `inv` ORDER BY `inv` ASC";
										    }
										} else {
											$query = "SELECT `inv` FROM `tasks` GROUP BY `inv` ORDER BY `inv` ASC";
										}
                                        $result = mysql_query($query);
                                        confirm_query($result);
                                        if (mysql_num_rows($result) != 0) {
                                        	echo "<option></option>";
                                            while($invs = mysql_fetch_array($result)) {
                                                echo "
                                                <option value=\"".$invs['inv']."\">".$invs['inv']."</option>";
	                                        }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row-form clearfix">
                                <div class="span5 tar"><?php echo get_lang($lang,'ad458'); ?>:</div>
                                <div class="span7">
                                    <select name="problem" id="problem" class="validate[required]">
                                        <?php if((isset($_POST['submit'])) && ($prob != "ALL")): ?>
                                        <option value="<?=$prob?>"><?php echo get_problem($prob); ?></option>
                                        <option></option>
                                        <?php endif; ?>
                                        <option value="ALL"><?php echo get_lang($lang,'ad469'); ?></option>
                                        <?php
                                        $queryu = "SELECT * FROM `tasks_problems`";
                                        $resultu = mysql_query($queryu);
                                        confirm_query($resultu);
                                        if (mysql_num_rows($resultu) != 0) {
                                        	echo "<option></option>";
                                            while($problems = mysql_fetch_array($resultu)) {
                                                echo "
                                                <option value=\"".$problems['id']."\">".$problems['problem']."</option>";
	                                        }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row-form clearfix">
                                <div class="span5 tar"><?php echo get_lang($lang,'ad181')." / ".get_lang($lang,'ad182'); ?>:</div>
                                <div class="span3">
                                <input name="from" id="from" type="text" value="<?php echo $dates;?>" readonly="readonly" class="validate[custom[date],past[#to]]" />
                                </div>
                                <div class="span4">
                                <input name="to" id="to" type="text" value="<?php echo $datex;?>" readonly="readonly" class="validate[custom[date],future[#from]]" />
                                </div>
                            </div>
 
                            <div class="footer">
                                <button class="btn btn-default" type="submit" name="submit">
		                            <i class="fa fa-filter"></i>&nbsp;<?php echo get_lang($lang,'Filter'); ?></button>
							</div>
                          </form>
                        </div>
                    </div>
                </div>


                <?php if(isset($_POST['submit'])): ?>

                <div class="page-header">
                    <h1><?php echo $dates." - ".$datex;?></h1>
                </div> 
                <div class="row-fluid">
                    <div class="col-md-12">                    
                        <div class="head clearfix">
                            <?php if((isset($_POST['submit'])) && ($line != "ALL")): ?>
                            <i class="fa fa-legal fa-1x"></i><span><?php echo get_lang($lang,'ad476'); ?>&nbsp;\&nbsp;<?=$line?></span>
                            <?php else: ?>
                            <i class="fa fa-legal fa-1x"></i><span><?php echo get_lang($lang,'ad476'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="block-fluid table-sorting clearfix">
                        <?php
                            $query = 'SELECT * FROM `tasks`';

                            $cond = array();

                            if ($line != "ALL") {
                                $cond[] = "`line`='".$line."'";
                            } else {
								$cond[] = "`line` IS NOT NULL";
							}
                            if ($mec != "ALL") {
                                $cond[] = "`mec`='".$mec."'";
                            } else {
								$cond[] = "`mec` IS NOT NULL";
							}
                            if ($inv != "ALL") {
                                $cond[] = "`inv`='".$inv."'";
                            } else {
								$cond[] = "`inv` IS NOT NULL";
							}
                            if ($prob != "ALL") {
                                $cond[] = "`problem`='".$prob."'";
                            } else {
								$cond[] = "`problem` IS NOT NULL";
							}
							
                            $cond[] = "`added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00'";
                            
                            if (count($cond)) {
                                $query .= ' WHERE ' . implode(' AND ', $cond);
                            }

                            $query .= " ORDER BY `id` DESC";
                            //echo $query;
                            ///$query = "SELECT * FROM `tasks` ORDER BY `id` DESC";
                            $result = mysql_query($query);
                            confirm_query($result);
                            if (mysql_num_rows($result) != 0) {
                            	echo "
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\" id=\"tSortMecp\">
                                <thead>
                                    <tr>
                                        <th>".get_lang($lang,'info6')."</th>
                                        <th>".get_lang($lang,'info5')."</th>
                                        <th>".get_lang($lang,'Inv')."</th>
                                        <th>".get_lang($lang,'ad462')."</th>
                                        <th>".get_lang($lang,'info9')."</th>
                                        <th>".get_lang($lang,'ad464').". / ".get_lang($lang,'ad463')."</th>
                                        <th>".get_lang($lang,'tu01')."</th>
                                        <th>".get_lang($lang,'inter23')."</th>
                                    </tr>
                                </thead>
                                <tbody>
                            	";
                            	while($list = mysql_fetch_array($result)) {
                            		//init
                                	$all_p = explode(", ",$list['parts']);
                                	$all_q = explode(", ",$list['quant']);
                            		//echo
                            		echo "
                            		<tr>
                            		    <td>".$list['added']."</td>
                            		    <td>".$list['line']."</td>
                            		    <td>".$list['inv']."</td>
                            		    <td>".get_problem($list['problem'])."</td>
                            		    <td>".$list['obs']."</td>
                            		    <td>";
                                        $x=0;
                                        foreach($all_q as $single_q) {
									        echo "<p>".$single_q." / ".get_part($all_p[$x])."</p>";
									        $x++;
									    }
                            		    echo "
                            		    </td>
                            		    <td>".get_name_from($list['mec'])."</td>
                            		    <td>".$list['time']."</td>
                            		</tr>
                            		";
                            		$all_time[] = $list['time'];
                            	}
                            	$timed = array_sum($all_time)*60;
                            	echo "
                                </tbody>
	                            <tfoot>
	                                <tr class=\"foot\">
	                                    <td colspan=\"7\">
	                                        <span style=\"float:right;color:red;padding-right:10px;line-height:14px;padding-bottom:10px;\">
	                                            ".get_lang($lang,'ad230').": ".seconds2human($timed,$lang)."</span>
	                                    </td>
	                                </tr>
	                            <tfoot>
                            </table>
                            	";
                            }
                        ?>
                        </div>
                    </div>
                </div>    
                
                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-bar-chart fa-1x"></i><span><?php echo get_lang($lang,'ad470'); ?></span>
                        </div>
                        <div class="block-fluid">
                        <?php
                        error_reporting(E_ALL);
                        if ($line == "ALL") {
							$query = "SELECT `mec` FROM `tasks` WHERE `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00' GROUP BY `mec` ORDER BY `mec` ASC";
						} else {
							$query = "SELECT `mec` FROM `tasks` WHERE `line`='".$line."' AND `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00' GROUP BY `mec` ORDER BY `mec` ASC";
						}
                        $result = mysql_query($query);
                        confirm_query($result);
                        $num_rows = mysql_num_rows($result);
                        if ($num_rows != 0) {
                            while ($mecs = mysql_fetch_array($result)) {
                                $all_mecs[] = $mecs['mec']; 	
                            }	
                        }
                        foreach($all_mecs as $single) {
                        	if ($line == "ALL") {
								$query = "SELECT SUM(time) AS all_time FROM `tasks` WHERE `mec`='".$single."' AND `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00'";
							} else {
								$query = "SELECT SUM(time) AS all_time FROM `tasks` WHERE `line`='".$line."' AND `mec`='".$single."' AND `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00'";
							}
                            $result = mysql_query($query);
                            confirm_query($result);
                            $row = mysql_fetch_assoc($result); 
                            //$sum = $row['all_time'];
                            //echo $single." - ".$sum."<br/>";
                            $timex = $row['all_time']/60;
                            $all_times[] = number_format($timex,2);
						}
                        //print_r($all_times);
                        $series = implode(",",$all_times);
                        //echo $series;
			echo "
<script type='text/javascript'>
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
                text: '".get_lang($lang,'ad470')."'
            },
            subtitle: {
                text: '".$dates." - ".$datex."'
            },
            xAxis: {
                categories: [";
				foreach ($all_mecs as $cat) {
					echo "'".get_name_from($cat)."',";
				}
			echo "],
                labels: {
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                },
                offset:5
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
                    text: '".get_lang($lang,'ad471')."'
                },
                labels: {
                    formatter: function () {
                        return Highcharts.numberFormat(this.value,1) + 'ч';
                    }
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
                        '".get_lang($lang, 'ad471').": '+ Highcharts.numberFormat(this.y,2) + ' Часа';
                }
            },
            series: [{";
			echo "data: [".$series."],";
				echo "
                dataLabels: {
                    enabled: true,
                    align: 'center',
                    x: 0,
                    y: 0,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    });
</script>
<div id=\"ener\" style=\"width:100%; height: 422px; margin: 0 auto;\"></div>";
                        ?>
                        </div>
                    </div>
                    
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-bar-chart fa-1x"></i><span><?php echo get_lang($lang,'ad470'); ?></span>
                        </div>
                        <div class="block-fluid">
                        <?php
                        if ($line == "ALL") {
							$query = "SELECT `inv` FROM `tasks` WHERE `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00' GROUP BY `inv` ORDER BY `inv` ASC";
						} else {
							$query = "SELECT `inv` FROM `tasks` WHERE `line`='".$line."' AND `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00' GROUP BY `inv` ORDER BY `inv` ASC";
						}
                        $result = mysql_query($query);
                        confirm_query($result);
                        $num_rows = mysql_num_rows($result);
                        if ($num_rows != 0) {
                            while ($invs = mysql_fetch_array($result)) {
                                $all_invs[] = $invs['inv'];
                            }	
                        }
                        foreach($all_invs as $alone) {
                        	if ($line == "ALL") {
								$query = "SELECT SUM(time) AS all_inv_time FROM `tasks` WHERE `inv`='".$alone."' AND `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00'";
							} else {
								$query = "SELECT SUM(time) AS all_inv_time FROM `tasks` WHERE `line`='".$line."' AND `inv`='".$alone."' AND `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00'";
							}
                            $result = mysql_query($query);
                            confirm_query($result);
                            $row = mysql_fetch_assoc($result); 
                            //$sum = $row['all_time'];
                            //echo $single." - ".$sum."<br/>";
                            $timed = $row['all_inv_time']/60;
                            $all_timex[] = number_format($timed,2);
						}
						$master = array_combine($all_invs,$all_timex);
                        arsort($master);
                        $i=1;
                        foreach($master as $u => $v) {
                            if($i<=5) {
                            	$catx[] = $u;
                            	$serx[] = $v;
						    }
                            $i++;
					    }
					    $series1 = implode(",",$serx);
			echo "
<script type='text/javascript'>
$(function () {
        $('#ener2').highcharts({
            chart: {
                type: 'column',
			spacingTop: 5,
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
            },
            title: {
                text: '".get_lang($lang,'ad473')."'
            },
            subtitle: {
                text: '".$start." - ".$datex."'
            },
            xAxis: {
                categories: [";
				foreach ($catx as $cat) {
					echo "'".$cat." - ".get_line_from($cat)."',";
				}
			echo "],
                labels: {
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                },
                offset:5
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
                    text: '".get_lang($lang,'ad474')."'
                },
                labels: {
                    formatter: function () {
                        return Highcharts.numberFormat(this.value,1) + 'ч';
                    }
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
                        '".get_lang($lang, 'ad474').": '+ Highcharts.numberFormat(this.y,2) + ' Часа';
                }
            },
            series: [{";
			echo "data: [".$series1."],";
				echo "
                dataLabels: {
                    enabled: true,
                    align: 'center',
                    x: 0,
                    y: 0,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    });
</script>
<div id=\"ener2\" style=\"width:100%; height: 422px; margin: 0 auto;\"></div>";
                        ?>
                        </div>
                    </div>    
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-pie-chart fa-1x"></i><span><?php echo get_lang($lang,'ad478'); ?></span>
                        </div>
                        <div class="block-fluid">
                        <?php
                        $query = "SELECT `id` FROM `tasks_parts` ORDER BY `id` ASC";
                        $result = mysql_query($query);
                        confirm_query($result);
                        $num_rows = mysql_num_rows($result);
                        if ($num_rows != 0) {
                            while ($parts = mysql_fetch_array($result)) {
                                $all_parts[] = $parts['id'];
                            }	
                        }
                        foreach($all_parts as $part_single) {
                        	if ($line == "ALL") {
                        		$query = "SELECT SUM(quant) AS all_parts_total FROM `tasks_parts_total` WHERE `parts`='".$part_single."' AND `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00'";
                        	} else {
								$query = "SELECT SUM(quant) AS all_parts_total FROM `tasks_parts_total` WHERE `line`='".$line."' AND `parts`='".$part_single."' AND `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00'";
							}
                            $result = mysql_query($query);
                            confirm_query($result);
                            $row = mysql_fetch_assoc($result); 
                            if ($row['all_parts_total'] != 0) {
								$parts_all[] = $row['all_parts_total'];
							} else {
								$parts_all[] = "0";
							}
						}
                        $total_parts = array_sum($parts_all);
                        if ($total_parts > 0) {
									        echo "
                                <script type=\"text/javascript\">
Highcharts.setOptions({
    global : {
	    useUTC : false
	}
});
$(function () {
    Highcharts.setOptions({
        colors: ['#06a7ec', '#f9932d', '#20ed1b', '#f724e1', '#24CBE5', '#fd0909', '#de76b1', '#FFF263', '#6AF9C4', '#8c02aa', '#b8833a', '#06935f']
    });
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.4).get('rgb')] // darken
            ]
        };
    });
    $('#hchart2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            }
        },
        title: {
            text: '".get_lang($lang,'ad478')."'
        },
        subtitle: {
            text: '".$start." - ".$datex."'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b> ({point.y})'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                        fontSize: '12px'
                    },
                }
            },
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
        },
        credits: {
           enabled: false
        },
        series: [{
            type: 'pie',
            data: [";
                $x=0;
                foreach($all_parts as $singlep){
                	if ($parts_all[$x] != 0) {
					    echo " ['".get_part($singlep)."',".$parts_all[$x]."], ";
					}
					$x++;
				}
                echo "
            ]
        }]
    });
});
                                </script>
                                <div id=\"hchart2\" style=\"height:534px;width:100%;margin:0;padding:0;\"></div>";							
						} else {
                            echo "For this period of time there wasn't not used any parts.";
						}

                        ?>
                        </div>
                    </div>

                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-pie-chart fa-1x"></i><span><?php echo get_lang($lang,'ad477'); ?></span>
                        </div>
                        <div class="block-fluid">
                        <?php
                        $query = "SELECT `line_name` FROM `lines` ORDER BY `line_name` ASC";
                        $result = mysql_query($query);
                        confirm_query($result);
                        $num_rows = mysql_num_rows($result);
                        if ($num_rows != 0) {
                            while ($lines = mysql_fetch_array($result)) {
                                $all_lines[] = $lines['line_name'];
                            }	
                        }
                        foreach($all_lines as $linha) {
                            $query = "SELECT SUM(time) AS all_line_time FROM `tasks` WHERE `line`='".$linha."' AND `added` BETWEEN '".$dates." 00:00:00' AND '".$datex." 00:00:00'";
                            $result = mysql_query($query);
                            confirm_query($result);
                            $row = mysql_fetch_assoc($result); 
                            //$sum = $row['all_time'];
                            //echo $single." - ".$sum."<br/>";
                            $timez = $row['all_line_time']/60;
                            $all_timez[] = number_format($timez,2);
						}
									        echo "
                                <script type=\"text/javascript\">
Highcharts.setOptions({
    global : {
	    useUTC : false
	}
});
$(function () {
    Highcharts.setOptions({
        colors: ['#06a7ec', '#f9932d', '#20ed1b', '#f724e1', '#24CBE5', '#fd0909', '#de76b1', '#FFF263', '#6AF9C4']
    });
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.4).get('rgb')] // darken
            ]
        };
    });
    $('#hchart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            }
        },
        title: {
            text: '".get_lang($lang,'ad477')."'
        },
        subtitle: {
            text: '".$start." - ".$datex."'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b> ({point.y}ч)'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}ч',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                        fontSize: '12px'
                    }
                }
            },
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
        },
        credits: {
           enabled: false
        },
        series: [{
            type: 'pie',
            data: [";
                $z=0;
                foreach($all_lines as $singled){
                	if ($all_timez[$z] != 0) {
						echo " ['".$singled."',   ".$all_timez[$z]."], ";
					}
					$z++;
				}
                echo "
            ]
        }]
    });
});
                                </script>
                                <div id=\"hchart\" style=\"height:534px;width:100%;margin:0;padding:0;\"></div>";
                        ?>
                        </div>
                    </div>
                    
                </div>

                
                <!-- else -->
                <?php else: ?>
                
                
                <div class="page-header">
                    <h1><?php echo get_lang($lang,'ad475');?></h1>
                </div> 
                
                <div class="row-fluid">
                    <div class="col-md-12">                    
                        <div class="head clearfix">
                            <i class="fa fa-legal fa-1x"></i><span><?php echo get_lang($lang,'ad476');?></span>
                        </div>
                        <div class="block-fluid table-sorting clearfix">
                        <?php
                            $query = "SELECT * FROM `tasks` WHERE `added` BETWEEN '".$start." 00:00:00' AND '".$datex." 00:00:00' ORDER BY `id` DESC";
                            //$query = "SELECT * FROM `tasks` ORDER BY `id` DESC";
                            $result = mysql_query($query);
                            confirm_query($result);
                            if (mysql_num_rows($result) != 0) {
                            	echo "
                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\" id=\"tSortMec\">
                                <thead>
                                    <tr>
                                        <th>".get_lang($lang,'info6')."</th>
                                        <th>".get_lang($lang,'info5')."</th>
                                        <th>".get_lang($lang,'Inv')."</th>
                                        <th>".get_lang($lang,'ad462')."</th>
                                        <th>".get_lang($lang,'info9')."</th>
                                        <th>".get_lang($lang,'ad464').". / ".get_lang($lang,'ad463')."</th>
                                        <th>".get_lang($lang,'tu01')."</th>
                                        <th>".get_lang($lang,'inter23')."</th>
                                    </tr>
                                </thead>
                                <tbody>
                            	";
                            	while($list = mysql_fetch_array($result)) {
                            		//init
                                	$all_p = explode(", ",$list['parts']);
                                	$all_q = explode(", ",$list['quant']);
                            		//echo
                            		echo "
                            		<tr>
                            		    <td>".$list['added']."</td>
                            		    <td>".$list['line']."</td>
                            		    <td>".$list['inv']."</td>
                            		    <td>".get_problem($list['problem'])."</td>
                            		    <td>".$list['obs']."</td>
                            		    <td>";
                                        $x=0;
                                        foreach($all_q as $single_q) {
									        echo "<p>".$single_q." / ".get_part($all_p[$x])."</p>";
									        $x++;
									    }
                            		    echo "
                            		    </td>
                            		    <td>".get_name_from($list['mec'])."</td>
                            		    <td>".$list['time']."</td>
                            		</tr>
                            		";
                            		$all_time[] = $list['time'];
                            	}
                            	$timed = array_sum($all_time)*60;
                            	echo "
                                </tbody>
	                            <tfoot>
	                                <tr class=\"foot\">
	                                    <td colspan=\"8\">
	                                        <span style=\"float:right;color:red;padding-right:10px;line-height:14px;padding-bottom:10px;\">
	                                            ".get_lang($lang,'ad230').": ".seconds2human($timed,$lang)."</span>
	                                    </td>
	                                </tr>
	                            <tfoot>
                            </table>
                            	";
                            }
                        ?>
                        </div>
                    </div>
                </div>    

                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-bar-chart fa-1x"></i><span><?php echo get_lang($lang,'ad470'); ?></span>
                        </div>
                        <div class="block-fluid">
                        <?php
                        $query = "SELECT `mec` FROM `tasks` WHERE `added` BETWEEN '".$start." 00:00:00' AND '".$datex." 00:00:00' GROUP BY `mec` ORDER BY `mec` ASC";
                        $result = mysql_query($query);
                        confirm_query($result);
                        $num_rows = mysql_num_rows($result);
                        if ($num_rows != 0) {
                            while ($mecs = mysql_fetch_array($result)) {
                                $all_mecs[] = $mecs['mec']; 	
                            }	
                        }
                        foreach($all_mecs as $single) {
                            $query = "SELECT SUM(time) AS all_time FROM `tasks` WHERE `mec`='".$single."' AND `added` BETWEEN '".$start." 00:00:00' AND '".$datex." 00:00:00'";
                            $result = mysql_query($query);
                            confirm_query($result);
                            $row = mysql_fetch_assoc($result); 
                            //$sum = $row['all_time'];
                            //echo $single." - ".$sum."<br/>";
                            $timex = $row['all_time']/60;
                            $all_times[] = number_format($timex,2);
						}
                        //print_r($all_times);
                        $series = implode(",",$all_times);
                        //echo $series;
			echo "
<script type='text/javascript'>
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
                text: '".get_lang($lang,'ad470')."'
            },
            subtitle: {
                text: '".$start." - ".$datex."'
            },
            xAxis: {
                categories: [";
				foreach ($all_mecs as $cat) {
					echo "'".get_name_from($cat)."',";
				}
			echo "],
                labels: {
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                },
                offset:5
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
                    text: '".get_lang($lang,'ad471')."'
                },
                labels: {
                    formatter: function () {
                        return Highcharts.numberFormat(this.value,1) + 'ч';
                    }
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
                        '".get_lang($lang, 'ad471').": '+ Highcharts.numberFormat(this.y,2) + ' Часа';
                }
            },
            series: [{";
			echo "data: [".$series."],";
				echo "
                dataLabels: {
                    enabled: true,
                    align: 'center',
                    x: 0,
                    y: 0,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    });
</script>
<div id=\"ener\" style=\"width:100%; height: 422px; margin: 0 auto;\"></div>";
                        ?>
                        </div>
                    </div>
          
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-bar-chart fa-1x"></i><span><?php echo get_lang($lang,'ad473'); ?></span>
                        </div>
                        <div class="block-fluid">
                        <?php
                        $query = "SELECT `inv` FROM `tasks` WHERE `added` BETWEEN '".$start." 00:00:00' AND '".$datex." 00:00:00' GROUP BY `inv` ORDER BY `inv` ASC";
                        $result = mysql_query($query);
                        confirm_query($result);
                        $num_rows = mysql_num_rows($result);
                        if ($num_rows != 0) {
                            while ($invs = mysql_fetch_array($result)) {
                                $all_invs[] = $invs['inv'];
                            }	
                        }
                        foreach($all_invs as $alone) {
                            $query = "SELECT SUM(time) AS all_inv_time FROM `tasks` WHERE `inv`='".$alone."' AND `added` BETWEEN '".$start." 00:00:00' AND '".$datex." 00:00:00'";
                            $result = mysql_query($query);
                            confirm_query($result);
                            $row = mysql_fetch_assoc($result); 
                            //$sum = $row['all_time'];
                            //echo $single." - ".$sum."<br/>";
                            $timed = $row['all_inv_time']/60;
                            $all_timex[] = number_format($timed,2);
						}
						$master = array_combine($all_invs,$all_timex);
                        arsort($master);
                        $i=1;
                        foreach($master as $u => $v) {
                            if($i<=5) {
                            	$catx[] = $u;
                            	$serx[] = $v;
						    }
                            $i++;
					    }
					    $series1 = implode(",",$serx);
			echo "
<script type='text/javascript'>
$(function () {
        $('#ener2').highcharts({
            chart: {
                type: 'column',
			spacingTop: 5,
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
            },
            title: {
                text: '".get_lang($lang,'ad473')."'
            },
            subtitle: {
                text: '".$start." - ".$datex."'
            },
            xAxis: {
                categories: [";
				foreach ($catx as $cat) {
					echo "'".$cat." - ".get_line_from($cat)."',";
				}
			echo "],
                labels: {
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                },
                offset:5
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
                    text: '".get_lang($lang,'ad474')."'
                },
                labels: {
                    formatter: function () {
                        return Highcharts.numberFormat(this.value,1) + 'ч';
                    }
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
                        '".get_lang($lang, 'ad474').": '+ Highcharts.numberFormat(this.y,2) + ' Часа';
                }
            },
            series: [{";
			echo "data: [".$series1."],";
				echo "
                dataLabels: {
                    enabled: true,
                    align: 'center',
                    x: 0,
                    y: 0,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    });
</script>
<div id=\"ener2\" style=\"width:100%; height: 422px; margin: 0 auto;\"></div>";
                        ?>
                        </div>
                    </div>
                </div>   
                
                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-pie-chart fa-1x"></i><span><?php echo get_lang($lang,'ad478'); ?></span>
                        </div>
                        <div class="block-fluid">
                        <?php
                        $query = "SELECT `id` FROM `tasks_parts` ORDER BY `id` ASC";
                        //$query = "SELECT `parts` FROM `tasks_parts_total` WHERE `added` BETWEEN '".$start." 00:00:00' AND '".$datex." 00:00:00' GROUP BY `parts` ORDER BY `parts` ASC";
                        $result = mysql_query($query);
                        confirm_query($result);
                        $num_rows = mysql_num_rows($result);
                        if ($num_rows != 0) {
                            while ($parts = mysql_fetch_array($result)) {
                                $all_parts[] = $parts['id'];
                            }	
                        }
                        foreach($all_parts as $part_single) {
                            $query = "SELECT SUM(quant) AS all_parts_total FROM `tasks_parts_total` WHERE `parts`='".$part_single."' AND `added` BETWEEN '".$start." 00:00:00' AND '".$datex." 00:00:00'";
                            $result = mysql_query($query);
                            confirm_query($result);
                            $row = mysql_fetch_assoc($result); 
                            if ($row['all_parts_total'] != 0) {
								$parts_all[] = $row['all_parts_total'];
							} else {
								$parts_all[] = "0";
							}
						}
                        $total_parts = array_sum($parts_all);
                        if ($total_parts > 0) {
									        echo "
                                <script type=\"text/javascript\">
Highcharts.setOptions({
    global : {
	    useUTC : false
	}
});
$(function () {
    Highcharts.setOptions({
        colors: ['#06a7ec', '#f9932d', '#20ed1b', '#f724e1', '#24CBE5', '#fd0909', '#de76b1', '#FFF263', '#6AF9C4', '#8c02aa', '#b8833a', '#06935f']
    });
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.4).get('rgb')] // darken
            ]
        };
    });
    $('#hchart2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            }
        },
        title: {
            text: '".get_lang($lang,'ad478')."'
        },
        subtitle: {
            text: '".$start." - ".$datex."'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b> ({point.y})'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                        fontSize: '12px'
                    },
                }
            },
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
        },
        credits: {
           enabled: false
        },
        series: [{
            type: 'pie',
            data: [";
                $x=0;
                foreach($all_parts as $singlep){
                	if ($parts_all[$x] != 0) {
					    echo " ['".get_part($singlep)."',".$parts_all[$x]."], ";
					}
					$x++;
				}
                echo "
            ]
        }]
    });
});
                                </script>
                                <div id=\"hchart2\" style=\"height:534px;width:100%;margin:0;padding:0;\"></div>";                        	
                        } else {
	                        echo "For this period of time there wasn't not used any parts.";
						}
                        ?>
                        </div>
                    </div>
                    
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-pie-chart fa-1x"></i><span><?php echo get_lang($lang,'ad477'); ?></span>
                        </div>
                        <div class="block-fluid">
                        <?php
                        $query = "SELECT `line_name` FROM `lines` ORDER BY `line_name` ASC";
                        $result = mysql_query($query);
                        confirm_query($result);
                        $num_rows = mysql_num_rows($result);
                        if ($num_rows != 0) {
                            while ($lines = mysql_fetch_array($result)) {
                                $all_lines[] = $lines['line_name'];
                            }	
                        }
                        foreach($all_lines as $linha) {
                            $query = "SELECT SUM(time) AS all_line_time FROM `tasks` WHERE `line`='".$linha."' AND `added` BETWEEN '".$start." 00:00:00' AND '".$datex." 00:00:00'";
                            $result = mysql_query($query);
                            confirm_query($result);
                            $row = mysql_fetch_assoc($result); 
                            //$sum = $row['all_time'];
                            //echo $single." - ".$sum."<br/>";
                            $timez = $row['all_line_time']/60;
                            $all_timez[] = number_format($timez,2);
						}
									        echo "
                                <script type=\"text/javascript\">
Highcharts.setOptions({
    global : {
	    useUTC : false
	}
});
$(function () {
    Highcharts.setOptions({
        colors: ['#06a7ec', '#f9932d', '#20ed1b', '#f724e1', '#24CBE5', '#fd0909', '#de76b1', '#FFF263', '#6AF9C4']
    });
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.4).get('rgb')] // darken
            ]
        };
    });
    $('#hchart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            }
        },
        title: {
            text: '".get_lang($lang,'ad477')."'
        },
        subtitle: {
            text: '".$start." - ".$datex."'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b> ({point.y}ч)'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}ч',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                        fontSize: '12px'
                    }
                }
            },
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
        },
        credits: {
           enabled: false
        },
        series: [{
            type: 'pie',
            data: [";
                $z=0;
                foreach($all_lines as $singled){
                	if ($all_timez[$z] != 0) {
						echo " ['".$singled."',   ".$all_timez[$z]."], ";
					}
					$z++;
				}
                echo "
            ]
        }]
    });
});
                                </script>
                                <div id=\"hchart\" style=\"height:534px;width:100%;margin:0;padding:0;\"></div>";
                        ?>
                        </div>
                    </div>
                </div> 
                
                <?php endif; ?>

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