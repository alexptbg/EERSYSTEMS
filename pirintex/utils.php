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
include('includes/utils_functions.php');
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
	<link rel='stylesheet' type='text/css' href='css/colpick.css' />
    <script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
    <script type='text/javascript' src='js/jquery-ui.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery.mousewheel.min.js'></script>
    <script type='text/javascript' src='js/plugins/cookie/jquery.cookies.2.2.0.min.js'></script>
    <script type='text/javascript' src='js/plugins/bootstrap.min.js'></script>
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
    <script type='text/javascript' src='js/plugins/zero/jquery.zclip.min.js'></script>
	<script type='text/javascript' src='js/colpick.js'></script>
	<script type='text/javascript' src='js/ntc.js'></script>
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
	<script type='text/javascript' src='js/lang.js'></script>
    <script type='text/javascript' src='js/alex.js'></script>
    <script type='text/javascript'>
	$(function(){
	    var c = '#ff0000';
        var n_match  = ntc.name(c);
        n_rgb        = n_match[0]; //RGB value of closest match
        n_name       = n_match[1]; //Text string: Color name
        n_exactmatch = n_match[2]; //True if exact color match
		if (n_exactmatch == true) { c_match = 'Solid'; } else { c_match = 'Approx'; }
		$('small.sm').text(c_match);
		$('span.in').text(n_match[1]);
		$('span.i1').text('0,100,100');
		$('span.i2').text(c);
		$('span.i3').text('255,0,0');
		$('.color-box').css('background-color', c);
        $('#picker').colpick({
			flat:true,
			submit:0,
			color: c,
            onChange:function(hsb,hex,rgb) {
				var n_match  = ntc.name('#'+hex);
				n_exactmatch = n_match[2]; //True if exact color match
				if (n_exactmatch == true) { c_match = 'Solid'; } else { c_match = 'Approx'; }
				$('small.sm').text(c_match);
				$('span.in').text(n_match[1]);
				$('span.i1').text(hsb.h+','+hsb.s+','+hsb.b);
				$('span.i2').text('#'+hex);
				$('span.i3').text(rgb.r+','+rgb.g+','+rgb.b);
				$('.color-box').css('background-color', '#'+hex);
            }
        });
        $('p#name').zclip({
            path:'js/plugins/zero/ZeroClipboard.swf',
            copy:function(){return $('span.in').text();}
        });
        $('p#hsb').zclip({
            path:'js/plugins/zero/ZeroClipboard.swf',
            copy:function(){return $('span.i1').text();}
        });
        $('p#hex').zclip({
            path:'js/plugins/zero/ZeroClipboard.swf',
		    copy:function(){return $('span.i2').text();}
        });
        $('p#rgb').zclip({
            path:'js/plugins/zero/ZeroClipboard.swf',
            copy:function(){return $('span.i3').text();}
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
                <li class="active">
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

                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'inter51'); ?></span>
                        </div>
                        <div class="block-fluid">
<?php
    echo "<form methode=\"post\" action=\"".$self_path."\" id=\"validation\" class=\"form\">
              <div class=\"row-form clearfix\">
                  <div class=\"span5\">".get_lang($lang, 'inter55').":</div>
                  <div class=\"span7\"><input name=\"host\" type=\"text\" value=\"".$ip."\" class=\"validate[required]\" />
							         <span>".get_lang($lang, 'inter56').": ".$ipx."</span></div>
			  </div>
              <div class=\"footer tal\">
				  <button name=\"submit\" type=\"submit\" class=\"btn btn-default\" value=\"Ping\">
				      <i class=\"fa fa-share\"></i>&nbsp; ".get_lang($lang, 'inter51')."</button>
              </div>
          </form>";
if ($submit == "Ping") {
	echo "<div class=\"w94\">";
      echo ("<h4>".get_lang($lang, 'inter53').":</h4>"); 
      echo "<pre>";           
         system("ping -n 4 $host");
      echo "</pre>";
	echo "</div>";
}
?>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'inter52'); ?></span>
                        </div>
                        <div class="block-fluid">
    <?php
    echo "<form methode=\"post\" action=\"".$self_path."\" id=\"validation2\" class=\"form\">
              <div class=\"row-form clearfix\">
                  <div class=\"span5\">".get_lang($lang, 'inter55').":</div>
                  <div class=\"span7\"><input name=\"host\" type=\"text\" value=\"".$ip."\" class=\"validate[required]\" />
							         <span>".get_lang($lang, 'inter56').": ".$ipx."</span></div>
			  </div>
              <div class=\"footer tal\">
		      	  <button name=\"submit\" type=\"submit\" class=\"btn btn-default\" value=\"Trace\">
				      <i class=\"fa fa-share\"></i>&nbsp; ".get_lang($lang, 'inter52')."</button>
              </div>
          </form>";
if ($submit == "Trace") {
	  echo "<div class=\"w94\">";
      echo ("<h4>".get_lang($lang, 'inter58').":</h4>"); 
      echo "<pre>";           
         system("tracert $host");
      echo "</pre>"; 
      echo "</div>";  
} else {
    //do nothing
}
    ?>
                        </div>
                    </div>				 
                </div>
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'ad201'); ?></span>
                        </div>
                        <div class="block-fluid">
<?php
    echo "<form methode=\"post\" action=\"".$self_path."\" id=\"validation3\" class=\"form\">
              <div class=\"row-form clearfix\">
                  <div class=\"span5\">".get_lang($lang, 'inter55').":</div>
                  <div class=\"span7\"><input name=\"host\" type=\"text\" value=\"".$ip."\" class=\"validate[required]\" /> 
							         <span>".get_lang($lang, 'inter56').": ".$ipx."</span></div>
			  </div>
              <div class=\"footer tal\">
		      	  <button name=\"submit\" type=\"submit\" class=\"btn btn-default\" value=\"Whois\">
				      <i class=\"fa fa-share\"></i>&nbsp; ".get_lang($lang, 'ad202')."</button>
              </div>
          </form>";
if ($submit == "Whois") {
	  $domain = $host;
	  echo "<div class=\"w94\">";
      echo ("<h4>".get_lang($lang, 'ad201').":</h4>");         
if($domain) {
    $domain = trim($domain);
    if(substr(strtolower($domain), 0, 7) == "http://") $domain = substr($domain, 7);
    if(substr(strtolower($domain), 0, 4) == "www.") $domain = substr($domain, 4);
    if(ValidateIP($domain)) { $result = LookupIP($domain); echo "<pre>\n" . $result . "\n</pre>\n"; }
    elseif(ValidateDomain($domain)) { $result = LookupDomain($domain); }
    else { echo "<div class=\"w98\">".get_error($lang,'1041')."<br/></div>"; }
	echo "<pre>\n" . $result . "\n</pre>\n";
}
      echo "</div>";  
} else {
    //do nothing
}
?>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'ad215'); ?></span>
                        </div>
                        <div class="block-fluid">
    <?php
    echo "<form methode=\"post\" action=\"".$self_path."\" id=\"validation4\" class=\"form\">
              <div class=\"row-form clearfix\">
                  <div class=\"span5\">".get_lang($lang, 'ad214').":</div>
                  <div class=\"span7\"><input name=\"host\" type=\"text\" value=\"".$ip."\" class=\"validate[required,custom[ipv4]]\" /> 
							         <span>".get_lang($lang, 'Example').": 213.226.1.254</span></div>
			  </div>
              <div class=\"footer tal\">
		      	  <button name=\"submit\" type=\"submit\" class=\"btn btn-default\" value=\"Location\">
				      <i class=\"fa fa-share\"></i>&nbsp; ".get_lang($lang, 'ad202')."</button>
              </div>
          </form>";
