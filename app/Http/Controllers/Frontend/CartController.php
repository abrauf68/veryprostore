<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
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
        return view('frontend.pages.cart.index', compact('cart', 'subtotal'));
    }

    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity'   => 'required|integer|min:1',
            ]);

            $cart = $this->getCart();

            // Check if product already in cart
            $product = Product::findOrFail($request->product_id);
            $item = $cart->items()->where('product_id', $request->product_id)->first();

            if ($item) {
                $item->increment('quantity', $request->quantity);
                $item->update(['price' => $product->price ? $product->price * $item->quantity : 0]);
            } else {
                $cart->items()->create([
                    'product_id' => $request->product_id,
                    'quantity'   => $request->quantity,
                    'price'      => $product->price ? $product->price * $request->quantity : 0, // optional if you store price
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
            ], 200);
        } catch (\Throwable $th) {
            Log::error('add to cart Failed', ['error' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! Please try again later',
            ], 500);
            throw $th;
        }
    }

    public function update(Request $request)
    {
        $cart = $this->getCart()->load('items.product');

        foreach ($request->items as $itemId => $data) {
            $cartItem = $cart->items->where('id', $itemId)->first();
            if ($cartItem) {
                $cartItem->quantity = max(1, (int) $data['quantity']); // at least 1
                $cartItem->price = $cartItem->quantity * $cartItem->product->price;
                $cartItem->save();
            }
        }

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function remove($id)
    {
        $cart = $this->getCart();
        $item = $cart->items()->where('id', $id)->firstOrFail();
        $item->delete();

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function clearCart()
    {
        $cart = $this->getCart();
        $cart->items()->delete();

        return redirect()->back()->with('success', 'Cart has been cleared!');
    }
}
