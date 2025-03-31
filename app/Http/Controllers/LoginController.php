<?php
namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

// Ce code est le LoginController qui gère 
// l'authentification des utilisateurs (connexion et déconnexion). Voici une explication détaillée :

class LoginController extends Controller
{
    // Cette fonction renvoie la vue auth.login, qui est probablement un formulaire de connexion (login.blade.php).
    // Elle est appelée lorsqu'un utilisateur veut accéder à la page de connexion.
    public function login(){

        return view('auth.login');
    }

    // Cette fonction gère l'authentification de l'utilisateur lorsqu'il soumet le formulaire de connexion.
    public function authenticate(Request $request): RedirectResponse
    {
        // Vérifie que :
        //     L’email est requis et a un format valide.
        //     Le mot de passe est requis
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 

        // Si la connexion réussit :
        //         La session est régénérée ($request->session()->regenerate();) pour éviter les attaques de fixation de session.
                // L'utilisateur est redirigé vers la page dashboard ou vers la dernière page qu'il voulait visiter (intended()).
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }
        
        // Si l'authentification échoue :
        //     L'utilisateur est renvoyé sur la page de connexion (back()).
        //     Un message d’erreur s'affiche.
        //     Le champ email est pré-rempli avec l’entrée précédente (onlyInput('email')).
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
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
        return redirect('/');
    }

    public function registration() {

        return view('auth.registration');

    }

    public function register(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'date' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

}
