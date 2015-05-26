<?php
defined('start') or die('Direct access not allowed.');
function get_weather($lang,$code) {
	echo "
	<script type='text/javascript' src='js/weather.js'></script>
    <script type='text/javascript' charset='UTF-8'>
$(document).ready(function() {
	$.simpleWeather({
		zipcode: '$code',
		unit: 'c',
		success: function(weather) {
			low = weather.low - 8;
			//html =  '<h3>'+weather.city+'</h3>';
			html = '<img class=\"w\" src='+weather.image+'>';
			html += '<span><strong>".get_lang($lang, 'Temperature').":</strong> '+weather.temp+'&deg; '+weather.units.temp+'</span><br/>';
			html += '<span><strong>".get_lang($lang, 'whigh').":</strong> '+weather.high+'&deg; '+weather.units.temp+'</span><br/>';
			html += '<span><strong>".get_lang($lang, 'wlow').":</strong> '+low+'&deg; '+weather.units.temp+'</span><br/>';
			html += '<span><strong>".get_lang($lang, 'Humidity').":</strong> '+weather.humidity+'%</span><br/>';
			html += '<span><strong>".get_lang($lang, 'Pressure').":</strong> '+weather.pressure+' mb</span><br/>';
			html += '<span><strong>".get_lang($lang, 'Wind').":</strong> '+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed+'</span>';
			$(\"#weather\").html(html);
		},
		error: function(error) {
			$(\"#weather\").html('<p>'+error+'</p>');
		}
	});
});
	</script>
	<div id='weather'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_temp_outside($lang,$line,$id,$tk) {
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_out() {
	    setInterval(function () {
			$.ajax({
				url: 'live_outside.php?lang=$lang&line=$line&id=$id&tk=$tk', 
				success: function(data) {
			        $('.weather h4').html(data);
			    },
				cache: false
			});
	    }, 10000);
	}
    $(function () {
			$.ajax({
				url: 'live_outside.php?lang=$lang&line=$line&id=$id&tk=$tk', 
				success: function(data) {
			        $('.weather h4').html(data);
			    },
				cache: false
			});
	    get_live_out(); 
	});
</script>";
}
function get_temp_inside($lang,$line,$id,$tk) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_in_$rand() {
	    setInterval(function () {
			$.ajax({
				url: 'live_inside.php?lang=$lang&line=$line&id=$id&tk=$tk', 
				success: function(data) {
			$('span#i_$rand').html(data);
			},
				cache: false
			});
	    }, 10000);
	}
    $(function () {
			$.ajax({
				url: 'live_inside.php?lang=$lang&line=$line&id=$id&tk=$tk', 
				success: function(data) {
			$('span#i_$rand').html(data);
			},
				cache: false
			});
	    get_live_in_$rand(); 
	});
</script><span id='i_$rand'></span>";
}
function get_temp_outside2($lang,$line,$id,$tk) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_in_$rand() {
	    setInterval(function () {
			$.ajax({
				url: 'live_outside2.php?lang=$lang&line=$line&id=$id&tk=$tk', 
				success: function(data) {
			$('span#i_$rand').html(data);
			},
				cache: false
			});
	    }, 10000);
	}
    $(function () {
			$.ajax({
				url: 'live_outside2.php?lang=$lang&line=$line&id=$id&tk=$tk', 
				success: function(data) {
			$('span#i_$rand').html(data);
			},
				cache: false
			});
	    get_live_in_$rand(); 
	});
</script>";
echo "<span id='i_$rand'></span>";
}
function get_vmeter_24_r($lang) {//simulation
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function () {
	var chart$rand = new Highcharts.Chart({
	    chart: {
	        renderTo: 'chart_$rand',
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			spacingTop: 0,
			margin: [0, 0, 0, 0],
            height: 200,
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
	        startAngle: -45,
	        endAngle: 45,
	        background: null,
	        center: ['50%', '110%'],
	        size: 260
	    }],	    		        
	    yAxis: [{
	        min: 0,
	        max: 32,
	        minorTickPosition: 'outside',
	        tickPosition: 'outside',
	        labels: {
	        	rotation: 'auto',
	        	distance: 20
	        },
	        plotBands: [{
	        	from: 18,
	        	to: 22,
	        	color: '#f4b906',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        },{
	        	from: 22,
	        	to: 27,
	        	color: '#45fa01',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        },{
	        	from: 27,
	        	to: 32,
	        	color: '#FF0000',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
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
	    			enabled: true
	    		},
	    		dial: {
	    			radius: '100%'
	    		}
	    	}
	    },
	    series: [{
	        data: [24],
	        yAxis: 0
	    }]
	},
	function(chart) {
	    setInterval(function() {
			y = 24.0;
	        var left = chart.series[0].points[0],
	            leftVal = y, 
	            inc = (Math.random()/3) * 2;
	        leftVal =  leftVal + inc;
			$('span#c$rand').text(leftVal.toPrecision(4)+' V');
	        left.update(leftVal, false);
	        chart.redraw();
	    }, 1000);
	});
});
</script>
<div id='clml10'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_analog_clock() {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function () {
	function getNow () {
	    var now = new Date();
	    return {
	        hours: now.getHours() + now.getMinutes() / 60,
	        minutes: now.getMinutes() * 12 / 60 + now.getSeconds() * 12 / 3600,
	        seconds: now.getSeconds() * 12 / 60
	    };
	};
	function pad(number, length) {
		return new Array((length || 2) + 1 - String(number).length).join(0) + number;
	}
	var now = getNow();
	var chart$rand = new Highcharts.Chart({
	    chart: {
	        renderTo: 'chart_$rand',
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
	        height: 200,
			margin: [10, 0, 10, 0],
            animation: {
                duration: 1500,
                easing: 'easeOutElastic'
            }
	    },
	    credits: {
	        enabled: false
	    },
	    title: {
	    	text: null
	    },
	    pane: {
	    	background: [{
	    	}, {
	    		backgroundColor: Highcharts.svg ? {
		    		radialGradient: {
		    			cx: 0.5,
		    			cy: -0.4,
		    			r: 1.9
		    		},
		    		stops: [
		    			[0.5, 'rgba(255, 255, 255, 0.2)'],
		    			[0.5, 'rgba(200, 200, 200, 0.2)']
		    		]
		    	} : null
	    	}]
	    },
	    yAxis: {
	        labels: {
	            distance: -20
	        },
	        min: 0,
	        max: 12,
	        lineWidth: 0,
	        showFirstLabel: false,
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 5,
	        minorTickPosition: 'inside',
	        minorGridLineWidth: 0,
	        minorTickColor: '#666',
	        tickInterval: 1,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        title: {
	            text: 'Powered by<br/>EES',
	            style: {
	                color: '#BBB',
	                fontWeight: 'normal',
	                fontSize: '8px',
	                lineHeight: '10px'                
	            },
	            y: 10
	        }       
	    },
	    tooltip: {
	    	formatter: function () {
	    		return chart$rand.tooltipText;
	    	}
	    },
	    series: [{
	        data: [{
	            id: 'hour',
	            y: now.hours,
	            dial: {
	                radius: '60%',
	                baseWidth: 4,
	                baseLength: '95%',
	                rearLength: 0
	            }
	        }, {
	            id: 'minute',
	            y: now.minutes,
	            dial: {
	                baseLength: '95%',
	                rearLength: 0
	            }
	        }, {
	            id: 'second',
	            y: now.seconds,
	            dial: {
	                radius: '100%',
	                baseWidth: 1,
	                rearLength: '20%'
	            }
	        }],
	        animation: false,
	        dataLabels: {
	            enabled: false
	        }
	    }]
	}, 
	function (chart) {
	    setInterval(function () {
	        var hour = chart.get('hour'),
	            minute = chart.get('minute'),
	            second = chart.get('second'),
	            now = getNow(),
	            animation = now.seconds == 0 ? 
	                false : 
	                {
	                    easing: 'easeOutElastic'
	                };
	        chart$rand.tooltipText = 
				pad(Math.floor(now.hours), 2) + ':' + 
	    		pad(Math.floor(now.minutes * 5), 2) + ':' + 
	    		pad(now.seconds * 5, 2);
	        hour.update(now.hours, true, animation);
	        minute.update(now.minutes, true, animation);
	        second.update(now.seconds, true, animation);
	    }, 1000);
	});
});
</script>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_gauge_temp_150($lang,$line,$id,$tk) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function(){
    var chart$rand = new Highcharts.Chart({
	    chart: {
	        renderTo: 'chart_$rand',
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			spacingTop: 0,
			margin: [0, 0, 0, 0],
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
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	    yAxis: {
	        min: 0,
	        max: 150,
	        minorTickInterval: 5,
	        minorTickWidth: 1,
	        minorTickLength: 5,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	        tickPixelInterval: 30,
	        tickWidth: 1,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: null
	        },
	        plotBands: [{
	            from: 0,
	            to: 80,
	            color: '#bfeeff' // blue
	        },{
	            from: 80,
	            to: 125,
	            color: '#45fa01' // green
	        },{
	            from: 125,
	            to: 140,
	            color: '#ec9f00' // yellow
	        },{
	            from: 140,
	            to: 150,
	            color: '#FF0000' // red
	        }]        
	    },
	    series: [{
	        name: '".get_lang($lang, 'Temperature')."',
	        data: [0],
	        dataLabels: {
	            formatter: function () {
	                var C = this.y,
					    C = C.toFixed(0);
	                return '<span style=\"font-size:9px;\">'+ C + ' ºC</span><br/>';
	            }
			},
	        tooltip: {
	            valueSuffix: ' ºC'
	        }
	    }]
	}, 
	function (chart) {
	    setInterval(function () {
			$.ajax({
				url: 'gauge.php?line=$line&id=$id&tk=$tk', 
				success: function(point) {
		    y = eval(point);
	        var point = chart.series[0].points[0],
	            newVal = y[1],
	            inc = Math.random()*2/3;
			    $('span#c$rand').text(newVal.toPrecision(3)+'ºC');
	        point.update(newVal); },
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='clml10'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:220px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_bar($lang,$line,$id,$tk) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function(){
    var chart$rand = new Highcharts.Chart({
	    chart: {
	        renderTo: 'chart_$rand',
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			spacingTop: 0,
			margin: [0, 0, 0, 0],
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
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	    yAxis: {
	        min: 0,
	        max: 10,
	        minorTickInterval: 5,
	        minorTickWidth: 1,
	        minorTickLength: 5,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	        tickPixelInterval: 30,
	        tickWidth: 1,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: null
	        },
	        plotBands: [{
	            from: 0,
	            to: 4,
	            color: '#bfeeff' // blue
	        },{
	            from: 4,
	            to: 6,
	            color: '#45fa01' // green
	        },{
	            from: 6,
	            to: 8,
	            color: '#ec9f00' // yellow
	        },{
	            from: 8,
	            to: 10,
	            color: '#FF0000' // red
	        }]        
	    },
	    series: [{
	        name: '".get_lang($lang, 'inter60')."',
	        data: [0],
	        dataLabels: {
	            formatter: function () {
	                var C = this.y,
					    C = C.toFixed(1);
	                return '<span style=\"font-size:9px;\">'+ C + ' ".get_lang($lang, 'inter60')."</span><br/>';
	            }
			},
	        tooltip: {
	            valueSuffix: ''
	        }
	    }]
	}, 
	function (chart) {
	    setInterval(function () {
			$.ajax({
				url: 'gauge.php?line=$line&id=$id&tk=$tk', 
				success: function(point) {
		    y = eval(point);
	        var point = chart.series[0].points[0],
	            newVal = y[1]/10,
	            inc = Math.random()*2/3;
			    $('span#c$rand').text(newVal.toPrecision(3)+' ".get_lang($lang, 'inter60')."');
	        point.update(newVal); },
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='clml10'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_gauge_tempbar_160($lang,$line,$id,$tk) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function(){
    var chart$rand = new Highcharts.Chart({
	    chart: {
	        renderTo: 'chart_$rand',
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			spacingTop: 0,
			margin: [0, 0, 0, 0],
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
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	    yAxis: {
	        min: 0,
	        max: 180,
	        minorTickInterval: 5,
	        minorTickWidth: 1,
	        minorTickLength: 5,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	        tickPixelInterval: 30,
	        tickWidth: 1,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: null
	        },
	        plotBands: [{
	            from: 0,
	            to: 80,
	            color: '#bfeeff' // blue
	        },{
	            from: 80,
	            to: 125,
	            color: '#FF0000' // green
	        },{
	            from: 125,
	            to: 140,
	            color: '#ec9f00' // yellow
	        },{
	            from: 140,
	            to: 180,
	            color: '#45fa01' // red
	        }]        
	    },
	    series: [{
	        name: '".get_lang($lang, 'Temperature')."',
	        data: [0],
	        dataLabels: {
	            formatter: function () {
	                var t = this.y,
					    t = t.toFixed(1);
	                return '<span style=\"font-size:9px;\">'+ t + ' ºC</span><br/>';
	            }
			},
	        tooltip: {
	            valueSuffix: ' ºC'
	        }
	    }]
	}, 
	function (chart) {
	    setInterval(function () {
			$.ajax({
				url: 'gauge.php?line=$line&id=$id&tk=$tk', 
				success: function(point) {
		    y = eval(point);
	        var point = chart.series[0].points[0],
	            newVal = y[1]/10,
	            inc = Math.random()*2/3;
                var a = 8.14019;
                var b = 1810.94;
                var c = 244.485;
                var d = log10(newVal*750.061683);
                var r = b/(a-d)-c;
			    $('span#c$rand').text(r.toPrecision(4)+'ºC');
	            point.update(r); },
				cache: false
			});
	    }, 2000);
	});
});
</script>
<div id='clml10'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_gauge_temp_c_160($lang,$line,$id,$tk) {//f and c
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function () {
	var chart$rand = new Highcharts.Chart({
	    chart: {
	        renderTo: 'chart_$rand',
	        type: 'gauge',
	        alignTicks: false,
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			spacingTop: 0,
			margin: [0, 0, 0, 0],
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
	    pane: {
	        startAngle: -140,
	        endAngle: 140
	    },	        
	    yAxis: [{
	        min: 0,
	        max: 160,
	        lineColor: '#ff004c',
	        tickColor: '#ff004c',
	        minorTickColor: '#ff004c',
	        offset: -25,
	        lineWidth: 1,
	        labels: {
	            distance: -20,
	            rotation: 'auto'
	        },
	        tickLength: 5,
	        minorTickLength: 5,
	        endOnTick: false
	    }, {
	        min: 33,
	        max: 320,
	        tickPosition: 'outside',
	        lineColor: '#1549b7',
	        lineWidth: 1,
	        minorTickPosition: 'outside',
	        tickColor: '#1549b7',
	        minorTickColor: '#1549b7',
	        tickLength: 5,
	        minorTickLength: 5,
	        labels: {
	            distance: 12,
	            rotation: 'auto'
	        },
	        offset: -20,
	        endOnTick: false
	    }],
	    series: [{
	        name: '".get_lang($lang, 'Temperature')."',
	        data: [0],
	        dataLabels: {
	            formatter: function () {
	                var C = this.y,
	                    F = Math.round(C * 1.8000 + 32.00);
	                return '<span style=\"color:#ff004c;font-size:9px;\">'+ C + 'º C</span><br/>' +
	                    '<span style=\"color:#1549b7;font-size:9px;\">' + F + 'º F</span>';
	            },
	            backgroundColor: {
	                linearGradient: {
	                    x1: 0,
	                    y1: 0,
	                    x2: 0,
	                    y2: 1
	                },
	                stops: [
	                    [0, '#DDD'],
	                    [1, '#FFF']
	                ]
	            }
	        },
	        tooltip: {
	            valueSuffix: ' ºC'
	        }
	    }]
	},
	function (chart) {
	    setInterval(function () {
			$.ajax({
				url: 'gauge.php?line=$line&id=$id&tk=$tk', 
				success: function(point) {
		    y = eval(point);
	        var point = chart.series[0].points[0],
	            newVal = y[1],
	            inc = Math.random();
                $('span#c$rand').text(newVal.toPrecision(3)+'ºC');
	        point.update(newVal); },
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='clml10'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_t_bu($lang,$line,$id) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_bu() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=".$id."&x=', 
				success: function(point) {
		            y = eval(point);
			        var bu1 = y[8]-22;
					var bu11 = bu1/20;
					var bu_1 = bu11.toFixed(2);
					$('span#bu1').text(bu_1);
			        var bu2 = y[7]-22;
					var bu22 = bu2/20;
					var bu_2 = bu22.toFixed(2);
					$('span#bu2').text(bu_2);
					$('span#bu3').text(y[3]);
                var a = 8.14019;
                var p = 1810.94;
                var c = 244.485;
                var d = log10(bu22*750.061683);
                var r = p/(a-d)-c;
				var z = r.toFixed(2);
			    $('span#bu4').text(z);
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () { get_live_bu(); });
</script>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
<tbody>
<tr>
<td class=\"tar\">".get_lang($lang, 'ad283').":</td>
<td><span id=\"bu1\">0</span> ".get_lang($lang, 'inter60')."</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi02').":</td>
<td><span id=\"bu2\">0</span> ".get_lang($lang, 'inter60')."</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'ad284').":</td>
<td><span id=\"bu3\">0</span> ºC</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi03').":</td>
<td><span id=\"bu4\">0</span> ºC</td>
</tr>
</tbody>
</table>";
}
function get_t_b1($lang,$line,$id) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_b1() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=".$id."&x=', 
				success: function(point) {
		            y = eval(point);
			        var b1 = y[1]/10;
					var b_1 = b1.toFixed(2);
					$('span#b1').text(b_1);
			        var b2 = y[2]/10;
					var b_2 = b2.toFixed(2);
					$('span#b2').text(b_2);
                var a = 8.14019;
                var p = 1810.94;
                var c = 244.485;
                var d = log10(b1*750.061683);
                var r = p/(a-d)-c;
				var z = r.toFixed(2);
			    $('span#b3').text(z);
                var e = 8.14019;
                var f = 1810.94;
                var g = 244.485;
                var h = log10(b2*750.061683);
                var l = f/(e-h)-g;
				var x = l.toFixed(2);
			    $('span#b4').text(x);
			        var b5 = y[5]/10;
					var b_5 = b5.toFixed(2);
					$('span#b5').text(b_5);		
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () { get_live_b1(); });
</script>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
<tbody>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi02').":</td>
<td><span id=\"b1\">0</span> / <span id=\"b2\">0</span> ".get_lang($lang, 'inter60')."</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi03').":</td>
<td><span id=\"b3\">0</span> / <span id=\"b4\">0</span> ºC</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi04').":</td>
<td><span id=\"b5\">0</span> ".get_lang($lang, 'inter60')."</td>
</tr>
</tbody>
</table>";
}
function get_t_b2($lang,$line,$id) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_b2() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=".$id."&x=', 
				success: function(point) {
		            y = eval(point);
			        var b1 = y[3]/10;
					var b_1 = b1.toFixed(2);
					$('span#c1').text(b_1);
			        var b2 = y[4]/10;
					var b_2 = b2.toFixed(2);
					$('span#c2').text(b_2);
                var a = 8.14019;
                var p = 1810.94;
                var c = 244.485;
                var d = log10(b1*750.061683);
                var r = p/(a-d)-c;
				var z = r.toFixed(2);
			    $('span#c3').text(z);
                var e = 8.14019;
                var f = 1810.94;
                var g = 244.485;
                var h = log10(b2*750.061683);
                var l = f/(e-h)-g;
				var x = l.toFixed(2);
			    $('span#c4').text(x);
			        var b5 = y[6]/10;
					var b_5 = b5.toFixed(2);
					$('span#c5').text(b_5);		
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () { get_live_b2(); });
</script>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
<tbody>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi02').":</td>
<td><span id=\"c1\">0</span> / <span id=\"c2\">0</span> ".get_lang($lang, 'inter60')."</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi03').":</td>
<td><span id=\"c3\">0</span> / <span id=\"c4\">0</span> ºC</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi04').":</td>
<td><span id=\"c5\">0</span> ".get_lang($lang, 'inter60')."</td>
</tr>
</tbody>
</table>";
}
function get_t_s1($lang,$line,$id) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_s1() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=".$id."&x=', 
				success: function(point) {
		            y = eval(point);
			        var b1 = y[3]/10;
					var b_1 = b1.toFixed(2);
					$('span#d1').text(b_1);

                var a = 8.14019;
                var p = 1810.94;
                var c = 244.485;
                var d = log10(b1*750.061683);
                var r = p/(a-d)-c;
				var z = r.toFixed(2);
			    $('span#d3').text(z);

			        var b5 = y[4]/10;
					var b_5 = b5.toFixed(2);
					$('span#d5').text(b_5);		
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () { get_live_s1(); });
</script>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
<tbody>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi02').":</td>
<td><span id=\"d1\">0</span> ".get_lang($lang, 'inter60')."</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi03').":</td>
<td><span id=\"d3\">0</span> ºC</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi04').":</td>
<td><span id=\"d5\">0</span> ".get_lang($lang, 'inter60')."</td>
</tr>
</tbody>
</table>";
}
function get_t_s2($lang,$line,$id) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_s2() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=".$id."&x=', 
				success: function(point) {
		            y = eval(point);
			        var b1 = y[1]/10;
					var b_1 = b1.toFixed(2);
					$('span#e1').text(b_1);
			        var b2 = y[2]/10;
					var b_2 = b2.toFixed(2);
					$('span#e2').text(b_2);
                var a = 8.14019;
                var p = 1810.94;
                var c = 244.485;
                var d = log10(b1*750.061683);
                var r = p/(a-d)-c;
				var z = r.toFixed(2);
			    $('span#e3').text(z);
                var e = 8.14019;
                var f = 1810.94;
                var g = 244.485;
                var h = log10(b2*750.061683);
                var l = f/(e-h)-g;
				var x = l.toFixed(2);
			    $('span#e4').text(x);
			        var b5 = y[5]/10;
					var b_5 = b5.toFixed(2);
					$('span#e5').text(b_5);		
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () { get_live_s2(); });
</script>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
<tbody>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi02').":</td>
<td><span id=\"e1\">0</span> / <span id=\"e2\">0</span> ".get_lang($lang, 'inter60')."</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi03').":</td>
<td><span id=\"e3\">0</span> / <span id=\"e4\">0</span> ºC</td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'egi04').":</td>
<td><span id=\"e5\">0</span> ".get_lang($lang, 'inter60')."</td>
</tr>
</tbody>
</table>";
}
function get_t_l_b1($lang,$line) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_l_b1_1() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=0&x=', 
				success: function(point) {
		            y = eval(point);
					if (y[1] < 80) { var b1 = '<font color=\"orange\">' + y[1] + ' ºC</font>'; }
					else if (y[1] > 125) { var b1 = '<font color=\"red\">' + y[1] + ' ºC</font>'; }
					else if ((y[1] == null) || (y[1] == 0) || (y[1] == 255)){ var b1 = y[1]; }
					else { var b1 = '<font color=\"green\">' + y[1] + ' ºC</font>'; }
	                $('span#l_b1_1').html(b1);
					if (y[2] < 80) { var b2 = '<font color=\"orange\">' + y[2] + ' ºC</font>'; }
					else if (y[2] > 125) { var b2 = '<font color=\"red\">' + y[2] + ' ºC</font>'; }
					else if ((y[2] == null) || (y[2] == 0) || (y[2] == 255)){ var b2 = y[2]; }
					else { var b2 = '<font color=\"green\">' + y[2] + ' ºC</font>'; }
	                $('span#l_b1_2').html(b2);
					if (y[3] < 80) { var b3 = '<font color=\"orange\">' + y[3] + ' ºC</font>'; }
					else if (y[3] > 125) { var b3 = '<font color=\"red\">' + y[3] + ' ºC</font>'; }
					else if ((y[3] == null) || (y[3] == 0) || (y[3] == 255)){ var b3 = y[3]; }
					else { var b3 = '<font color=\"green\">' + y[3] + ' ºC</font>'; }
	                $('span#l_b1_3').html(b3);
					if (y[4] < 80) { var b4 = '<font color=\"orange\">' + y[4] + ' ºC</font>'; }
					else if (y[4] > 125) { var b4 = '<font color=\"red\">' + y[4] + ' ºC</font>'; }
					else if ((y[4] == null) || (y[4] == 0) || (y[4] == 255)){ var b4 = y[4]; }
					else { var b4 = '<font color=\"green\">' + y[4] + ' ºC</font>'; }
	                $('span#l_b1_4').html(b4);
					if (y[5] < 80) { var b5 = '<font color=\"orange\">' + y[5] + ' ºC</font>'; }
					else if (y[5] > 125) { var b5 = '<font color=\"red\">' + y[5] + ' ºC</font>'; }
					else if ((y[5] == null) || (y[5] == 0) || (y[5] == 255)){ var b5 = y[5]; }
					else { var b5 = '<font color=\"green\">' + y[5] + ' ºC</font>'; }
	                $('span#l_b1_5').html(b5);
					if (y[6] < 80) { var b6 = '<font color=\"orange\">' + y[6] + ' ºC</font>'; }
					else if (y[6] > 125) { var b6 = '<font color=\"red\">' + y[6] + ' ºC</font>'; }
					else if ((y[6] == null) || (y[6] == 0) || (y[6] == 255)){ var b6 = y[6]; }
					else { var b6 = '<font color=\"green\">' + y[6] + ' ºC</font>'; }
	                $('span#l_b1_6').html(b6);
					if (y[7] < 80) { var b7 = '<font color=\"orange\">' + y[7] + ' ºC</font>'; }
					else if (y[7] > 125) { var b7 = '<font color=\"red\">' + y[7] + ' ºC</font>'; }
					else if ((y[7] == null) || (y[7] == 0) || (y[7] == 255)){ var b7 = y[7]; }
					else { var b7 = '<font color=\"green\">' + y[7] + ' ºC</font>'; }
	                $('span#l_b1_7').html(b7);
					if (y[8] < 80) { var b8 = '<font color=\"orange\">' + y[8] + ' ºC</font>'; }
					else if (y[8] > 125) { var b8 = '<font color=\"red\">' + y[8] + ' ºC</font>'; }
					else if ((y[8] == null) || (y[8] == 0) || (y[8] == 255)){ var b8 = y[8]; }
					else { var b8 = '<font color=\"green\">' + y[8] + ' ºC</font>'; }
	                $('span#l_b1_8').html(b8);
			},
				cache: false
			});
	    }, 2000);
	}
    function get_live_l_b1_2() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=1&x=', 
				success: function(point) {
		            y = eval(point);
					if (y[1] < 80) { var b9 = '<font color=\"orange\">' + y[1] + ' ºC</font>'; }
					else if (y[1] > 125) { var b9 = '<font color=\"red\">' + y[1] + ' ºC</font>'; }
					else if ((y[1] == null) || (y[1] == 0) || (y[1] == 255)){ var b9 = y[1]; }
					else { var b9 = '<font color=\"green\">' + y[1] + ' ºC</font>'; }
	                $('span#l_b1_9').html(b9);
					if (y[2] < 80) { var b10 = '<font color=\"orange\">' + y[2] + ' ºC</font>'; }
					else if (y[2] > 125) { var b10 = '<font color=\"red\">' + y[2] + ' ºC</font>'; }
					else if ((y[2] == null) || (y[2] == 0) || (y[2] == 255)){ var b10 = y[2]; }
					else { var b10 = '<font color=\"green\">' + y[2] + ' ºC</font>'; }
	                $('span#l_b1_10').html(b10);
					if (y[3] < 80) { var b11 = '<font color=\"orange\">' + y[3] + ' ºC</font>'; }
					else if (y[3] > 125) { var b11 = '<font color=\"red\">' + y[3] + ' ºC</font>'; }
					else if ((y[3] == null) || (y[3] == 0) || (y[3] == 255)){ var b11 = y[3]; }
					else { var b11 = '<font color=\"green\">' + y[3] + ' ºC</font>'; }
	                $('span#l_b1_11').html(b11);
					if (y[4] < 80) { var b12 = '<font color=\"orange\">' + y[4] + ' ºC</font>'; }
					else if (y[4] > 125) { var b12 = '<font color=\"red\">' + y[4] + ' ºC</font>'; }
					else if ((y[4] == null) || (y[4] == 0) || (y[4] == 255)){ var b12 = y[4]; }
					else { var b12 = '<font color=\"green\">' + y[4] + ' ºC</font>'; }
	                $('span#l_b1_12').html(b12);
					if (y[5] < 80) { var b13 = '<font color=\"orange\">' + y[5] + ' ºC</font>'; }
					else if (y[5] > 125) { var b13 = '<font color=\"red\">' + y[5] + ' ºC</font>'; }
					else if ((y[5] == null) || (y[5] == 0) || (y[5] == 255)){ var b13 = y[5]; }
					else { var b13 = '<font color=\"green\">' + y[5] + ' ºC</font>'; }
	                $('span#l_b1_13').html(b13);
			},
				cache: false
			});
	    }, 3000);
	}
    function get_live_l_b1_3() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=2&x=', 
				success: function(point) {
		            y = eval(point);
					if (y[1] < 80) { var b14 = '<font color=\"orange\">' + y[1] + ' ºC</font>'; }
					else if (y[1] > 125) { var b14 = '<font color=\"red\">' + y[1] + ' ºC</font>'; }
					else if ((y[1] == null) || (y[1] == 0) || (y[1] == 255)){ var b14 = y[1]; }
					else { var b14 = '<font color=\"green\">' + y[1] + ' ºC</font>'; }
	                $('span#l_b1_14').html(b14);
					if (y[2] < 80) { var b15 = '<font color=\"orange\">' + y[2] + ' ºC</font>'; }
					else if (y[2] > 125) { var b15 = '<font color=\"red\">' + y[2] + ' ºC</font>'; }
					else if ((y[2] == null) || (y[2] == 0) || (y[2] == 255)){ var b15 = y[2]; }
					else { var b15 = '<font color=\"green\">' + y[2] + ' ºC</font>'; }
	                $('span#l_b1_15').html(b15);
					if (y[3] < 80) { var b16 = '<font color=\"orange\">' + y[3] + ' ºC</font>'; }
					else if (y[3] > 125) { var b16 = '<font color=\"red\">' + y[3] + ' ºC</font>'; }
					else if ((y[3] == null) || (y[3] == 0) || (y[3] == 255)){ var b16 = y[3]; }
					else { var b16 = '<font color=\"green\">' + y[3] + ' ºC</font>'; }
	                $('span#l_b1_16').html(b16);
					if (y[4] < 80) { var b17 = '<font color=\"orange\">' + y[4] + ' ºC</font>'; }
					else if (y[4] > 125) { var b17 = '<font color=\"red\">' + y[4] + ' ºC</font>'; }
					else if ((y[4] == null) || (y[4] == 0) || (y[4] == 255)){ var b17 = y[4]; }
					else { var b17 = '<font color=\"green\">' + y[4] + ' ºC</font>'; }
	                $('span#l_b1_17').html(b17);
			},
				cache: false
			});
	    }, 4000);
	}
    $(function () { get_live_l_b1_1(); get_live_l_b1_2(); get_live_l_b1_3(); });
</script>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
<thead>
<tr>
<th>".get_lang($lang, 'info5')."</th>
<th>".get_lang($lang, 'Temperature')."</th>
<th>".get_lang($lang, 'info5')."</th>
<th>".get_lang($lang, 'Temperature')."</th>								
</tr>
</thead>
<tbody>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=1\"><span class=\"label label-info\">1</span></a></td>
    <td><span id=\"l_b1_1\">0</span></td>
	<td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=10\"><span class=\"label label-info\">10</span></a></td>
	<td><span id=\"l_b1_10\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=2\"><span class=\"label label-info\">2</span></a></td>
    <td><span id=\"l_b1_2\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=11\"><span class=\"label label-info\">11</span></a></td>
	<td><span id=\"l_b1_11\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=3\"><span class=\"label label-info\">3</span></a></td>
    <td><span id=\"l_b1_3\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=12\"><span class=\"label label-info\">12</span></a></td>
	<td><span id=\"l_b1_12\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=4\"><span class=\"label label-info\">4</span></a></td>
    <td><span id=\"l_b1_4\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=13\"><span class=\"label label-info\">13</span></a></td>
	<td><span id=\"l_b1_13\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=5\"><span class=\"label label-info\">5</span></a></td>
    <td><span id=\"l_b1_5\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=14\"><span class=\"label label-info\">14</span></a></td>
	<td><span id=\"l_b1_14\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=6\"><span class=\"label label-info\">6</span></a></td>
    <td><span id=\"l_b1_6\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=15\"><span class=\"label label-info\">15</span></a></td>
	<td><span id=\"l_b1_15\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=7\"><span class=\"label label-info\">7</span></a></td>
    <td><span id=\"l_b1_7\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=16\"><span class=\"label label-info\">16</span></a></td>
	<td><span id=\"l_b1_16\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=8\"><span class=\"label label-info\">8</span></a></td>
    <td><span id=\"l_b1_8\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=17\"><span class=\"label label-info\">17</span></a></td>
	<td><span id=\"l_b1_17\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=9\"><span class=\"label label-info\">9</span></a></td>
    <td><span id=\"l_b1_9\">0</span></td>
    <td class=\"tar\">&nbsp;</td>
	<td>&nbsp;</td></tr>
</tbody>
</table>";
}
function get_t_l_b2($lang,$line) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_l_b2_1() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=0&x=', 
				success: function(point) {
		            y = eval(point);
					if (y[1] < 80) { var bb1 = '<font color=\"orange\">' + y[1] + ' ºC</font>'; }
					else if (y[1] > 125) { var bb1 = '<font color=\"red\">' + y[1] + ' ºC</font>'; }
					else if ((y[1] == null) || (y[1] == 0) || (y[1] == 255)){ var bb1 = y[1]; }
					else { var bb1 = '<font color=\"green\">' + y[1] + ' ºC</font>'; }
	                $('span#l_b2_1').html(bb1);
					if (y[2] < 80) { var bb2 = '<font color=\"orange\">' + y[2] + ' ºC</font>'; }
					else if (y[2] > 125) { var bb2 = '<font color=\"red\">' + y[2] + ' ºC</font>'; }
					else if ((y[2] == null) || (y[2] == 0) || (y[2] == 255)){ var bb2 = y[2]; }
					else { var bb2 = '<font color=\"green\">' + y[2] + ' ºC</font>'; }
	                $('span#l_b2_2').html(bb2);
					if (y[3] < 80) { var bb3 = '<font color=\"orange\">' + y[3] + ' ºC</font>'; }
					else if (y[3] > 125) { var bb3 = '<font color=\"red\">' + y[3] + ' ºC</font>'; }
					else if ((y[3] == null) || (y[3] == 0) || (y[3] == 255)){ var bb3 = y[3]; }
					else { var bb3 = '<font color=\"green\">' + y[3] + ' ºC</font>'; }
	                $('span#l_b2_3').html(bb3);
					if (y[4] < 80) { var bb4 = '<font color=\"orange\">' + y[4] + ' ºC</font>'; }
					else if (y[4] > 125) { var bb4 = '<font color=\"red\">' + y[4] + ' ºC</font>'; }
					else if ((y[4] == null) || (y[4] == 0) || (y[4] == 255)){ var bb4 = y[4]; }
					else { var bb4 = '<font color=\"green\">' + y[4] + ' ºC</font>'; }
	                $('span#l_b2_4').html(bb4);
					if (y[5] < 80) { var bb5 = '<font color=\"orange\">' + y[5] + ' ºC</font>'; }
					else if (y[5] > 125) { var bb5 = '<font color=\"red\">' + y[5] + ' ºC</font>'; }
					else if ((y[5] == null) || (y[5] == 0) || (y[5] == 255)){ var bb5 = y[5]; }
					else { var bb5 = '<font color=\"green\">' + y[5] + ' ºC</font>'; }
	                $('span#l_b2_5').html(bb5);
					if (y[6] < 80) { var bb6 = '<font color=\"orange\">' + y[6] + ' ºC</font>'; }
					else if (y[6] > 125) { var bb6 = '<font color=\"red\">' + y[6] + ' ºC</font>'; }
					else if ((y[6] == null) || (y[6] == 0) || (y[6] == 255)){ var bb6 = y[6]; }
					else { var bb6 = '<font color=\"green\">' + y[6] + ' ºC</font>'; }
	                $('span#l_b2_6').html(bb6);
					if (y[7] < 80) { var bb7 = '<font color=\"orange\">' + y[7] + ' ºC</font>'; }
					else if (y[7] > 125) { var bb7 = '<font color=\"red\">' + y[7] + ' ºC</font>'; }
					else if ((y[7] == null) || (y[7] == 0) || (y[7] == 255)){ var bb7 = y[7]; }
					else { var bb7 = '<font color=\"green\">' + y[7] + ' ºC</font>'; }
	                $('span#l_b2_7').html(bb7);
					if (y[8] < 80) { var bb8 = '<font color=\"orange\">' + y[8] + ' ºC</font>'; }
					else if (y[8] > 125) { var bb8 = '<font color=\"red\">' + y[8] + ' ºC</font>'; }
					else if ((y[8] == null) || (y[8] == 0) || (y[8] == 255)){ var bb8 = y[8]; }
					else { var bb8 = '<font color=\"green\">' + y[8] + ' ºC</font>'; }
	                $('span#l_b2_8').html(bb8);
			},
				cache: false
			});
	    }, 2000);
	}
    function get_live_l_b2_2() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=1&x=', 
				success: function(point) {
		            y = eval(point);
					if (y[1] < 80) { var bb9 = '<font color=\"orange\">' + y[1] + ' ºC</font>'; }
					else if (y[1] > 125) { var bb9 = '<font color=\"red\">' + y[1] + ' ºC</font>'; }
					else if ((y[1] == null) || (y[1] == 0) || (y[1] == 255)){ var bb9 = y[1]; }
					else { var bb9 = '<font color=\"green\">' + y[1] + ' ºC</font>'; }
	                $('span#l_b2_9').html(bb9);
					if (y[2] < 80) { var bb10 = '<font color=\"orange\">' + y[2] + ' ºC</font>'; }
					else if (y[2] > 125) { var bb10 = '<font color=\"red\">' + y[2] + ' ºC</font>'; }
					else if ((y[2] == null) || (y[2] == 0) || (y[2] == 255)){ var bb10 = y[2]; }
					else { var bb10 = '<font color=\"green\">' + y[2] + ' ºC</font>'; }
	                $('span#l_b2_10').html(bb10);
					if (y[3] < 80) { var bb11 = '<font color=\"orange\">' + y[3] + ' ºC</font>'; }
					else if (y[3] > 125) { var bb11 = '<font color=\"red\">' + y[3] + ' ºC</font>'; }
					else if ((y[3] == null) || (y[3] == 0) || (y[3] == 255)){ var bb11 = y[3]; }
					else { var bb11 = '<font color=\"green\">' + y[3] + ' ºC</font>'; }
	                $('span#l_b2_11').html(bb11);
			},
				cache: false
			});
	    }, 3000);
	}
    $(function () { get_live_l_b2_1(); get_live_l_b2_2(); });
