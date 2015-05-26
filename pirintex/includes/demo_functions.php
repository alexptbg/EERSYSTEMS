<?php
defined('start') or die('Direct access not allowed.');
function demo_kw($value) {
    $today = time();
    $since = $today - $value;
    return $since;
}
function get_vmeter_220_r($lang,$value) {
	$rand = rand(1000,9999);
    echo "
<script type=\"text/javascript\" charset=\"UTF-8\">
$(function () {
	var chart$rand = new Highcharts.Chart({
	    chart: {
			renderTo: 'chart_$rand',
	        type: 'gauge',
	        plotBorderWidth: 2,
			plotBorderColor: '#333333',
	        plotBackgroundColor: {
	        	linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	        	stops: [
	        		[0, '#BBBBBB'],
	        		[0.5, '#FFFFFF'],
	        		[1, '#BBBBBB']
	        	]
	        },
	        plotBackgroundImage: null,
	        plotShadow: false,
			spacingTop: 0,
			margin: [0, 0, 0, 0],
            height: 240,
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
	    },
	    title: {
	        text: null
	    },
        credits: {
            enabled: false
        },
	    pane: [{
	        startAngle: -50,
	        endAngle: 50,
	        background: null,
	        center: ['50%', '85%'],
	        size: 300
	    }],	    		        
	    yAxis: [{
	        min: 0,
	        max: 240,
	        minorTickPosition: 'outside',
			minorTickColor: '#000000',
	        tickPosition: 'outside',
			tickColor: '#000000',
	        labels: {
	        	rotation: 'auto',
	        	distance: 20,
                style: {
	                color: '#000000'
                }
            },
	        plotBands: [{
	        	from: 200,
	        	to: 225,
	        	color: '#45fa01',
	        	innerRadius: '95%',
	        	outerRadius: '102%'
	        },{
	        	from: 225,
	        	to: 240,
	        	color: '#FF0000',
	        	innerRadius: '95%',
	        	outerRadius: '102%'
	        }],
	        pane: 0,
	        title: {
	        	text: '".get_lang($lang, 'Voltage')."',
	        	y: -40
	        }
	    }],
	    plotOptions: {
	    	gauge: {
	    		dataLabels: {
	    			enabled: true,
	            formatter: function () {
	                var B = this.y,
					    B = B.toFixed(2);
	                return '<span>'+ B + ' V</span>';
	            },
                    x:-90,
                    y:-15
	    		},
				dial: {
					radius: '100%',
					rearLength: '10%'
				}
	    	},
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
	    },
        tooltip: {
            formatter: function() {
                return this.y.toFixed(2) + ' V';
            }
        },
	    series: [{
	        data: [".$value."],
	        yAxis: 0
	    }]
	},
	function(chart) {
	    setInterval(function() {
			y = ".$value.";
	        var volt = chart.series[0].points[0],
	            voltVal = y, 
	            incy = (Math.random()/2) * 3;
	        voltVal =  voltVal + incy;
	        volt.update(voltVal, false);
	        chart.redraw();
	    }, 900);
	});
});
</script>
<div id=\"chart_$rand\" style=\"width:100%; height:250px; margin: 0 auto;\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_amperage_r($lang,$value) {
	$rand = rand(1000,9999);
	echo "
<script type=\"text/javascript\" charset=\"UTF-8\">
$(function () {
	var chart$rand = new Highcharts.Chart({
	    chart: {
			renderTo: 'chart_$rand',
	        type: 'gauge',
	        plotBorderWidth: 2,
			plotBorderColor: '#333333',
	        plotBackgroundColor: {
	        	linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	        	stops: [
	        		[0, '#BBBBBB'],
	        		[0.5, '#FFFFFF'],
	        		[1, '#BBBBBB']
	        	]
	        },
	        plotBackgroundImage: null,
	        plotShadow: false,
			spacingTop: 0,
			margin: [0, 0, 0, 0],
            height: 240,
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
	    },
	    title: {
	        text: null
	    },
        credits: {
            enabled: false
        },
	    pane: [{
	        startAngle: -90,
	        endAngle: 10,
	        background: null,
	        center: ['70%', '85%'],
	        size: 300
	    }],	    		        
	    yAxis: [{
	        min: 0,
	        max: 40,
	        minorTickPosition: 'outside',
			minorTickColor: '#000000',
	        tickPosition: 'outside',
			tickColor: '#000000',
	        labels: {
	        	rotation: 'auto',
	        	distance: 20,
                style: {
	                color: '#000000'
                }
            },
	        plotBands: [
            {
	        	from: 25,
	        	to: 35,
	        	color: '#45fa01',
	        	innerRadius: '95%',
	        	outerRadius: '102%'
	        },
            {
	        	from: 35,
	        	to: 40,
	        	color: '#FF0000',
	        	innerRadius: '95%',
	        	outerRadius: '102%'
	        }
            ],
	        pane: 0,
	        title: {
	        	text: '".get_lang($lang, 'Amperage')."',
	        	y: 0,
                x: -70
	        }
	    }],
	    plotOptions: {
	    	gauge: {
	    		dataLabels: {
	    			enabled: true,
	            formatter: function () {
	                var B = this.y,
					    B = B.toFixed(2);
	                return '<span>'+ B + ' A</span>';
	            },
                    x:-160,
                    y:-160
	    		},
				dial: {
					radius: '100%',
					rearLength: '10%'
				}
	    	},
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
	    },
        tooltip: {
            formatter: function() {
                return this.y.toFixed(2) + ' A';
            }
        },
	    series: [{
	        data: [".$value."],
	        yAxis: 0
	    }]
	},
	function(chart) {
	    setInterval(function() {
			z = ".$value.";
	        var amp = chart.series[0].points[0],
	            ampVal = z, 
	            incz = (Math.random()/2) * 3;
	        ampVal =  ampVal + incz;
	        amp.update(ampVal, false);
	        chart.redraw();
	    }, 900);
	});
});
</script>
<div id=\"chart_$rand\" style=\"width:100%; height:250px; margin: 0 auto;\"><div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div>";
}
function get_meter_r($lang,$value) {
	$rand = rand(1000,9999);
	echo "
<script type=\"text/javascript\" charset=\"UTF-8\">
    var meter_$rand;
	var led_$rand;
    function init_$rand() {
        meter_$rand = new steelseries.DisplayMulti('canvas_$rand', {
                            width: 260,
                            height: 80,
                            unitString: \" kw/h\",
                            unitStringVisible: true,
                            headerString: \"OK\",
                            headerStringVisible: true,
                            detailString: \"detail: \",
                            detailStringVisible: false,
                            linkOldValue: false,
                            oldValue: 99.9
                            });
		        led_$rand = new steelseries.Led('Led_$rand', {
                            width: 32,
                            height: 32
                            });
        led_$rand.blink(true);
		setInterval(function(){ setRandomValue2(meter_$rand, $value); }, 1100);
    }
    function setRandomValue2(gauge, range) {
        gauge.setValue(Math.random()/2 + range);
    }
    $(function () {
		init_$rand();
	});
</script>
<div id=\"chart_$rand\" style=\"width:100%; height:80px; margin: 0 auto;\">
    <canvas id=\"canvas_$rand\" width=\"260\" height=\"80\"></canvas>
    <canvas id=\"Led_$rand\" width=\"32\" height=\"32\"></canvas>
</div>
";
}
function get_odometer_r($lang,$value) {
	$rand = rand(1000,9999);
	echo "
<script type=\"text/javascript\" charset=\"UTF-8\">
    var odometer_$rand, 
	n = ".demo_kw($value)."/10;
	var led_$rand;
	function init_$rand() {
		        led_$rand = new steelseries.Led('Led_$rand', {
                            width: 40,
                            height: 40
                            });
        led_$rand.blink(true);
		led_$rand.setLedColor(steelseries.LedColor.GREEN_LED);
	    odometer_$rand = new steelseries.Odometer('canvas_$rand', {});
	    updateOdo();
	}
    function updateOdo() {
        n += 0.010;
        odometer_$rand.setValue(n);
        setTimeout(\"updateOdo()\", 70);
    }
    $(function () {
		init_$rand();
	});
</script>
<div id=\"chart_$rand\" style=\"width:100%; height:50px; margin: 0 auto;\">
    <canvas id=\"canvas_$rand\" width=\"90\" height=\"50\"></canvas>
	<canvas id=\"Led_$rand\" width=\"40\" height=\"40\"></canvas>
</div>
";
}
function get_hled($lang) {
	$rand = rand(1000,9999);
    echo "<script type=\"text/javascript\" charset=\"UTF-8\">
	    var currentRenderer = 'javascript';
	    var chartObj;
	 	window.onload = function() { 
	   FusionCharts.setCurrentRenderer(currentRenderer);
        chartObj = new FusionCharts({
           swfUrl: 'js/plugins/c/hled.swf',
           width: '100%', 
		   height: '70',
           id: 'sampleChart',
           dataSource: 'hled.php?lang=".$lang."',
           dataFormat: FusionChartsDataFormats.XMLURL,           
           renderAt: 'chart_$rand'
        }).render();
	    rendererAfterToggle  = FusionCharts.getCurrentRenderer();
		jQuery.extend (jQuery.easing, {
			easeInOutExpo: function (x, t, b, c, d) {
				if (t==0) return b;
				if (t==d) return b+c;
				if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
				return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
			}
		});
        }
	</script>
	<div id=\"chart_$rand\" style=\"width:100%; height:70px; margin: 0 auto; background-color:#CECCBB;\"></div>";
}
?>