<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'address_line1' => 'required|string|max:1000',
            'address_line2' => 'required|string|max:1000',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email',
            'notes' => 'required|string|max:1000',
            'subtotal' => 'required',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $order = new Order();
            if (Auth::check()) {
                $currentUser = Auth::user();
                $order->user_id = $currentUser->id;
            }
            $order->session_id = session('cart_session_id');
            $order->subtotal = $request->subtotal;
            $order->total = $request->subtotal;
            $order->notes = $request->notes;
            $order->payment_method_id = $request->payment_method_id;
            $order->order_no = 'ORD-' . time();
            $order->save();

            $cart = $this->getCart()->load('items.product');
            foreach ($cart->items as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->product_id;
                $orderItem->quantity = $item->quantity;
                $orderItem->price = $item->product->price;
                $orderItem->total = $item->product->price * $item->quantity;
                $orderItem->save();
            }

            $billing = new Billing();
            $billing->order_id = $order->id;
            $billing->first_name = $request->first_name;
            $billing->last_name = $request->last_name;
            $billing->company_name = $request->company_name;
            $billing->country = $request->country;
            $billing->address_line1 = $request->address_line1;
            $billing->address_line2 = $request->address_line2;
            $billing->city = $request->city;
            $billing->zip = $request->zip;
            $billing->state = $request->state;
            $billing->phone = $request->phone;
            $billing->email = $request->email;
            $billing->save();

            DB::commit();
            return redirect()->route('frontend.order.confirm', $order->order_no)->with('success', 'Your order has been received successfully');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            Log::error('Order store Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    public function orderConfirmation($order_no)
    {
        $order = Order::with('orderItems.product', 'paymentMethod', 'billing')->where('order_no', $order_no)->firstOrFail();
        return view('frontend.pages.order-confirmation', compact('order'));
    }
}
