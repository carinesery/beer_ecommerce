<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    //
    public function downloadDataBase()
    {
    // Lance la sauvegarde
    Artisan::call('backup:run --only-db');

    // Récupère le dernier fichier de backup
    $disk = Storage::disk(config('config.backup.backup.destination.disks')[1]);
    $files = $disk->files('Laravel');
    $backupFile = collect($files)
        ->filter(fn($file) => str_ends_with($file, '.zip'))
        ->sort()
        ->last();

    if (!$backupFile) {
        abort(404, 'Aucune sauvegarde trouvée.');
    }

    // Télécharge le fichier
    return $disk->download($backupFile);
}
    public function dataBase()
    {
        // Logique pour afficher la page de téléchargement de la base de données
        // Vous pouvez renvoyer une vue ou un message indiquant que le téléchargement est en cours
        return view('data.index');
    }
}
