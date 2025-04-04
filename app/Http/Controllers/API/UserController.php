<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){

        // Validation des données
         $request->validate([
             'firstname' => 'required|string|max:255',
             'lastname' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'password' => 'required|string|max:255',
             'role' => 'required|string|in:customer',
             'birthdate' => 'required|date',

         ]);
     
         // Création de l'utilisateur (en utilisant l'assignation de masse)
     
         $user = User::create([
             'firstname' => $request->firstname,
             'lastname' => $request->lastname,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'role'=> $request->role,
             'birthdate' => $request->birthdate,
         ]);
     
         return response()->json($user, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
    
        ]);

        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);
        
        return response()->json($user, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // $user->delete(); Utiliser un update et le solfDelete. On ne supprime pas les données totalement pour la gestion des comptes comptables
        return response()->json(null, 204);
    }
}
