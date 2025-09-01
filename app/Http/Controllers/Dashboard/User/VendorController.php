<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Mail\UserCredentialMail;
use App\Models\Order;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserShop;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view vendor');
        try {
            // Base query for vendors
            $vendorQuery = User::whereHas('roles', function ($query) {
                $query->where('name', 'vendor');
            });

            // Get all vendors with relations
            $vendors = $vendorQuery->with('userShop', 'products', 'profile')->get();

            // Counts
            $totalVendors = $vendors->count();
            $totalDeactivatedVendors = $vendors->where('is_active', 'inactive')->count();
            $totalActiveVendors = $vendors->where('is_active', 'active')->count();

            // Archived vendors (must use query, not collection)
            $totalArchivedVendors = (clone $vendorQuery)->onlyTrashed()->count();

            return view('dashboard.vendors.index', compact(
                'vendors',
                'totalVendors',
                'totalDeactivatedVendors',
                'totalActiveVendors',
                'totalArchivedVendors'
            ));
        } catch (\Throwable $th) {
            Log::error("Vendor Index Failed:" . $th->getMessage());
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create vendor');
        try {
            return view('dashboard.vendors.create');
        } catch (\Throwable $th) {
            Log::error("Vendor Create Failed:" . $th->getMessage());
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create vendor');
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'string', 'min:8'],
            'transaction_password' => ['required', 'string', 'min:8'],
            'shop_name' => ['required', 'string', 'max:255'],
            'certificate_type' => ['required', 'string', 'max:255'],
            'certificate_front' => 'required|image|mimes:jpeg,png,jpg|max_size',
            'certificate_back' => 'required|image|mimes:jpeg,png,jpg|max_size',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->transaction_password = $request->transaction_password;
            $user->email_verified_at = now();
            $username = $this->generateUsername($request->name);

            while (User::where('username', $username)->exists()) {
                $username = $this->generateUsername($request->name);
            }
            $user->username = $username;
            $user->save();
            $user->syncRoles('vendor');

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->first_name = $request->name;
            $profile->save();

            $userShop = new UserShop();
            $userShop->user_id = $user->id;
            $userShop->shop_name = $request->shop_name;
            $userShop->certificate_type = $request->certificate_type;
            if ($request->hasFile('certificate_front')) {
                $certificate_front = $request->file('certificate_front');
                $certificate_front_ext = $certificate_front->getClientOriginalExtension();
                $certificate_front_name = time() . '_certificate_front.' . $certificate_front_ext;

                $certificate_front_path = 'uploads/certificates';
                $certificate_front->move(public_path($certificate_front_path), $certificate_front_name);
                $userShop->certificate_front = $certificate_front_path . "/" . $certificate_front_name;
            }
            if ($request->hasFile('certificate_back')) {
                $certificate_back = $request->file('certificate_back');
                $certificate_back_ext = $certificate_back->getClientOriginalExtension();
                $certificate_back_name = time() . '_certificate_back.' . $certificate_back_ext;

                $certificate_back_path = 'uploads/certificates';
                $certificate_back->move(public_path($certificate_back_path), $certificate_back_name);
                $userShop->certificate_back = $certificate_back_path . "/" . $certificate_back_name;
            }
            $userShop->save();

            // try {
            //     Mail::to($request->email)->send(new UserCredentialMail($user->name, $request->email, $request->password));
            // } catch (\Throwable $th) {
            //     // throw $th;
            // }

            DB::commit();

            return redirect()->route('dashboard.vendors.index')->with('success', 'Vendor created successfully');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollback();
            Log::error("Vendor Create Failed:" . $th->getMessage());
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('view vendor');
        try {
            $vendor = User::with('userShop', 'userBankDetail', 'products', 'profile')->findOrFail($id);
            $profile = Profile::with('gender', 'maritalStatus', 'language', 'designation', 'country')->where('user_id', $vendor->id)->first();
            $orders = Order::whereHas('orderItems.product', function($q) use ($vendor) {
                $q->where('vendor_id', $vendor->id);
            })->with(['orderItems.product', 'billing'])->get();
            $totalOrders = $orders->count();
            $pendingOrders = $orders->where('status','pending')->count();
            $paidOrders = $orders->where('status','paid')->count();
            $shippedOrders = $orders->where('status','shipped')->count();
            $completedOrders = $orders->where('status','completed')->count();
            $cancelledOrders = $orders->where('status','cancelled')->count();
            return view('dashboard.vendors.show', compact('vendor','profile', 'orders', 'totalOrders','pendingOrders','paidOrders','shippedOrders','completedOrders','cancelledOrders'));
        } catch (\Throwable $th) {
            Log::error("Vendor Show Failed:" . $th->getMessage());
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update vendor');
        try {
            $vendor = User::with('userShop', 'products', 'profile')->findOrFail($id);
            return view('dashboard.vendors.edit', compact('vendor'));
        } catch (\Throwable $th) {
            Log::error("Vendor Edit Failed:" . $th->getMessage());
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update vendor');
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => ['nullable', 'string', 'min:8'],
            'transaction_password' => ['nullable', 'string', 'min:8'],
            'shop_name' => ['required', 'string', 'max:255'],
            'certificate_type' => ['required', 'string', 'max:255'],
            'certificate_front' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
            'certificate_back' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            if ($request->transaction_password) {
                $user->transaction_password = $request->transaction_password;
            }
            $user->save();
            $user->syncRoles('vendor');

            $profile = Profile::where('user_id', $user->id)->first();
            $profile->first_name = $request->name;
            $profile->save();

            $userShop = UserShop::where('user_id', $user->id)->first();
            $userShop->shop_name = $request->shop_name;
            $userShop->certificate_type = $request->certificate_type;
            if ($request->hasFile('certificate_front')) {
                if (isset($userShop->certificate_front) && File::exists(public_path($userShop->certificate_front))) {
                    File::delete(public_path($userShop->certificate_front));
                }
                $certificate_front = $request->file('certificate_front');
                $certificate_front_ext = $certificate_front->getClientOriginalExtension();
                $certificate_front_name = time() . '_certificate_front.' . $certificate_front_ext;

                $certificate_front_path = 'uploads/certificates';
                $certificate_front->move(public_path($certificate_front_path), $certificate_front_name);
                $userShop->certificate_front = $certificate_front_path . "/" . $certificate_front_name;
            }
            if ($request->hasFile('certificate_back')) {
                if (isset($userShop->certificate_back) && File::exists(public_path($userShop->certificate_back))) {
                    File::delete(public_path($userShop->certificate_back));
                }
                $certificate_back = $request->file('certificate_back');
                $certificate_back_ext = $certificate_back->getClientOriginalExtension();
                $certificate_back_name = time() . '_certificate_back.' . $certificate_back_ext;

                $certificate_back_path = 'uploads/certificates';
                $certificate_back->move(public_path($certificate_back_path), $certificate_back_name);
                $userShop->certificate_back = $certificate_back_path . "/" . $certificate_back_name;
            }
            $userShop->save();

            DB::commit();

            return redirect()->route('dashboard.vendors.index')->with('success', 'Vendor updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("Vendor Update Failed:" . $th->getMessage());
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete vendor');
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->back()->with('success', 'Account Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Account Deletion Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
    /**
     * Update status of the specified resource from storage.
     */
    public function updateStatus(string $id)
    {
        $this->authorize('update vendor');
        try {
            $user = User::findOrFail($id);
            $message = $user->is_active == 'active' ? 'Account Deactivated Successfully' : 'Account Activated Successfully';
            if ($user->is_active == 'active') {
                $user->is_active = 'inactive';
                $user->save();
            } else {
                $user->is_active = 'active';
                $user->save();
            }
            return redirect()->back()->with('success', $message);
        } catch (\Throwable $th) {
            Log::error('Account Status Updation Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
    public function generateUsername($name)
    {
        $name = strtolower(str_replace(' ', '', $name));
        $username = $name . rand(1000, 9999);
        return $username;
    }
}
