<?php

namespace Tests\Unit;

use App\Services\Gestionale\InvoiceCalculator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class InvoiceCalculatorTest extends TestCase
{
    #[Test]
    public function flatRateWithRivalsaIncludedAndStamp(): void
    {
        // 2 sessions at 50 € in "regime forfettario", INPS 4% included in the price, stamp charged to the patient.
        $amounts = InvoiceCalculator::calculate(
            [['unit_price' => '50,00', 'quantity' => '2', 'discount' => '0', 'vat_code' => 'N2.2']],
            ['contribution_enabled' => true, 'contribution_rate' => 4, 'contribution_included' => true, 'stamp_enabled' => true, 'stamp_amount' => '2'],
        );

        $this->assertSame([100.0], $amounts['lines']);
        $this->assertSame(96.15, $amounts['taxable_amount']);
        $this->assertSame(3.85, $amounts['contribution_amount']);
        $this->assertSame(0.0, $amounts['vat_amount']);
        $this->assertSame(100.0, $amounts['untaxed_amount']);
        $this->assertSame(102.0, $amounts['total']);
        $this->assertSame(102.0, $amounts['net_due']);
    }

    #[Test]
    public function ordinaryRegimeWithVatDiscountAndWithholding(): void
    {
        // 100 € less 10%, rivalsa INPS 4% on top, VAT 22% on fee + rivalsa, withholding 20% on fee + rivalsa.
        $amounts = InvoiceCalculator::calculate(
            [['unit_price' => '100', 'quantity' => 1, 'discount' => '10', 'vat_code' => '22']],
            ['contribution_enabled' => true, 'contribution_rate' => 4, 'pension_fund' => 'inps_separate', 'withholding_enabled' => true, 'withholding_rate' => 20],
        );

        $this->assertSame(90.0, $amounts['taxable_amount']);
        $this->assertSame(3.6, $amounts['contribution_amount']);
        $this->assertSame(20.59, $amounts['vat_amount']);
        $this->assertSame(114.19, $amounts['total']);
        $this->assertSame(18.72, $amounts['withholding_amount']);
        $this->assertSame(95.47, $amounts['net_due']);
    }

    #[Test]
    public function stampPaidByTheIssuerAndProfessionalFundsAreNotWithheld(): void
    {
        $amounts = InvoiceCalculator::calculate(
            [['unit_price' => '80', 'quantity' => 1, 'vat_code' => 'N4']],
            ['contribution_enabled' => true, 'contribution_rate' => 2, 'pension_fund' => 'enpap', 'stamp_enabled' => true, 'stamp_amount' => 2, 'stamp_charged_to_issuer' => true, 'withholding_enabled' => true, 'withholding_rate' => 20],
        );

        $this->assertSame(0.0, $amounts['stamp_charged']);
        $this->assertSame(81.6, $amounts['total']);
        $this->assertSame(16.0, $amounts['withholding_amount']);
    }

    #[Test]
    public function italianNumbersAreParsed(): void
    {
        $this->assertSame(1234.5, InvoiceCalculator::number('1.234,50'));
        $this->assertSame(50.5, InvoiceCalculator::number('50,5'));
        $this->assertSame(12.0, InvoiceCalculator::number('12'));
        $this->assertSame(0.0, InvoiceCalculator::number(''));
    }
}
