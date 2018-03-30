$(document).ready(function () {

    

    /**$("#main-image").vegas({
        slides: [
            { src: APP_WEB + "/images/main_slider/wines.jpg"},
            { src: APP_WEB + "/images/main_slider/stradom.jpg"},
        ],
        //overlay: true,
        animation: 'kenburns',
    });**/

    /*$('.parallax-window.parallax-section-hotel').parallax({
        imageSrc: APP_WEB + 'upload/parallax/parallax_1.jpg'
    });*/

    //gallery
    $('.owl-carousel').magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        }
    });


    //gallery
    $(".owl-carousel").owlCarousel({
        center: false,
        loop:   true,
        margin: 10,
        nav:    true,
        navText: ['<span class="glyphicon glyphicon-chevron-left"></span>', '<span class="glyphicon glyphicon-chevron-right"></span>'],
        dots:   true,
        responsive:{
            0:{
                items: 1
            },
            600:{
                items: 3
            },
            1000:{
                items:4
            }
        }
    });
    
    

    //scroll to content
    $('.img-box-scroll-btn').on('click', function() {
        $('html, body').animate({
            scrollTop: $('.image-box').height() + 20,
        }, 500);
        /**$(window).scrollTo($('#main-content-scroll'), 1500, {
            'offset': {top: 20}
        });**/
    });



    //fade gallery images
    var fadeTime = 0.1;
    $('.image-block').each(function () {
        $(this).css('animation', 'fadein ' +fadeTime+  's');
        fadeTime += .3;
    })

    
    //calendars








    
    

});



