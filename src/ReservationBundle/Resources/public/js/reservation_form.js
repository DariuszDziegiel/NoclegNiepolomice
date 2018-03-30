$(document).ready(function () {

    $('.reservation-form').on('focus', '.dateFrom', function (e) {
        $(this).datepicker({
            minDate:0,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                $( ".dateTo" ).datepicker( "option", "minDate", selectedDate );
            },
            beforeShow: function() {
            },
            onSelect: function() {
            }
        });
    });

    $('.reservation-form').on('focus', '.dateTo', function (e) {
        $(this).datepicker({
            minDate: $('.dateFrom').datepicker('getDate'),
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                $( ".dateFrom" ).datepicker("option", "maxDate", selectedDate );
            }
        });
    });



    $('.reservation-form').on('click', '.reservation-save-btn', function (e) {

        e.preventDefault();
        $('.cms-reservation-loader').html('<img src="' + APP_WEB + 'images/loading_circle.gif">');

        $.ajax({
            method:   'POST',
            dataType: 'json',
            url:       Routing.generate('cms_reservation_add'),
            data:      $('.reservation-form').serialize(),
        })
            .done(function (data) {
                $('.reservation-form-message').html('<div class="alert alert-success">' + data.message + '</div>');
                $('.cms-reservation-loader').html('');
                $('.reservation-form-body').fadeOut();
            })

            .fail(function (data, textStatus, errorThrown) {
                if (typeof data.responseJSON !== 'undefined') {
                    $('.reservation-form-body').html(data.responseJSON.form);
                    $('.reservation-form-message').html('<div class="alert alert-danger">' + data.responseJSON.message + '</div>');
                    //console.log(data.responseJSON);
                } else {
                    alert(errorThrown);
                }
                $('.cms-reservation-loader').html('');
            })
    });
    
})
