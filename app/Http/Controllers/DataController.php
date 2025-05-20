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
   
}
}
