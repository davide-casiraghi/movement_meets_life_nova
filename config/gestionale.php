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

    /*
     * Defaults of a new invoice ("Nuova fattura").
     */
    'invoice' => [
        'type' => 'health',
        'payment_method' => 'cash',
        'tax_regime' => 'RF19',            // Regime forfettario
        'pension_fund' => 'inps_separate', // Gestione Separata INPS
        'contribution_enabled' => true,
        'contribution_rate' => 4,
        'contribution_included' => true,
        'stamp_amount' => 2,
        'withholding_rate' => 20,
        'vat_code' => 'N2.2',              // Non soggette - regime forfettario

        'bank' => [
            'name' => env('GESTIONALE_BANK_NAME'),
            'holder' => env('GESTIONALE_BANK_HOLDER'),
            'iban' => env('GESTIONALE_BANK_IBAN'),
            'bic' => env('GESTIONALE_BANK_BIC'),
        ],

        // "Scegli Template" of the "Dicitura centrale"; the default one is pre-filled.
        'central_texts' => [
            [
                'name' => 'Dicitura personalizzata 1',
                'default' => true,
                'text' => "Operazione effettuata ai sensi dell'articolo 1, commi da 54 a 89 della Legge n. 190/2014, così come modificato dalla Legge numero 208/2015. Si richiede la non applicazione della ritenuta d'acconto ai sensi dell'articolo 1 comma 67 della Legge numero 190/2014.",
            ],
        ],
    ],
];
