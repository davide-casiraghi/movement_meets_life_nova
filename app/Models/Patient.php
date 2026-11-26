<?php

namespace App\Models;

use App\Contracts\ContainsHealthData;
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
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'phone',
        'fiscal_code',
        'address',
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
        'address',
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
            'birth_date' => 'date',
            'privacy_notice_signed_at' => 'datetime',
            'fiscal_code' => 'encrypted',
            'address' => 'encrypted',
            'occupation' => 'encrypted',
            'current_complaint' => 'encrypted',
            'medical_history' => 'encrypted',
            'medications' => 'encrypted',
            'allergies' => 'encrypted',
            'clinical_notes' => 'encrypted',
        ];
    }

    public function treatmentSessions(): HasMany
    {
        return $this->hasMany(TreatmentSession::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(fn () => trim("{$this->last_name} {$this->first_name}"));
    }
}
