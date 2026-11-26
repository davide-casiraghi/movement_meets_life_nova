<?php

namespace App\Models;

use App\Contracts\ContainsHealthData;
use App\Enums\AppointmentStatus;
use App\Enums\AppointmentType;
use App\Models\Concerns\LogsDataAccess;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A calendar event. Linked to a patient it reveals that the person is treated,
 * so it is handled as health data (policy, access log, encrypted notes).
 */
class Appointment extends Model implements ContainsHealthData
{
    use HasFactory;
    use LogsDataAccess;
    use SoftDeletes;

    protected $fillable = [
        'type',
        'status',
        'patient_id',
        'service_id',
        'user_id',
        'title',
        'price',
        'color',
        'starts_at',
        'ends_at',
        'address',
        'notes',
        'recurrence_group',
    ];

    protected $hidden = ['notes'];

    protected function casts(): array
    {
        return [
            'type' => AppointmentType::class,
            'status' => AppointmentStatus::class,
            'price' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'notes' => 'encrypted',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Events that overlap the [from, to) interval. */
    public function scopeOverlapping(Builder $query, CarbonInterface $from, CarbonInterface $to): Builder
    {
        return $query->where('starts_at', '<', $to)->where('ends_at', '>', $from);
    }

    /** Events that occupy the professional's time (everything except cancelled ones). */
    public function scopeBlockingTime(Builder $query): Builder
    {
        return $query->where('status', '!=', AppointmentStatus::Cancelled->value);
    }
}
