<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    public function index()
    {
        // Logique pour afficher la page d'accueil ou d'autres informations
        return view('admin.data.index');
    }

    public function downloadDataBase(){
    // Lance la sauvegarde
    Artisan::call('backup:run --only-db');
    // dd(Artisan::call('backup:run --only-db'));

    // Récupère le dernier fichier de backup
    $disk = Storage::disk('local');
    // dd($disk);

    $files = $disk->files('backups');
    // dd($files);

    $backupFile = collect($files)
        ->filter(fn($file) => str_ends_with($file, '.zip'))
        ->sort()
        ->last();
    dd("Téléchargement de la base de données ", $files, $backupFile);


    if (!$backupFile) {
        abort(404, 'Aucune sauvegarde trouvée.');
    }
    // dd('Téléchargement de la base de données terminé');


    // Télécharge le fichier
    return view('admin.data.downloadDB', ['file' => $disk->download($backupFile)]);
}
}
