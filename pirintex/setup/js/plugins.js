$(document).ready(function(){
    $("#setup").dialog({autoOpen: false, modal: true });
    $(".row-form,.row-fluid,.dialog,.loginBox,.block,.block-fluid").find("input:checkbox, input:radio, input:file").not(".skip").uniform();
    $("#mask_phone").mask('99 (999) 999-99-99');
    $("#mask_credit").mask('9999-9999-9999-9999');
    $("#mask_date").mask('99/99/9999');
    $("#mask_tin").mask('99-9999999');
    $("#mask_ssn").mask('999-99-9999');
    $("#validation").validationEngine({promptPosition : "topLeft", scroll: true});
	$("#validation2").validationEngine({promptPosition : "topLeft", scroll: true});     
    $(".scroll").mCustomScrollbar();
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
    $(".tipt").tooltip({placement: 'top', trigger: 'hover'});
    $(".tipb").tooltip({placement: 'bottom', trigger: 'hover'});
    $(".tipl").tooltip({placement: 'left', trigger: 'hover'});
    $(".tipr").tooltip({placement: 'right', trigger: 'hover'});    
    $("#sort_1").sortable({placeholder: "placeholder"});
    $("#sort_1").disableSelection();    
    $("#selectable_1").selectable();
});