if ($submit == "Location") {
	echo "<div class=\"w94\">";
    echo ("<h4>".get_lang($lang, 'ad216').":</h4>"); 
    echo "<pre>";           
    $ip2c=new ip2country();
    echo $ip2c->get_country_name($host)." (".$ip2c->get_country_code($host).")";
    echo "</pre>"; 
    echo "</div>";  
} else {
    //do nothing
}
    ?>
                        </div>
                    </div>				 
                </div>
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'ad255'); ?></span>
                        </div>
                        <div class="block-fluid">
<?php
    echo "<form methode=\"post\" action=\"".$self_path."\" id=\"validation5\" class=\"form\">
              <div class=\"row-form clearfix\">
                  <div class=\"span3\">".get_lang($lang, 'ad256').":</div>
                  <div class=\"span4\"><input name=\"timex\" type=\"text\" value=\"\" class=\"validate[required,custom[onlyNumberSp]]\" MAXLENGTH=\"13\" /> 
							         <span>".get_lang($lang, 'Example').": 1370846107</span></div>
                  <div class=\"span5\">
                      <select name=\"format\" class=\"validate[required]\">
						<option value=\"".$format."\">".$format."</option>
						<option value=\"\"></option>
						<option value=\"Y-m-d H:i:s\">Y-m-d H:i:s</option>
						<option value=\"Y-m-d\">Y-m-d</option>
						<option value=\"d-m-Y H:i:s\">d-m-Y H:i:s</option>
						<option value=\"d-m-Y\">d-m-Y</option>																	
                      </select>
				  </div>
			  </div>
              <div class=\"footer tal\">
		      	  <button name=\"submit\" type=\"submit\" class=\"btn btn-default\" value=\"Timestamp\">
				      <i class=\"fa fa-share\"></i>&nbsp; ".get_lang($lang, 'ad202')."</button>
              </div>
          </form>";
