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
get_line_options($line);
$datafile = "../data/{$line_options['data_file']}";
include("$datafile");
$dev = ${'dev' . $id};
$d = explode(" ", $dev);
$status = $d[9];
echo "
	          <script type=\"text/javascript\" charset=\"utf-8\">
                  $(function() {
                      $('select#ex').switchify().data('switch').bind('switch:slide', function(e, type) {
                          if (type == 'on') {
                              var postData = { 'action' : 'on', 'line' : '".$line."', 'id' : '".$id."' }; 
                              $.ajax({
                                  url: 'con_handle.php',
                                  type: 'post',
                                  data: postData,
                                  success: function(result){ }
                              });
	                      } else {
                              var postData = { 'action' : 'off', 'line' : '".$line."', 'id' : '".$id."' }; 
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
				    <div class='span4 tar'>".get_lang($lang,'inter77').":</div>
					<div class='span8'>";
					if ($user_settings['level']<4) {
						if ($status == 'OFF') {
						    echo "
                                  <select id=\"ex\" disabled=\"disabled\">
                                    <option value=\"1\">On</option>
                                    <option value=\"0\" selected=\"selected\">Off</option>
                                  </select>";
						} else {
							 echo "
                                   <select id=\"ex\" disabled=\"disabled\">
                                     <option value=\"1\" selected=\"selected\">On</option>
                                     <option value=\"0\">Off</option>
                                   </select>";
						}
						echo "</div><p class=\"fr label label-important\">". get_lang($lang, 'ad136').": 4</p>";
					} else {
						if ($status == 'OFF') {
						    echo "
                                  <select id=\"ex\">
                                    <option value=\"1\">On</option>
                                    <option value=\"0\" selected=\"selected\">Off</option>
                                  </select>";
						} else {
							 echo "
                                   <select id=\"ex\">
                                     <option value=\"1\" selected=\"selected\">On</option>
                                     <option value=\"0\">Off</option>
                                   </select>";
						}
						echo "</div><p class=\"fr label label-success\">". get_lang($lang, 'ad136').": 4</p>";
					}
					echo "</div>";
?>