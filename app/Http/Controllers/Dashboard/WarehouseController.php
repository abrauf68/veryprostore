<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
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
                $products = Product::with('vendor', 'category')
                    ->where('vendor_id', $currentUser->id)
                    ->where('is_active', 'active')
                    ->get();
            }else{
                $products = Product::with('vendor', 'category')->where('vendor_id', '!=', null)->get();
            }
            return view('dashboard.warehouse.index', compact('products'));
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
            $product = Product::findOrFail($id);
            if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
                $product->vendor_id = $currentUser->id;
            }
            $product->save();
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
            $product = Product::findOrFail($id);
            $product->vendor_id = null;
            $product->save();

            return redirect()->back()->with('success', 'Product removed from warehouse successfully!');
        } catch (\Throwable $th) {
            Log::error('Warehouse Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
