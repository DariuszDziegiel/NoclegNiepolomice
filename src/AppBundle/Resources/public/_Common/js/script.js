//default setting for datepicker
$.datepicker.setDefaults({
    dateFormat: 'yy-mm-dd',
    firstDay: 1,
    monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Pazdziernik','Listopad','Grudzień'],
    monthNamesShort: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Pazdziernik','Listopad','Grudzień'],
    dayNames: ['Nd','Pn','Wt','Śr','Cz','Pt','Sb'],
    dayNamesShort: ['Nd','Pn','Wt','Śr','Cz','Pt','Sb'],
    dayNamesMin: ['Nd','Pn','Wt','Śr','Cz','Pt','Sb']
});

var MENU = {
    load: function () {
        var pos = $(window).scrollTop();
        if (pos) {
            $('.navbar').addClass('navbar-onscroll');
        } else {
            $('.navbar').removeClass('navbar-onscroll');
        }
    }
};




$(document).ready(function() {

    MENU.load();

    $('img.lazy-load, img.lazy').lazyload({
        effect : "fadeIn"
    });

    /**
    $("body").vegas({
        slides: [
            { src: "upload/cms_page_background/marantz.jpg" },
            { src: "upload/cms_page_background/devialet.jpg" },
            { src: "upload/cms_page_background/zestaw.jpg" }
        ],
        delay: 15000,
        overlay: APP_VENDOR + 'vegas/dist/overlays/05.png'
    });
     **/

    
 
    //privacy policy
    $('#privacy-policy-close').click(function() {
        $('#privacy-policy-box').slideUp();
        $.cookie('privacy_policy_close', true , {expires: 365});
    })

    //scroll to page top
    $('#return-to-top').click(function() {
        $(window).scrollTo($('body'), 1500);
    });


    //menu scroll to position
    $('.navbar-nav a, .page-logo').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            /**$('html, body').stop().animate({
                scrollTop: target.offset().top + $('.navbar').height()
            }, 1000);**/
            $.scrollTo($(target), 1500, {
                'offset': - $('.navbar').height() - 20
            });
        }
        /*setTimeout(function() {
         target.find('.page-title-header').addClass('menu-title-animate')
         }, 750); */
    });




    /*var knp = new KnpPaginatorAjax();
    knp.init({
        'loadMoreText': 'Load More', //load more text
        'loadingText': 'Loading..', //loading text
        'elementsSelector': '.news-wrapper', //this is where the script will append and search results
        'paginationSelector': 'ul.pagination', //pagination selector
    });*/

    /**
    $('#news').on('click', 'ul.pagination a', function (e) {
        e.preventDefault();
        $(this).append('<img src="' + APP_WEB + 'images/loading_circle.gif">');
        var url = $.url($(this).attr('href'));
        $.ajax({
            type: "GET",
            url: Routing.generate('news_pagination', {page: url.param('page')}),
        })
            .done(function(msg) {
                $('#news-container').html(msg);
                //$('#nees ul.pagination li').removeClass('active');
                //$(this).closest('li').addClass('active');
            });
    })
     **/
    
    
    /*
    $('[data-toggle="popover"]').popover({
        html:       true,
        placement: 'auto',
    });
    */




    setTimeout(function() {
        $('.img-box-txt-fade').fadeIn();
    }, 250);


})


$(window).on('scroll', function () {
   MENU.load();
});

