<?php

namespace App\Support;

/**
 * Checks of the Italian fiscal code (codice fiscale).
 *
 * Individuals: 16 characters, with the last one a check character computed from
 * the first 15. "Omocodia" codes (digits replaced by letters) are accepted.
 * Companies and other bodies: 11 digits (same as the VAT number).
 */
class CodiceFiscale
{
    private const INDIVIDUAL_PATTERN = '/^[A-Z]{6}[0-9LMNPQRSTUV]{2}[A-EHLMPRST][0-9LMNPQRSTUV]{2}[A-Z][0-9LMNPQRSTUV]{3}[A-Z]$/';

    /** Values of the characters in odd positions (1st, 3rd, ...). */
    private const ODD_VALUES = [
        '0' => 1, '1' => 0, '2' => 5, '3' => 7, '4' => 9, '5' => 13, '6' => 15, '7' => 17, '8' => 19, '9' => 21,
        'A' => 1, 'B' => 0, 'C' => 5, 'D' => 7, 'E' => 9, 'F' => 13, 'G' => 15, 'H' => 17, 'I' => 19, 'J' => 21,
        'K' => 2, 'L' => 4, 'M' => 18, 'N' => 20, 'O' => 11, 'P' => 3, 'Q' => 6, 'R' => 8, 'S' => 12, 'T' => 14,
        'U' => 16, 'V' => 10, 'W' => 22, 'X' => 25, 'Y' => 24, 'Z' => 23,
    ];

    public static function normalize(?string $code): ?string
    {
        $code = strtoupper(preg_replace('/\s+/', '', (string) $code));

        return $code === '' ? null : $code;
    }

    public static function isValidIndividual(string $code): bool
    {
        $code = self::normalize($code) ?? '';

        if (! preg_match(self::INDIVIDUAL_PATTERN, $code)) {
            return false;
        }

        $sum = 0;

        for ($i = 0; $i < 15; $i++) {
            $char = $code[$i];
            $sum += $i % 2 === 0
                ? self::ODD_VALUES[$char]
                : (ctype_digit($char) ? (int) $char : ord($char) - ord('A'));
        }

        return chr(ord('A') + $sum % 26) === $code[15];
    }

    /** Fiscal code of a company or other body: 11 digits, or 16 characters for some bodies. */
    public static function isValidCompany(string $code): bool
    {
        $code = self::normalize($code) ?? '';

        return (bool) preg_match('/^[0-9]{11}$/', $code) || self::isValidIndividual($code);
    }
}
