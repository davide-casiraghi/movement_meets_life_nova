<?php

namespace App\Models;

use App\Contracts\ContainsHealthData;
use App\Enums\InvoiceType;
use App\Enums\PaymentMethod;
use App\Enums\PensionFund;
use App\Enums\TaxRegime;
use App\Enums\WithholdingReason;
use App\Enums\WithholdingType;
use App\Models\Concerns\LogsDataAccess;
use App\Services\Gestionale\InvoiceCalculator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Invoice issued to a patient. It shows which treatment the patient received,
 * so it is handled as health data (encrypted texts, access log, physiotherapists only).
 */
class Invoice extends Model implements ContainsHealthData
{
    use HasFactory;
    use LogsDataAccess;

    protected $guarded = ['id'];

    protected $hidden = ['customer', 'causals', 'notes'];

    protected function casts(): array
    {
        return [
            'type' => InvoiceType::class,
            'payment_method' => PaymentMethod::class,
            'tax_regime' => TaxRegime::class,
            'pension_fund' => PensionFund::class,
            'withholding_type' => WithholdingType::class,
            'withholding_reason' => WithholdingReason::class,
            'withholding_base' => 'decimal:2',
            'issued_on' => 'date',
            'paid_on' => 'date',
            'due_on' => 'date',
            'paid' => 'boolean',
            'contribution_enabled' => 'boolean',
            'contribution_included' => 'boolean',
            'stamp_enabled' => 'boolean',
            'stamp_charged_to_issuer' => 'boolean',
            'stamp_virtual' => 'boolean',
            'withholding_enabled' => 'boolean',
            'contribution_rate' => 'decimal:2',
            'stamp_amount' => 'decimal:2',
            'withholding_rate' => 'decimal:2',
            'taxable_amount' => 'decimal:2',
            'contribution_amount' => 'decimal:2',
            'vat_amount' => 'decimal:2',
            'stamp_charged' => 'decimal:2',
            'total' => 'decimal:2',
            'withholding_amount' => 'decimal:2',
            'net_due' => 'decimal:2',
            'customer' => 'encrypted:array',
            'causals' => 'encrypted:array',
            'notes' => 'encrypted',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('position');
    }

    public function scopeIssuedIn(Builder $query, int $year, ?int $month = null): Builder
    {
        $query->where('year', $year);

        if ($month) {
            $query->whereMonth('issued_on', $month);
        }

        return $query;
    }

    /** First free number for the year: invoices and credit notes share one sequence. */
    public static function nextNumber(int $year): int
    {
        return (int) static::query()->where('year', $year)->max('number') + 1;
    }

    /** "1/2026" */
    protected function displayNumber(): Attribute
    {
        return Attribute::get(fn () => "{$this->number}/{$this->year}");
    }

    /** Recomputes and stores the totals from the saved lines. */
    public function recalculate(): void
    {
        $items = $this->items()->get();
        $amounts = InvoiceCalculator::calculate(
            $items->map(fn (InvoiceItem $item) => [
                'unit_price' => (float) $item->unit_price,
                'quantity' => (float) $item->quantity,
                'discount' => (float) $item->discount,
                'vat_code' => $item->vat_code,
            ])->all(),
            $this->attributesToArray(),
        );

        foreach ($items as $index => $item) {
            $item->updateQuietly(['total' => $amounts['lines'][$index]]);
        }

        $this->updateQuietly(collect($amounts)->only([
            'taxable_amount', 'contribution_amount', 'vat_amount', 'stamp_charged', 'total', 'withholding_amount', 'net_due',
        ])->all());
    }
}
