$(document).ready(function () {

    
    $('.reservation-remove-btn').on('click', function (event) {
        if (confirm('Usunąć wybraną rezerwację?')) {
            return true;
        }
        return false
    })
    
    
    //highlite calendar cells 
    $("#reservations-tbl .reservation-row").on({
        mouseenter: function (obj) {
            $('.day-cell[data-reservation-id=' + $(this).data('reservation-id') + ']').addClass('reservation-active');
        },
        mouseleave: function (obj) {
            $('.day-cell[data-reservation-id=' + $(this).data('reservation-id') + ']').removeClass('reservation-active');
        }
    });
    
  










    
})