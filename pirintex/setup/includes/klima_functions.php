<?php
defined('start') or die('Direct access not allowed.');
function get_klima($lang,$name,$line,$id) {
    $rand = rand(1000,9999);
	echo "
    <script>
        jQuery(document).ready(function($) {
 	        $('#klima_$rand').load('live_klima.php?lang=".$lang."&line=".$line."&id=".$id."&name=".$name."&x=');
            var refreshId = setInterval(function() {
                $('#klima_$rand').load('live_klima.php?lang=".$lang."&line=".$line."&id=".$id."&name=".$name."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });  
        });
    </script>
    <div id=\"klima_$rand\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
?>