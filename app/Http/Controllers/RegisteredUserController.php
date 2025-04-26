<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisteredUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
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

    public function destroy()
    {
        // Vérifier si l'utilisateur est authentifié
        $user = Auth::user();

        // Supprimer l'utilisateur
        $user->delete();

        // Déconnecter l'utilisateur après la suppression (facultatif)
        Auth::logout();

        // Rediriger vers la page d'accueil ou une autre page
        return redirect('/')->with('message', 'Votre compte a été supprimé.');
    }
}
