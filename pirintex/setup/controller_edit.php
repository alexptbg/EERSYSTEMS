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
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js' charset='utf-8'></script>
	<link rel='stylesheet' type='text/css' href='js/plugins/datepick/jquery.datepick.css' />
	<script type='text/javascript' src='js/plugins/datepick/jquery.datepick.min.js'></script>
	<script type='text/javascript' src='js/plugins/datepick/jquery.datepick-<?=$lang?>.js'></script>
    <script type='text/javascript' src='js/cookies.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/actions.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins.js' charset='utf-8'></script>
	<script type='text/javascript' src='js/settings.js' charset='utf-8'></script>
	<script type='text/javascript' src='js/lang.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/alex.js' charset='utf-8'></script>
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
                <li>
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
                <li class="active">
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
                <div class='row-fluid'>

                    <div class="span12">
                        <div class="head clearfix">
                            <i class="fa fa-edit fa-1x"></i><span><?php echo get_lang($lang, 'inter125'); ?></span>
                            <ul class="buttons">
                                <li class="tip_" title="<?php echo get_lang($lang, 'Back'); ?>">
                                    <a href="javascript: history.go(-1);" class="isw-left_circle"></a>
                                </li>
                            </ul>
                        </div>
						<div class="block-fluid">
<?php
    $result = mysql_query("SELECT * FROM `controller` WHERE `inv`='$inv' AND `main_line`='$line'");  
	confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
	$line_options = get_line_options($line);
    $controller_data = get_controller_data($inv,$line);
        echo "
<form action='controller_update.php?lang=".$lang."&line=".$line."&inv=".$inv.'&sys='.$sys."&id=".$id."' method='post' id='validation'>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info3').":</div>
    <div class='span8'>