</script>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
<thead>
<tr>
<th>".get_lang($lang, 'info5')."</th>
<th>".get_lang($lang, 'Temperature')."</th>
<th>".get_lang($lang, 'info5')."</th>
<th>".get_lang($lang, 'Temperature')."</th>								
</tr>
</thead>
<tbody>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=1\"><span class=\"label label-info\">1</span></a></td>
    <td><span id=\"l_b2_1\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=10\"><span class=\"label label-info\">10</span></a></td>
	<td><span id=\"l_b2_10\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=2\"><span class=\"label label-info\">2</span></a></td>
    <td><span id=\"l_b2_2\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=11\"><span class=\"label label-info\">11</span></a></td>
	<td><span id=\"l_b2_11\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=3\"><span class=\"label label-info\">3</span></a></td>
    <td><span id=\"l_b2_3\">0</span></td>
    <td class=\"tar\">&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=4\"><span class=\"label label-info\">4</span></a></td>
    <td><span id=\"l_b2_4\">0</span></td>
    <td class=\"tar\">&nbsp;</td>
	<td>&nbsp;</td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=5\"><span class=\"label label-info\">5</span></a></td>
    <td><span id=\"l_b2_5\">0</span></td>
    <td class=\"tar\">&nbsp;</td>
	<td>&nbsp;</td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=6\"><span class=\"label label-info\">6</span></a></td>
    <td><span id=\"l_b2_6\">0</span></td>
    <td class=\"tar\">&nbsp;</td>
	<td>&nbsp;</td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=7\"><span class=\"label label-info\">7</span></a></td>
    <td><span id=\"l_b2_7\">0</span></td>
    <td class=\"tar\">&nbsp;</td>
	<td>&nbsp;</td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=8\"><span class=\"label label-info\">8</span></a></td>
    <td><span id=\"l_b2_8\">0</span></td>
    <td class=\"tar\">&nbsp;</td>
	<td>&nbsp;</td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=9\"><span class=\"label label-info\">9</span></a></td>
    <td><span id=\"l_b2_9\">0</span></td>
    <td class=\"tar\">&nbsp;</td>
	<td>&nbsp;</td></tr>
