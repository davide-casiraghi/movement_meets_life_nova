$(document).ready(function() {

    $('#startDateAndTime').flatpickr({
        dateFormat: 'd/m/Y h:i K',
        enableTime: true,
        locale: {
            firstDayOfWeek: 1,
        }
    });

});