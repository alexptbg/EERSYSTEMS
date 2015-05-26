$(function() {
            $(".dial").knob({
                change : function (value) {
                    console.log("change : " + value.toPrecision(3));
					s = value*10;
					console.log("send : " + s.toPrecision(3));
                },
                /*release : function (value) {
                    console.log("release : " + value);
                },
                cancel : function () {
                    console.log("cancel : " + this.value);
                },*/
				/*'readOnly': true,*/
                draw : function () {
					$(this.i).val(this.cv + ' ºC');
                    if(this.$.data('skin') == 'tron') {
                        var a = this.angle(this.cv)
                            , sa = this.startAngle     
                            , sat = this.startAngle    
                            , ea                      
                            , eat = sat + a       
                            , r = true;
                        this.g.lineWidth = this.lineWidth;
                        this.o.cursor
                            && (sat = eat - 0.3)
                            && (eat = eat + 0.3);
                        if (this.o.displayPrevious) {
                            ea = this.startAngle + this.angle(this.value);
                            this.o.cursor
                                && (sa = ea - 0.3)
                                && (ea = ea + 0.3);
                            this.g.beginPath();
                            this.g.strokeStyle = this.previousColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                            this.g.stroke();
                        }
                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                        this.g.stroke();
                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();
                        return false;
                    }
                }  
			});
            //$('.dial').val(27.1).trigger('change');
            $(".vent").knob({
                draw : function () {
					$(this.i).val(this.cv + '');
                    if(this.$.data('skin') == 'tron') {
                        var a = this.angle(this.cv)
                            , sa = this.startAngle     
                            , sat = this.startAngle    
                            , ea                      
                            , eat = sat + a       
                            , r = true;
                        this.g.lineWidth = this.lineWidth;
                        this.o.cursor
                            && (sat = eat - 0.3)
                            && (eat = eat + 0.3);
                        if (this.o.displayPrevious) {
                            ea = this.startAngle + this.angle(this.value);
                            this.o.cursor
                                && (sa = ea - 0.3)
                                && (ea = ea + 0.3);
                            this.g.beginPath();
                            this.g.strokeStyle = this.previousColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                            this.g.stroke();
                        }
                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                        this.g.stroke();
                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();
                        return false;
                    }
                }        
			});
            $(".ener").knob({
                draw : function () {
                    if(this.$.data('skin') == 'tron') {
                        var a = this.angle(this.cv)
                            , sa = this.startAngle     
                            , sat = this.startAngle    
                            , ea                      
                            , eat = sat + a       
                            , r = true;
                        this.g.lineWidth = this.lineWidth;
                        this.o.cursor
                            && (sat = eat - 0.3)
                            && (eat = eat + 0.3);
                        if (this.o.displayPrevious) {
                            ea = this.startAngle + this.angle(this.value);
                            this.o.cursor
                                && (sa = ea - 0.3)
                                && (ea = ea + 0.3);
                            this.g.beginPath();
                            this.g.strokeStyle = this.previousColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                            this.g.stroke();
                        }
                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                        this.g.stroke();
                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();
                        return false;
                    }
                }            
			});
//get input value
//bla = $('.dial').val(); alert(bla);
//set
//$('#txt_name').val('bla');
});