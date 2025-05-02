<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    
    public function login(){
        // dd('ok');

        // return view('auth.login');
    }

    // Cette fonction gère l'authentification de l'utilisateur lorsqu'il soumet le formulaire de connexion.
    public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required','email'],
        'password' => ['required'],
    ]);

    if (! Auth::attempt($credentials)) {
        return response()->json([
            'message' => "Identifiants incorrects."
        ], 401);
    }

    $user = Auth::user();

    if (is_null($user->email_verified_at)) {
        Auth::logout();
        return response()->json([
            'message' => "Vérifiez votre e‑mail avant de vous connecter."
        ], 403);
    }

    // Création du token
    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'message' => "Authentification réussie.",
        'user'    => $user,
        'token'   => $token,
    ], 200);
}


    // Cette fonction déconnecte l'utilisateur.
    public function logout(Request $request): RedirectResponse
    {
        // Déconnecte l'utilisateur.
        Auth::logout();
        // Invalidate la session : Supprime toutes les données de session de l'utilisateur.
        // Régénère le token CSRF pour éviter des attaques de type CSRF.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirige l'utilisateur vers la page d'accueil (/)
        return redirect('http://localhost:5174');
    }
}
