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
    <script type='text/javascript' src='http://maps.googleapis.com/maps/api/js?sensor=false'></script>
    <script type='text/javascript' src='js/gmap3.js'></script>
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
	<script type='text/javascript' src='js/lang.js'></script>
	<script type='text/javascript' src='js/alex.js'></script>
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
                    <a href="klima.php?lang=<?=$lang?>">
                        <span class="isw-calc"></span><span class="text"><?php echo get_lang($lang, 'ad275'); ?></span>                 
                    </a>
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
                <li class="active">
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
                            <i class="fa fa-location-arrow fa-1x"></i><span><?php echo get_lang($lang, 'ad239'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <div id="map"></div>
                        </div>
                    </div>   
				</div>
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span9">
                        <div class="head clearfix">
                            <i class="fa fa-envelope fa-1x"></i><span><?php echo get_lang($lang, 'ad243'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <div class="row-form">
								<p><strong><?php echo get_lang($lang, 'ad244'); ?></strong></p>
                            </div>
<?php
if(isset($_POST['submit'])) {
	echo "<div class=\"row-form\">";
    $e_name = mysql_prep($_POST['name']);
    $e_mail = mysql_prep($_POST['mail']);
    $e_phone = mysql_prep($_POST['phone']);	
    $e_subj = mysql_prep($_POST['subject']);
    $e_msg = mysql_prep($_POST['message']);
        if ($e_name != NULL) {
            $from=$e_mail;
            $namefrom=$e_name;
            $to = $site_email;
            $nameto = $smtp_name;
            $subject = $company_name." ".$company_slogan.": ".$e_subj;
            $message = "
            <h5>".get_lang($lang, 'ad248').": ".$company_name." ".$company_slogan.": ".$e_subj."</h5>
			<p>".get_lang($lang, 'Name').": ".$namefrom."</p>
			<p>".get_lang($lang, 'ad05').": ".$from."</p>
			<p>".get_lang($lang, 'ad23').": ".$e_phone."</p>
			<p>".get_lang($lang, 'ad245').": ".$e_subj."</p>
            <p>".$e_msg.".</p>";
            if (authgMail($lang,$from,$namefrom,$to,$nameto,$subject,$message,$smtp_server,$smtp_port,$smtp_username,$smtp_password)) {
		        echo "<p class=\"text-success\">".get_lang($lang, '2019')."</p>"; //message sent
            } else {
	            echo "<div class='w94 pt10'>";
	            get_error($lang,'1042');
	            echo "</div>";
			}		
        } else {
	        echo "<div class='w94 pt10'>";
	        get_error($lang,'1000');
	        echo "</div>";
		}
		echo "</div>";
} else {
	echo "
					    <form action=\"".$self_path."?lang=".$lang."\" method=\"post\" id=\"validation\">
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'Name').":</div>
                                <div class=\"span8\">
								  <input name=\"name\" type=\"text\" class=\"validate[required]\" value=\"\" MAXLENGTH=\"64\" />
								</div>
                            </div>
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'inter67').":</div>
                                <div class=\"span8\">
								  <input name=\"mail\" type=\"text\" class=\"validate[required,custom[email]]\" value=\"\" MAXLENGTH=\"96\" />
								</div>
                            </div>
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'ad23').":</div>
                                <div class=\"span8\">
								  <input name=\"phone\" type=\"text\" value=\"\" MAXLENGTH=\"64\" />
								</div>
                            </div>
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'ad245').":</div>
                                <div class=\"span8\">
								  <input name=\"subject\" type=\"text\" class=\"validate[required]\" value=\"\" MAXLENGTH=\"64\" />
								</div>
                            </div>
                            <div class=\"row-form clearfix\">
                                <div class=\"span4 tar\">".get_lang($lang, 'ad246').":</div>
                                <div class=\"span8\">
								  <textarea name=\"message\" class=\"validate[required]\" value=\"\" MAXLENGTH=\"512\" placeholder=\"".get_lang($lang, 'ad259')."\"></textarea>
								</div>
                            </div>
                            <div class=\"footer\">
                                <button class=\"btn btn-default\" type=\"submit\" name=\"submit\">
		                            <i class=\"fa fa-mail-forward\"></i>&nbsp; ".get_lang($lang, 'ad247')."</button>
							</div>
						</form>";
}
?>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="head clearfix">
                            <i class="fa fa-map-marker fa-1x"></i><span><?php echo get_lang($lang, 'ad66'); ?></span>
                        </div>
                        <div class="block">
                            <address>
                                <strong><?=$company_name?></strong><br>
                                <?php echo $settings['street']; ?><br>
                                <?php echo $settings['region']; ?><br>
                                <?php echo $settings['postal']; ?><br>
                                <?php echo $settings['city']; ?><br>
                                <?php echo $settings['country']; ?>
                            </address>
                            <address>
                                <strong><?=$smtp_name?></strong><br>
								<i class="fa fa-mobile fa-1x"></i> <?php echo $settings['tele']; ?><br/>
                                <i class="fa fa-envelope"></i> <a href="mailto:<?=$site_email?>"><?=$site_email?></a>
                            </address>  
                        </div>
                    <div class="dr"><span></span></div>
                        <div class="head clearfix">
                            <i class="fa fa-envelope-o fa-1x"></i><span><?php echo get_lang($lang, 'ad243'); ?></span>
                        </div>
                        <div class="block-fluid">
                            <img src="qrmail.php" />
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
if ($().gmap3) {
$("#map").gmap3({
  marker:{
    values:[
      {latLng:[<?php echo $settings['lat']; ?>,<?php echo $settings['lon']; ?>], 
	   data:"<b><?=$company_name?> &curren; <?=$company_slogan?><br/><?=$site_name?><br/><?php echo get_lang($lang, 'ad240'); ?></b>"
	   /*, options:{icon: "images/pin.png"}*/}
    ],
    options:{
      draggable: false
    },
    events:{
      mouseover: function(marker, event, context){
        var map = $(this).gmap3("get"),
          infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.open(map, marker);
          infowindow.setContent(context.data);
        } else {
          $(this).gmap3({
            infowindow:{
              anchor:marker,
              options:{content: context.data}
            }
          });
        }
      },
      mouseout: function(){
        var infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.close();
        }
      }
    }
  },
    map:{
     /* address:"Gotse Delchev, Bulgaria",*/
      options:{
        zoom:15,
		center:[<?php echo $settings['lat']; ?>,<?php echo $settings['lon']; ?>],
        mapTypeId: google.maps.MapTypeId.SATELLITE,
        mapTypeControl: true,
        mapTypeControlOptions: {
          style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        },
        navigationControl: true,
        scrollwheel: true,
        streetViewControl: true
      }
    }
  });
}
});
	</script>
</body>
</html>