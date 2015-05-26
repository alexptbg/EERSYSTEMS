$(document).ready(function(){
    $("div[class^='span']").find(".row-form:first").css('border-top', '0px');
    $("div[class^='span']").find(".row-form:last").css('border-bottom', '0px');
    $(".header_menu .list_icon").click(function(){
        var menu = $("body .wrapper .menu");
        if(menu.is(":visible")){
            menu.fadeOut(200);
            $("body > .modal-backdrop").remove();
        } else {
            menu.fadeIn(300);
            $("body").append("<div class='modal-backdrop fade in'></div>");
        }
        return false;
    });
    if($(".adminControl").hasClass('active')){
        $('.admin').show();
    }
    $(".adminControl").click(function(){
        if($(this).hasClass('active')){
            $.cookies.set('b_Admin_visibility','hidden');
            $('.admin').fadeOut(100);
            $(this).removeClass('active');
        } else {
            $.cookies.set('b_Admin_visibility','visible');
            $('.admin').fadeIn(100);
            $(this).addClass('active');
        }
    });
    $(".navigation .openable > a").click(function(){
        var par = $(this).parent('.openable');
        var sub = par.find("ul");
        if(sub.is(':visible')){
            par.find('.popup').hide();
            par.removeClass('active');            
        } else {
            par.addClass('active');            
        }
        return false;
    });
    $(".jbtn").button();
    $(".alert").click(function(){
        $(this).fadeOut(300, function(){            
            $(this).remove();            
        });
    });
    $(".buttons li > a").click(function(){
        var parent = $(this).parent();
        if(parent.find(".dd-list").length > 0){
            var dropdown = parent.find(".dd-list");
            if(dropdown.is(":visible")){
                dropdown.hide();
                parent.removeClass('active');
            } else {
                dropdown.show();
                parent.addClass('active');
            }
            return false;
        }
    });
    $("input[name=checkall]").click(function(){
        if(!$(this).is(':checked'))
            $(this).parents('table').find('.checker span').removeClass('checked').find('input[type=checkbox]').attr('checked',false);
        else
            $(this).parents('table').find('.checker span').addClass('checked').find('input[type=checkbox]').attr('checked',true);
    });    
    $(".fancybox").fancybox();
});
$(window).load(function(){
    headInfo();    
});
$(window).resize(function(){
    headInfo();    
});
$('.wrapper').resize(function(){
    if($("body > .content").css('margin-left') == '220px'){
        if($("body > .menu").is(':hidden'))
            $("body > .menu").show();
    }
    headInfo();
});
function headInfo(){
    var block = $(".headInfo .input-append");
    var input = block.find("input[type=text]");
    var button = block.find("button");
    input.width(block.width()-button.width()-44);
}
function loginBlock(block){
    $(".loginBlock:visible").animate({
        top: '200px',
        opacity: 0
    },'200','linear',function(){
        $(this).css('top','0px').css('display','none');
    });    
    $(block).css({opacity: 0, display: 'block',top: '0px'});    
    $(block).find('.checker').show();
    $(block).animate({opacity: 1, top: '100px'},'200');
}