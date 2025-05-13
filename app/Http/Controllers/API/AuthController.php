<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/** Le AuthController permet l'authentification d'un utilisateur à partir du front React */
/** Ce qu’il fait :
* - Gère la connexion de l'utilisateur.
* - Vérifie les identifiants (email + mot de passe).
* - Retourne un token Sanctum si l'authentification réussit. 
*/

class AuthController extends Controller
{
    public function login(Request $request) 
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('Trink')->plainTextToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Non autorisé'], 401);
    }
}
