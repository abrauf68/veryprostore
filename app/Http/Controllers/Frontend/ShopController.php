<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function shop($categorySlug = null)
    {
        try {
            $products = Product::with('category', 'productImages')->where('is_active', 'active')->get();
            if ($categorySlug) {
                $category = ProductCategory::where('slug', $categorySlug)->first()->id;
                $products = $products->where('category_id', $category);
            }
            $categories = ProductCategory::where('is_active', 'active')->where('is_popular', '1')->get();
            return view('frontend.pages.shop.index', compact('products', 'categories'));
        } catch (\Throwable $th) {
            Log::error('Shop index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function quickView($id)
    {
        try {
            $product = Product::with('category', 'productImages')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category ? $product->category->name : 'N/A',
                    'category_slug' => $product->category ? $product->category->slug : null,
                    'sku' => $product->sku ?? 'N/A',
                    'price' => \App\Helpers\Helper::formatCurrency($product->price),
                    'rating' => $product->rating ?? 80, // Adjust as per your rating logic
                    'reviews' => $product->reviews_count ?? 3, // Adjust as per your reviews logic
                    'description' => $product->description ?? 'No description available.',
                    'images' => collect([[
                        'full' => asset($product->main_image),
                        'thumb' => asset($product->main_image), // yahan thumb ka alag path rakh sakte ho
                    ]])->merge(
                        $product->productImages->map(function ($image) {
                            return [
                                'full' => asset($image->image),
                                'thumb' => asset($image->image),
                            ];
                        })
                    )->toArray(),
                ],
            ]);
        } catch (\Throwable $th) {
            Log::error('Quick View Failed', ['error' => $th->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function productDetails($slug)
    {
        try {
            $product = Product::with('category', 'productImages')->where('slug', $slug)->firstOrFail();
            return view('frontend.pages.shop.product-details', compact('product'));
        } catch (\Throwable $th) {
            Log::error('Product Details Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