</tbody>
</table>";
}
function get_t_l_s1($lang,$line) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_l_s1_1() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=1&x=', 
				success: function(point) {
		            y = eval(point);
					if (y[1] < 80) { var s1 = '<font color=\"orange\">' + y[1] + ' ºC</font>'; }
					else if (y[1] > 125) { var s1 = '<font color=\"red\">' + y[1] + ' ºC</font>'; }
					else if ((y[1] == null) || (y[1] == 0) || (y[1] == 255)){ var s1 = y[1]; }
					else { var s1 = '<font color=\"green\">' + y[1] + ' ºC</font>'; }
	                $('span#l_s1_1').html(s1);
					if (y[2] < 80) { var s2 = '<font color=\"orange\">' + y[2] + ' ºC</font>'; }
					else if (y[2] > 125) { var s2 = '<font color=\"red\">' + y[2] + ' ºC</font>'; }
					else if ((y[2] == null) || (y[2] == 0) || (y[2] == 255)){ var s2 = y[2]; }
					else { var s2 = '<font color=\"green\">' + y[2] + ' ºC</font>'; }
	                $('span#l_s1_2').html(s2);
					if (y[3] < 80) { var s3 = '<font color=\"orange\">' + y[3] + ' ºC</font>'; }
					else if (y[3] > 125) { var s3 = '<font color=\"red\">' + y[3] + ' ºC</font>'; }
					else if ((y[3] == null) || (y[3] == 0) || (y[3] == 255)){ var s3 = y[3]; }
					else { var s3 = '<font color=\"green\">' + y[3] + ' ºC</font>'; }
	                $('span#l_s1_3').html(s3);
					if (y[4] < 80) { var s4 = '<font color=\"orange\">' + y[4] + ' ºC</font>'; }
					else if (y[4] > 125) { var s4 = '<font color=\"red\">' + y[4] + ' ºC</font>'; }
					else if ((y[4] == null) || (y[4] == 0) || (y[4] == 255)){ var s4 = y[4]; }
					else { var s4 = '<font color=\"green\">' + y[4] + ' ºC</font>'; }
	                $('span#l_s1_4').html(s4);
					if (y[5] < 80) { var s5 = '<font color=\"orange\">' + y[5] + ' ºC</font>'; }
					else if (y[5] > 125) { var s5 = '<font color=\"red\">' + y[5] + ' ºC</font>'; }
					else if ((y[5] == null) || (y[5] == 0) || (y[5] == 255)){ var s5 = y[5]; }
					else { var s5 = '<font color=\"green\">' + y[5] + ' ºC</font>'; }
	                $('span#l_s1_5').html(s5);
					if (y[6] < 80) { var s6 = '<font color=\"orange\">' + y[6] + ' ºC</font>'; }
					else if (y[6] > 125) { var s6 = '<font color=\"red\">' + y[6] + ' ºC</font>'; }
					else if ((y[6] == null) || (y[6] == 0) || (y[6] == 255)){ var s6 = y[6]; }
					else { var s6 = '<font color=\"green\">' + y[6] + ' ºC</font>'; }
	                $('span#l_s1_6').html(s6);
					if (y[7] < 80) { var s7 = '<font color=\"orange\">' + y[7] + ' ºC</font>'; }
					else if (y[7] > 125) { var s7 = '<font color=\"red\">' + y[7] + ' ºC</font>'; }
					else if ((y[7] == null) || (y[7] == 0) || (y[7] == 255)){ var s7 = y[7]; }
					else { var s7 = '<font color=\"green\">' + y[7] + ' ºC</font>'; }
	                $('span#l_s1_7').html(s7);
					if (y[8] < 80) { var s8 = '<font color=\"orange\">' + y[8] + ' ºC</font>'; }
					else if (y[8] > 125) { var s8 = '<font color=\"red\">' + y[8] + ' ºC</font>'; }
					else if ((y[8] == null) || (y[8] == 0) || (y[8] == 255)){ var s8 = y[8]; }
					else { var s8 = '<font color=\"green\">' + y[8] + ' ºC</font>'; }
	                $('span#l_s1_8').html(s8);
			},
				cache: false
			});
	    }, 3000);
	}
    $(function () { get_live_l_s1_1(); });
