<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view product');
        try {
            $currentUser = User::findOrFail(auth()->user()->id);
            $products = Product::with('category')->where('vendor_id', null)->get();
            return view('dashboard.products.index', compact('products'));
        } catch (\Throwable $th) {
            Log::error('Products Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create product');
        try {
            $categories = ProductCategory::where('is_active', 'active')->get();
            $vendors = User::whereHas('roles', function ($query) {
                $query->where('name', 'vendor');
            })
                ->with('userShop')
                ->get();
            return view('dashboard.products.create', compact('categories', 'vendors'));
        } catch (\Throwable $th) {
            Log::error('Product Create Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create product');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:product_categories,id',
            'vendor_id' => 'nullable|exists:users,id',
            'is_popular' => 'required|in:0,1',
            'main_image' => 'required|image|mimes:jpeg,png,jpg|max_size',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max_size',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $product = new Product();
            $product->name = $request->name;
            $product->slug = $request->slug;
            // Generate SKU
            $words = explode(' ', $request->name);
            $initials = '';
            foreach ($words as $w) {
                $initials .= strtoupper(substr($w, 0, 1));
            }
            $product->sku = $initials . '-' . mt_rand(100000, 999999);
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->cost_price = $request->cost_price;
            $product->profit = $request->price - $request->cost_price;
            $product->stock = $request->stock;
            $product->category_id = $request->category_id;
            $product->vendor_id = $request->vendor_id;
            $product->is_popular = $request->is_popular;
            $product->discount = 0;
            if ($request->hasFile('main_image')) {
                $Image = $request->file('main_image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_main_image.' . $Image_ext;

                $Image_path = 'uploads/products';
                $Image->move(public_path($Image_path), $Image_name);
                $product->main_image = $Image_path . "/" . $Image_name;
            }
            $product->save();

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;

                    $Image_ext = $image->getClientOriginalExtension();
                    $Image_name = uniqid() . '_image.' . $Image_ext;

                    $Image_path = 'uploads/products/gallery';
                    $image->move(public_path($Image_path), $Image_name);
                    $productImage->image = $Image_path . "/" . $Image_name;

                    $productImage->save();
                }
            }

            DB::commit();
            return redirect()->route('dashboard.products.index')->with('success', 'Product Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Product Store Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->authorize('view product');
        try {
            $product = Product::with('productImages','category','vendor.userShop')->where('id', $id)->first();
            return view('dashboard.products.show', compact('product'));
        } catch (\Throwable $th) {
            Log::error('Product Show Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update product');
        try {
            $product = Product::with('productImages')->findOrFail($id);
            $categories = ProductCategory::where('is_active', 'active')->get();
            $vendors = User::whereHas('roles', function ($query) {
                $query->where('name', 'vendor');
            })
                ->with('userShop')
                ->get();
            return view('dashboard.products.edit', compact('product', 'categories', 'vendors'));
        } catch (\Throwable $th) {
            Log::error('Product Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $this->authorize('update product');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'short_description' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:product_categories,id',
            'vendor_id' => 'nullable|exists:users,id',
            'is_popular' => 'required|in:0,1',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max_size',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->cost_price = $request->cost_price;
            $product->profit = $request->profit - $request->cost_price;
            $product->stock = $request->stock;
            $product->category_id = $request->category_id;
            $product->vendor_id = $request->vendor_id;
            $product->is_popular = $request->is_popular;
            $product->discount = 0;
            if ($request->hasFile('main_image')) {
                if (isset($product->main_image) && File::exists(public_path($product->main_image))) {
                    File::delete(public_path($product->main_image));
                }
                $Image = $request->file('main_image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_main_image.' . $Image_ext;

                $Image_path = 'uploads/products';
                $Image->move(public_path($Image_path), $Image_name);
                $product->main_image = $Image_path . "/" . $Image_name;
            }
            $product->save();
            if (isset($request->images)) {
                foreach ($product->productImages as $image) {
                    if (isset($image->image) && File::exists(public_path($image->image))) {
                        File::delete(public_path($image->image));
                    }
                    $image->delete();
                }
                $images = $request->file('images');
                foreach ($images as $image) {
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;

                    $Image_ext = $image->getClientOriginalExtension();
                    $Image_name = uniqid() . '_image.' . $Image_ext;

                    $Image_path = 'uploads/products/gallery';
                    $image->move(public_path($Image_path), $Image_name);
                    $productImage->image = $Image_path . "/" . $Image_name;

                    $productImage->save();
                }
            }
            DB::commit();
            return redirect()->route('dashboard.products.index')->with('success', 'Product Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Product Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete product');
        try {
            $product = Product::findOrFail($id);
            if (isset($product->main_image) && File::exists(public_path($product->main_image))) {
                File::delete(public_path($product->main_image));
            }
            foreach ($product->productImages as $image) {
                if (isset($image->image) && File::exists(public_path($image->image))) {
                    File::delete(public_path($image->image));
                }
                $image->delete();
            }
            $product->delete();
            return redirect()->back()->with('success', 'Product Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Product Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function updateStatus(string $id)
    {
        $this->authorize('update product');
        try {
            $product = Product::findOrFail($id);
            $message = $product->is_active == 'active' ? 'Product Deactivated Successfully' : 'Product Activated Successfully';
            if ($product->is_active == 'active') {
                $product->is_active = 'inactive';
                $product->save();
            } else {
                $product->is_active = 'active';
                $product->save();
            }
            return redirect()->back()->with('success', $message);
        } catch (\Throwable $th) {
            Log::error('Product Status Updation Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
