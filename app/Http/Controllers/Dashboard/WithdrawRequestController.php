<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WithdrawRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view withdraw request');
        try {
            $currentUser = User::findOrFail(auth()->user()->id);

            if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
                $withdrawalRequests = WithdrawalRequest::with('user')->where('user_id', $currentUser->id)->get();
            } else {
                $withdrawalRequests = WithdrawalRequest::with('user')->get();
            }

            return view('dashboard.withdraw-requests.index', compact(
                'withdrawalRequests',
            ));
        } catch (\Throwable $th) {
            Log::error('withdraw requests Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
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
    public function show(string $id)
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
        $this->authorize('update withdraw request');
        $validator = Validator::make($request->all(), [
            'withdraw_id' => 'required|exists:withdrawal_requests,id',
            'status' => 'required|in:pending,inprogress,success,canceled,failed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();

            $withdraw = WithdrawalRequest::findOrFail($request->withdraw_id);
            $withdraw->status = $request->status;
            $withdraw->save();

            DB::commit();
            return redirect()->route('dashboard.withdraw-requests.index')->with('success', 'Withdraw request status updated successfully');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            Log::error('WithdrawalRequest status update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