</script>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
<thead>
<tr>
<th>".get_lang($lang, 'info5')."</th>
<th>".get_lang($lang, 'Temperature')."</th>							
</tr>
</thead>
<tbody>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=1\"><span class=\"label label-info\">1</span></a></td>
    <td><span id=\"l_s1_1\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=2\"><span class=\"label label-info\">2</span></a></td>
    <td><span id=\"l_s1_2\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=3\"><span class=\"label label-info\">3</span></a></td>
    <td><span id=\"l_s1_3\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=4\"><span class=\"label label-info\">4</span></a></td>
    <td><span id=\"l_s1_4\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=5\"><span class=\"label label-info\">5</span></a></td>
    <td><span id=\"l_s1_5\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=6\"><span class=\"label label-info\">6</span></a></td>
    <td><span id=\"l_s1_6\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=7\"><span class=\"label label-info\">7</span></a></td>
    <td><span id=\"l_s1_7\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=8\"><span class=\"label label-info\">8</span></a></td>
    <td><span id=\"l_s1_8\">0</span></td></tr>
</tbody>
</table>";
}
function get_t_l_s2($lang,$line) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_l_s2_1() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=0&x=', 
				success: function(point) {
		            y = eval(point);
					if (y[1] < 80) { var ss1 = '<font color=\"orange\">' + y[1] + ' ºC</font>'; }
					else if (y[1] > 125) { var ss1 = '<font color=\"red\">' + y[1] + ' ºC</font>'; }
					else if ((y[1] == null) || (y[1] == 0) || (y[1] == 255)){ var ss1 = y[1]; }
					else { var ss1 = '<font color=\"green\">' + y[1] + ' ºC</font>'; }
	                $('span#l_s2_1').html(ss1);
					if (y[2] < 80) { var ss2 = '<font color=\"orange\">' + y[2] + ' ºC</font>'; }
					else if (y[2] > 125) { var ss2 = '<font color=\"red\">' + y[2] + ' ºC</font>'; }
					else if ((y[2] == null) || (y[2] == 0) || (y[2] == 255)){ var ss2 = y[2]; }
					else { var ss2 = '<font color=\"green\">' + y[2] + ' ºC</font>'; }
	                $('span#l_s2_2').html(ss2);
					if (y[3] < 80) { var ss3 = '<font color=\"orange\">' + y[3] + ' ºC</font>'; }
					else if (y[3] > 125) { var ss3 = '<font color=\"red\">' + y[3] + ' ºC</font>'; }
					else if ((y[3] == null) || (y[3] == 0) || (y[3] == 255)){ var ss3 = y[3]; }
					else { var ss3 = '<font color=\"green\">' + y[3] + ' ºC</font>'; }
	                $('span#l_s2_3').html(ss3);
					if (y[4] < 80) { var ss4 = '<font color=\"orange\">' + y[4] + ' ºC</font>'; }
					else if (y[4] > 125) { var ss4 = '<font color=\"red\">' + y[4] + ' ºC</font>'; }
					else if ((y[4] == null) || (y[4] == 0) || (y[4] == 255)){ var ss4 = y[4]; }
					else { var ss4 = '<font color=\"green\">' + y[4] + ' ºC</font>'; }
	                $('span#l_s2_4').html(ss4);
					if (y[5] < 80) { var ss5 = '<font color=\"orange\">' + y[5] + ' ºC</font>'; }
					else if (y[5] > 125) { var ss5 = '<font color=\"red\">' + y[5] + ' ºC</font>'; }
					else if ((y[5] == null) || (y[5] == 0) || (y[5] == 255)){ var ss5 = y[5]; }
					else { var ss5 = '<font color=\"green\">' + y[5] + ' ºC</font>'; }
	                $('span#l_s2_5').html(ss5);
			},
				cache: false
			});
	    }, 2000);
	}
    function get_live_l_s2_2() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=1&x=', 
				success: function(point) {
		            y = eval(point);
					if (y[1] < 80) { var ss6 = '<font color=\"orange\">' + y[1] + ' ºC</font>'; }
					else if (y[1] > 125) { var ss6 = '<font color=\"red\">' + y[1] + ' ºC</font>'; }
					else if ((y[1] == null) || (y[1] == 0) || (y[1] == 255)){ var ss6 = y[1]; }
					else { var ss6 = '<font color=\"green\">' + y[1] + ' ºC</font>'; }
	                $('span#l_s2_6').html(ss6);
					if (y[2] < 80) { var ss7 = '<font color=\"orange\">' + y[2] + ' ºC</font>'; }
					else if (y[2] > 125) { var ss7 = '<font color=\"red\">' + y[2] + ' ºC</font>'; }
					else if ((y[2] == null) || (y[2] == 0) || (y[2] == 255)){ var ss7 = y[2]; }
					else { var ss7 = '<font color=\"green\">' + y[2] + ' ºC</font>'; }
	                $('span#l_s2_7').html(ss7);
					if (y[3] < 80) { var ss8 = '<font color=\"orange\">' + y[3] + ' ºC</font>'; }
					else if (y[3] > 125) { var ss8 = '<font color=\"red\">' + y[3] + ' ºC</font>'; }
					else if ((y[3] == null) || (y[3] == 0) || (y[3] == 255)){ var ss8 = y[3]; }
					else { var ss8 = '<font color=\"green\">' + y[3] + ' ºC</font>'; }
	                $('span#l_s2_8').html(ss8);
					if (y[4] < 80) { var ss9 = '<font color=\"orange\">' + y[4] + ' ºC</font>'; }
					else if (y[4] > 125) { var ss9 = '<font color=\"red\">' + y[4] + ' ºC</font>'; }
					else if ((y[4] == null) || (y[4] == 0) || (y[4] == 255)){ var ss9 = y[4]; }
					else { var ss9 = '<font color=\"green\">' + y[4] + ' ºC</font>'; }
	                $('span#l_s2_9').html(ss9);
					if (y[5] < 80) { var ss10 = '<font color=\"orange\">' + y[5] + ' ºC</font>'; }
					else if (y[5] > 125) { var ss10 = '<font color=\"red\">' + y[5] + ' ºC</font>'; }
					else if ((y[5] == null) || (y[5] == 0) || (y[5] == 255)){ var ss10 = y[5]; }
					else { var ss10 = '<font color=\"green\">' + y[5] + ' ºC</font>'; }
	                $('span#l_s2_10').html(ss10);
			},
				cache: false
			});
	    }, 3000);
	}
    function get_live_l_s2_3() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=2&x=', 
				success: function(point) {
		            y = eval(point);
					if (y[1] < 80) { var ss11 = '<font color=\"orange\">' + y[1] + ' ºC</font>'; }
					else if (y[1] > 125) { var ss11 = '<font color=\"red\">' + y[1] + ' ºC</font>'; }
					else if ((y[1] == null) || (y[1] == 0) || (y[1] == 255)){ var ss11 = y[1]; }
					else { var ss11 = '<font color=\"green\">' + y[1] + ' ºC</font>'; }
	                $('span#l_s2_11').html(ss11);
					if (y[2] < 80) { var ss12 = '<font color=\"orange\">' + y[2] + ' ºC</font>'; }
					else if (y[2] > 125) { var ss12 = '<font color=\"red\">' + y[2] + ' ºC</font>'; }
					else if ((y[2] == null) || (y[2] == 0) || (y[2] == 255)){ var ss12 = y[2]; }
					else { var ss12 = '<font color=\"green\">' + y[2] + ' ºC</font>'; }
	                $('span#l_s2_12').html(ss12);
					if (y[3] < 80) { var ss13 = '<font color=\"orange\">' + y[3] + ' ºC</font>'; }
					else if (y[3] > 125) { var ss13 = '<font color=\"red\">' + y[3] + ' ºC</font>'; }
					else if ((y[3] == null) || (y[3] == 0) || (y[3] == 255)){ var ss13 = y[3]; }
					else { var ss13 = '<font color=\"green\">' + y[3] + ' ºC</font>'; }
	                $('span#l_s2_13').html(ss13);
					if (y[4] < 80) { var ss14 = '<font color=\"orange\">' + y[4] + ' ºC</font>'; }
					else if (y[4] > 125) { var ss14 = '<font color=\"red\">' + y[4] + ' ºC</font>'; }
					else if ((y[4] == null) || (y[4] == 0) || (y[4] == 255)){ var ss14 = y[4]; }
					else { var ss14 = '<font color=\"green\">' + y[4] + ' ºC</font>'; }
	                $('span#l_s2_14').html(ss14);
					if (y[5] < 80) { var ss15 = '<font color=\"orange\">' + y[5] + ' ºC</font>'; }
					else if (y[5] > 125) { var ss15 = '<font color=\"red\">' + y[5] + ' ºC</font>'; }
					else if ((y[5] == null) || (y[5] == 0) || (y[5] == 255)){ var ss15 = y[5]; }
					else { var ss15 = '<font color=\"green\">' + y[5] + ' ºC</font>'; }
	                $('span#l_s2_15').html(ss15);
			},
				cache: false
			});
	    }, 4000);
	}
    function get_live_l_s2_4() {
	    setInterval(function () {
			$.ajax({
				url: 'live.php?lang=".$lang."&line=".$line."&id=3&x=', 
				success: function(point) {
		            y = eval(point);
					if (y[1] < 80) { var ss16 = '<font color=\"orange\">' + y[1] + ' ºC</font>'; }
					else if (y[1] > 125) { var ss16 = '<font color=\"red\">' + y[1] + ' ºC</font>'; }
					else if ((y[1] == null) || (y[1] == 0) || (y[1] == 255)){ var ss16 = y[1]; }
					else { var ss16 = '<font color=\"green\">' + y[1] + ' ºC</font>'; }
	                $('span#l_s2_16').html(ss16);
					if (y[2] < 80) { var ss17 = '<font color=\"orange\">' + y[2] + ' ºC</font>'; }
					else if (y[2] > 125) { var ss17 = '<font color=\"red\">' + y[2] + ' ºC</font>'; }
					else if ((y[2] == null) || (y[2] == 0) || (y[2] == 255)){ var ss17 = y[2]; }
					else { var ss17 = '<font color=\"green\">' + y[2] + ' ºC</font>'; }
	                $('span#l_s2_17').html(ss17);
					if (y[3] < 80) { var ss18 = '<font color=\"orange\">' + y[3] + ' ºC</font>'; }
					else if (y[3] > 125) { var ss18 = '<font color=\"red\">' + y[3] + ' ºC</font>'; }
					else if ((y[3] == null) || (y[3] == 0) || (y[3] == 255)){ var ss18 = y[3]; }
					else { var ss18 = '<font color=\"green\">' + y[3] + ' ºC</font>'; }
	                $('span#l_s2_18').html(ss18);
					if (y[4] < 80) { var ss19 = '<font color=\"orange\">' + y[4] + ' ºC</font>'; }
					else if (y[4] > 125) { var ss19 = '<font color=\"red\">' + y[4] + ' ºC</font>'; }
					else if ((y[4] == null) || (y[4] == 0) || (y[4] == 255)){ var ss19 = y[4]; }
					else { var ss19 = '<font color=\"green\">' + y[4] + ' ºC</font>'; }
	                $('span#l_s2_19').html(ss19);
					if (y[5] < 80) { var ss20 = '<font color=\"orange\">' + y[5] + ' ºC</font>'; }
					else if (y[5] > 125) { var ss20 = '<font color=\"red\">' + y[5] + ' ºC</font>'; }
					else if ((y[5] == null) || (y[5] == 0) || (y[5] == 255)){ var ss20 = y[5]; }
					else { var ss20 = '<font color=\"green\">' + y[5] + ' ºC</font>'; }
	                $('span#l_s2_20').html(ss20);
			},
				cache: false
			});
	    }, 5000);
	}
    $(function () { get_live_l_s2_1(); get_live_l_s2_2(); get_live_l_s2_3(); get_live_l_s2_4(); });
