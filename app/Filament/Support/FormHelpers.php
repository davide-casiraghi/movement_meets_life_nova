<?php

namespace App\Filament\Support;

use App\Models\Service;
use Illuminate\Support\HtmlString;

/**
 * Small pieces shared by the forms of the physiotherapy panel.
 */
class FormHelpers
{
    /** Label followed by a grey "(opzionale)". */
    public static function optional(string $label): HtmlString
    {
        return new HtmlString(e($label).' <span class="gest-optional">(opzionale)</span>');
    }

    /** Options for a colour select: "Colore 1" ... with a coloured background. */
    public static function colorOptions(): array
    {
        return collect(Service::COLORS)
            ->mapWithKeys(fn (string $hex, int $i) => [
                $hex => '<span class="gest-color-option" style="background:'.$hex.'">Colore '.($i + 1).'</span>',
            ])
            ->all();
    }

    public static function colorDot(?string $hex): string
    {
        $hex = in_array($hex, Service::COLORS, true) ? $hex : '#E0E0E0';

        return '<span class="gest-color-dot" style="background:'.$hex.'"></span>';
    }

    /**
     * Countries for the nationality and address selects, in Italian, keyed by
     * ISO 3166 code ("IT" => "Italia"), alphabetical. Names come from ICU (PHP intl).
     */
    public static function countryOptions(): array
    {
        static $options;

        if ($options !== null) {
            return $options;
        }

        $names = [];

        foreach (\ResourceBundle::create('it', 'ICUDATA-region')['Countries'] as $code => $name) {
            // Skip groupings and placeholders such as "Unione europea" or "Regione sconosciuta".
            if (preg_match('/^[A-Z]{2}$/', $code) && ! in_array($code, ['EU', 'EZ', 'UN', 'QO', 'XA', 'XB', 'ZZ'], true)) {
                $names[$code] = $name;
            }
        }

        (new \Collator('it_IT'))->asort($names);

        return $options = $names;
    }

    public static function countryName(?string $code): ?string
    {
        return $code ? (self::countryOptions()[$code] ?? $code) : null;
    }

    /** Validation regex for prices typed as "100", "100,5" or "100.50". */
    public const PRICE_REGEX = '/^\d{1,8}([.,]\d{1,2})?$/';

    /** "50.00" -> "50,00" for the form fields. */
    public static function formatPrice(mixed $value): ?string
    {
        return filled($value) ? number_format((float) $value, 2, ',', '') : null;
    }

    /** "50,00" -> "50.00" for the database. */
    public static function parsePrice(mixed $value): ?string
    {
        return filled($value) ? str_replace(',', '.', (string) $value) : null;
    }
}
