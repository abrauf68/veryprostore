<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $currentUser = User::findOrFail(auth()->user()->id);
            if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
                $orders = Order::whereHas('orderItems.product', function($q) use ($currentUser) {
                    $q->where('vendor_id', $currentUser->id);
                })->with(['orderItems.product', 'billing'])->get();

                $products = Product::with('vendor', 'category')
                    ->where('vendor_id', $currentUser->id)
                    ->where('is_active', 'active')
                    ->get();

                $popularProducts = DB::table('products')
                    ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                    ->select(
                        'products.id',
                        'products.name',
                        'products.sku',
                        'products.main_image',
                        'products.price',
                        DB::raw('COALESCE(COUNT(order_items.id), 0) as order_count')
                    )
                    ->where('products.vendor_id', $currentUser->id)
                    ->groupBy('products.id', 'products.name','products.sku','products.main_image','products.price')
                    ->orderByDesc('order_count')
                    ->limit(3)
                    ->get();
            }else{
                $orders = Order::with(['orderItems.product', 'billing'])->get();
                $products = Product::with('vendor', 'category')
                    ->where('is_active', 'active')
                    ->get();

                $popularProducts = DB::table('products')
                    ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                    ->select(
                        'products.id',
                        'products.name',
                        'products.sku',
                        'products.main_image',
                        'products.price',
                        DB::raw('COALESCE(COUNT(order_items.id), 0) as order_count')
                    )
                    ->groupBy('products.id', 'products.name','products.sku','products.main_image','products.price')
                    ->orderByDesc('order_count')
                    ->limit(3)
                    ->get();
            }
            $totalOrders = $orders->count();
            $pendingOrders = $orders->where('status','pending')->count();
            $paidOrders = $orders->where('status','paid')->count();
            $shippedOrders = $orders->where('status','shipped')->count();
            $completedOrders = $orders->where('status','completed')->count();
            $cancelledOrders = $orders->where('status','cancelled')->count();
            $totalRevenue = $orders->sum('total');
            $totalProducts = $products->count();
            // dd($popularProducts);
            return view('dashboard.index', compact(
            'orders','totalOrders','totalProducts','totalRevenue','popularProducts'
        ));
        } catch (\Throwable $th) {
            Log::error('Dashboard Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
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
