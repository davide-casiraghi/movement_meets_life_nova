<?php

namespace App\Models;

use App\Enums\VatCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Line of an invoice ("Trattamento"); the description is encrypted. */
class InvoiceItem extends Model
{
    protected $guarded = ['id'];

    protected $hidden = ['description'];

    protected function casts(): array
    {
        return [
            'description' => 'encrypted',
            'vat_code' => VatCode::class,
            'unit_price' => 'decimal:2',
            'quantity' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
