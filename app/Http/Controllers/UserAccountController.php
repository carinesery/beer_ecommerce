<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisteredUserRequest;
use App\Http\Requests\UserAccountUpdateRequest;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends Controller
{
    public function create() 
    {
        return view('auth.register');
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
            return view('auth.show', compact('user')); 

        } else {

            return redirect()->route('login');

        }

    }

    public function edit()
    {
        if(Auth::check()) {
            $user = Auth::user(); 
            return view('auth.edit', compact('user'));
        } else {
            return redirect()->route('login');
        }
    }

    public function update(UserAccountUpdateRequest $useraccountupdaterequest)
    {
        $user = auth()->user();

        // Enregistrement 
        $data = $useraccountupdaterequest->validated();

        // (1) Enregistrement si l'email a été modifié
        if(array_key_exists('email', $data) && $data['email'] !== $user->email) {
            $user->email_verified_at = null;
            $user->fill($data);
            $user->save();
            $user->sendEmailVerificationNotification();

            return redirect()->route('verification.notice');
        }

        // (2) ENregistrement si l'email n'a pas été modifié 
        $user->update($data);

        // Redirection
        return redirect()->route('account.show')->with('success', 'Votre compte a été mis à jour.');
    }

    public function todestroy() {

        return view('auth.delete');
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
