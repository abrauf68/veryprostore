<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    private function getCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $sessionId = session('cart_session_id');
            return Cart::firstOrCreate(['session_id' => $sessionId]);
        }
    }

    public function index()
    {
        $cart = $this->getCart()->load('items.product');
        $subtotal = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        $countries = Country::all();
        $paymentMethods = PaymentMethod::all();
        return view('frontend.pages.checkout', compact('cart', 'subtotal', 'countries','paymentMethods'));
    }
}
