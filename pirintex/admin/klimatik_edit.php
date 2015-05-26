<!DOCTYPE html>
<html lang="en">
<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
$krouter = mysql_prep($_GET['krouter']);
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
			minDate: new Date(2009, 1 - 1, 1),
			maxDate: '+0d',
			pickerClass: 'noPrevNext'
		});
	});
	function noSunday(date){ 
           var day = date.getDay(); 
                       return [(day > 0), '']; 
    };	
	</script>
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
                    <ul><?php get_controllers_for_edit($lang,$line); ?></ul>
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
                            <i class="fa fa-square fa-1x"></i><span><?php echo get_lang($lang, 'ad319'); ?></span>
                            <ul class="buttons">
                                <li class="tip_" title="<?php echo get_lang($lang, 'Back'); ?>">
                                    <a href="javascript: history.go(-1);" class="isw-left_circle"></a>
                                </li>
                            </ul>  
                        </div>
                        <div class="block-fluid">
<?php
    mysql_query("SET NAMES 'utf8'");
    $result = mysql_query("SELECT * FROM `klimatik` WHERE `inv`='$inv' AND `router`='$krouter'");  
	confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
	$krouter_options = get_krouter_options($line);
    $klima_data = get_klima_data($inv,$krouter);
        echo "
<form action='klimatik_update.php?lang=".$lang."&krouter=".$krouter."&inv=".$inv."' method='post' id='validation'>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info3').":</div>
    <div class='span7'>";
if ($user_settings['level'] < 10) {
	echo "<input id='inv' name='inv' type='text' class='validate[required,custom[onlyNumberSp]]' readonly='readonly' MAXLENGTH='6' value='".$klima_data['inv']."' /></div>";
} else {
	echo "<input id='inv' name='inv' type='text' class='validate[required,custom[onlyNumberSp]]' MAXLENGTH='6' value='".$klima_data['inv']."' /></div>";
}
echo "<div class='span1'><span id='status'></span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info4').":</div>
    <div class='span8'>
	<input name='router' type='text' class='validate[required]' readonly='readonly' MAXLENGTH='32' value='".$klima_data['router']."' /></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info4').":</div>
    <div class='span8'>
	<input name='main_line' type='text' class='validate[required]' MAXLENGTH='32' value='".$klima_data['main_line']."' /></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info5').":</div>
    <div class='span8'>
	<input name='linex' type='text' class='validate[required]' MAXLENGTH='32' value='".$klima_data['line']."' />
	<span>".get_lang($lang, 'Example').": Joop</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info6').":</div>
    <div class='span8'>
	<input id='from' name='from' type='text' MAXLENGTH='10' value='".$klima_data['date']."' readonly='readonly' />
	<span>".get_lang($lang, 'Example').": 2010-11-20</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>RTU:</div>
    <div class='span8'>
	<input name='rtu' type='text' MAXLENGTH='2' value='".$klima_data['rtu']."' />
	<span>".get_lang($lang, 'Example').": 1</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>ADDR:</div>
    <div class='span8'>
	<input name='addr' type='text' MAXLENGTH='2' value='".$klima_data['addr']."' />
	<span>".get_lang($lang, 'Example').": 05</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'ad314').":</div>
    <div class='span8'>
	<input name='where' type='text' MAXLENGTH='64' value='".$klima_data['where']."' /></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'Name')."</div>
    <div class='span8'>
	<input name='name' type='text' MAXLENGTH='64' value='".$klima_data['name']."' /></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info9').":</div>
    <div class='span8'>
	<textarea name='desc' type='text' MAXLENGTH='256' value=''>".$klima_data['desc']."</textarea></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info19')." :</div>
    <div class='span8'>
	<input name='org' type='text' MAXLENGTH='48' readonly='readonly' value='".$klima_data['org']."' /></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info20')." :</div>
    <div class='span8'>
	<input name='plant' type='text' MAXLENGTH='2' value='".$klima_data['plant']."' /></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info21')." :</div>
    <div class='span8'>
	<input name='floor' type='text' MAXLENGTH='2' value='".$klima_data['floor']."' /></div>
</div>
    <div class='footer'>
	    <input type='hidden' id='id' name='id' value='".$klima_data['id']."'> 
	    <button class='fl btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		<i class='fa fa-times'></i>&nbsp; ". get_lang($lang, 'Cancel')."</button>";
						    if ($user_settings['level'] < 4) {
								echo "
								<span class=\"label label-important\">". get_lang($lang, 'ad136').": 4</span>
							        <button class='btn btn-default' type='submit' name='submit' disabled='disabled' disabled>
		                            <i class='fa fa-save'></i>&nbsp; ".get_lang($lang, 'inter126')."</button>
							    ";
							} else {
								echo "
								<span class=\"label label-success\">". get_lang($lang, 'ad136').": 4</span>
							        <button class='btn btn-default' type='submit' name='submit'>
		                            <i class='fa fa-save'></i>&nbsp; ".get_lang($lang, 'inter126')."</button>
								";
							}
echo "
    </div>
</form>
";
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
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
$("#inv").keyup(function() { 
var klimaid = $("#id").val();
var klimainv = $("#inv").val();
if (klimainv != null) {
$("#inv").html('<img src="img/loaders/s_loader_bw.gif" />');
			$.ajax({
				url: 'klimatik_check2.php?klimaid='+klimaid+'&klimainv='+klimainv,
				type: 'POST',
				success: function(data) {
			$('span#status').html(data);
			},
				cache: false
			});
return false;
}
});
$("#inv").change(function() { 
var klimaid = $("#id").val();
var klimainv = $("#inv").val();
if (klimainv != null) {
$("#inv").html('<img src="img/loaders/s_loader_bw.gif" />');
			$.ajax({
				url: 'klimatik_check2.php?klimaid='+klimaid+'&klimainv='+klimainv,
				type: 'POST',
				success: function(data) {
			$('span#status').html(data);
			},
				cache: false
			});
return false;
}
});
});
</script>
</body>
</html>