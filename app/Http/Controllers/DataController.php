<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index()
    {
        // Logique pour afficher la page d'accueil ou d'autres informations
        return view('admin.data.index');
    }

    public function downloadDataBase(){
    // Vérifiez si le répertoire de sauvegarde existe, sinon créez-le
    if (!file_exists(storage_path('app/backups'))) {
        mkdir(storage_path('app/backups'), 0755, true);
    }
    // Récupérez les informations de connexion à la base de données
    $db = config('database.connections.mysql.database');
    $user = config('database.connections.mysql.username');
    $pass = config('database.connections.mysql.password');
    $host = config('database.connections.mysql.host');
    $port = config('database.connections.mysql.port', 3306);

    $filename = 'dump_' . date('Ymd_His') . '.sql';
    $path = storage_path('app/backups/' . $filename);

    $command = sprintf(
        '"%s" -h%s -P%s -u%s %s %s > "%s"',
        'C:\xampp\mysql\bin\mysqldump.exe', // adapte le chemin si besoin
        $host,
        $port,
        $user,
        $pass ? '-p' . $pass : '',
        $db,
        $path
    );

    $result = null;
    $output = null;
    exec($command, $output, $result);

    if ($result !== 0) {
        return response()->json(['error' => 'Dump failed', 'cmd' => $command], 500);
    }

    return response()->download($path)->deleteFileAfterSend(true);
   
}
}
