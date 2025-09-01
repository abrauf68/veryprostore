<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\UserBankDetail;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    public function index()
    {
        $this->authorize('view wallet');
        try {
            $currentUser = User::findOrFail(auth()->user()->id);

            if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
                $orders = Order::whereHas('orderItems.product', function ($q) use ($currentUser) {
                    $q->where('vendor_id', $currentUser->id);
                })->with(['orderItems.product', 'paymentMethod', 'billing'])->get();

                $withdrawalRequests = WithdrawalRequest::where('user_id', $currentUser->id)->latest()->get();
            } else {
                $orders = Order::with('orderItems.product', 'paymentMethod', 'billing')->latest()->get();
                $withdrawalRequests = WithdrawalRequest::all();
            }

            // initialize
            $totalCost = 0;
            $totalProfit = 0;
            $pendingAmount = 0;

            foreach ($orders as $order) {
                foreach ($order->orderItems as $item) {
                    $product = $item->product;
                    if (!$product) continue;

                    // total cost = price * qty
                    $totalCost += $product->price * $item->quantity;

                    // check order status
                    if ($order->status === 'completed') {
                        $totalProfit += $product->profit * $item->quantity;
                    } elseif (!in_array($order->status, ['cancelled'])) {
                        $pendingAmount += $product->profit * $item->quantity;
                    }
                }
            }

            // withdrawal calculations
            $totalWithdraw = $withdrawalRequests->where('status', 'success')->sum('amount');
            $pendingWithdraw = $withdrawalRequests
                ->whereIn('status', ['pending', 'inprogress'])
                ->sum('amount');

            // remaining balance (earned but not yet withdrawn or pending)
            $remainingAmount = $totalProfit - ($pendingWithdraw + $totalWithdraw);

            return view('dashboard.wallet.index', compact(
                'orders',
                'withdrawalRequests',
                'totalCost',
                'totalProfit',
                'pendingAmount',
                'totalWithdraw',
                'pendingWithdraw',
                'remainingAmount',
            ));
        } catch (\Throwable $th) {
            Log::error('wallet Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    public function withdrawNow()
    {
        $this->authorize('create withdraw');
        try {
            $currentUser = User::findOrFail(auth()->user()->id);
            $userBankDetail = UserBankDetail::where('user_id', $currentUser->id)->first();
            return view('dashboard.wallet.create_withdrawal', compact(
                'userBankDetail',
            ));
        } catch (\Throwable $th) {
            Log::error('Withdraw Create Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    public function getRemainingAmount($userId)
    {
        $user = User::findOrFail($userId);

        if (!($user->hasRole('admin') || $user->hasRole('super-admin'))) {
            $orders = Order::whereHas('orderItems.product', function ($q) use ($user) {
                $q->where('vendor_id', $user->id);
            })->with(['orderItems.product'])->get();

            $withdrawalRequests = WithdrawalRequest::where('user_id', $user->id)->get();
        } else {
            $orders = Order::with(['orderItems.product'])->get();
            $withdrawalRequests = WithdrawalRequest::all();
        }

        $totalProfit = 0;

        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                if (!$product) continue;

                if ($order->status === 'completed') {
                    $totalProfit += $product->profit * $item->quantity;
                }
            }
        }

        // ✅ Withdrawals
        $totalWithdraw = $withdrawalRequests->where('status', 'success')->sum('amount');
        $pendingWithdraw = $withdrawalRequests->whereIn('status', ['pending', 'inprogress'])->sum('amount');

        // ✅ Remaining = profit - all withdrawals (successful + pending)
        return $totalProfit - ($totalWithdraw + $pendingWithdraw);
    }


    public function withdrawStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'method' => 'required|in:bank,upi,binance',
        ]);

        // Additional rules based on selected method
        if ($request->method === 'bank') {
            $validator->addRules([
                'account_name'   => 'required|string|max:255',
                'account_number' => 'required|string|max:50',
                'account_type'   => 'required|in:savings,current,salary,fixed_deposit,nri,recurring_deposit,demat,others',
                'bank_name'      => 'required|string|max:255',
                'ifsc_code'      => 'required|string|max:20',
                'branch'         => 'required|string|max:255',
            ]);
        }

        if ($request->method === 'upi') {
            $validator->addRules([
                'upi_id' => 'required|string|max:100',
            ]);
        }

        if ($request->method === 'binance') {
            $validator->addRules([
                'binance_id' => 'required|string|max:100',
            ]);
        }

        // Handle validation errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())
                ->with('error', $validator->errors()->first());
        }
        try {
            $currentUser = User::findOrFail(auth()->user()->id);
            $remainingAmount = $this->getRemainingAmount($currentUser->id);
            if ($remainingAmount < $request->amount) {
                return redirect()->back()->with('error', "Insufficient Balance");
            }
            $withdrawalRequest = new WithdrawalRequest();
            $withdrawalRequest->user_id = $currentUser->id;
            $withdrawalRequest->amount = $request->amount;
            $withdrawalRequest->method = $request->method;
            // Format: WD-YYYYMMDD-RANDOM6
            $withdrawalRequest->withdrawal_id = 'WD-' . date('Ymd') . '-' . mt_rand(100000, 999999);
            $withdrawalRequest->save();

            $userBankDetail = UserBankDetail::where('user_id', $currentUser->id)->first();
            if (!$userBankDetail) {
                $userBankDetail = new UserBankDetail();
                $userBankDetail->user_id = $currentUser->id;
            }
            $userBankDetail->method   = $request->method;
            $userBankDetail->account_name   = $request->account_name;
            $userBankDetail->account_number = $request->account_number;
            $userBankDetail->account_type   = $request->account_type;
            $userBankDetail->bank_name      = $request->bank_name;
            $userBankDetail->ifsc_code      = $request->ifsc_code;
            $userBankDetail->branch         = $request->branch;
            $userBankDetail->upi_id = $request->upi_id;
            $userBankDetail->binance_id = $request->binance_id;
            $userBankDetail->save();

            return redirect()->route('dashboard.wallet.index')->with('success', 'Withdraw request submitted successfully!');
        } catch (\Throwable $th) {
            Log::error('Bank Details Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
