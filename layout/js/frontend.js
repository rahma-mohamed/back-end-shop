$(function (){
    'use strict';
    //switch betwen login & signup
    $('.login-page h1 span').click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.' + $(this).data('class')).fadeIn(100);
    })
    $('[placeholder]').focus(
        function(){
            $(this).attr('data-text', $(this).attr('placeholder'));
            $(this).attr('placeholder', '');
        })
    .blur(function(){
        $(this).attr('placeholder', $(this).attr('data-text'));
    });
    //confirmtion massage on button
    $('.confirm').click(function(){
        return confirm('Are You Sure?');
    });
    $('.live').keyup(function(){
        $($(this).data('class')).text($(this).val());
    });
  
});
