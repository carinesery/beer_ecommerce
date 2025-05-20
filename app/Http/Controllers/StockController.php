<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductVariant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
     public function index()
    {
        // Récupérer les total des ventes
        $totalSales = Order::where('status', 'completed')->sum('total_price_without_tax');

        //Récupérer les ventes par mois
        $salesMonth = Order::where('status', 'completed')
        ->selectRaw('MONTH(created_at) as mois, SUM(total_price_without_tax) as total')
        ->groupByRaw('MONTH(created_at)')
        ->get();

        //Récupérer les top 10 produits les plus vendus
        // $topProducts = Order::where('status', 'completed')
        // ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        // ->selectRaw('products.name, SUM(order_items.quantity) as total_quantity')
        // ->groupBy('products.id')
        // ->orderByDesc('total_quantity')
        // ->limit(10)
        // ->get();

        // Si méthode ci-dessus ne fonction pas, essayer celle-ci
        $topProducts = DB::table('order_items')
         ->select('product_variant_id', DB::raw('SUM(quantity) as total_vendus'))
         ->groupBy('product_variant_id')
         ->orderByDesc('total_vendus')
         ->take(10)
         ->get();

        // $stocksFaibles = ProductVariant::where('stock_quantity', '<', 10)->get();
        $lowStocks = ProductVariant::with('product')->where('stock_quantity', '<', 10)->get();

        return view('admin.data.index', compact('lowStocks', 'totalSales', 'salesMonth', 'topProducts'));
    }
}
