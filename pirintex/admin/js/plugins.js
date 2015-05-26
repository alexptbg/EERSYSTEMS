$(document).ready(function(){
    // SELECT2       
        $("#s2_1").select2();
        $("#s2_2").select2();
        
    // CHECKBOXES AND RADIO
        $(".row-form,.row-fluid,.dialog,.loginBox,.block,.block-fluid").find("input:checkbox, input:radio, input:file").not(".skip").uniform();
    
    
    // MASKED INPUTS
        
        $("#mask_phone").mask('99 (999) 999-99-99');
        $("#mask_credit").mask('9999-9999-9999-9999');
        $("#mask_date").mask('99/99/9999');
        $("#mask_tin").mask('99-9999999');
        $("#mask_ssn").mask('999-99-9999');
        
    //FORM VALIDATION

        $("#validation").validationEngine({promptPosition : "topLeft", scroll: true});        
        $("#validation2").validationEngine({promptPosition : "topLeft", scroll: true}); 
    // CUSTOM SCROLLING
    
        $(".scroll").mCustomScrollbar();
    
    // ACCORDION 
    
        $(".accordion").accordion();
    
    // PROGRESSBAR
    
    if($("#progressbar-1").length > 0)    
        $("#progressbar-1").anim_progressbar();
    
    if($("#progressbar-2").length > 0){
        var iNow = new Date().setTime(new Date().getTime() + 3 * 1000);
	var iEnd = new Date().setTime(new Date().getTime() + 20 * 1000);
	$('#progressbar-2').anim_progressbar({start: iNow, finish: iEnd, interval: 1});        
    }
    if($("#progressbar-3").length > 0)
        $('#progressbar-3').progressbar({value: 65});
    
    if($("#progressbar-4").length > 0)
        $('#progressbar-4').progressbar({value: 35});
        
    // DIALOG
    
    $("#b_popup_1").dialog({autoOpen: false});
        
        $("#popup_1").click(function(){$("#b_popup_1").dialog('open')});
        
    $("#b_popup_2").dialog({autoOpen: false, show: "blind", hide: "explode"});

        $("#popup_2").click(function(){$("#b_popup_2").dialog('open')});

    $("#b_popup_3").dialog({autoOpen: false, modal: true});
        
        $("#popup_3").click(function(){$("#b_popup_3").dialog('open')});
        
    $("#box").dialog({
		autoOpen: false, 
        modal: true,
        width: 400,
        buttons: {                            
            "Ok": function() {
                $( this ).dialog("close");
            }
    }});
    $("#add_server").dialog({autoOpen: false});
    $("#pop_adserver").click(
        function () {
            $("#add_server").dialog('open');
            return false;
        }
    );
    $("#chat_pop").dialog({autoOpen: false});
    $("#pop_chat").click(
        function () {
            $("#chat_pop").dialog('open');
            return false;
        }
    );
    $("#closes").click(
        function () {
            $("#add_server").dialog('close');
            return false;
        }
    );
    $("#closed").click(
        function () {
            $("#chat_pop").dialog('close');
            return false;
        }
    );
    // SLIDER
    
        $("#slider_1").slider({
            value: 60,
            orientation: "horizontal",
            range: "min",
            animate: true,
            slide: function( event, ui ) {
                $( "#slider_1_amount" ).html( "$" + ui.value );
            }
        });
        
        $("#slider_2").slider({
            values: [ 17, 67 ],
            orientation: "horizontal",
            range: true,
            animate: true,
            slide: function( event, ui ) {
                $( "#slider_2_amount" ).html( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            }            
        });    
            
        $("#slider_3").slider({
            orientation: "vertical",
            range: "min",
            min: 0,
            max: 100,
            value: 10,
            slide: function( event, ui ) {
                $( "#slider_3_amount" ).html( '$'+ui.value );
            }            
        }); 

        $("#slider_4").slider({
            orientation: "vertical",
            range: true,
            values: [ 17, 67 ]
        }); 

        $("#slider_5").slider({
            orientation: "vertical",            
            range: "max",
            min: 1,
            max: 10,
            value: 2
        }); 
        
        
    // TABS
    
        $( ".tabs" ).tabs();

   // TOOLTIPS
        $('.tip').qtip({ style: {name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'bottomMiddle',
                                tooltip: 'topLeft'
                            }
                        },
						hide: { when: 'mouseout', delay: 0 },
						show: { solo: true }
                    });
        $('.tip_').qtip({ style: {name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'bottomMiddle',
                                tooltip: 'topRight'
                            }
                        },
						hide: { when: 'mouseout', delay: 0 },
						show: { solo: true }
                    });
        $('.tip-').qtip({ style: {name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'bottomMiddle',
                                tooltip: 'topRight'
                            }
                        },
						hide: { when: 'mouseout', delay: 0 },
						show: { solo: true }
                    });
        $('.tt').qtip({ style: {name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'topRight',
                                tooltip: 'bottomLeft'
                            }
                        } 
                    });
        
        $('.ttRC').qtip({ style: { name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'rightMiddle',
                                tooltip: 'leftMiddle'
                            }
                        } 
                    });        

        $('.ttRB').qtip({ style: { name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'bottomRight',
                                tooltip: 'topLeft'
                            }
                        } 
                    });
                    
        $('.ttLT').qtip({ style: { name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'topLeft',
                                tooltip: 'bottomRight'
                            }
                        } 
                    });
        
        $('.ttLC').qtip({ style: { name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'leftMiddle',
                                tooltip: 'rightMiddle'
                            }
                        } 
                    });        

        $('.ttLB').qtip({ style: { name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'bottomLeft',
                                tooltip: 'topRight'
                            }
                        } 
                    });
         
         // Bootstrap tooltip
         $(".tipt").tooltip({placement: 'top', trigger: 'hover'});
         $(".tipb").tooltip({placement: 'bottom', trigger: 'hover'});
         $(".tipl").tooltip({placement: 'left', trigger: 'hover'});
         $(".tipr").tooltip({placement: 'right', trigger: 'hover'});


        // SORTABLE       
            $("#sort_1").sortable({placeholder: "placeholder"});
            $("#sort_1").disableSelection();    
         if($("#lines_t").length > 0) { 
             $('#lines_t').dataTable( { "aaSorting": [[ 0, "asc" ]] });
		 }
         if($("#klines_t").length > 0) { 
             $('#klines_t').dataTable( { "aaSorting": [[ 0, "asc" ]] });
		 }
		 
        // SELECTABLE
            $("#selectable_1").selectable();
            
            
        // WYSIWIG HTML EDITOR
            if($("#wysiwyg").length > 0){
                editor = $("#wysiwyg").cleditor({width:"100%", height:"100%"})[0].focus();                
            }                                          
            if($("#mail_wysiwyg").length > 0)
                m_editor = $("#mail_wysiwyg").cleditor({width:"100%", height:"100%",controls:"bold italic underline strikethrough | font size style | color highlight removeformat | bullets numbering | outdent alignleft center alignright justify"})[0].focus();
            
            $('#sendmail').on('shown', function () {
                m_editor.refresh();
                $(this).find('.uploader').show();
            });            
            
        // WYSIWIG HTML EDITOR    
            
         // Sortable table
         if($("#users_t").length > 0) { 
             $('#users_t').dataTable( { "aaSorting": [[ 1, "asc" ]] });
		 }
         if($("#logs_t").length > 0) { 
             $('#logs_t').dataTable( { "aaSorting": [[ 0, "desc" ]] });
		 }
         //File manager
         
         if($("#filemanager").length > 0){
             $("#filemanager").elfinder({url : 'php/elfinder/connector.php'}).elfinder('instance');
         }            
         
         // File uploader
         if($("#uploader_v5").length > 0){
            $("#uploader_v5").pluploadQueue({		
                    runtimes : 'html5',
                    url : 'php/pluploader/upload.php',
                    max_file_size : '1mb',
                    chunk_size : '1mb',
                    unique_names : true,
                    dragdrop : true,

                    resize : {width : 320, height : 240, quality : 100},

                    filters : [
                            {title : "Image files", extensions : "jpg,gif,png"},
                            {title : "Zip files", extensions : "zip"}
                    ]
            });
         }
         if($("#uploader_v4").length > 0){
            $("#uploader_v4").pluploadQueue({		
                    runtimes : 'html4',
                    url : 'php/pluploader/upload.php',
                    unique_names : true,
                    filters : [
                            {title : "Image files", extensions : "jpg,gif,png"},
                            {title : "Zip files", extensions : "zip"}
                    ]
            });
         }                  
         
         /* Multiselect */
         if($("#multiselect").length > 0){
            $("#multiselect").multiSelect();
         }
         if($("#fmultiselect").length > 0){
            $("#fmultiselect").multiSelect({
                selectableHeader: "<div class='multipleselect-header'>Selectable item</div>",
                selectedHeader: "<div class='multipleselect-header'>Selected items</div>"
            });
            $('#multiselect-selectAll').click(function(){
                $('#fmultiselect').multiSelect('select_all');
                return false;
            });
            $('#multiselect-deselectAll').click(function(){
                $('#fmultiselect').multiSelect('deselect_all');
                return false;
            });
            $('#multiselect-selectIndia').click(function(){
                $('#fmultiselect').multiSelect('select', 'in');
                return false;
            });         
         }
         
});


$('.wrapper').resize(function(){

    if($("#wysiwyg").length > 0) editor.refresh();
    if($("#mail_wysiwyg").length > 0) m_editor.refresh();
}); 