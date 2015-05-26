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
                <li class="active">
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
                            <i class="fa fa-plus fa-1x"></i><span><?php echo get_lang($lang,'ad460'); ?></span>
                        </div>
                        <div class="block-fluid">
                          <form action="controller_repairs_add.php?lang=<?=$lang?>&line=<?=$line?>&inv=<?=$inv?>&sys=<?=$sys?>&id=<?=$id?>" method="post" id="validation">
                            <div class="row-form clearfix">
                                <div class="span4"><?php echo get_lang($lang,'info3'); ?>:</div>
                                <div class="span8"><input name="inventory" type="text" value="<?=$inv?>" readonly="readonly" /></div>
                            </div> 
                            <div class="row-form clearfix">
                                <div class="span4"><?php echo get_lang($lang,'ad458'); ?>:</div>
                                <div class="span8">
                                    <select name="problem" class="validate[required]">
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
                                <div class="span4"><?php echo get_lang($lang,'info9'); ?>:</div>
                                <div class="span8"><input name="obs" type="text" value="" class="validate[required]" /></div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4"><?php echo get_lang($lang,'ad463'); ?>:</div>
                                <div class="span8">
                                    <?php
                                        $queryu = "SELECT * FROM `tasks_parts`";
                                        $resultu = mysql_query($queryu);
                                        confirm_query($resultu);
                                        if (mysql_num_rows($resultu) != 0) {
                                        	$z=1;
                                            while($parts = mysql_fetch_array($resultu)) {
                                                echo "
                                    <div class=\"extend\">
                                        <label class=\"checkbox\">
                                            <input type=\"checkbox\" name=\"parts_$z\" value=\"".$parts['id']."\" class=\"validate[condRequired[quant_$z]]\" id=\"parts_$z\" /> ".$parts['parts']."
                                        </label>
                                        <select name=\"quant_$z\" class=\"small validate[condRequired[parts_$z]]\" id=\"quant_$z\">
                                            <option></option>
                                            <option value=\"1\">1</option>
                                            <option value=\"2\">2</option>
                                            <option value=\"3\">3</option>
                                            <option value=\"4\">4</option>
                                            <option value=\"5\">5</option>
                                            <option value=\"6\">6</option>
                                            <option value=\"7\">7</option>
                                            <option value=\"8\">8</option>
                                            <option value=\"9\">9</option>";
                                            if ($parts['id'] == '4') {
											echo "
                                            <option value=\"10\">10</option>
                                            <option value=\"11\">11</option>
                                            <option value=\"12\">12</option>
                                            <option value=\"13\">13</option>
                                            <option value=\"14\">14</option>
                                            <option value=\"15\">15</option>
                                            <option value=\"16\">16</option>
                                            <option value=\"17\">17</option>
                                            <option value=\"18\">18</option>
                                            <option value=\"19\">19</option>
                                            <option value=\"20\">20</option>
                                            <option value=\"21\">21</option>
                                            <option value=\"22\">22</option>
                                            <option value=\"23\">23</option>
                                            <option value=\"24\">24</option>
                                            <option value=\"25\">25</option>
											";	
											}
                                      echo "
                                        </select>
                                    </div>";
                                                $z++;
	                                        }
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="row-form clearfix">
                                <div class="span4"><?php echo get_lang($lang,'tu01'); ?>:</div>
                                <div class="span8"><input name="mec" type="text" value="<?php echo $user_settings['user_name'];?>" readonly="readonly" /></div>
                            </div> 
                            <div class="row-form clearfix">
                                <div class="span4"><?php echo get_lang($lang,'ad459'); ?>:</div> 
                                <div class="span8"><input name="time" type="text" value="" class="validate[required,custom[onlyNumberSp],min[5],max[480]]" /></div>
                            </div>
                            <div class="row-form clearfix">
                            <?php
		                    if ($user_settings['level']<3) {
			                    echo "
                                    <button class=\"btn btn-default fr\" type=\"submit\" name=\"submit\" disabled=\"disabled\" disabled>
		                                <i class=\"fa fa-save\"></i>&nbsp; ".get_lang($lang,'inter94')."</button>";		
		                    } else {
			                    echo "
                                    <button class=\"btn btn-default fr\" type=\"submit\" name=\"submit\" id=\"submit\">
		                                <i class=\"fa fa-save\"></i>&nbsp; ".get_lang($lang,'inter94')."</button>";
		                    }
                            ?>
                            </div>
                          </form>
                        </div>
                    </div>
                    <div class="span7">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang,'ad461'); ?></span>
                        </div>
                        <div class="block-fluid">
                        <?php
                            $query = "SELECT * FROM `tasks` WHERE `inv`=".$inv." ORDER BY `id` DESC";
                            $result = mysql_query($query);
                            confirm_query($result);
                            if (mysql_num_rows($result) != 0) {
                            	echo "
                                    <table cellpadding='0' cellspacing='0' class='table alarms'>
		                              <thead>
                                        <tr>                                    
                                          <th>".get_lang($lang,'info6')."</th>
                                          <th>".get_lang($lang,'Inv')."</th>
                                          <th>".get_lang($lang,'ad462')."</th>
                                          <th>".get_lang($lang,'info9')."</th>
                                          <th>".get_lang($lang,'ad464').". / ".get_lang($lang,'ad463')."</th>
                                          <th>".get_lang($lang,'tu01')."</th>
                                          <th>".get_lang($lang,'inter23')."</th>
                                          <th>&nbsp;</th>                       
                                        </tr>
		                              </thead>
		                              <tbody>";
                                while($prob = mysql_fetch_array($result)) {
                                	$all_p = explode(", ",$prob['parts']);
                                	$all_q = explode(", ",$prob['quant']);
                                    echo "
                                        <tr>
                                          <td>".$prob['added']."</td>
                                          <td>".$prob['inv']."</td>
                                          <td>".get_problem($prob['problem'])."</td>
                                          <td>".$prob['obs']."</td>
                                          <td>";
                                          $x=0;
                                      foreach($all_q as $single_q) {
									      echo "<p>".$single_q." / ".get_part($all_p[$x])."</p>";
									      $x++;
									  }
                                    echo" </td>
                                          <td>".get_name_from($prob['mec'])."</td>
                                          <td>".$prob['time']."</td>
                                          <td>";
                                          if ($prob['mec'] == $user_settings['user_name']) {
										      echo "
										      <button class=\"btn btn-small btn-danger ttLB\" title=\"".get_lang($lang,'ad466')."\" onClick=\"confirms('".$prob['id']."'); return false;\">
                                                  <span class=\"icon-trash icon-white\"></span></button></td>
										      ";
										      echo "
<script type=\"text/javascript\">
function confirms(id) {
	var answer = confirm(\"".get_lang($lang,'ad466')."\");
	if (answer){ remontdel(id); }
	else{ alert(\"".get_lang($lang,'ad467')."\"); }
}
function remontdel(id) {
   $.ajax({
   type: \"POST\",
   url: \"controller_repairs_del.php?id=\"+id,
   success: function(){
     alert(\"".get_lang($lang,'ad468')."\");
     var delay = 1000;
     setTimeout(function(){ window.location.href = 'controller_repairs.php?lang=".$lang."&line=".$line."&inv=".$inv."&sys=".$sys."&id=".$id."'; }, delay);
   }
 });
    return false;
}
</script>
										      ";
										  } else {
										      echo "
										      <button class=\"btn btn-small btn-danger ttLB\" title=\"z\"
                                                  disabled=\"disabled\" disabled><span class=\"icon-trash icon-white\"></span></button></td>
										      ";
										  }
                                          
                                          echo "
                                        </tr>
                                    ";
                                    $all_time[] = $prob['time'];
	                            }
	                            $timed = array_sum($all_time)*60;
	                            echo "
	                                  <tbody>
	                                  <tfoot>
	                                    <tr class=\"foot\">
	                                      <td colspan=\"8\">
	                                        <span style=\"float:right;\">".get_lang($lang,'ad230').": ".seconds2human($timed,$lang)."</span>
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
	<script type='text/javascript'>
	$(function() {
		$('input[name="parts_1"]').attr('disabled','disabled');
		$('select[name="quant_1"]').attr('disabled','disabled');
		$('input[name="parts_2"]').attr('disabled','disabled');
		$('select[name="quant_2"]').attr('disabled','disabled');
		$('input[name="parts_3"]').attr('disabled','disabled');
		$('select[name="quant_3"]').attr('disabled','disabled');
		$('input[name="parts_4"]').attr('disabled','disabled');
		$('select[name="quant_4"]').attr('disabled','disabled');
		$('input[name="parts_5"]').attr('disabled','disabled');
		$('select[name="quant_5"]').attr('disabled','disabled');
		$('input[name="parts_6"]').attr('disabled','disabled');
		$('select[name="quant_6"]').attr('disabled','disabled');
		$('input[name="parts_7"]').attr('disabled','disabled');
		$('select[name="quant_7"]').attr('disabled','disabled');
		$('input[name="parts_8"]').attr('disabled','disabled');
		$('select[name="quant_8"]').attr('disabled','disabled');
		$('input[name="parts_9"]').attr('disabled','disabled');
		$('select[name="quant_9"]').attr('disabled','disabled');
		$('input[name="parts_10"]').attr('disabled','disabled');
		$('select[name="quant_10"]').attr('disabled','disabled');
		$('input[name="parts_11"]').attr('disabled','disabled');
		$('select[name="quant_11"]').attr('disabled','disabled');
        jQuery("select[name='problem']").change(function(){	
            var problem = $("select[name='problem']").val();
            if (problem == '1') {
            	$('input[name="parts_1"]').removeAttr('disabled');
            	$('select[name="quant_1"]').removeAttr('disabled');
				$('input[name="parts_2"]').attr('disabled','disabled');
				$('select[name="quant_2"]').attr('disabled','disabled');
            	$('input[name="parts_3"]').removeAttr('disabled');
            	$('select[name="quant_3"]').removeAttr('disabled');
            	$('input[name="parts_4"]').removeAttr('disabled');
            	$('select[name="quant_4"]').removeAttr('disabled');
				$('input[name="parts_5"]').attr('disabled','disabled');
				$('select[name="quant_5"]').attr('disabled','disabled');
            	$('input[name="parts_6"]').removeAttr('disabled');
            	$('select[name="quant_6"]').removeAttr('disabled');
            	$('input[name="parts_7"]').removeAttr('disabled');
            	$('select[name="quant_7"]').removeAttr('disabled');
            	$('input[name="parts_8"]').removeAttr('disabled');
            	$('select[name="quant_8"]').removeAttr('disabled');
            	$('input[name="parts_9"]').removeAttr('disabled');
            	$('select[name="quant_9"]').removeAttr('disabled');
            	$('input[name="parts_10"]').removeAttr('disabled');
            	$('select[name="quant_10"]').removeAttr('disabled');
				$('input[name="parts_11"]').attr('disabled','disabled');
				$('select[name="quant_11"]').attr('disabled','disabled');
			} else if (problem == '2') {
				$('input[name="parts_1"]').attr('disabled','disabled');
				$('select[name="quant_1"]').attr('disabled','disabled');
            	$('input[name="parts_2"]').removeAttr('disabled');
            	$('select[name="quant_2"]').removeAttr('disabled');
				$('input[name="parts_3"]').attr('disabled','disabled');
				$('select[name="quant_3"]').attr('disabled','disabled');
            	$('input[name="parts_4"]').removeAttr('disabled');
            	$('select[name="quant_4"]').removeAttr('disabled');
				$('input[name="parts_5"]').attr('disabled','disabled');
				$('select[name="quant_5"]').attr('disabled','disabled');
				$('input[name="parts_6"]').attr('disabled','disabled');
				$('select[name="quant_6"]').attr('disabled','disabled');
				$('input[name="parts_7"]').attr('disabled','disabled');
				$('select[name="quant_7"]').attr('disabled','disabled');
				$('input[name="parts_8"]').attr('disabled','disabled');
				$('select[name="quant_8"]').attr('disabled','disabled');
				$('input[name="parts_9"]').attr('disabled','disabled');
				$('select[name="quant_9"]').attr('disabled','disabled');
            	$('input[name="parts_10"]').removeAttr('disabled');
            	$('select[name="quant_10"]').removeAttr('disabled');
				$('input[name="parts_11"]').attr('disabled','disabled');
				$('select[name="quant_11"]').attr('disabled','disabled');
			} else if (problem == '3') {
				$('input[name="parts_1"]').attr('disabled','disabled');
				$('select[name="quant_1"]').attr('disabled','disabled');
				$('input[name="parts_2"]').attr('disabled','disabled');
				$('select[name="quant_2"]').attr('disabled','disabled');
				$('input[name="parts_3"]').attr('disabled','disabled');
				$('select[name="quant_3"]').attr('disabled','disabled');
            	$('input[name="parts_4"]').removeAttr('disabled');
            	$('select[name="quant_4"]').removeAttr('disabled');
				$('input[name="parts_5"]').attr('disabled','disabled');
				$('select[name="quant_5"]').attr('disabled','disabled');
				$('input[name="parts_6"]').attr('disabled','disabled');
				$('select[name="quant_6"]').attr('disabled','disabled');
				$('input[name="parts_7"]').attr('disabled','disabled');
				$('select[name="quant_7"]').attr('disabled','disabled');
				$('input[name="parts_8"]').attr('disabled','disabled');
				$('select[name="quant_8"]').attr('disabled','disabled');
				$('input[name="parts_9"]').attr('disabled','disabled');
				$('select[name="quant_9"]').attr('disabled','disabled');
            	$('input[name="parts_10"]').removeAttr('disabled');
            	$('select[name="quant_10"]').removeAttr('disabled');
				$('input[name="parts_11"]').attr('disabled','disabled');
				$('select[name="quant_11"]').attr('disabled','disabled');
			} else if (problem == '4') {
				$('input[name="parts_1"]').attr('disabled','disabled');
				$('select[name="quant_1"]').attr('disabled','disabled');
				$('input[name="parts_2"]').attr('disabled','disabled');
				$('select[name="quant_2"]').attr('disabled','disabled');
				$('input[name="parts_3"]').attr('disabled','disabled');
				$('select[name="quant_3"]').attr('disabled','disabled');
            	$('input[name="parts_4"]').removeAttr('disabled');
            	$('select[name="quant_4"]').removeAttr('disabled');
            	$('input[name="parts_5"]').removeAttr('disabled');
            	$('select[name="quant_5"]').removeAttr('disabled');
				$('input[name="parts_6"]').attr('disabled','disabled');
				$('select[name="quant_6"]').attr('disabled','disabled');
				$('input[name="parts_7"]').attr('disabled','disabled');
				$('select[name="quant_7"]').attr('disabled','disabled');
				$('input[name="parts_8"]').attr('disabled','disabled');
				$('select[name="quant_8"]').attr('disabled','disabled');
				$('input[name="parts_9"]').attr('disabled','disabled');
				$('select[name="quant_9"]').attr('disabled','disabled');
            	$('input[name="parts_10"]').removeAttr('disabled');
            	$('select[name="quant_10"]').removeAttr('disabled');
            	$('input[name="parts_11"]').removeAttr('disabled');
            	$('select[name="quant_11"]').removeAttr('disabled');
			} else {
				$('input[name="parts_1"]').attr('disabled','disabled');
				$('select[name="quant_1"]').attr('disabled','disabled');
				$('input[name="parts_2"]').attr('disabled','disabled');
				$('select[name="quant_2"]').attr('disabled','disabled');
				$('input[name="parts_3"]').attr('disabled','disabled');
				$('select[name="quant_3"]').attr('disabled','disabled');
				$('input[name="parts_4"]').attr('disabled','disabled');
				$('select[name="quant_4"]').attr('disabled','disabled');
				$('input[name="parts_5"]').attr('disabled','disabled');
				$('select[name="quant_5"]').attr('disabled','disabled');
				$('input[name="parts_6"]').attr('disabled','disabled');
				$('select[name="quant_6"]').attr('disabled','disabled');
				$('input[name="parts_7"]').attr('disabled','disabled');
				$('select[name="quant_7"]').attr('disabled','disabled');
				$('input[name="parts_8"]').attr('disabled','disabled');
				$('select[name="quant_8"]').attr('disabled','disabled');
				$('input[name="parts_9"]').attr('disabled','disabled');
				$('select[name="quant_9"]').attr('disabled','disabled');
				$('input[name="parts_10"]').attr('disabled','disabled');
				$('select[name="quant_10"]').attr('disabled','disabled');
				$('input[name="parts_11"]').attr('disabled','disabled');
				$('select[name="quant_11"]').attr('disabled','disabled');
			}
        });
	});
	</script>
</body>
</html>