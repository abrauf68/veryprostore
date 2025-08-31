<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    public function index()
    {
        $this->authorize('view wallet');
        try {
            $currentUser = User::findOrFail(auth()->user()->id);

            if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
                $orders = Order::whereHas('orderItems.product', function ($q) use ($currentUser) {
                    $q->where('vendor_id', $currentUser->id);
                })->with(['orderItems.product', 'paymentMethod', 'billing'])->get();
            } else {
                $orders = Order::with('orderItems.product', 'paymentMethod', 'billing')->get();
            }

            // initialize
            $totalCost = 0;
            $totalProfit = 0;
            $pendingAmount = 0;
            $totalWithdrawn = 0; // as per your requirement, always 0 for now

            foreach ($orders as $order) {
                foreach ($order->orderItems as $item) {
                    $product = $item->product;
                    if (!$product) continue;

                    // total cost = price * qty
                    $totalCost += $product->price * $item->quantity;

                    // check order status
                    if ($order->status === 'completed') {
                        $totalProfit += $product->profit * $item->quantity;
                    } elseif (!in_array($order->status, ['cancelled'])) {
                        $pendingAmount += $product->profit * $item->quantity;
                    }
                }
            }

            return view('dashboard.wallet.index', compact(
                'orders',
                'totalCost',
                'totalProfit',
                'pendingAmount',
                'totalWithdrawn'
            ));
        } catch (\Throwable $th) {
            Log::error('wallet Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }
}
