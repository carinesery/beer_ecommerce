<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->user()->id;

        // dd($userId);
        // Vérifiez si l'utilisateur est connecté
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à votre panier.');
        }
        $user = User::findOrFail($userId);
        // dd($user);
        $orders = $user->orders;
        // Vérifiez si l'utilisateur a des commandes
        if ($orders->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Votre panier est vide.');
        }
        // dd($orders);

        $orderItems = OrderItem::whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
        
        dd($orderItems);
        
        return view('cart/index',[
            'orders' => $orders,
            'orderItems' => $orderItems,
            'user' => $user,
        ]);
    
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
