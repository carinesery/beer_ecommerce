<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisteredUserRequest;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends Controller
{
    public function create() 
    {
        return view('/auth/register');
    }

    public function store (RegisteredUserRequest $registeredUserRequest)
    {

        $user = User::create([
            ...$registeredUserRequest->validated(),
            'role' => 'customer',
        ]);

        // Après avoir créé l'utilisateur
        Auth::login($user); // Tu connectes ton utilisateur

        return redirect()->route('verification.notice');

    }

    public function show()
    {   
        if (Auth::check()) {
            // L'utilisateur est authentifié
            $user = Auth::user();  // Récupère l'utilisateur authentifié
            return view('/auth/show', compact('user')); 

        } else {

            return redirect()->route('login');

        }

    }

    public function edit()
    {

    }

    public function update()
    {
        
    }

    public function todestroy() {

        return view('auth/delete');
    }

    public function destroy()
    {
        // Vérifier si l'utilisateur est authentifié
        $user = Auth::user();

        if ($user) {
            $user->delete();  // Effectue une suppression douce (SoftDelete)
            Auth::logout();  // Déconnecte l'utilisateur
            return redirect('/')->with('message', 'Votre compte a été supprimé.');
        } else {
            return redirect()->route('home')->with('error', 'Utilisateur non trouvé.');
        }
    }
}
