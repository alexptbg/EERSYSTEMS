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
function get_klimatik_data($lang,$kline,$l) {
	echo "
    <script>
    jQuery(document).ready(function($) {
 	        $('#data').load('k.php?lang=".$lang."&kline=".$kline."&l=".$l."&x=');
            var refreshId = setInterval(function() {
                $('#data').load('k.php?lang=".$lang."&kline=".$kline."&l=".$l."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });
    });
    </script>
    <div id=\"data\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_klimatik_printable_data($lang,$kline,$l) {
	echo "
    <script>
    jQuery(document).ready(function($) {
 	        $('#data').load('k_p.php?lang=".$lang."&kline=".$kline."&l=".$l."&x=');
            var refreshId = setInterval(function() {
                $('#data').load('k_p.php?lang=".$lang."&kline=".$kline."&l=".$l."&x='+ Math.random());
                }, 10000);
                $.ajaxSetup({ cache: false });
    });
    </script>
    <div id=\"data\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
//led
function led($status) {
    echo "
<script type='text/javascript' charset='UTF-8'>
    $(function () {
        $(\".lamp span\").toggleClass(\"".$status."\");
	});
</script>";
}
//mode
function mode($m) {
	if ($m == 12) {
    echo "
<script type='text/javascript' charset='UTF-8'>
    $(function () {
		$(\"i#off\").removeClass(\"active\");
		$(\"i#det\").removeClass(\"active\");
		$(\"i#cold\").removeClass(\"active\");
		$(\"i#vent\").removeClass(\"active\");
		$(\"i#hot\").addClass(\"active\");
		$(\"i#auto\").removeClass(\"active\");		
	});
</script>";
	}
	elseif ($m == 11) {
    echo "
<script type='text/javascript' charset='UTF-8'>
    $(function () {
		$(\"i#off\").removeClass(\"active\");
		$(\"i#det\").removeClass(\"active\");
		$(\"i#cold\").removeClass(\"active\");
		$(\"i#vent\").addClass(\"active\");
		$(\"i#hot\").removeClass(\"active\");
		$(\"i#auto\").removeClass(\"active\");
	});
</script>";
	}
	elseif  ($m == 10) {
    echo "
<script type='text/javascript' charset='UTF-8'>
    $(function () {
		$(\"i#off\").removeClass(\"active\");
		$(\"i#det\").addClass(\"active\");
		$(\"i#cold\").removeClass(\"active\");
		$(\"i#vent\").removeClass(\"active\");
		$(\"i#hot\").removeClass(\"active\");
		$(\"i#auto\").removeClass(\"active\");
	});
</script>";
	}
	elseif ($m == 9) {
    echo "
<script type='text/javascript' charset='UTF-8'>
    $(function () {
		$(\"i#off\").removeClass(\"active\");
		$(\"i#det\").removeClass(\"active\");
		$(\"i#cold\").addClass(\"active\");
		$(\"i#vent\").removeClass(\"active\");
		$(\"i#hot\").removeClass(\"active\");
		$(\"i#auto\").removeClass(\"active\");
	});
</script>";
	}
	elseif ($m == 8) {
    echo "
<script type='text/javascript' charset='UTF-8'>
    $(function () {
		$(\"i#off\").removeClass(\"active\");
		$(\"i#det\").removeClass(\"active\");
		$(\"i#cold\").removeClass(\"active\");
		$(\"i#vent\").removeClass(\"active\");
		$(\"i#hot\").removeClass(\"active\");
		$(\"i#auto\").addClass(\"active\");
	});
</script>";
	}
	else {
    echo "
<script type='text/javascript' charset='UTF-8'>
    $(function () {
		$(\"i#off\").addClass(\"active\");
		$(\"i#det\").removeClass(\"active\");
		$(\"i#cold\").removeClass(\"active\");
		$(\"i#vent\").removeClass(\"active\");
		$(\"i#hot\").removeClass(\"active\");
	});
</script>";
	}
}
function get_klimatik($lang,$kline,$inv) {
    echo "<script type=\"text/javascript\" charset=\"UTF-8\">
    function get_klimatik_live() {
	    setInterval(function () {
			$.ajax({
				url: 'klimatik_live.php?lang=$lang&kline=$kline&inv=$inv', 
				success: function(point) {
					data = eval(point);
			$('span#d0').text(data[1]);
			$('span#d1').text(data[2]);
			$('span#d2').text(data[3]);
			$('span#d3').text(data[4]);
			$('span#d4').text(data[5]);
			$('span#d5').text(data[6]);
			$('span#d6').text(data[7]);
			$('span#d7').text(data[8]);
			$('span#d8').text(data[9]);
			$('span#d9').text(data[10]);
			$('span#d10').text(data[11]);
			$('span#d11').text(data[12]);
			$('span#d12').text(data[13]);
			$('span#d13').text(data[14]);
			$('span#d14').text(data[15]);
			if (data[15] == 'ON') {
				$(\".lamp span\").removeClass(\"err\");
				$(\".lamp span\").removeClass(\"off\");
				$(\".lamp span\").removeClass(\"on\");
				$(\".lamp span\").addClass(\"on\");
			} else if (data[15] == 'OFF') {
				$(\".lamp span\").removeClass(\"err\");
				$(\".lamp span\").removeClass(\"on\");
				$(\".lamp span\").removeClass(\"off\");
				$(\".lamp span\").addClass(\"off\");
			} else {
				$(\".lamp span\").removeClass(\"err\");
				$(\".lamp span\").removeClass(\"on\");
				$(\".lamp span\").removeClass(\"off\");
				$(\".lamp span\").addClass(\"err\");
			}
			if (data[9] == 12) {
		$(\"i#off\").removeClass(\"active\");
		$(\"i#det\").removeClass(\"active\");
		$(\"i#cold\").removeClass(\"active\");
		$(\"i#vent\").removeClass(\"active\");
		$(\"i#hot\").addClass(\"active\");
		$(\"i#auto\").removeClass(\"active\");	
			} else if (data[9] == 11) {
		$(\"i#off\").removeClass(\"active\");
		$(\"i#det\").removeClass(\"active\");
		$(\"i#cold\").removeClass(\"active\");
		$(\"i#vent\").addClass(\"active\");
		$(\"i#hot\").removeClass(\"active\");
		$(\"i#auto\").removeClass(\"active\");
			} else if (data[9] == 10) {
		$(\"i#off\").removeClass(\"active\");
		$(\"i#det\").addClass(\"active\");
		$(\"i#cold\").removeClass(\"active\");
		$(\"i#vent\").removeClass(\"active\");
		$(\"i#hot\").removeClass(\"active\");
		$(\"i#auto\").removeClass(\"active\");
			} else if (data[9] == 9) {
		$(\"i#off\").removeClass(\"active\");
		$(\"i#det\").removeClass(\"active\");
		$(\"i#cold\").addClass(\"active\");
		$(\"i#vent\").removeClass(\"active\");
		$(\"i#hot\").removeClass(\"active\");
		$(\"i#auto\").removeClass(\"active\");
			} else if (data[9] == 8) {
		$(\"i#off\").removeClass(\"active\");
		$(\"i#det\").removeClass(\"active\");
		$(\"i#cold\").removeClass(\"active\");
		$(\"i#vent\").removeClass(\"active\");
		$(\"i#hot\").removeClass(\"active\");
		$(\"i#auto\").addClass(\"active\");
			} else {
		$(\"i#off\").addClass(\"active\");
		$(\"i#det\").removeClass(\"active\");
		$(\"i#cold\").removeClass(\"active\");
		$(\"i#vent\").removeClass(\"active\");
		$(\"i#hot\").removeClass(\"active\");
		$(\"i#auto\").removeClass(\"active\");
			}
		var \$t = $('.dial');
		\$t.val(data[6]).trigger('change');
		var \$v = $('.vent');
		\$v.val(data[10]).trigger('change');
		var \$r = $('.ener');
		\$r.val(data[9]).trigger('change');
		},
			cache: false
		});
	}, 10000);
}
$(function () { get_klimatik_live(); });
</script>";
}
?>