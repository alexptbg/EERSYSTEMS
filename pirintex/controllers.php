<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(0);
define('start', TRUE);
include('includes/db.php');
include('includes/functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('includes/config.php');
$line = mysql_prep($_GET['line']);
if ($_GET['inv'] != null){ $inv = $_GET['inv']; }
$page = htmlentities($_SERVER['PHP_SELF'])."?lang=".$lang;
$line_options = get_line_options($line);
$img_dir = "img/controllers/".$line_options['line_sname']."/";
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
    <script type='text/javascript' src='js/plugins/select2/select2.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/uniform/uniform.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/languages/jquery.validationEngine-<?=$lang?>.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/jquery.validationEngine.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/cleditor/jquery.cleditor.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/dataTables/jquery.dataTables.min.js' charset='utf-8'></script>    
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
	<script type='text/javascript' src='js/lang.js'></script>
    <script type='text/javascript' src='js/alex.js'></script>
</head>
<body>
    <div class="wrapper <?=$site_theme?>">
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
				<li class="openable active">
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
                            <i class="fa fa-inbox fa-1x"></i><span><?php echo get_lang($lang, 'td47') . " " . $line; ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php
							echo "<div class='w98 pt10'>";
							$controllers = get_all_controllers($line);
							if (empty($controllers)) {
								get_error($lang,'1030');
							} else {
								$z = count($controllers);
								foreach ($controllers as $controller) {
									if (($inv != NULL) && ($controller == $inv)){
										echo "<a href='".$page."&line=".$line."&inv=".$controller."' class='btn btn-primary'>".$controller."</a>\n";
									} else {
										echo "<a href='".$page."&line=".$line."&inv=".$controller."' class='btn btn-default'>".$controller."</a>\n";
									}
								}
							}
							echo "</div>";
							?>
                            <div class="footer">
							    <?php
							        if (!empty($controllers)) { 
									    echo "<span class=\"fl label label-info\">".get_lang($lang, 'inter08').": ".$z."</span><br/>";
									}
										echo "
                                             <div class=\"input-append\">
											   <form id=\"validation\" action=\"#\" method=\"post\" class=\"form\">
                                                 <input id=\"appendedInputButton\" style=\"width: 76px;\" type=\"text\" value=\"\" name=\"inv\" class=\"validate[required,custom[onlyNumberSp]]\" MAXLENGTH='6'>
					                             <button class=\"btn btn-default\" type=\"submit\" name=\"submit\">
												 <i class=\"fa fa-search\"></i>&nbsp; ".get_lang($lang, 'inter87')."</button>
											   </form>
                                             </div>  
										";
								?>
                            </div>
                        </div>
                    </div>
                </div>   

                <div class="dr"><span></span></div>

                <div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'info1'); ?></span>
							<?php
							if ($inv != NULL){
							    echo "
                            <ul class=\"buttons\">";
                                echo "
                                <li class=\"tip-\" title=\"".get_lang($lang, 'Print')."\">
                                    <a target=\"_blank\" href=\"print_controller.php?line=".$line."&lang=".$lang."&inv=".$inv."\" class=\"isw-print\"></a>
                                </li>
                            </ul> 
								";
							}
							?>
                        </div>
                        
                            <?php
                                if(isset($_POST['submit'])) {
									echo "<div class=\"block-fluid\">";
                                    if ($_POST['inv'] != null){ $inv = $_POST['inv']; }
										$data = search_controller($inv);
										if ($data == NULL) {
											echo "<p class='text-error'>".get_lang($lang, 'ad149')."</p>";
										} else {
                                            echo "<div class=\"accordion\">";
                                            foreach($data as $row => $innerArray){
												$k = count($innerArray);
	                                            echo "<h3>".$row." (".$k.")</h3><div><div class=\"w98 pt10\">";
                                                foreach($innerArray as $innerRow => $value){
									                if (($inv != NULL) && ($row == $inv)){
										                echo "<a href='".$page."&line=".$row."&inv=".$value."' class='btn btn-primary'>".$value."</a>\n";
									                } else {
										                echo "<a href='".$page."&line=".$row."&inv=".$value."' class='btn btn-default'>".$value."</a>\n";
									                }
                                                }
                                                echo "</div></div>";
                                            }
                                            echo "</div><br/>";
										}
								} else {
                                if ($inv != null) {
									echo "<div class=\"block-fluid\">";
									$controller_data = get_controller_data($inv,$line);
	                                $photo = $img_dir.$inv.".jpg";
                                    $thumb = $img_dir."th_".$inv.".jpg";
                                    echo "
	<table cellpadding='0' cellspacing='0' class='table'>
      <tr><th style='text-align:center;' colspan='2'>".get_lang($lang, 'Controller')." ".$controller_data['inv']."</th></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info3').":</td><td class='x70'>".$controller_data['inv']."</td></tr>
      <tr><td class='x30 tar b'>".get_lang($lang, 'Image').":</td><td class='x70'>";
            if (file_exists($photo)) {
                echo "<a class='fancybox' rel='group' href='".$photo."'>
				          <img src='".$thumb."' style='width:50px;height:50px;' class='img-polaroid' />";
            } else {
                echo "<a class='fancybox' rel='group' href='img/controllers/noimage.png'>
				          <img src='img/controllers/noimage.png' style='width:50px;height:50px;' class='img-polaroid' />";
            }
		  echo "</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info4').":</td><td class='x70'>".$controller_data['main_line']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info5').":</td><td class='x70'>".$controller_data['line']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info6').":</td><td class='x70'>".$controller_data['date']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info7').":</td><td class='x70'>".$controller_data['mark']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info8').":</td><td class='x70'>".$controller_data['type']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info9').":</td><td class='x70'>".$controller_data['desc']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info10').":</td><td class='x70'>".$controller_data['machine']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info11').":</td><td class='x70'>".$controller_data['serial']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info12').":</td><td class='x70'>".$controller_data['cmode']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info13').":</td><td class='x70'>".$controller_data['t1']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info14').":</td><td class='x70'>".$controller_data['t2']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info15').":</td><td class='x70'>".$controller_data['t3']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info16').":</td><td class='x70'>".$controller_data['t4']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info17').":</td><td class='x70'>".$controller_data['t5']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info18').":</td><td class='x70'>".$controller_data['t6']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info24').":</td><td class='x70'>".$controller_data['tl1']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info25').":</td><td class='x70'>".$controller_data['tl2']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info26').":</td><td class='x70'>".$controller_data['tl3']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info27').":</td><td class='x70'>".$controller_data['tl4']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info28').":</td><td class='x70'>".$controller_data['tl5']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info29').":</td><td class='x70'>".$controller_data['tl6']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info19').":</td><td class='x70'>".$controller_data['org']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info20').":</td><td class='x70'>".$controller_data['plant']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info21').":</td><td class='x70'>".$controller_data['floor']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info22').":</td><td class='x70'>".$controller_data['group_number']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info32').":</td><td class='x70'>".$controller_data['group_name']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info23').":</td><td class='x70'>".$controller_data['oper']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info30').":</td><td class='x70'>".$controller_data['vizor']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info31').":</td><td class='x70'>".$controller_data['mobile']."</td></tr>
	  </table>";
								} else {
									echo "<div class=\"block-fluid\">";
							        if (empty($controllers)) {
									    echo "<div class='w98 pt10'><p class='text-error'>";
									    echo get_lang($lang, 'ad60');
									    echo "</p></div>";
							        } else {
									    echo "<div class='w98 pt10'><p class='text-info'>";
									    echo get_lang($lang, 'ad59');
									    echo "</p></div>";
									}
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
