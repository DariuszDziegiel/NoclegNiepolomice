$(document).ready(function () {

    $('#av-calendar-wrapper').on('click', '.calendar-btn', function (event) {

        $('#av-calendar-wrapper').html('<img src="' + APP_WEB + 'images/loading_circle.gif" class="loading-circle">');
        $.ajax({
            method:   'GET',
            dataType: 'html',
            url: Routing.generate(
                'calendar_draw', {
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
                console.log(data);
            })
    })

})
