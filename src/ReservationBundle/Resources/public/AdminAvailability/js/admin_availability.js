//Change single date status
function changeDateStatus(date) {

    $('.calendar-operation-loader').show();
    
    $.ajax({
        method:   'GET',
        dataType: 'json',
        url: Routing.generate(
            'admin_availability_change_date_status', {
                date: date,
            }
        )
    })
        .done(function (data) {
            $('.day-cell[data-date=' + date + ']').removeClass('day-free')
                .removeClass('day-reserved')
                .addClass(data.class);

            $('.calendar-operation-loader').hide();
        })
        .fail(function (data, textStatus, errorThrown) {
            //$('#av-calendar-wrapper').html('<b>Błąd ładowania kalendarza</b>');
            //console.log(data);
        })

}



$(document).ready(function() {

    //reservation days
    $("#av-calendar-wrapper").on('mouseenter', '.day-reserved[data-reservation-id]', function (obj) {
        $('.reservation-row[data-reservation-id=' + $(this).data('reservation-id') + ']').addClass('reservation-active');
        $('.day-cell[data-reservation-id=' + $(this).data('reservation-id') + ']').addClass('reservation-active');
    });

    $("#av-calendar-wrapper").on('mouseleave', '.day-reserved[data-reservation-id]', function (obj) {
        $('.reservation-row[data-reservation-id=' + $(this).data('reservation-id') + ']').removeClass('reservation-active');
        $('.day-cell[data-reservation-id=' + $(this).data('reservation-id') + ']').removeClass('reservation-active');
    });

    //not reservation day
    $("#av-calendar-wrapper").on('mouseenter', '.day-cell:not([data-reservation-id])', function (obj) {
        $(this).find('.msg-box').html('<small>Kliknij aby zmienić dostępność daty</small>');
    });

    $("#av-calendar-wrapper").on('mouseleave', '.day-cell:not([data-reservation-id])', function (obj) {
        $(this).find('.msg-box').html('');
    });


        //$('#av-calendar-wrapper').on('m', '.day-cell', function (event) {

    $('#av-calendar-wrapper').on('click', '.day-cell', function (event) {

        if ($(this).data('reservation-id')) {
            bootbox.alert(
                'Nie można zmienić dostępności wybranej daty.<br />Wybrana data jest zarezerwowana.<br />' +
                'Usuń rezerwację aby zwolnić dostępność tej daty.'
            );
            return false;
        }

        changeDateStatus($(this).data('date'));

    })





   
    
})