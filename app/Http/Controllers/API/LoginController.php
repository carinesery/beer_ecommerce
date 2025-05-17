<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

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
    public function logout(Request $request)
    {
        // Supprime le token utilisé pour cette requête
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.'
        ], 200);
    }
}
