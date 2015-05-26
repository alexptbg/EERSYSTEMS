<?php
defined('start') or die('Direct access not allowed.');
function get_weather($lang,$code) {
	echo "
	<script type='text/javascript' src='js/weather.js'></script>
    <script type='text/javascript' charset='UTF-8'>
$(document).ready(function() {
	$.simpleWeather({
		/*zipcode: '$code',*/
		woeid: '836607',
		unit: 'c',
		success: function(weather) {
			low = weather.low - 3;
			high = weather.high - 1;
			//html =  '<h3>'+weather.city+'</h3>';
			html = '<img class=\"w\" src='+weather.image+'>';
			html += '<span><strong>".get_lang($lang, 'Temperature').":</strong> '+weather.temp+'&deg; '+weather.units.temp+'</span><br/>';
			html += '<span><strong>".get_lang($lang, 'whigh').":</strong> '+high+'&deg; '+weather.units.temp+'</span><br/>';
			html += '<span><strong>".get_lang($lang, 'wlow').":</strong> '+low+'&deg; '+weather.units.temp+'</span><br/>';
			html += '<span><strong>".get_lang($lang, 'Humidity').":</strong> '+weather.humidity+'%</span><br/>';
			html += '<span><strong>".get_lang($lang, 'Pressure').":</strong> '+weather.pressure+' mb</span><br/>';
			html += '<span><strong>".get_lang($lang, 'Wind').":</strong> '+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed+'</span>';
			$(\"#weather\").html(html);
		},
		cache: false,
		error: function(error) { $(\"#weather\").html('<p>'+error+'</p>'); }
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
function get_temp_inside($lang,$line,$id,$tk,$offset) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_live_in_$rand() {
	    setInterval(function () {
			$.ajax({
				url: 'live_inside.php?lang=$lang&line=$line&id=$id&tk=$tk&offset=$offset', 
				success: function(data) {
			$('span#i_$rand').html(data);
			},
				cache: false
			});
	    }, 10000);
	}
    $(function () {
			$.ajax({
				url: 'live_inside.php?lang=$lang&line=$line&id=$id&tk=$tk&offset=$offset', 
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
function get_thermometer2_v($lang,$line,$id,$tk,$min,$max) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function () {
    var chart$rand;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_$rand',
                type: 'column',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            xAxis: {
                title: {
                    text: this.value
                },
                labels: {
                    enabled: false
                }
            },
        plotOptions: {
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
        },
            yAxis: {
                min: $min,
				max: $max,
            minorGridLineWidth: 0,
            minorTickInterval: 'auto',
            minorTickWidth: 1,
			minorTickLength: 10,
				tickInterval: 10,
				tickLength: 12,
				minTickInterval: 1,
                title: {
                    text: null
                },
                labels: {
                    formatter: function() {
                        return this.value +'ºC';
                    }
                }
            },
        legend: {
            enabled: false
        },
        credits: {
            enabled: false
        },
            tooltip: {
                formatter: function() {
                    return ''+ this.series.name +': '+ this.y +' ºC';
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
	    series: [{
	        name: '".get_lang($lang, 'Temperature')."',
	        data: [0],
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
	            newVal,
	            inc = Math.round((Math.random() - 0.5) * 1);
	        newVal = y[1] + inc;
	        if (newVal < $min || newVal > $max) {
	            newVal = y[1] - inc;
	        }
	        point.update(newVal); },
				cache: false
			});
	    }, 1000);
	});
});
});
</script>
<div id='chart_$rand' style='width:100%; height:380px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_thermometer2_h($lang,$line,$id,$tk,$min,$max) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function () {
    var chart$rand;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_$rand',
                type: 'bar',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			marginBottom: 30,
			marginLeft: 20,
			marginRight: 20,
			marginTop: 0,
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            xAxis: {
                title: {
                    text: this.value
                },
                labels: {
                    enabled: false
                }
            },
        plotOptions: {
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
        },
            yAxis: {
                min: $min,
				max: $max,
            minorGridLineWidth: 0,
            minorTickInterval: 'auto',
            minorTickWidth: 1,
			minorTickLength: 10,
				tickInterval: 10,
				tickLength: 12,
				minTickInterval: 1,
                title: {
                    text: null
                },
                labels: {
                    formatter: function() {
                        return this.value +'ºC';
                    },
					y: 20
                }
            },
        legend: {
            enabled: false
        },
        credits: {
            enabled: false
        },
            tooltip: {
                formatter: function() {
                    return ''+ this.series.name +': '+ this.y +' ºC';
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
	    series: [{
	        name: '".get_lang($lang, 'Temperature')."',
	        data: [0],
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
	            newVal,
	            inc = Math.round((Math.random() - 0.5) * 1);
	        newVal = y[1] + inc;
	        if (newVal < $min || newVal > $max) {
	            newVal = y[1] - inc;
	        }
	        point.update(newVal); },
				cache: false
			});
	    }, 1000);
	});
});
});
</script>
<div id='chart_$rand' style='width:100%; height:100px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_thermometer_multi($lang,$line,$id,$min,$max){
	$rand = rand(1000,9999);
	echo "
	<!--[if lt IE 9]><script type='text/javascript' src='js/plugins/c/excanvas.js'></script><![endif]-->
	<script type='text/javascript' charset='UTF-8'>
	var values = { v1: $min,v2: $min,v3: $min };
        $(document).ready(function () {
            $('#chart_$rand').jqLinearGauge({
                orientation: 'vertical',
                background: '#F7F7F7',
                border: {
                    lineWidth: 0,
                    strokeStyle: '#76786A',
                    padding: 2
                },
                tooltips: {
                    disabled: true,
                    highlighting: false
                },
                scales: [
                         {
                             minimum: $min,
                             maximum: $max,
                             interval: 10,
                             labels: {
                                 showFirstLabel: false,
                                 showLastLabel: true,
                                 offset: 0.26,
								 stringFormat: '%dºC',
                                 hAlign: 'right',
								 fillStyle: '#666666'
                             },
                             majorTickMarks: {
                                 offset: 0.30,
                                 lineWidth: 2,
								 strokeStyle: '#666666'
                             },
                             minorTickMarks: {
                                 visible: true,
                                 offset: 0.34,
                                 interval: 2,
                                 lineWidth: 1,
								 strokeStyle: '#1F66A8'
                             },
                             barMarkers: [
                                            {
                                                title : '".get_lang($lang, 'Temperature')."',
                                                value: values.v1,
                                                fillStyle: l_green,
                                                innerOffset: 0.45,
                                                outerOffset: 0.60
                                            },
                                            {
                                                title : '".get_lang($lang, 'Temperature')."',
                                                value: values.v2,
                                                fillStyle: l_blue,
                                                innerOffset: 0.60,
                                                outerOffset: 0.75
                                            },
                                            {
                                                title : '".get_lang($lang, 'Temperature')."',
                                                value: values.v3,
                                                fillStyle: l_pink,
                                                innerOffset: 0.75,
                                                outerOffset: 0.90
                                            }
                                         ]
                         }
                    ]
            });
			chart$rand();
        });
	function chart$rand() {
	    setInterval(function () {
			$.ajax({
				url: 'gauge_multi.php?line=$line&id=$id',
				success: function(point) {
			        y = eval(point);
					updateGauge$rand(y);
			},
				cache: false
			});
	    }, 2000);
	}
        function updateGauge$rand(valuex) {
            $(values).animate({
				v1: valuex[1] + (Math.random()*0.5),
				v2: valuex[2] + (Math.random()*0.5),
				v3: valuex[3] + (Math.random()*0.5)			
            }, {
                duration: 1000,
                step: function () {
                    var scales = $('#chart_$rand').jqLinearGauge('option', 'scales');
                    scales[0].barMarkers[0].value = this.v1;
                    scales[0].barMarkers[1].value = this.v2;
                    scales[0].barMarkers[2].value = this.v3;	
					num1 = this.v1;
					num2 = this.v2;
					num3 = this.v3;
					$('span#c1$rand').text(num1.toPrecision(4)+' ºC');
					$('span#c2$rand').text(num2.toPrecision(4)+' ºC');
					$('span#c3$rand').text(num3.toPrecision(4)+' ºC');					
                    $('#chart_$rand').jqLinearGauge('update');
                },
                complete: function () {
                    $('#chart_$rand').jqLinearGauge('update');
                }
            });
        }
