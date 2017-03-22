(function ($) {
    $.fn.scrollingTo = function (opts) {
        var defaults = {
            animationTime: 1000,
            easing: '',
            callbackBeforeTransition: function () {
            },
            callbackAfterTransition: function () {
            }
        };

        var config = $.extend({}, defaults, opts);

        $(this).click(function (e) {
            var eventVal = e;
            e.preventDefault();

            var $section = $(document).find($(this).data('section'));
            if ($section.length < 1) {
                return false;
            }
            ;

            if ($('html, body').is(':animated')) {
                $('html, body').stop(true, true);
            }
            ;

            var scrollPos = $section.offset().top;

            if ($(window).scrollTop() == scrollPos) {
                return false;
            }
            ;

            config.callbackBeforeTransition(eventVal, $section);

            $('html, body').animate({
                'scrollTop': (scrollPos + 'px')
            }, config.animationTime, config.easing, function () {
                config.callbackAfterTransition(eventVal, $section);
            });
        });
    };
}(jQuery));



jQuery(document).ready(function () {
    "use strict";
    new WOW().init();


    (function () {
        jQuery('.smooth-scroll').scrollingTo();
    }());

});

$(document).ready(function () {
    $(window).scroll(function () {
        if ($(window).scrollTop() > 50) {
            $(".navbar-brand a").css("color", "#fff");
            $("#top-bar").removeClass("animated-header");
        } else {
            $(".navbar-brand a").css("color", "inherit");
            $("#top-bar").addClass("animated-header");
        }
    });

    $("#clients-logo").owlCarousel({
        itemsCustom: false,
        pagination: false,
        items: 5,
        autoplay: true,
    })

});
// fancybox
$(".fancybox").fancybox({
    padding: 0,
    openEffect: 'elastic',
    openSpeed: 450,
    closeEffect: 'elastic',
    closeSpeed: 350,
    closeClick: true,
    helpers: {
        title: {
            type: 'inside'
        },
        overlay: {
            css: {
                'background': 'rgba(0,0,0,0.8)'
            }
        }
    }
});
$('#contact-submit').click(function () {
    var nome = $('#nome').val();
    var email = $('#email').val();
    var assunto = $('#assunto').val();
    var mensagem = $('#mensagem').val();
    var fone = $('#fone').val();
    $('#nome,#email,#fone,#assunto,#mensagem').removeClass('error');
    $('#msg').addClass('hidden');
    $.ajax({
        type: "POST",
        url: 'php/sendmail.php',
        dataType: 'json',
        cache: false,
        data: {
            nome: nome,
            email: email,
            assunto: assunto,
            mensagem: mensagem,
            fone: fone
        },
        success: function (json) {
            if(json.info == 1){
                $('#msg').removeClass('hidden');
                $('#msg').addClass('alert-success');
                $('#msg').html(json.msg);
                $('#nome,#email,#fone,#assunto,#mensagem').val('');
            }else {
                $('#msg').removeClass('hidden');
                $('#msg').addClass('alert-danger');
                $('#msg').html(json.msg);
                json.campo.forEach(function(string) {
                    $(string).addClass('error');
                });
            }
        }
    }, 'json');

})










