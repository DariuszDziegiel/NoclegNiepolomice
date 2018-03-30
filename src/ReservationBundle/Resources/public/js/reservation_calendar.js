$(document).ready(function () {

    $('#av-calendar-wrapper').on('click', '.calendar-btn', function (event) {

        $('#av-calendar-wrapper').html('<div class="calendar-loader">' +
            '<b>Trwa ładowanie kalendarza</b>' +
            '<br />' +
            '<img src="' + APP_WEB + 'images/loading_circle.gif" class="loading-circle">' +
            '</div>'
        );

        $.ajax({
            method:   'GET',
            dataType: 'html',
            url: Routing.generate(
                CALENDAR_ROUTE, {
                    year: $(this).data('year'),
                    month: $(this).data('month')
                }
            )
        })
            .done(function (data) {
                $('#av-calendar-wrapper').html(data);
            })
            .fail(function (data, textStatus, errorThrown) {
                $('#av-calendar-wrapper').html('<b>Błąd ładowania kalendarza</b>');
                //console.log(data);
            })
    })

})
