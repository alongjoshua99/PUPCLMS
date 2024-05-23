<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $path = 'Computer Laboratory AMS';
        $files = collect(Storage::disk('backup')->allFiles($path));
        // dd($files);
        $backups = $files->map(function ($file) use ($path) {
            return [
                'name' => basename($file),
                'path' => $file,
                'size' => Storage::disk('backup')->size($file) >= 1048576 ? round(Storage::disk('backup')->size($file) / 1024 / 1024, 2) . ' MB' : round(Storage::disk('backup')->size($file) / 1024, 2) . ' KB',
                'disk' => 'backup',
                'url' => Storage::disk('backup')->url($file),
                'created_at' => Storage::disk('backup')->lastModified($file),
            ];
        })->sortByDesc('created_at');

        return view('AMS.backend.admin-layouts.backups.index', compact('backups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $file_name = 'PUP-CLMS-BACKUP-' . Carbon::now()->format('Y-m-d') . '.zip';
        $command = 'backup:run';
        $arguments = ['--filename' => $file_name];

        //check if there is a backup already created
        if (Storage::disk('backup')->exists('Computer Laboratory AMS/' . $file_name)) {
            return redirect()->back()->with('error', 'Backup already created');
        }

        Artisan::call($command, $arguments);

        return redirect()->back()->with('success', 'Backup created successfully');
    }
    public function download(string $file_name)
    {
        return Storage::disk('backup')->download('Computer Laboratory AMS/' . $file_name);
    }
}
