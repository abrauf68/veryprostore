<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view order');
        try {
            $currentUser = User::findOrFail(auth()->user()->id);
            if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
                $orders = Order::whereHas('orderItems.product', function ($q) use ($currentUser) {
                    $q->where('vendor_id', $currentUser->id);
                })->with(['orderItems.product', 'paymentMethod', 'billing'])->latest()->get();
            } else {
                $orders = Order::with('orderItems', 'paymentMethod', 'billing')->latest()->get();
            }
            return view('dashboard.orders.index', compact('orders'));
        } catch (\Throwable $th) {
            Log::error('Order Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create order');
        try {
            $countries = Country::all();
            $vendors = User::whereHas('roles', function ($query) {
                $query->where('name', 'vendor');
            })->with('userShop', 'products')->get();
            return view('dashboard.orders.create', compact('vendors', 'countries'));
        } catch (\Throwable $th) {
            Log::error('Order Create Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'address_line1' => 'required|string|max:1000',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email',
            'notes' => 'nullable|string|max:1000',
            'subtotal' => 'required',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'numeric|min:0',
            // 'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $order = new Order();
            $order->subtotal = $request->subtotal;
            $order->total = $request->subtotal;
            $order->notes = $request->notes;
            $order->payment_method_id = 3;
            $order->order_no = 'ORD-' . time();
            $order->save();

            $vendorIds = [];

            if (isset($request->products) && count($request->products) > 0) {
                foreach ($request->products as $key => $product_id) {
                    $product = Product::find($product_id);
                    if (!$product) {
                        return redirect()->back()->with('error', 'Product not found');
                    }
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $product_id;
                    $orderItem->quantity = $request->quantities[$key];
                    $orderItem->price = $product->price;
                    $orderItem->total = $product->price * $request->quantities[$key];
                    $orderItem->save();

                    // Collect vendor IDs
                    if ($product->vendor_id) {
                        $vendorIds[] = $product->vendor_id;
                    }
                }
            }

            $billing = new Billing();
            $billing->order_id = $order->id;
            $billing->first_name = $request->first_name;
            $billing->last_name = $request->last_name;
            $billing->company_name = $request->company_name;
            $billing->country = $request->country;
            $billing->address_line1 = $request->address_line1;
            $billing->address_line2 = null;
            $billing->city = $request->city;
            $billing->zip = $request->zip;
            $billing->state = $request->state;
            $billing->phone = $request->phone;
            $billing->email = $request->email;
            $billing->save();

            // 🔥 Notify all admins and super-admins except current user
            $adminUsers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'super-admin']);
            })->where('id', '!=', auth()->id()) // Exclude current user
                ->get();

            if ($adminUsers->count() > 0) {
                app('notificationService')->notifyUsers(
                    $adminUsers,
                    'A new Order #' . $order->order_no . ' has been created by ' . auth()->user()->name . '. Click to check details.',
                    'orders',
                    $order->id
                );
            }

            // 🔥 Notify Vendors (only those whose products were ordered)
            if (!empty($vendorIds)) {
                $vendors = User::whereIn('id', array_unique($vendorIds))->get();

                foreach ($vendors as $vendor) {
                    app('notificationService')->notifyUsers(
                        collect([$vendor]),
                        'You have received a new Order #' . $order->order_no . '. Click to check details.',
                        'orders',
                        $order->id
                    );
                }
            }

            DB::commit();
            return redirect()->route('dashboard.orders.index')->with('success', 'Order created successfully');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            Log::error('Order store Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('view order');
        try {
            $order = Order::with('orderItems.product', 'paymentMethod', 'billing')->findOrFail($id);
            return view('dashboard.orders.show', compact('order'));
        } catch (\Throwable $th) {
            Log::error('Order Show Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
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
        $this->authorize('update order');
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();

            $order = Order::findOrFail($request->order_id);
            $order->status = $request->status;
            $order->save();

            DB::commit();
            return redirect()->route('dashboard.orders.index')->with('success', 'Order status Updated successfully');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            Log::error('Order status update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete order');
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return redirect()->back()->with('success', 'Order Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Order Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function getVendorProducts(Request $request)
    {
        $products = Product::where('vendor_id', $request->vendor_id)->get(['id', 'name', 'price']);
        return response()->json($products);
    }
}
