<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function home()
    {
        try {
            $popularProducts = Product::with('productImages')
                ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->select(
                    'products.id',
                    'products.name',
                    'products.sku',
                    'products.main_image',
                    'products.price',
                    'products.slug',
                    DB::raw('COALESCE(COUNT(order_items.id), 0) as order_count')
                )
                ->groupBy('products.id', 'products.name','products.sku','products.main_image','products.price','products.slug')
                ->orderByDesc('order_count')
                ->limit(3)
                ->get();

            $categories = ProductCategory::where('is_active', 'active')
                ->where('parent_category_id', null)
                ->take(6)
                ->get();

            $topCategories = ProductCategory::with(['products' => function ($q) {
                $q->where('is_active', 'active')
                ->limit(10); // ✅ only take 10 products per category
            }])
            ->withCount(['products' => function ($q) {
                $q->where('is_active', 'active');
            }])
            ->orderByDesc('products_count') // ✅ most products first
            ->take(4) // ✅ top 4 categories
            ->get();

            $sessionId = session('cart_session_id');

            $hideNewsletter = Newsletter::where('session_id', $sessionId)->exists();

            // dd($topCategories);
            return view('frontend.pages.home', compact('popularProducts','categories','topCategories','hideNewsletter'));
        } catch (\Throwable $th) {
            Log::error('Home Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function becomeAVendor()
    {
        try {
            return view('frontend.pages.become-a-vendor');
        } catch (\Throwable $th) {
            Log::error('becomeAVendor Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function about()
    {
        try {
            return view('frontend.pages.about');
        } catch (\Throwable $th) {
            Log::error('about Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function contact()
    {
        try {
            return view('frontend.pages.contact');
        } catch (\Throwable $th) {
            Log::error('contact Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function faqs()
    {
        try {
            return view('frontend.pages.faqs');
        } catch (\Throwable $th) {
            Log::error('faqs Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function newsletterStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())
                ->with('error', $validator->errors()->first());
        }
        try {
            $sessionId = session('cart_session_id');
            $newsletter = Newsletter::where('email', $request->email)->first();
            if (!$newsletter) {
                $newsletter = new Newsletter();
            }
            $newsletter->session_id = $sessionId;
            $newsletter->email = $request->email;
            $newsletter->save();

            return redirect()->back()->with('success', 'You have successfully subscribed to our newsletter.');
        } catch (\Throwable $th) {
            Log::error('newsletterStore Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
