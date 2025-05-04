<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function cancel($orderId)
    {
        $order = Order::findOrFail($orderId);

        if (in_array($order->status, ['pending', 'completed'])) {
            $order->status = 'cancelled';
            $order->save();
        }

        return redirect()->route('admin-orders.index')->with('success', 'Commande annulée.');
    }

}
