<?php

namespace App\Models;

use App\Contracts\ContainsHealthData;
use App\Enums\IdentityDocumentType;
use App\Enums\RepresentativeRole;
use App\Models\Concerns\LogsDataAccess;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Legal representative of a patient (parent, guardian, ...). Linked to a
 * patient, so it reveals a health relationship: treated like the patient data.
 */
class PatientRepresentative extends Model implements ContainsHealthData
{
    use HasFactory;
    use LogsDataAccess;

    protected $fillable = [
        'role',
        'first_name',
        'last_name',
        'fiscal_code',
        'birth_date',
        'email',
        'mobile',
        'country',
        'address',
        'city',
        'province',
        'postal_code',
        'document_type',
        'document_number',
        'document_issued_by',
        'document_issued_at',
        'document_expires_at',
    ];

    protected $hidden = [
        'fiscal_code',
        'address',
        'document_number',
    ];

    protected function casts(): array
    {
        return [
            'role' => RepresentativeRole::class,
            'document_type' => IdentityDocumentType::class,
            'birth_date' => 'date',
            'document_issued_at' => 'date',
            'document_expires_at' => 'date',
            'fiscal_code' => 'encrypted',
            'address' => 'encrypted',
            'document_number' => 'encrypted',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(fn () => trim("{$this->first_name} {$this->last_name}"));
    }
}
