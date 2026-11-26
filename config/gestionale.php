<?php

/*
 * Settings of the physiotherapy panel (/gestionale).
 * They will move to the "Impostazioni" page when it is built.
 */
return [

    // Time zone of the practice: dates are stored in UTC and shown in this zone.
    'timezone' => env('GESTIONALE_TIMEZONE', 'Europe/Rome'),

    // Name of the (single) calendar of the practice.
    'calendar_name' => env('GESTIONALE_CALENDAR_NAME', 'Studio'),

    /*
     * Opening hours used by "Trova disponibilità".
     * Keys are ISO weekdays (1 = Monday ... 7 = Sunday); each day has a list of [from, to] blocks.
     */
    'working_hours' => [
        1 => [['09:00', '13:00'], ['14:00', '20:00']],
        2 => [['09:00', '13:00'], ['14:00', '20:00']],
        3 => [['09:00', '13:00'], ['14:00', '20:00']],
        4 => [['09:00', '13:00'], ['14:00', '20:00']],
        5 => [['09:00', '13:00'], ['14:00', '20:00']],
        6 => [],
        7 => [],
    ],

    // Free slots are proposed every N minutes and right after the end of each appointment.
    'slot_step_minutes' => 30,
];
