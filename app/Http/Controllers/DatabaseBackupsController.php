<?php

namespace App\Http\Controllers;

use App\Services\DatabaseBackupService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DatabaseBackupsController extends Controller
{
    private DatabaseBackupService $databaseBackupService;

    public function __construct(
        DatabaseBackupService $databaseBackupService
    ) {
        $this->databaseBackupService = $databaseBackupService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {
        $databaseBackupFiles = $this->databaseBackupService->getDbBackups();

        return view('dbBackupFiles.index', [
            'databaseBackupFiles' => $databaseBackupFiles,
        ]);
    }

    /**
     * Download db backup file.
     *
     * @param  string  $databaseBackupFileName
     */
    public function download(string $databaseBackupFileName)
    {
        $this->databaseBackupService->downloadDbBackupFile($databaseBackupFileName);

        /*return redirect()->route('databaseBackups.index')
            ->with('success', 'Database backups downloaded successfully');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $databaseBackupFileName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $databaseBackupFileName): RedirectResponse
    {
        $this->databaseBackupService->deleteDbBackup($databaseBackupFileName);

        return redirect()->route('databaseBackups.index')
            ->with('success', 'Database backups deleted successfully');
    }
}
