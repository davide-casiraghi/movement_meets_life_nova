$(document).ready(function() {
    var today = new Date();

    $('.datepicker input').datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        startDate: today,
        todayHighlight: true,
    });

});