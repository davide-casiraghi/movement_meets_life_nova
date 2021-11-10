<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DatabaseBackupRepository
{

    /**
     * Get all backup files from /storage/app/Laravel.
     *
     * @return array
     */
    public function getAll(): array
    {
        $fileNames = Storage::files(env('APP_NAME'));
        $backupFileNames = [];
        foreach($fileNames as $fileName){
            if (str_ends_with($fileName, '.zip')) {
                $backupFileNames[] = substr($fileName, strrpos($fileName, '/' )+1);
            }
        }

        return $backupFileNames;
    }

    /**
     * Download db backup file
     *
     * @param $file_name
     */
    function downloadFile(string $file_name)
    {
        //return Storage::download('Laravel/'.$file_name);

        $path = env('APP_NAME').'/'.$file_name;
        $zipNewName = $file_name;
        $headers = ['Content-Type: application/octet-stream'];
        //$headers = ["Content-Type"=>"application/zip"];
        return Storage::download($path, $zipNewName, $headers);

        //return response()->download(storage_path('/app/Laravel/'. $file_name));
    }

    /**
     * Delete db backup file
     *
     * @param  string  $file_name
     * @return void
     */
    public function delete(string $file_name): void
    {
        Storage::delete(env('APP_NAME').'/'.$file_name);
    }
}
