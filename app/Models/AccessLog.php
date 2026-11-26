<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use LogicException;

/**
 * Append-only audit trail of the accesses to health data and of the logins.
 */
class AccessLog extends Model
{
    use MassPrunable;

    public const UPDATED_AT = null;

    public const EVENT_LABELS = [
        'login' => 'Accesso',
        'login_failed' => 'Accesso fallito',
        'logout' => 'Uscita',
        'viewed' => 'Visualizzato',
        'created' => 'Creato',
        'updated' => 'Modificato',
        'deleted' => 'Cestinato',
        'restored' => 'Ripristinato',
        'force_deleted' => 'Eliminato definitivamente',
    ];

    /** How long the audit trail is kept. */
    public const RETENTION_MONTHS = 24;

    protected $fillable = [
        'user_id',
        'event',
        'subject_type',
        'subject_id',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    protected static function booted(): void
    {
        // A log entry can never be changed or removed by the application,
        // except by the scheduled pruning of entries older than the retention period.
        static::updating(fn () => throw new LogicException('Access logs are append-only.'));
        static::deleting(fn () => throw new LogicException('Access logs are append-only.'));
    }

    /**
     * Records an event for the current request.
     */
    public static function record(string $event, ?Model $subject = null, array $properties = [], ?int $userId = null): self
    {
        $request = request();

        return static::create([
            'user_id' => $userId ?? auth()->id(),
            'event' => $event,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'properties' => $properties ?: null,
            'ip_address' => $request?->ip(),
            'user_agent' => $request ? substr((string) $request->userAgent(), 0, 512) : null,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo()->withTrashed();
    }

    public function prunable(): Builder
    {
        return static::where('created_at', '<', now()->subMonths(self::RETENTION_MONTHS));
    }
}
