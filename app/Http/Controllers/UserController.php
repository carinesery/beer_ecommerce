<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère les utilisateurs
         // Ajout d'une pagination. 20 livres par pages
         $users = User::paginate(9)->withQueryString();
          
        return view('users.index',['users'=> $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Gére l'autorisation de créer
        // Gate::authorize('createUser', User::class);

        return view('users.registration');

    }

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
    
        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'=> $request->role,
            'birthdate' => $request->birthdate,
        ]);

        // Redirection vers la liste des utilisateurs ou autre page souhaitée avec un message de succès
        return redirect()->route('admin.index')->with('success', 'Utilisateur créé avec succès !');

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show',[
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {   

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => 'required|string|in:customer,admin',
            'birthdate' => 'required|date',
    
        ]);

        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'role'=> $request->role,
            'birthdate' => $request->birthdate,
        ]);

        return redirect()->route('users.show', ['user'=>$user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {   
        $user->delete();
        return redirect()->route('users');
    }
}
