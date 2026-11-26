<?php

namespace App\Services\Gestionale;

use App\Enums\PensionFund;
use App\Enums\VatCode;

/**
 * Amounts of an invoice. Works in cents to avoid rounding drift.
 *
 * - Line total: unit price x quantity, less the discount.
 * - Rivalsa / contributo integrativo: added on top of the lines, or, when
 *   "included in the price", taken out of them (line = net x (1 + rate)).
 * - VAT: on each line plus its share of the rivalsa.
 * - Stamp duty: added to the total unless it is "a mio carico" (paid by the issuer).
 *   It is due when the amounts without VAT exceed 77,47 €.
 * - Withholding tax: on the "base imponibile" typed in the invoice; when it is
 *   empty, on the fees plus the INPS rivalsa (not on the contributo integrativo
 *   of the professional funds). Taken off the amount due.
 */
class InvoiceCalculator
{
    public const STAMP_THRESHOLD = 77.47;

    /**
     * @param  array<int, array{unit_price: mixed, quantity: mixed, discount?: mixed, vat_code?: mixed}>  $lines
     * @param  array<string, mixed>  $settings  invoice fields (contribution_*, stamp_*, withholding_*, pension_fund)
     * @return array{lines: array<int, float>, taxable_amount: float, contribution_amount: float, vat_amount: float, untaxed_amount: float, stamp_charged: float, total: float, withholding_base: float, withholding_amount: float, net_due: float}
     */
    public static function calculate(array $lines, array $settings): array
    {
        $contributionRate = ! empty($settings['contribution_enabled']) ? self::number($settings['contribution_rate'] ?? 0) : 0.0;
        $contributionIncluded = ! empty($settings['contribution_included']);

        $lineTotals = [];
        $taxable = $contribution = $vat = $untaxed = 0;

        foreach ($lines as $key => $line) {
            $lineTotal = self::cents(self::number($line['unit_price'] ?? 0) * self::number($line['quantity'] ?? 0) * (1 - self::number($line['discount'] ?? 0) / 100));
            $lineTotals[$key] = $lineTotal / 100.0;

            if ($contributionIncluded) {
                $lineTaxable = (int) round($lineTotal / (1 + $contributionRate / 100));
                $lineContribution = $lineTotal - $lineTaxable;
            } else {
                $lineTaxable = $lineTotal;
                $lineContribution = (int) round($lineTotal * $contributionRate / 100);
            }

            $vatCode = self::vatCode($line['vat_code'] ?? null);
            $rate = $vatCode?->rate() ?? 0;

            $taxable += $lineTaxable;
            $contribution += $lineContribution;
            $vat += (int) round(($lineTaxable + $lineContribution) * $rate / 100);

            if ($rate === 0) {
                $untaxed += $lineTaxable + $lineContribution;
            }
        }

        $stampCharged = (! empty($settings['stamp_enabled']) && empty($settings['stamp_charged_to_issuer']))
            ? self::cents(self::number($settings['stamp_amount'] ?? 0))
            : 0;

        $total = $taxable + $contribution + $vat + $stampCharged;

        $fund = $settings['pension_fund'] ?? null;
        $fund = $fund instanceof PensionFund ? $fund : PensionFund::tryFrom((string) $fund);
        $suggestedBase = $taxable + ($fund?->isSubjectToWithholding() ? $contribution : 0);

        $withholding = 0;

        if (! empty($settings['withholding_enabled'])) {
            $base = filled($settings['withholding_base'] ?? null) ? self::cents(self::number($settings['withholding_base'])) : $suggestedBase;
            $withholding = (int) round($base * self::number($settings['withholding_rate'] ?? 0) / 100);
        }

        return [
            'lines' => $lineTotals,
            'taxable_amount' => $taxable / 100.0,
            'contribution_amount' => $contribution / 100.0,
            'vat_amount' => $vat / 100.0,
            'untaxed_amount' => $untaxed / 100.0,
            'stamp_charged' => $stampCharged / 100.0,
            'total' => $total / 100.0,
            'withholding_base' => $suggestedBase / 100.0,
            'withholding_amount' => $withholding / 100.0,
            'net_due' => ($total - $withholding) / 100.0,
        ];
    }

    /** "50,5", "1.234,50", 12 -> float. */
    public static function number(mixed $value): float
    {
        if (is_int($value) || is_float($value)) {
            return (float) $value;
        }

        $value = trim((string) $value);

        if ($value === '') {
            return 0.0;
        }

        if (str_contains($value, ',')) {
            $value = str_replace(['.', ','], ['', '.'], $value);
        }

        return is_numeric($value) ? (float) $value : 0.0;
    }

    private static function cents(float $euros): int
    {
        return (int) round($euros * 100);
    }

    private static function vatCode(mixed $code): ?VatCode
    {
        return $code instanceof VatCode ? $code : VatCode::tryFrom((string) $code);
    }
}