</script>
<div id='cl'><span id='c1$rand'>0</span><br/><span id='c2$rand'>0</span><br/><span id='c3$rand'>0</span></div>
<div id='chart_$rand' style='width:120px; height:380px; margin:0 auto; padding:0;'></div>";
}
function get_thermometer3($lang,$line,$id,$tk,$min,$max){
	//only one per page
	$rand = rand(1000,9999);
	$f1 = $max*1.8+32;
	$f2 = $min*1.8+32;
	$n = $min-3;
	echo "
	<script type='text/javascript' charset='UTF-8'>
	var values = { v1: $min };
        $(document).ready(function () {
            $('#chart_$rand').jqLinearGauge({
                orientation: 'vertical',
                background: '#F7F7F7',
                border: {
                    padding: 0,
                    lineWidth: 0,
                    strokeStyle: '#76786A'
                },
                tooltips: {
                    disabled: true,
                    highlighting: false
                },
                scales: [
                         {
                             margin: {
                                 top: 6,
                                 left: 0,
                                 right: 0,
                                 bottom: 30
                             },
                             minimum: $min,
                             maximum: $max,
                             interval: 10,
                             labels: {
                                 offset: 0.22,
                                 font: '11px sans-serif',
								 showFirstLabel: false,
								 stringFormat: '%dºC',
                                 hAlign: 'right',
								 fillStyle: '#666666',
                             },
                             majorTickMarks: {
                                 offset: 0.25,
                                 length: 15,
								 strokeStyle: '#666666',
                                 interval: 10
                             },
                             minorTickMarks: {
                                 visible: true,
                                 interval: 2,
								 length: 5,
                                 offset: 0.34,
								 strokeStyle: '#0055aa'
                             },
                             ranges: [
                                      {
                                          startValue: $min,
                                          endValue: $max,
                                          fillStyle: '#333333',
                                          innerOffset: 0.38,
                                          outerStartOffset: 0.39,
                                          outerEndOffset: 0.39
                                      }
                                     ],
                             barMarkers: [
                                            {
                                                value: values.v1,
                                                innerOffset: 0.39,
                                                outerOffset: 0.56,
                                                fillStyle: linearGradientBarMarker,
                                                zIndex: 5
                                            }
                                         ],
                             needles: [
                                       {
                                           type: 'ellipse',
                                           fillStyle: radialGradient,
                                           lineWidth: 1,
                                           strokeStyle: 'black',
                                           value: $n,
                                           width: 36,
                                           height: 36,
                                           innerOffset: 0.315
                                       }
                                      ]
                         },
                         {
                             minimum: $f2,
                             maximum: $f1,
                             interval: 20,
                             margin: {
                                 top: 6,
                                 left: 0,
                                 right: 30,
                                 bottom: 30
                             },
                             labels: {
                                 offset: 0.98,
                                 font: '11px sans-serif',
								 showFirstLabel: false,
								 stringFormat: '%dºF',
                                 hAlign: 'left',
								 fillStyle: '#666666',
                             },
                             majorTickMarks: {
                                 offset: 0.80,
                                 length: 15,
								 strokeStyle: '#666666',
                                 interval: 20
                             },
                             minorTickMarks: {
                                 visible: true,
                                 interval: 4,
								 length: 5,
                                 offset: 0.80,
							     strokeStyle: '#0055aa'
                             },
                             ranges:
                                    [
                                        {
                                            startValue: $f2,
                                            endValue: $f1,
                                            fillStyle: '#333333',
                                            innerOffset: 0.78,
                                            outerStartOffset: 0.79,
                                            outerEndOffset: 0.79
                                        }
                                    ]
                         }
                        ]
            });
			chart$rand();
        });
	function chart$rand() {
	    setInterval(function () {
			$.ajax({
				url: 'gauge.php?line=$line&id=$id&tk=$tk', 
				success: function(point) {
			        y = eval(point);
					updateGauge$rand(y[1]);
			},
				cache: false
			});
	    }, 1000);
	}
        function updateGauge$rand(valuex) {
            $(values).animate({
				v1: valuex + (Math.random()*0.5)
            }, {
                duration: 1000,
                step: function () {
                    var scales = $('#chart_$rand').jqLinearGauge('option', 'scales');
                    scales[0].barMarkers[0].value = this.v1;
                    $('#chart_$rand').jqLinearGauge('update');
					num = this.v1;
					$('span#c1$rand').text(num.toPrecision(4)+' ºC');
		            F = this.v1 * 1.8000 + 32.00;
			        $('span#c2$rand').text(F.toPrecision(4)+' ºF');
                },
                complete: function () {
					$('#chart_$rand').jqLinearGauge('update');
                }
            });
        }
</script>
<div id='clm0'><span id='c1$rand'>0</span><br/><span id='c2$rand'>0</span></div>
<div id='chart_$rand' style='width:120px; height:380px; margin:0 auto; padding:0;'></div>";
}
function get_thermometer($lang,$line,$id,$tk,$min,$max){
	$rand = rand(1000,9999);
	echo "
	<script type='text/javascript' charset='UTF-8'>
	var values = { v1: $min };
        $(document).ready(function () {
            $('#chart_$rand').jqLinearGauge({
                orientation: 'vertical',
                background: '#F7F7F7',
                border: {
                    lineWidth: 0,
                    strokeStyle: '#76786A',
                    padding: 2
                },
                tooltips: {
                    disabled: true,
                    highlighting: false
                },
                scales: [
                         {
                             minimum: $min,
                             maximum: $max,
                             interval: 10,
                             labels: {
                                 showFirstLabel: false,
                                 showLastLabel: true,
                                 offset: 0.26,
								 stringFormat: '%dºC',
                                 hAlign: 'right',
								 fillStyle: '#666666'
                             },
                             majorTickMarks: {
                                 offset: 0.30,
                                 lineWidth: 2,
								 strokeStyle: '#666666'
                             },
                             minorTickMarks: {
                                 visible: true,
                                 offset: 0.34,
                                 interval: 2,
                                 lineWidth: 1,
								 strokeStyle: '#1F66A8'
                             },
                             barMarkers: [
                                            {
                                                title : '".get_lang($lang, 'Temperature')."',
                                                value: values.v1,
                                                fillStyle: l_green,
                                                innerOffset: 0.46,
                                                outerOffset: 0.66
                                            }
                                         ]
                         }
                    ]
            });
			chart$rand();
        });
	function chart$rand() {
	    setInterval(function () {
			$.ajax({
				url: 'gauge.php?line=$line&id=$id&tk=$tk', 
				success: function(point) {
			        y = eval(point);
					updateGauge$rand(y[1]);
			},
				cache: false
			});
	    }, 2000);
	}
        function updateGauge$rand(valuex) {
            $(values).animate({
                v1: valuex + (Math.random()*0.5)
            }, {
                duration: 1000,
                step: function () {
                    var scales = $('#chart_$rand').jqLinearGauge('option', 'scales');
                    scales[0].barMarkers[0].value = this.v1;
                    $('#chart_$rand').jqLinearGauge('update');
					num = this.v1;
					$('span#c$rand').text(num.toPrecision(4)+' ºC');
                },
                complete: function () {
                    $('#chart_$rand').jqLinearGauge('update');
                }
            });
        }
</script>
<div id='cl'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100px; height:380px; margin:0 auto; padding:0;'></div>";
}
function get_gauge_temp_c_260($lang,$line,$id,$tk) {//f and c
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
	        max: 260,
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
	        max: 500,
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
	        if (newVal < 0 || newVal > 180) {
	            newVal = newVal - inc;
	        }
	        point.update(newVal); },
				cache: false
			});
	    }, 1000);
	});
});
</script>
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
	        if (newVal < 0 || newVal > 180) {
	            newVal = newVal - inc;
	        }
	        point.update(newVal); },
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='chart_$rand' style='width:100%; height:280px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_gauge_temp_c_180($lang,$line,$id,$tk) {//f and c
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
	        max: 180,
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
	        max: 356,
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
	        if (newVal < 0 || newVal > 180) {
	            newVal = newVal - inc;
	        }
	        point.update(newVal); },
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_bar($lang,$line,$id,$tk) {//bar and psi
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
			spacingTop: 5,
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
        plotOptions: {
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
        },  
	    yAxis: [{
	        min: 0,
	        max: 10,
	        lineColor: '#1f8a00',
	        tickColor: '#1f8a00',
	        minorTickColor: '#1f8a00',
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
	        min: 0,
	        max: 145.03773773,
	        tickPosition: 'outside',
	        lineColor: '#a70a01',
	        lineWidth: 1,
	        minorTickPosition: 'outside',
	        tickColor: '#a70a01',
	        minorTickColor: '#a70a01',
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
	        name: '".get_lang($lang, 'inter59')."',
	        data: [0],
	        dataLabels: {
	            formatter: function () {
	                var B = this.y,
					    B = B.toFixed(2);
	                    P = B * 14.503773773;
						P = P.toFixed(2);
	                return '<span style=\"color:#1f8a00;font-size:7px;\">'+ B + ' b</span><br/>' +
	                    '<span style=\"color:#a70a01;font-size:7px;\">' + P + ' p</span>';
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
	            valueSuffix: ' ".get_lang($lang, 'inter60')."'
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
	        if (newVal < 0 || newVal > 10) {
	            newVal = newVal - inc;
	        } 
			$('span#c1$rand').text(newVal.toFixed(2)+' ".get_lang($lang, 'inter60')."');
		    P = newVal * 14.503773773;
			$('span#c2$rand').text(P.toFixed(2)+' psi');
			point.update(newVal);
			},
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='clml10'><span id='c1$rand'>0</span><br/><span id='c2$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_gauge_temp_c_60($lang,$line,$id,$tk) {//f and c
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
        plotOptions: {
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
        },  
	    yAxis: [{
	        min: 0,
	        max: 60,
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
	        max: 140,
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
					    C = C.toFixed(1);
	                    F = C * 1.8000 + 32.00;
						F = F.toFixed(1);
	                return '<span style=\"color:#ff004c;font-size:8px;\">'+ C + 'º C</span><br/>' +
	                    '<span style=\"color:#1549b7;font-size:8px;\">' + F + 'º F</span>';
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
	            inc = Math.random()*2/3;
	        if (newVal < 0 || newVal > 60) {
	            newVal = newVal - inc;
	        }
			$('span#c1$rand').text(newVal.toFixed(1)+' ºC');
		    F = newVal * 1.8000 + 32.00;
			$('span#c2$rand').text(F.toFixed(1)+' ºF');
	        point.update(newVal); 
			},
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='clml10'><span id='c1$rand'>0</span><br/><span id='c2$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_gauge_temp_60($lang,$line,$id,$tk) {
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
	        max: 60,
	        minorTickInterval: 'auto',
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
	            to: 15,
	            color: '#bfeeff' // blue
	        },{
	            from: 15,
	            to: 30,
	            color: '#45fa01' // green
	        },{
	            from: 30,
	            to: 40,
	            color: '#ec9f00' // orange
	        },{
	            from: 40,
	            to: 60,
	            color: '#FF0000' // red
	        }]        
	    },
	    series: [{
	        name: '".get_lang($lang, 'Temperature')."',
	        data: [0],
	        dataLabels: {
	            formatter: function () {
	                var C = this.y,
					    C = C.toFixed(1);
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
	        if (newVal < 0 || newVal > 60) {
	            newVal = newVal - inc;
	        }
	        point.update(newVal); },
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_gauge_temp_180($lang,$line,$id,$tk) {
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
	            to: 85,
	            color: '#bfeeff' // blue
	        },{
	            from: 85,
	            to: 130,
	            color: '#45fa01' // green
	        },{
	            from: 130,
	            to: 160,
	            color: '#ec9f00' // yellow
	        },{
	            from: 160,
	            to: 180,
	            color: '#FF0000' // red
	        }]        
	    },
	    series: [{
	        name: '".get_lang($lang, 'Temperature')."',
	        data: [0],
	        dataLabels: {
	            formatter: function () {
	                var C = this.y,
					    C = C.toFixed(1);
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
	        if (newVal < 0 || newVal > 180) {
	            newVal = newVal - inc;
	        }
	        point.update(newVal); },
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='chart_$rand' style='width:100%; height:180px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_vmeter_220($lang,$line,$id,$tk) {
	//gauge.php?line=$line&id=$id&tk=$tk
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
            height: 180,
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
	        size: 280
	    }],	   		        
	    yAxis: [{
	        min: 0,
	        max: 250,
	        minorTickPosition: 'outside',
	        tickPosition: 'outside',
	        labels: {
	        	rotation: 'auto',
	        	distance: 20
	        },
	        plotBands: [{
	        	from: 0,
	        	to: 190,
	        	color: '#bfeeff',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        },{
	        	from: 190,
	        	to: 210,
	        	color: '#ec9f00',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        },{
	        	from: 210,
	        	to: 235,
	        	color: '#45fa01',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        },{
	        	from: 235,
	        	to: 250,
	        	color: '#FF0000',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        }],
	        pane: 0,
	        title: {
	        	text: 'VU',
	        	y: -40
	        }
	    }],
	    plotOptions: {
	    	gauge: {
	    		dataLabels: {
	    			enabled: false
	    		},
	    		dial: {
	    			radius: '100%'
	    		}
	    	}
	    },
	    series: [{
	        data: [0],
	        yAxis: 0
	    }]
	},
	function (chart) {
	    setInterval(function () {
			$.ajax({
				url: 'gauge.php?line=$line&id=$id&tk=$tk', 
				success: function(point) {
		    y = eval(point);
	        var left = chart.series[0].points[0],
	            leftVal = y[1], 
	            inc = (Math.random() - 0.5) * 1;
	        leftVal =  leftVal + inc;
	        if (leftVal < 0 || leftVal > 250) {
	            leftVal = leftVal - inc;
	        }
	        left.update(leftVal, false);
	        chart.redraw(); 
			num = leftVal;
			$('span#c$rand').text(num.toPrecision(4)+' V');
			},
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='clml10'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto;'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_vmeter_24($lang,$line,$id,$tk) {
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
            height: 180,
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
	        size: 280
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
	        	from: 0,
	        	to: 20,
	        	color: '#bfeeff',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        },{
	        	from: 20,
	        	to: 25,
	        	color: '#45fa01',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        },{
	        	from: 25,
	        	to: 32,
	        	color: '#FF0000',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        }],
	        pane: 0,
	        title: {
	        	text: 'VU',
	        	y: -40
	        }
	    }],
	    plotOptions: {
	    	gauge: {
	    		dataLabels: {
	    			enabled: false
	    		},
	    		dial: {
	    			radius: '100%'
	    		}
	    	}
	    },
	    series: [{
	        data: [0],
	        yAxis: 0
	    }]
	},
	function (chart) {
	    setInterval(function () {
			$.ajax({
				url: 'gauge.php?line=$line&id=$id&tk=$tk', 
				success: function(point) {
		    y = eval(point);
	        var left = chart.series[0].points[0],
	            leftVal = y[1], 
	            inc = (Math.random() - 0.5) * 1;
	        leftVal =  leftVal + inc;
	        if (leftVal < 0 || leftVal > 32) {
	            leftVal = leftVal - inc;
	        }
	        left.update(leftVal, false);
	        chart.redraw(); 
			num = leftVal;
			$('span#c$rand').text(num.toPrecision(3)+' V');
			},
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='clml10'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_vmeter_12($lang,$line,$id,$tk) {
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
            height: 180,
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
	        size: 280
	    }],	    		        
	    yAxis: [{
	        min: 0,
	        max: 26,
	        minorTickPosition: 'outside',
	        tickPosition: 'outside',
	        labels: {
	        	rotation: 'auto',
	        	distance: 20
	        },
	        plotBands: [{
	        	from: 0,
	        	to: 10,
	        	color: '#bfeeff',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        },{
	        	from: 10,
	        	to: 14,
	        	color: '#45fa01',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        },{
	        	from: 14,
	        	to: 26,
	        	color: '#FF0000',
	        	innerRadius: '100%',
	        	outerRadius: '105%'
	        }],
	        pane: 0,
	        title: {
	        	text: 'VU',
	        	y: -40
	        }
	    }],
	    plotOptions: {
	    	gauge: {
	    		dataLabels: {
	    			enabled: false
	    		},
	    		dial: {
	    			radius: '100%'
	    		}
	    	}
	    },
	    series: [{
	        data: [0],
	        yAxis: 0
	    }]
	},
	function (chart) {
	    setInterval(function () {
			$.ajax({
				url: 'gauge.php?line=$line&id=$id&tk=$tk', 
				success: function(point) {
		    y = eval(point);
	        var left = chart.series[0].points[0],
	            leftVal = y[1], 
	            inc = (Math.random() - 0.5) * 1;
	        leftVal =  leftVal + inc;
	        left.update(leftVal, false);
	        chart.redraw(); 
			num = leftVal;
			$('span#c$rand').text(num.toPrecision(3)+' V');	
			},
				cache: false
			});
	    }, 1000);
	});
});
</script>
<div id='clml10'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:200px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_tank($lang,$line,$id) {
	$rand = rand(1000,9999);
    echo "<script type=\"text/javascript\" charset=\"UTF-8\">
		var currentRenderer = 'javascript';	 		
	    var chartObj;
	 	window.onload = function() { 
	   FusionCharts.setCurrentRenderer(currentRenderer);
        chartObj = new FusionCharts({
           swfUrl: 'js/plugins/c/Cylinder.swf',
           width: '100%', 
		   height: '240',
           id: 'sampleChart',
           dataSource: 'tank.php?line=".$line."&id=".$id."&lang=".$lang."',
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
    <div id=\"tank\" style=\"width:100%; height:260px; margin: 0 auto; background-color:#F9F9F9;\">
	    <div id=\"chart_$rand\" style=\"margin: 0 auto; padding-top:20px; width:94%; float:right;\"></div></div>";
}
function get_voda($lang,$line,$id) {
	$rand = rand(1000,9999);
    echo "<script type=\"text/javascript\" charset=\"UTF-8\">
    function get_live_tank_m() {
	    setInterval(function () {
			$.ajax({
				url: 'live_tank_m.php?lang=$lang&line=$line&id=$id', 
				success: function(data) {
			$('span#c$rand').html(data[1]);
			$('span#s$rand').html(data[2]);
			$('span#v$rand').html(data[3]);			
			},
				cache: false
			});
	    }, 2000);
	}
    $(function () { get_live_tank_m(); });
	</script>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table pompa\">
<tbody>
<tr>
<td class=\"tar\">".get_lang($lang, 'ad222').":</td>
<td><span id=\"s".$rand."\">0</span></td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'ad286').":</td>
<td><span id=\"c".$rand."\">0</span></td>
</tr>
<tr>
<td class=\"tar\">".get_lang($lang, 'ad287').":</td>
<td><span id=\"v".$rand."\">0</span></td>
</tr>
</tbody>
</table>";
}
function get_tank_old($lang,$line,$id) {
	$rand = rand(1000,9999);
    echo "<script type=\"text/javascript\" charset=\"UTF-8\">
		var currentRenderer = 'javascript';	 		
	    var chartObj;
	 	window.onload = function() { 
	   FusionCharts.setCurrentRenderer(currentRenderer);
        chartObj = new FusionCharts({
           swfUrl: 'js/plugins/c/Cylinder.swf',
           width: '100%', 
		   height: '230',
           id: 'sampleChart',
           dataSource: 'tank.php?line=".$line."&id=".$id."&lang=".$lang."',
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
    function get_live_tank_m() {
	    setInterval(function () {
			$.ajax({
				url: 'live_tank_m.php?lang=$lang&line=$line&id=$id', 
				success: function(data) {
			$('span#c$rand').text(data[1]+' м');
			$('span#s$rand').html(data[2]);
			},
				cache: false
			});
	    }, 2000);
	}
    $(function () { get_live_tank_m(); });
	</script>
    <div id=\"tank\" style=\"width:100%; height:240px; margin: 0 auto; background-color:#F9F9F9;\">
	<div id=\"clml10\"><span id=\"c".$rand."\" class=\"tip\" title=\"".get_lang($lang, 'ad221')."\">0</span>
	    <br/><span id=\"s".$rand."\" class=\"tip\" title=\"".get_lang($lang, 'ad222')."\">0</span></div>
	    <div id=\"chart_$rand\" style=\"margin: 0 auto; padding-top:10px; width:90%; float:right;\"></div></div>";
}
function get_thermo($lang,$line,$id,$tk,$max) {
    $rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
	var thermo_$rand;	
	function init_$rand() {
        thermo_$rand = new steelseries.Linear('canvas_$rand', {
                    minValue: 0,      
                    maxValue: $max, 
                            width: 140,
                            height: 240,
                            gaugeType: steelseries.GaugeType.TYPE2,
							frameDesign: steelseries.FrameDesign.TILTED_BLACK,
							backgroundColor: steelseries.BackgroundColor.BEIGE,
							ledColor: steelseries.LedColor.RED_LED,
							lcdColor: steelseries.LcdColor.STANDARD, 
                            titleString: 'Thermometer',
                            unitString: 'ºC',
                            threshold: 30,
                            lcdVisible: true,
                            unitStringVisible: true,
                            valuesNumeric: true,
							digitalFont: true,
                            degreeScaleHalf: true,
                            pointSymbolsVisible: true
        });
        getValue$rand(thermo_$rand, 100);
    }
    function getValue$rand(gauge, range) {
	    setInterval(function () {
			$.ajax({
				url: 'live_thermo.php?line=$line&id=$id&tk=$tk', 
				success: function(data) {
			num = data;
			inc = (Math.random() - 0.5) * 1;
			gauge.setValueAnimated(num+inc);
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () {
		init_$rand();
    });
</script>
<div id='chart_$rand' style='margin: 0 auto; width:100%;'>
<canvas id='canvas_$rand' width='140' height='240'>No canvas in your browser...sorry...</canvas></div>";
}
function get_level_stk($lang,$line,$id) {
    $rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
	var level_$rand;	
	function init_$rand() {
        level_$rand = new steelseries.RadialVertical('canvas_$rand', {
                    minValue: 0,      
                    maxValue: 100,
            threshold: 70,                  
            titleString: 'Water',
            unitString: '%',
            size: 180,
            orientation: steelseries.Orientation.WEST,
            pointerType: steelseries.PointerType.TYPE2,
            frameDesign: steelseries.FrameDesign.TILTED_BLACK, 
            backgroundColor: steelseries.BackgroundColor.BEIGE,  
            pointerColor: steelseries.ColorDef.RED,                     
            ledColor: steelseries.LedColor.RED_LED,
		    foregroundType: steelseries.ForegroundType.TYPE4
        });	
        getValue$rand(level_$rand, 100);
    }
    function getValue$rand(gauge, range) {
	    setInterval(function () {
			$.ajax({
				url: 'e__.php?line=$line&id=$id', 
				success: function(point) {
		            y = eval(point);
			        num = y[1];
			        level_$rand.setValueAnimated(num);
					/*level_$rand.setThreshold(20);*/
			        $('span#c$rand').text(num.toPrecision(3)+' %');
			        level_$rand.setLedColor(steelseries.LedColor.GREEN_LED);
			    },
				cache: false
			});
	    }, 1000);
	}
    $(function () {
		init_$rand();
    });
</script>
<div id='clm0'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:180px; height:180px; margin: 0 auto;'>
<canvas id='canvas_$rand' width='200' height='180'>No canvas in your browser...sorry...</canvas></div>";
}
function get_level($lang,$line,$id,$tk) {
    $rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
	var level_$rand;	
	function init_$rand() {
        level_$rand = new steelseries.RadialVertical('canvas_$rand', {
                    minValue: 0,      
                    maxValue: 100,
            threshold: 60,                  
            titleString: 'Water',
            unitString: '%',
            size: 180,
            orientation: steelseries.Orientation.EAST,
            pointerType: steelseries.PointerType.TYPE2,
            frameDesign: steelseries.FrameDesign.TILTED_BLACK, 
            backgroundColor: steelseries.BackgroundColor.BEIGE,  
            pointerColor: steelseries.ColorDef.RED,                     
            ledColor: steelseries.LedColor.RED_LED,
		    foregroundType: steelseries.ForegroundType.TYPE4
        });	
        getValue$rand(level_$rand, 100);
    }
    function getValue$rand(gauge, range) {
	    setInterval(function () {
			$.ajax({
				url: 'gauge.php?line=$line&id=$id&tk=$tk', 
				success: function(point) {
		    y = eval(point);
			num = y[1];
			gauge.setValueAnimated(num);
			$('span#c$rand').text(num.toPrecision(3)+' %');
			},
				cache: false
			});
	    }, 1000);
	}
    $(function () {
		init_$rand();
    });
</script>
<div id='clm0'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:180px; height:180px; margin: 0 auto;'>
<canvas id='canvas_$rand' width='200' height='180'>No canvas in your browser...sorry...</canvas></div>";
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
                duration: 2000,
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
function get_clock() {
    $rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    var clock_$rand;
	function init_$rand() {
        clock_$rand = new steelseries.Clock('canvas_$rand', {
                            width: 180,
                            height: 180,
							frameDesign: steelseries.FrameDesign.TILTED_BLACK,
							backgroundColor: steelseries.BackgroundColor.BEIGE
                            });
	}
    $(function () {
		init_$rand();
    });
</script>
<div id='chart_$rand' style='width:180px; height:190px; margin: 0 auto; padding-top:10px;'>
<canvas id='canvas_$rand' width='180' height='180'>No canvas in your browser...sorry...</canvas></div>";
}
function get_users_activity($lang) {
	mysql_query("SET NAMES 'utf8'");
	$query = "SELECT `user_name` FROM `users`";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0) {
		while($user = mysql_fetch_array($result)) {
            $cnt = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) as cnt FROM `logs` WHERE `user`= '".$user['user_name']."'"));
			if (($cnt['cnt'] != 0) && ($user['user_name'] != 'Alex')) {
				$users[] = $user['user_name'];
				$counters[] = $cnt['cnt'];
			}
	    }
		$rand = rand(1000,9999);
		$all_users = implode("','",$users);
		$actions = implode(",",$counters);
echo "<script type=\"text/javascript\" charset=\"UTF-8\">
$(function () {
	$('#chart_$rand').highcharts({
	    chart: {
	        polar: true,
	        type: 'line',
			borderWidth: 0,
	    },
	    title: {
	        text: null
	    },
	    xAxis: {
	        categories: ['$all_users'],
	        tickmarkPlacement: 'on',
	        lineWidth: 0
	    },
	    yAxis: {
	        gridLineInterpolation: 'polygon',
	        lineWidth: 0,
	        min: 0
	    },
	    tooltip: {
	    	shared: true,
            formatter: function() {
                var s = '<b>'+ this.x +'</b>';
                $.each(this.points, function(i, point) {
                    s += '<br/>'+ point.series.name +': '+point.y;
                });
                return s;
            }
	    },
        credits: {
            enabled: false
        },
	    legend: {
			enabled: false,
	        align: 'right',
	        verticalAlign: 'top',
	        y: 70,
	        layout: 'vertical'
	    },
	    series: [{
	        name: '".get_lang($lang, 'ad293')."',
	        data: [$actions],
	        pointPlacement: 'on'
	    }]
	});
});
	</script>
	<div class=\"cc10\"><div id=\"chart_$rand\" style=\"width:100%; height:270px; margin: 0 auto;\">
	    <div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div></div>";
	} else {
		//do nothing
	}
}
function get_controllers_widget($lang) {
	mysql_query("SET NAMES 'utf8'");
    $query = "SELECT * FROM `lines`";
	$query .= " order by `line_name` asc";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
		$rand = rand(1000,9999);
        while ($lines = mysql_fetch_array($result)) {
			$linex[] = $lines['line_name'];
            $controllerx[] = count_controllers($lines['line_name']);
			$valvex[] = count_valves($lines['line_name']);
	    }
		//$s = count($linex)/1.5;
		//$c = number_format($s, 2, '', '');
		$lines = implode("','",$linex);
		$controllers = implode(",",$controllerx);
		$valves = implode(',',$valvex);
		$tc = array_sum($controllerx);
		$tv = array_sum($valvex);		
echo "<script type=\"text/javascript\" charset=\"UTF-8\">
$(function () {
var chart;
$(document).ready(function() {
   chart = new Highcharts.Chart({
      chart: {
         renderTo: 'chart_$rand',
         defaultSeriesType: 'bar',
		 marginTop: 40,
		 marginBottom: 40,
		 plotShadow: false,
            animation: {
                duration: 2000,
                easing: 'easeOutBounce'
            }
      },
      title: {
         text: '".$tc." ".get_lang($lang, 'td47')."',
            style: {
                fontSize: '12px'
            }
      },
      subtitle: {
         text: '".$tv." ".get_lang($lang, 'td48')."',
            style: {
                fontSize: '12px'
            }
      },
      xAxis: {
         categories: ['".$lines."'],
         title: {
            text: null
         }
      },
      yAxis: {
         min: 0,
		 showLastLabel: false,
         title: {
            text: null,
            align: 'high'
         }
      },
            tooltip: {
                headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
                pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
                    '<td style=\"padding:0\"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
        plotOptions: {
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            },
            dataLabels: {
               enabled: true
            }
        },
        legend: {
            align: 'left',
            verticalAlign: 'bottom',
            y: 15,
			x: -10,
            floating: true,
			borderWidth: 0
        },
      credits: {
         enabled: false
      },
      series: [{
         name: '".get_lang($lang, 'td47')."',
         data: [$controllers]	   		   
      },{
         name: '".get_lang($lang, 'td48')."',
         data: [$valves]	   		   
      }]
   });  });	});	
	</script>
	<div class=\"cc10\"><div id=\"chart_$rand\" style=\"width:100%; height:420px; margin: 0 auto;\">
	    <div class=\"loading\"><img src=\"img/loaders/c_loader_gr.gif\" /></div></div></div>";
	} else {
        //do nothing
	}
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
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table bukovo\">
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
?>