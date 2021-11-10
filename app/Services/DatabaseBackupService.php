<?php

namespace App\Services;

use App\Repositories\DatabaseBackupRepository;

class DatabaseBackupService
{
    private DatabaseBackupRepository $databaseBackupRepository;

    /**
     * TagService constructor.
     *
     * @param  DatabaseBackupRepository  $databaseBackupRepository
     */
    public function __construct(
        DatabaseBackupRepository $databaseBackupRepository
    ) {
        $this->databaseBackupRepository = $databaseBackupRepository;
    }

    /**
     * Get all the db backup file names
     *
     * @return array
     */
    public function getDbBackups(): array
    {
        return $this->databaseBackupRepository->getAll();
    }

    /**
     * Download the db backup file
     *
     * @param  string  $fileName
     */
    public function downloadDbBackupFile(string $fileName): void
    {
        $this->databaseBackupRepository->downloadFile($fileName);
    }

    /**
     * Delete the db backup file
     *
     * @param  string  $fileName
     */
    public function deleteDbBackup(string $fileName): void
    {
        $this->databaseBackupRepository->delete($fileName);
    }
}
