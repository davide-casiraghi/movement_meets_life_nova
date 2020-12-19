$(document).ready(function() {

    var today = new Date();

    // Normal datepicker - Enabled just from today (no past allowed)
    $('.datepicker input').datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        startDate: today,
        todayHighlight: true,
    });


    $('.datepickerMultiple input').datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        todayHighlight: true,
        startDate: today,
        multidate: true,
        multidateSeparator: ","
    });

});