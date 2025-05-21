<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ... $roles): Response
    {
        // Vérifie si l'utilisateur est authentifié
        $user = $request->user();

        if (!$user) {
            // Si l'utilisateur n'est pas authentifié, redirige vers la page de connexion
            return redirect()->route('login');
        }

        // Vérifie si l'utilisateur a le rôle requis
        if (in_array($user->role, $roles)) {
            // Si l'utilisateur a le rôle requis, continue la requête
            return $next($request);
        }

        // Si l'utilisateur n'a pas le rôle requis, redirige vers une page d'erreur ou affiche un message
        return redirect()->route('homepage')->with('error', 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.');
    }
}
