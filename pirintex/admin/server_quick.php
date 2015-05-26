<?php
//error_reporting(0);
define('start', TRUE);
include('../includes/db.php');
include('includes/admin_functions.php');
include('includes/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('../includes/config.php');
check_login($lang,$web_dir);
mysql_query("SET NAMES 'utf8'");
$query = "SELECT `line_name`,`ip_address`,`port`,`data_file` FROM `lines`";
$result = mysql_query($query);
confirm_query($result);
$num_rows = mysql_num_rows($result);
if ($num_rows != 0) {
    while ($lines = mysql_fetch_array($result)) {
	    $rand = rand(1000,9999);
		echo "
	          <script type=\"text/javascript\" charset=\"utf-8\">
                  $(function() {
                      $('select#ex_".$rand."').switchify().data('switch').bind('switch:slide', function(e, type) {
                          if (type == 'on') {
                              var postData = { 'action' : 'on', 'line' : '".$lines['line_name']."' }; 
                              $.ajax({
                                  url: 'con_handle.php',
                                  type: 'post',
                                  data: postData,
                                  success: function(result){ }
                              });
	                      } else {
                              var postData = { 'action' : 'off', 'line' : '".$lines['line_name']."' }; 
                                  $.ajax({
                                      url: 'con_handle.php',
                                      type: 'post',
                                      data: postData,
                                      success: function(result){ }
                                  });
	                          }
                          });
                      });
                  </script>
				<div class='row-form clearfix'>
				    <div class='span4 tar'>".$lines['line_name'].":</div>
					<div class='span8'>";
                    $datafile = "../data/{$lines['data_file']}";
					$size = filesize($datafile);
					if ($user_settings['level']<10) {
					    if ($size<100) {
						    echo "
                                  <select id=\"ex_".$rand."\" disabled=\"disabled\">
                                    <option value=\"1\">On</option>
                                    <option value=\"0\" selected=\"selected\">Off</option>
                                  </select>";
						} else {
							echo "
                                  <select id=\"ex_".$rand."\" disabled=\"disabled\">
                                    <option value=\"1\" selected=\"selected\">On</option>
                                    <option value=\"0\">Off</option>
                                  </select>";
						}
					} else {
						if ($size<100) {
						    echo "
                                  <select id=\"ex_".$rand."\">
                                    <option value=\"1\">On</option>
                                    <option value=\"0\" selected=\"selected\">Off</option>
                                  </select>";
						} else {
							 echo "
                                   <select id=\"ex_".$rand."\">
                                     <option value=\"1\" selected=\"selected\">On</option>
                                     <option value=\"0\">Off</option>
                                   </select>";
						}
					}
					echo " </div></div>";
				}
							if ($user_settings['level'] > 5) {
								echo "
                            <div class=\"footer\">
							    <span class=\"label label-success\">". get_lang($lang, 'ad136').": 10</span>
                            </div>";
							} else {
								echo "
                            <div class=\"footer\">
							    <span class=\"label label-important\">". get_lang($lang, 'ad136').": 10</span>
                            </div>";
							}
			}
?>