<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view warehouse');
        try {
            $currentUser = User::findOrFail(auth()->user()->id);
            if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
                // $products = Product::with('vendor', 'category')
                //     ->where('vendor_id', $currentUser->id)
                //     ->where('is_active', 'active')
                //     ->latest()
                //     ->get();

                $userProducts = UserProduct::with('product')->where('user_id', $currentUser->id)->get();
            } else {
                $userProducts = UserProduct::with('product', 'user')->get();
                // $products = Product::with('vendor', 'category')->where('vendor_id', '!=', null)->latest()->get();
            }
            return view('dashboard.warehouse.index', compact('userProducts'));
        } catch (\Throwable $th) {
            Log::error('Warehouse Index Failed', ['error' => $th->getMessage()]);
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
    public function show($id)
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
        // dd($request->all());
        $this->authorize('update warehouse');
        try {
            DB::beginTransaction();
            $currentUser = User::findOrFail(auth()->user()->id);
            $userProduct = UserProduct::where('product_id', $id)->where('user_id', $currentUser->id)->first();
            if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
                if ($userProduct) {
                    return redirect()->back()->with('message', 'Product already exists inside your warehouse.');
                } else {
                    $userProduct = new UserProduct();
                    $userProduct->user_id = $currentUser->id;
                    $userProduct->product_id = $id;
                    $userProduct->save();
                }
            }
            DB::commit();
            return redirect()->route('dashboard.warehouse.index')->with('success', 'Product Added to Warehouse Successfully');
        } catch (\Throwable $th) {
            Log::error('Warehouse Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete warehouse');
        try {
            $userProduct = UserProduct::findOrFail($id);
            $userProduct->delete();
            return redirect()->back()->with('success', 'Product removed from warehouse successfully!');
        } catch (\Throwable $th) {
            Log::error('Warehouse Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function bulkAddToWarehouse(Request $request)
    {
        $this->authorize('update warehouse');

        try {
            DB::beginTransaction();

            $currentUser = User::findOrFail(auth()->user()->id);
            $productIds = explode(',', $request->product_ids);
            foreach ($productIds as $productId) {
                $productId = (int) $productId;
                $exists = UserProduct::where('product_id', $productId)
                    ->where('user_id', $currentUser->id)
                    ->exists();
                if ($exists) {
                    continue;
                }
                if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
                    $userProduct = new UserProduct();
                    $userProduct->user_id = $currentUser->id;
                    $userProduct->product_id = $productId;
                    $userProduct->save();
                }
            }

            DB::commit();
            return redirect()->route('dashboard.warehouse.index')
                ->with('success', 'Selected products added to warehouse successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Warehouse Bulk Add Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }
}
