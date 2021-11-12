$(document).ready(function() {

    // Check the options available: https://flatpickr.js.org/examples/

    $('.flatpickr.dateTime.all').flatpickr({
        dateFormat: 'd/m/Y h:i K',
        enableTime: true,
        locale: {
            firstDayOfWeek: 1,
        }
    });

    $('.flatpickr.dateTime.future').flatpickr({
        dateFormat: 'd/m/Y h:i K',
        enableTime: true,
        minDate: "today",
        maxDate: new Date().fp_incr(365), // 365 days from now
        locale: {
            firstDayOfWeek: 1,
        }
    });

    $('.flatpickr.dateTime.past').flatpickr({
        dateFormat: 'd/m/Y h:i K',
        enableTime: true,
        maxDate: "today",
        locale: {
            firstDayOfWeek: 1,
        }
    });

    $('.flatpickr.date.multiple').flatpickr({
        dateFormat: 'd/m/Y h:i K',
        mode: "multiple",
        enableTime: false,
        minDate: "today",
        locale: {
            firstDayOfWeek: 1,
        }
    });

});