if ($submit == "Timestamp") {
	echo "<div class=\"w94\">";
    echo ("<h4>".get_lang($lang, 'ad257').":</h4>"); 
    echo "<pre>";           
    echo date($format, $str);
    echo "</pre>"; 
    echo "</div>";  
    
} else {
    //do nothing
}
?>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-info-circle fa-1x"></i><span><?php echo get_lang($lang, 'ad258'); ?></span>
                        </div>
                        <div class="block-fluid">
<?php
    echo "<form methode=\"post\" action=\"".$self_path."\" id=\"validation6\" class=\"form\">
              <div class=\"row-form clearfix\">
                  <div class=\"span3\">".get_lang($lang, 'info6').":</div>
                  <div class=\"span4\"><input name=\"datex\" type=\"text\" value=\"\" class=\"validate[required]\" MAXLENGTH=\"19\" /> 
							         <span>".get_lang($lang, 'Example').": 2013-06-10</span></div>
			  </div>
              <div class=\"footer tal\">
		      	  <button name=\"submit\" type=\"submit\" class=\"btn btn-default\" value=\"datetostring\">
				      <i class=\"fa fa-share\"></i>&nbsp; ".get_lang($lang, 'ad202')."</button>
              </div>
          </form>";
if ($submit == "datetostring") {
	echo "<div class=\"w94\">";
    echo ("<h4>".get_lang($lang, 'ad257').":</h4>"); 
    echo "<pre>";
	echo strtotime($datex);     
    echo "</pre>"; 
    echo "</div>";  
} else {
    //do nothing
}
?>
                        </div>
                    </div>				 
                </div>
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span5">
                        <div class="head clearfix">
                            <i class="fa fa-exchange fa-1x"></i><span>CRC16</span>
                        </div>
                        <div class="block-fluid">
<?php
    echo "<form method=\"post\" action=\"".$self_path."\" id=\"validation7\" class=\"form\">
              <div class=\"row-form clearfix\">
                  <div class=\"span2\">".get_lang($lang, 'ad304').":</div>
                  <div class=\"span10\"><input name=\"crc\" type=\"text\" value=\"\" class=\"validate[required]\" /> 
							         <span>".get_lang($lang, 'Example').": 05 03 00 81 00 01</span></div>
			  </div>
              <div class=\"footer tal\">
			      <input type=\"hidden\" name=\"crc16\" value=\"\" />
		      	  <button name=\"submit\" type=\"submit\" class=\"btn btn-default\" value=\"crc16\">
				      <i class=\"fa fa-share\"></i>&nbsp; ".get_lang($lang, 'ad202')."</button>
              </div>
          </form>";
