<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.show');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
    $request->validate([
        'user_id' => 'required|numeric|exists:users,id',
        'total_price_without_tax' => 'required|numeric',
        'total_price_with_tax' => 'required|numeric',
        'tax_amount' => 'required|numeric',
        'status' => 'required|string|in:cart',
    ]);

    // Création de l'utilisateur (en utilisant l'assignation de masse)
   
    Order::create([
        'user_id' => $request->user_id,
        'total_price_without_tax' => $request->total_price_without_tax,
        'total_price_with_tax' =>$request-> total_price_with_tax,
        'tax_amount' => $request->tax_amount,
        'status' =>$request->status,
    ]);

    // Redirection vers la liste des utilisateurs ou autre page souhaitée avec un message de succès
    return redirect()->route('login')->with('success', 'Utilisateur créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
