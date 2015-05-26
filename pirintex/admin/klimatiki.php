<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
$krouter = mysql_prep($_GET['krouter']);
if ($_GET['inv'] != null){ $inv = $_GET['inv']; }
$page = htmlentities($_SERVER['PHP_SELF'])."?lang=".$lang;
$krouter_options = get_krouter_options($krouter);
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
    <script type='text/javascript' src='js/plugins/sparklines/jquery.sparkline.min.js' charset='utf-8'></script>
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
            <a class="logo" href="../index.php?lang=<?=$lang?>">
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
                    <li><span class="icon-cog"></span> <a href="my_profile.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'ad22'); ?></a></li>
                    <li><span class="icon-share-alt"></span> 
					    <a href="logout.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'Logout'); ?></a></li>
                </ul>
                <div class="info">
                    <span><?php echo get_lang($lang, 'inter84') . "!"; ?></span><br/>
					<span><?php echo get_lang($lang, 'inter135').":<br/>".$user_settings['last_login']; ?></span>
                </div>
            </div>
			
            <ul class="navigation">            
                <li>
                    <a href="admin.php?lang=<?=$lang?>">
                        <span class="isw-grid"></span><span class="text"><?php echo get_lang($lang, 'home'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="settings.php?lang=<?=$lang?>">
                        <span class="isw-settings"></span><span class="text"><?php echo get_lang($lang, 'ad26'); ?></span>
                    </a>
                </li>   
                <li>
                    <a href="users.php?lang=<?=$lang?>">
                        <span class="isw-users"></span><span class="text"><?php echo get_lang($lang, 'ad01'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="lines.php?lang=<?=$lang?>">
                        <span class="isw-list"></span><span class="text"><?php echo get_lang($lang, 'ad27'); ?></span>
                    </a>
                </li> 
				<li class="openable">
                    <a href="#">
                        <span class="isw-calendar"></span><span class="text"><?php echo get_lang($lang, 'ad28'); ?></span>
                    </a>
                    <ul> <?php get_controllers_for_edit($lang,$line); ?></ul>
				</li>
                <li>
                    <a href="klima_routers.php?lang=<?=$lang?>">
                        <span class="isw-bookmark"></span><span class="text"><?php echo get_lang($lang, 'ad300'); ?></span>
                    </a>
                </li>
				<li class="openable active">
                    <a href="#">
                        <span class="isw-archive"></span><span class="text"><?php echo get_lang($lang, 'ad310'); ?></span>
                    </a>
                    <ul><?php get_klimas($lang,$krouter); ?></ul>
				</li>
                <li>
                    <a href="server.php?lang=<?=$lang?>">
                        <span class="isw-target"></span><span class="text"><?php echo get_lang($lang, 'inter93'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="logs.php?lang=<?=$lang?>">
                        <span class="isw-text_document"></span><span class="text"><?php echo get_lang($lang, 'ad120'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="license.php?lang=<?=$lang?>">
                        <span class="isw-unlock"></span><span class="text"><?php echo get_lang($lang, 'License'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="faq.php?lang=<?=$lang?>">
                        <span class="isw-tag"></span><span class="text"><?php echo get_lang($lang, 'FAQ'); ?></span>                 
                    </a>
                </li>
                <li>
                    <a href="../index.php?lang=<?=$lang?>">
                        <span class="isw-left_circle"></span><span class="text"><?php echo get_lang($lang, 'ad193'); ?></span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="content">
            <div class="breadLine">
                <ul class="breadcrumb">
                    <li><?php echo get_lang($lang, 'inter61'); ?></li>
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
                            <i class="fa fa-square fa-1x"></i><span><?php echo get_lang($lang, 'ad310') . " " . $line; ?></span>
                        </div>
                        <div class="block-fluid">
                            <?php
							echo "<div class=\"w98 pt10\">";
							$klimas = get_all_klimas($krouter);
							if (empty($klimas)) {
								get_error($lang,'1046');
							} else {
								$z = count($klimas);
								foreach ($klimas as $klima) {
									if (($inv != NULL) && ($klima == $inv)){
										echo "<a href=\"".$page."&krouter=".$krouter."&inv=".$klima."\" class=\"btn btn-primary\">".$klima."</a>\n";
									} else {
										echo "<a href=\"".$page."&krouter=".$krouter."&inv=".$klima."\" class=\"btn btn-default\">".$klima."</a>\n";
									}
								}
							}
							echo "</div>";
							?>
                            <div class="footer">
							    <?php
							        if (!empty($klimas)) { 
									    echo "<span class=\"fl label label-info\">".get_lang($lang, 'inter08').": ".$z."</span><br/>";
									}
										echo "
                                             <div class=\"fl input-append\">
											   <form id=\"validation\" action=\"#\" method=\"post\" class=\"form\">
                                                 <input id=\"appendedInputButton\" style=\"width: 76px;\" type=\"text\" value=\"\" name=\"inv\" class=\"validate[required,custom[onlyNumberSp]]\" MAXLENGTH='6'>
					                             <button class=\"btn btn-default\" type=\"submit\" name=\"submit\">
												 <i class=\"fa fa-search\"></i>&nbsp; ".get_lang($lang, 'ad311')."</button>
											   </form>
                                             </div>";
							if ($user_settings['level'] > 3) {
								echo "<span class=\"label label-success\">". get_lang($lang, 'ad136').": 4</span>";
							} else {
								echo "<span class=\"label label-important\">". get_lang($lang, 'ad136').": 4</span>";
							}
                                    echo "
                                         <button class=\"btn btn-default\" onClick=\"document.location.href = 'klimatik_add.php?lang=".$lang."&krouter=".$krouter."'; return false;\"><i class=\"fa fa-plus\"></i>&nbsp; ".get_lang($lang, 'ad312')."</button>";
								?>
                            </div>
                        </div>
                    </div>
                </div>   
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span12">                    
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'ad313'); ?></span>
							<?php
							if ($inv != NULL) {
							    echo "<ul class=\"buttons\">
                                <li class=\"tip-\" title=\"".get_lang($lang, 'Edit')."\">
                                    <a href=\"klimatik_edit.php?lang=".$lang."&krouter=".$krouter."&inv=".$inv."\" class=\"isw-edit\"></a>
                                </li>
                                <li class=\"tip-\" title=\"".get_lang($lang, 'Print')."\">
                                    <a target=\"_blank\" href=\"print_klimatik.php?krouter=".$krouter."&lang=".$lang."&inv=".$inv."\" class=\"isw-print\"></a>
                                </li>
                            </ul>";
							}
							?>
                        </div>
                        <div class="block-fluid">
                            <?php
                                if(isset($_POST['submit'])) {
                                    if ($_POST['inv'] != null){ $inv = $_POST['inv']; }
										$data = search_klimatik($inv);
										if ($data == NULL) {
											echo "<p class=\"text-error\" style=\"padding:10px 0px 0px 10px;\">".get_lang($lang, 'ad149')."</p>";
										} else {
                                            echo "<div class=\"accordion\">";
                                            foreach($data as $row => $innerArray){
												$k = count($innerArray);
	                                            echo "<h3>".$row." (".$k.")</h3><div><div class=\"w98 pt10\">";
                                                foreach($innerArray as $innerRow => $value){
									                if (($inv != NULL) && ($row == $inv)){
										                echo "<a href='".$page."&krouter=".$row."&inv=".$value."' class='btn btn-primary'>".$value."</a>\n";
									                } else {
										                echo "<a href='".$page."&krouter=".$row."&inv=".$value."' class='btn btn-default'>".$value."</a>\n";
									                }
                                                }
                                                echo "</div></div>";
                                            }
                                            echo "</div>";
										}
								} else {
                                if ($inv != null) {
									echo "<div class=\"block-fluid\">";
									$klima_data = get_klima_data($inv,$krouter);
                                    echo "
	<table cellpadding='0' cellspacing='0' class='table'>
      <tr><th style='text-align:center;' colspan='2'>".get_lang($lang, 'ad275')." ".$klima_data['inv']."</th></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info3').":</td><td class='x70'>".$klima_data['inv']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'ad302').":</td><td class='x70'>".$klima_data['router']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info4').":</td><td class='x70'>".$klima_data['main_line']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info5').":</td><td class='x70'>".$klima_data['line']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info6').":</td><td class='x70'>".$klima_data['date']."</td></tr>
	  <tr><td class='x30 tar b'>RTU:</td><td class='x70'>".$klima_data['rtu']."</td></tr>
	  <tr><td class='x30 tar b'>ADDR:</td><td class='x70'>".$klima_data['addr']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'ad314').":</td><td class='x70'>".$klima_data['where']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'Name').":</td><td class='x70'>".$klima_data['name']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info9').":</td><td class='x70'>".$klima_data['desc']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info19').":</td><td class='x70'>".$klima_data['org']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info20').":</td><td class='x70'>".$klima_data['plant']."</td></tr>
	  <tr><td class='x30 tar b'>".get_lang($lang, 'info21').":</td><td class='x70'>".$klima_data['floor']."</td></tr>
	  </table>
	  <div class='row-fluid w98'>
	  <div class=\"span6\">";
	  if ($user_settings['level'] > 5) {
	  echo "
	  <span class=\"fl label label-success\">". get_lang($lang, 'ad136').": 10</span><br/>
      <button class=\"fl btn btn-danger\" onClick=\"confirmz('$krouter','$inv'); return false;\"><i class=\"fa fa-times\"></i>&nbsp; ". get_lang($lang, 'ad315')."</button>
<script type=\"text/javascript\">
function confirmz(krouter,inv) {
	var answer = confirm(\" ".get_lang($lang, 'ad315')." \" + inv + \"? (\" +krouter+ \") \");
	if (answer){ invdel(krouter,inv); }
	else{ alert(\"".get_lang($lang, 'ad317')."\"); }
}
function invdel(krouter,inv) {
   $.ajax({
   type: \"POST\",
   url: \"klimatik_del.php?krouter=\"+krouter+\"&inv=\"+inv,
   success: function(){
     alert(inv + \" ".get_lang($lang, 'ad318')."\");
     var delay = 1000;
     setTimeout(function(){ window.location.href = 'klimatiki.php?lang=".$lang."&krouter=".$krouter."'; }, delay);
   }
 });
    return false;
}
</script>";
	  } else {
	  echo "
	  <span class=\"fl label label-important\">". get_lang($lang, 'ad136').": 10</span><br/>
      <button class=\"fl btn btn-default\" disabled=\"disabled\" disabled><i class=\"fa fa-times\"></i>&nbsp; ". get_lang($lang, 'ad315')."</button>";
	  }
echo "</div><div class=\"span6 tar\">";
if ($user_settings['level'] > 3) {
	echo "<span class=\"label label-success\">". get_lang($lang, 'ad136').": 4</span><br/>
	<button class=\"btn btn-default\" onClick=\"document.location.href = 'klimatik_edit.php?lang=".$lang."&krouter=".$krouter."&inv=".$inv."'; return false;\"><i class=\"fa fa-edit\"></i>&nbsp; ". get_lang($lang, 'ad319')."</button>";
} else {
	echo "<span class=\"label label-important\">". get_lang($lang, 'ad136').": 4</span><br/>
	<button class=\"btn btn-default\" onClick=\"document.location.href = 'klimatik_edit.php?lang=".$lang."&krouter=".$krouter."&inv=".$inv."'; return false;\"><i class=\"fa fa-edit\" disabled=\"disabled\" disabled></i>&nbsp; ". get_lang($lang, 'ad319')."</button>";
}
echo "</div></div>";
								} else {
							        if (empty($klimas)) {
									    echo "<div class=\"w98 pt10\"><p class=\"text-error\">";
									    echo get_lang($lang, 'ad60');
									    echo "</p></div>";
							        } else {
									    echo "<div class=\"w98 pt10\"><p class=\"text-info\">";
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