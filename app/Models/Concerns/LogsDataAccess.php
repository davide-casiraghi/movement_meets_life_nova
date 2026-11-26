<?php

namespace App\Models\Concerns;

use App\Models\AccessLog;

/**
 * Writes an access log entry every time a record is created, changed, trashed,
 * restored or permanently deleted. Only the names of the changed fields are
 * stored, never their values.
 */
trait LogsDataAccess
{
    protected static function bootLogsDataAccess(): void
    {
        static::created(fn ($model) => AccessLog::record('created', $model));

        static::updated(function ($model) {
            $fields = array_values(array_diff(
                array_keys($model->getChanges()),
                ['updated_at', 'deleted_at']
            ));

            if ($fields !== []) {
                AccessLog::record('updated', $model, ['fields' => $fields]);
            }
        });

        static::deleted(function ($model) {
            AccessLog::record($model->isForceDeleting() ? 'force_deleted' : 'deleted', $model);
        });

        static::restored(fn ($model) => AccessLog::record('restored', $model));
    }

    public function logView(): void
    {
        AccessLog::record('viewed', $this);
    }
}
