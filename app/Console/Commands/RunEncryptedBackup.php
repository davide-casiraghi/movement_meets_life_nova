<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Runs the database backup only if the archive will be encrypted.
 * spatie/laravel-backup silently writes an unencrypted zip when no password is set:
 * with health data in the database that must never happen.
 */
class RunEncryptedBackup extends Command
{
    protected $signature = 'gestionale:backup';

    protected $description = 'Backup cifrato (AES-256) del database. Si rifiuta di partire senza BACKUP_ARCHIVE_PASSWORD.';

    public function handle(): int
    {
        $password = (string) config('backup.backup.password');

        if (strlen($password) < 20) {
            $this->error('BACKUP_ARCHIVE_PASSWORD mancante o più corta di 20 caratteri: backup non eseguito.');
            report(new \RuntimeException('Encrypted backup not run: BACKUP_ARCHIVE_PASSWORD missing or too short.'));

            return self::FAILURE;
        }

        if (in_array(config('backup.backup.encryption'), [null, false], true)) {
            $this->error('La cifratura dei backup è disattivata in config/backup.php: backup non eseguito.');

            return self::FAILURE;
        }

        return $this->call('backup:run', ['--only-db' => true]);
    }
}
