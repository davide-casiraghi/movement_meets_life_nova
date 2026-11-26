<?php

namespace App\Models;

use App\Enums\VatCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A service of the price list (listino prezzi). "price" is the taxable amount (imponibile).
 */
class Service extends Model
{
    use HasFactory;

    /** Preset colours offered in the form ("Colore 1" ... "Colore 12"). */
    public const COLORS = [
        '#A8B8F8',
        '#8FE3C0',
        '#D4B0F8',
        '#F08C7C',
        '#F5D76E',
        '#F4B87E',
        '#76D3D8',
        '#E0E0E0',
        '#5B82E6',
        '#6AB04C',
        '#C8372D',
        '#9B6B4E',
    ];

    protected $fillable = [
        'name',
        'code',
        'color',
        'description',
        'duration_minutes',
        'vat_code',
        'price',
        'archived_at',
    ];

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'vat_code' => VatCode::class,
            'price' => 'decimal:2',
            'archived_at' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('archived_at');
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->whereNotNull('archived_at');
    }

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    public function archive(): void
    {
        $this->update(['archived_at' => now()]);
    }

    public function unarchive(): void
    {
        $this->update(['archived_at' => null]);
    }
}
