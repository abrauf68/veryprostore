<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function home()
    {
        try {
            return view('frontend.pages.home');
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
}