";
if ($user_settings['level'] < 10) {
	echo "<input name='inv' type='text' class='validate[required,custom[onlyNumberSp]]' readonly='readonly' MAXLENGTH='6' value='".$controller_data['inv']."' /></div>";
} else {
	echo "<input name='inv' type='text' class='validate[required,custom[onlyNumberSp]]' MAXLENGTH='6' value='".$controller_data['inv']."' /></div>";
}
echo "
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info4').":</div>
    <div class='span8'>
	<input name='main_line' type='text' class='validate[required]' readonly='readonly' MAXLENGTH='32' value='".$controller_data['main_line']."' /></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info5').":</div>
    <div class='span8'>
	<input name='linex' type='text' class='validate[required]' MAXLENGTH='32' value='".$controller_data['line']."' />
	<span>".get_lang($lang, 'Example').": Joop</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info6').":</div>
    <div class='span8'>
	<input id='from' name='from' type='text' MAXLENGTH='10' value='".$controller_data['date']."' readonly='readonly' />
	<span>".get_lang($lang, 'Example').": 2010-11-20</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info7').":</div>
    <div class='span8'>
	<input name='mark' type='text' MAXLENGTH='32' value='".$controller_data['mark']."' />
	<span>".get_lang($lang, 'Example').": BRISAY</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info8').":</div>
    <div class='span8'>
	<input name='type' type='text' MAXLENGTH='32' value='".$controller_data['type']."' />
	<span>".get_lang($lang, 'Example').": BRI-860</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info9').":</div>
    <div class='span8'>
	<textarea name='desc' type='text' MAXLENGTH='256' value=''>".$controller_data['desc']."</textarea></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info10').":</div>
    <div class='span8'>
	<input name='machine' type='text' MAXLENGTH='32' value='".$controller_data['machine']."' />
	<span>".get_lang($lang, 'Example').": 4455/97</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info11').":</div>
    <div class='span8'>
	<input name='serial' type='text' MAXLENGTH='32' value='".$controller_data['serial']."' />
	<span>".get_lang($lang, 'Example').": 48861161767</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info12').":</div>
    <div class='span8'>
    <select name='cmode' class='validate[required]'>
    <option value='".$controller_data['cmode']."'>".$controller_data['cmode']."</option>
	<option value=''></option>
	<option value='0'>0</option>
    <option value='1'>1</option>
	<option value='2'>2</option>
    <option value='3'>3</option>
	<option value='4'>4</option>
	<option value='5'>5</option>
	<option value='6'>6</option>			
    </select>
	</div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info13')." (".get_lang($lang, 'inter117')."):</div>
    <div class='span8'>
	<input name='t1' type='text' MAXLENGTH='64' value='".$controller_data['t1']."' />
	<span>".get_lang($lang, 'Example').": ".get_lang($lang, 'inter118')."</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info14')." (".get_lang($lang, 'inter117')."):</div>
    <div class='span8'>
	<input name='t2' type='text' MAXLENGTH='64' value='".$controller_data['t2']."' />
	<span>".get_lang($lang, 'Example').": ".get_lang($lang, 'inter119')."</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info15')." (".get_lang($lang, 'inter117')."):</div>
    <div class='span8'>
	<input name='t3' type='text' MAXLENGTH='64' value='".$controller_data['t3']."' />
	<span>".get_lang($lang, 'Example').": ".get_lang($lang, 'inter120')."</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info16')." (".get_lang($lang, 'inter117')."):</div>
    <div class='span8'>
	<input name='t4' type='text' MAXLENGTH='64' value='".$controller_data['t4']."' />
	<span>".get_lang($lang, 'Example').": ".get_lang($lang, 'inter121')."</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info17')." (".get_lang($lang, 'inter117')."):</div>
    <div class='span8'>
	<input name='t5' type='text' MAXLENGTH='64' value='".$controller_data['t5']."' />
	<span>".get_lang($lang, 'Example').": ".get_lang($lang, 'info3')." 6969</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info18')." (".get_lang($lang, 'inter117')."):</div>
    <div class='span8'>
	<input name='t6' type='text' MAXLENGTH='64' value='".$controller_data['t6']."' />
	<span>".get_lang($lang, 'Example').": ".get_lang($lang, 'iron')." - Veit - 3061</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info24')." :</div>
    <div class='span8'>
	<input name='tl1' type='text' MAXLENGTH='2' value='".$controller_data['tl1']."' />
	<span>".get_lang($lang, 'Example').": 1</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info25')." :</div>
    <div class='span8'>
	<input name='tl2' type='text' MAXLENGTH='2' value='".$controller_data['tl2']."' />
	<span>".get_lang($lang, 'Example').": 2</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info26')." :</div>
    <div class='span8'>
	<input name='tl3' type='text' MAXLENGTH='2' value='".$controller_data['tl3']."' />
	<span>".get_lang($lang, 'Example').": 1</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info27')." :</div>
    <div class='span8'>
	<input name='tl4' type='text' MAXLENGTH='2' value='".$controller_data['tl4']."' />
	<span>".get_lang($lang, 'Example').": 4</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info28')." :</div>
    <div class='span8'>
	<input name='tl5' type='text' MAXLENGTH='2' value='".$controller_data['tl5']."' />
	<span>".get_lang($lang, 'Example').": 8</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info29')." :</div>
    <div class='span8'>
	<input name='tl6' type='text' MAXLENGTH='2' value='".$controller_data['tl6']."' />
	<span>".get_lang($lang, 'Example').": 17</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info19')." :</div>
    <div class='span8'>
	<input name='org' type='text' MAXLENGTH='48' readonly='readonly' value='".$line_options['org']."' /></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info20')." :</div>
    <div class='span8'>
	<input name='plant' type='text' MAXLENGTH='2' readonly='readonly' value='".$line_options['plant']."' /></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info21')." :</div>
    <div class='span8'>
	<input name='floor' type='text' MAXLENGTH='2' readonly='readonly' value='".$line_options['floor']."' /></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info22')." :</div>
    <div class='span8'>
	<input name='group_number' type='text' MAXLENGTH='8' value='".$controller_data['group_number']."' />
	<span>".get_lang($lang, 'Example').": 3429</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info32')." :</div>
    <div class='span8'>
	<input name='group_name' type='text' MAXLENGTH='64' value='".$controller_data['group_name']."' />
	<span>".get_lang($lang, 'Example').": ".get_lang($lang, 'inter123')."</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info23')." :</div>
    <div class='span8'>
	<input name='oper' type='text' MAXLENGTH='128' value='".$controller_data['oper']."' />
	<span>".get_lang($lang, 'inter124')."</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info30')." :</div>
    <div class='span8'>
	<input name='vizor' type='text' MAXLENGTH='128' value='".$controller_data['vizor']."' />
	<span>".get_lang($lang, 'info30')." ".get_lang($lang, 'Name'). " 1 / ".get_lang($lang, 'info30')." ".get_lang($lang, 'Name')." 2</span></div>
</div>
<div class='row-form clearfix'>
    <div class='span4 tar'>".get_lang($lang, 'info31')." :</div>
    <div class='span8'>
	<input name='mobile' type='text' MAXLENGTH='128' value='".$controller_data['mobile']."' />
	<span>".get_lang($lang, 'Example').": 089 1234567 / 087 7654321</span></div>
</div>
    <div class='footer'>
	    <input type=\"hidden\" name=\"id\" value=\"".$controller_data['id']."\">
	    <button class='fl btn btn-default' type='button' onClick='javascript: history.go(-1); return false;'>
		<i class='fa fa-times'></i>&nbsp; ". get_lang($lang, 'Cancel')."</button>";
		if ($user_settings['level']<4) {
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
	echo "</div></form>";
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