if ((isset($_POST['submit']))&&(isset($_POST['crc16']))) {
	  $str = $_POST['crc'];
	  $string = explodeX(Array(".","!"," ","?",";",","),$str);
      echo "<div class=\"w94\">";
	  echo ("<h4>".get_lang($lang, 'ad257').": <small>".$str."</small></h4>");  
	  echo "<pre style=\"text-transform:uppercase;\">\n" . crc16($string) . "\n</pre>\n";
      echo "</div>";
} else {
    //do nothing
}
?>
                        </div>
                    </div>
                    <div class="span7">
                        <div class="head clearfix">
                            <i class="fa fa-adjust fa-1x"></i><span><?php echo get_lang($lang, 'ad456'); ?></span>
                        </div>
						<div class="block">
                            <div id="picker">
							    <div class="pick fr">
								    <p class="ma"><small class="sm text-info"></small></p>
								    <p id="name">NAME: <span class="in"></span></p>
								    <p id="hsb">HSB: <span class="i1"></span></p>
								    <p id="hex">HEX: <span class="i2"></span></p>
								    <p id="rgb">RGB: <span class="i3"></span></p>
                                    <div class="color-box"></div>
								</div>
							</div>
						</div>
                    </div>				 
                </div>
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-code fa-1x"></i><span>hex2dec</span>
                        </div>
                        <div class="block-fluid">
<?php
    echo "<form method=\"post\" action=\"".$self_path."\" id=\"validation8\" class=\"form\">
              <div class=\"row-form clearfix\">
                  <div class=\"span2\">".get_lang($lang, 'ad304').":</div>
                  <div class=\"span10\"><input name=\"hex\" type=\"text\" value=\"\" class=\"validate[required]\" /> 
							         <span>".get_lang($lang, 'Example').": 05 03 00 51 00 01</span></div>
			  </div>
              <div class=\"footer tal\">
			      <input type=\"hidden\" name=\"hex2dec\" value=\"\" />
		      	  <button name=\"submit\" type=\"submit\" class=\"btn btn-default\" value=\"hex2dec\">
				      <i class=\"fa fa-share\"></i>&nbsp; ".get_lang($lang, 'ad202')."</button>
              </div>
          </form>";
if ((isset($_POST['submit']))&&(isset($_POST['hex2dec']))) {
	$hex = $_POST['hex'];
	$string = explodeX(Array(".","!"," ","?",";",","),$hex);
	echo "<div class=\"w94\">";
    echo ("<h4>".get_lang($lang, 'ad257').": <small>".$hex."</small></h4>");
    echo "<pre>";
    foreach ($string as $v) {
		echo hexdec($v)."&nbsp;";
	}    
    echo "</pre>"; 
    echo "</div>";  
} else {
    //do nothing
}
?>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="head clearfix">
                            <i class="fa fa-code fa-1x"></i><span>dec2hex</span>
                        </div>
                        <div class="block-fluid">
<?php
    echo "<form method=\"post\" action=\"".$self_path."\" id=\"validation9\" class=\"form\">
              <div class=\"row-form clearfix\">
                  <div class=\"span2\">".get_lang($lang, 'ad304').":</div>
                  <div class=\"span10\"><input name=\"dec\" type=\"text\" value=\"\" class=\"validate[required]\" /> 
							         <span>".get_lang($lang, 'Example').": 05 03 00 51 00 01</span></div>
			  </div>
              <div class=\"footer tal\">
			      <input type=\"hidden\" name=\"dec2hex\" value=\"\" />
		      	  <button name=\"submit\" type=\"submit\" class=\"btn btn-default\" value=\"dec2hex\">
				      <i class=\"fa fa-share\"></i>&nbsp; ".get_lang($lang, 'ad202')."</button>
              </div>
          </form>";
if ((isset($_POST['submit']))&&(isset($_POST['dec2hex']))) {
	$dec = $_POST['dec'];
	$string = explodeX(Array(".","!"," ","?",";",","),$dec);
	echo "<div class=\"w94\">";
    echo ("<h4>".get_lang($lang, 'ad257').": <small>".$dec."</small></h4>");
    echo "<pre>";
    foreach ($string as $v) {
		echo dechex($v)."&nbsp;";
	}    
    echo "</pre>"; 
    echo "</div>"; 	
} else {
    //do nothing
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