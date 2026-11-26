<?php

namespace App\Models;

use App\Contracts\ContainsHealthData;
use App\Models\Concerns\LogsDataAccess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentSession extends Model implements ContainsHealthData
{
    use HasFactory;
    use LogsDataAccess;
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'performed_at',
        'duration_minutes',
        'pain_before',
        'pain_after',
        'assessment',
        'treatment',
        'home_exercises',
        'notes',
    ];

    protected $hidden = [
        'pain_before',
        'pain_after',
        'assessment',
        'treatment',
        'home_exercises',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'performed_at' => 'datetime',
            'duration_minutes' => 'integer',
            'pain_before' => 'encrypted',
            'pain_after' => 'encrypted',
            'assessment' => 'encrypted',
            'treatment' => 'encrypted',
            'home_exercises' => 'encrypted',
            'notes' => 'encrypted',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }
}