</script>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
<thead>
<tr>
<th>".get_lang($lang, 'info5')."</th>
<th>".get_lang($lang, 'Temperature')."</th>
<th>".get_lang($lang, 'info5')."</th>
<th>".get_lang($lang, 'Temperature')."</th>
<th>".get_lang($lang, 'info5')."</th>
<th>".get_lang($lang, 'Temperature')."</th>								
</tr>
</thead>
<tbody>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=1\"><span class=\"label label-info\">1</span></a></td>
    <td><span id=\"l_s2_1\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=9\"><span class=\"label label-info\">9</span></a></td>
	<td><span id=\"l_s2_9\">0</span></td>
	<td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=17\"><span class=\"label label-info\">17</span></a></td>
	<td><span id=\"l_s2_17\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=2\"><span class=\"label label-info\">2</span></a></td>
    <td><span id=\"l_s2_2\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=10\"><span class=\"label label-info\">10</span></a></td>
	<td><span id=\"l_s2_10\">0</span></td>
	<td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=18\"><span class=\"label label-info\">18</span></a></td>
	<td><span id=\"l_s2_18\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=3\"><span class=\"label label-info\">3</span></a></td>
    <td><span id=\"l_s2_3\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=11\"><span class=\"label label-info\">11</span></a></td>
	<td><span id=\"l_s2_11\">0</span></td>
	<td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=19\"><span class=\"label label-info\">19</span></a></td>
	<td><span id=\"l_s2_19\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=4\"><span class=\"label label-info\">4</span></a></td>
    <td><span id=\"l_s2_4\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=12\"><span class=\"label label-info\">12</span></a></td>
	<td><span id=\"l_s2_12\">0</span></td>
	<td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=20\"><span class=\"label label-info\">20</span></a></td>
	<td><span id=\"l_s2_20\">0</span></td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=5\"><span class=\"label label-info\">5</span></a></td>
    <td><span id=\"l_s2_5\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=13\"><span class=\"label label-info\">13</span></a></td>
	<td><span id=\"l_s2_13\">0</span></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=6\"><span class=\"label label-info\">6</span></a></td>
    <td><span id=\"l_s2_6\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=14\"><span class=\"label label-info\">14</span></a></td>
	<td><span id=\"l_s2_14\">0</span></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=7\"><span class=\"label label-info\">7</span></a></td>
    <td><span id=\"l_s2_7\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=15\"><span class=\"label label-info\">15</span></a></td>
	<td><span id=\"l_s2_15\">0</span></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td></tr>
<tr><td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=8\"><span class=\"label label-info\">8</span></a></td>
    <td><span id=\"l_s2_8\">0</span></td>
    <td class=\"tar\"><a href=\"egi_lines.php?lang=".$lang."&line=".$line."&sline=16\"><span class=\"label label-info\">16</span></a></td>
	<td><span id=\"l_s2_16\">0</span></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td></tr>
</tbody>
</table>";
}
?>