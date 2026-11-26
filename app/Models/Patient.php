<?php

namespace App\Models;

use App\Contracts\ContainsHealthData;
use App\Enums\PersonType;
use App\Enums\Sex;
use App\Models\Concerns\LogsDataAccess;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model implements ContainsHealthData
{
    use HasFactory;
    use LogsDataAccess;
    use SoftDeletes;

    protected $fillable = [
        'person_type',
        'first_name',
        'last_name',
        'nationality',
        'sex',
        'birth_date',
        'birth_city',
        'birth_province',
        'fiscal_code',
        'vat_number',
        'recipient_code',
        'notes',
        'email',
        'mobile',
        'phone',
        'pec',
        'address_country',
        'address',
        'city',
        'province',
        'postal_code',
        'id_card_number',
        'health_card_number',
        'ts_transmission',
        'occupation',
        'current_complaint',
        'medical_history',
        'medications',
        'allergies',
        'clinical_notes',
        'privacy_notice_signed_at',
    ];

    /** Never serialize the encrypted fields by accident (JSON, logs, dumps). */
    protected $hidden = [
        'fiscal_code',
        'notes',
        'address',
        'id_card_number',
        'health_card_number',
        'occupation',
        'current_complaint',
        'medical_history',
        'medications',
        'allergies',
        'clinical_notes',
    ];

    protected function casts(): array
    {
        return [
            'person_type' => PersonType::class,
            'sex' => Sex::class,
            'birth_date' => 'date',
            'ts_transmission' => 'boolean',
            'privacy_notice_signed_at' => 'datetime',
            'fiscal_code' => 'encrypted',
            'notes' => 'encrypted',
            'address' => 'encrypted',
            'id_card_number' => 'encrypted',
            'health_card_number' => 'encrypted',
            'occupation' => 'encrypted',
            'current_complaint' => 'encrypted',
            'medical_history' => 'encrypted',
            'medications' => 'encrypted',
            'allergies' => 'encrypted',
            'clinical_notes' => 'encrypted',
        ];
    }

    protected $attributes = [
        'person_type' => 'individual',
        'nationality' => 'IT',
        'address_country' => 'IT',
        'ts_transmission' => true,
    ];

    public function treatmentSessions(): HasMany
    {
        return $this->hasMany(TreatmentSession::class);
    }

    public function representatives(): HasMany
    {
        return $this->hasMany(PatientRepresentative::class);
    }

    public function isCompany(): bool
    {
        return $this->person_type === PersonType::Company;
    }

    protected function fullName(): Attribute
    {
        // For a company, last_name holds the company name.
        return Attribute::get(fn () => trim("{$this->last_name} {$this->first_name}"));
    }
}
