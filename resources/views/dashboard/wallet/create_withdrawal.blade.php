@extends('layouts.master')

@section('title', __('Withdraw'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Withdraw') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bank Details -->
        <div class="card mb-6">
            <h4 class="card-header">{{ __('Withdraw Now') }}</h4>
            <div class="card-body pt-1">
                <form id="formBankDetails" method="POST" action="{{ route('dashboard.withdraw.store') }}">
                    @csrf
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label for="amount" class="form-label">{{ __('Ammount') }}</label><span
                                class="text-danger">*</span>
                            <input type="number" step="any" class="form-control @error('amount') is-invalid @enderror"
                                id="amount" name="amount"
                                value="{{ old('amount') }}"
                                placeholder="{{ __('Enter ammount') }}">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Method -->
                        <div class="col-md-6 mb-4">
                            <label for="method" class="form-label">{{ __('Method') }} <span
                                    class="text-danger">*</span></label>
                            <select class="form-select select2 @error('method') is-invalid @enderror" id="method"
                                name="method" required>
                                <option value="" selected disabled>{{ __('Select Method') }}</option>
                                <option value="bank"
                                    {{ old('method', $userBankDetail->method) == 'bank' ? 'selected' : '' }}>Bank</option>
                                <option value="upi"
                                    {{ old('method', $userBankDetail->method) == 'upi' ? 'selected' : '' }}>UPI</option>
                                <option value="binance"
                                    {{ old('method', $userBankDetail->method) == 'binance' ? 'selected' : '' }}>Binance
                                </option>
                            </select>
                            @error('method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bank Fields -->
                        <div id="bankFields"
                            class="{{ old('method', $userBankDetail->method) == 'bank' ? '' : 'd-none' }}">
                            <div class="row">
                                <h5>Bank Account Details</h5>
                                <hr>
                                <div class="mb-4 col-md-6">
                                    <label for="account_name" class="form-label">{{ __('Account Name') }}</label><span
                                        class="text-danger">*</span>
                                    <input type="text" class="form-control @error('account_name') is-invalid @enderror"
                                        id="account_name" name="account_name"
                                        value="{{ old('account_name', $userBankDetail->account_name) }}"
                                        placeholder="{{ __('Enter account name') }}">
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="account_number" class="form-label">{{ __('Account Number') }}</label><span
                                        class="text-danger">*</span>
                                    <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                                        id="account_number" name="account_number"
                                        value="{{ old('account_number', $userBankDetail->account_number) }}"
                                        placeholder="{{ __('Enter account number') }}">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="account_type" class="form-label">{{ __('Account Type') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2 @error('account_type') is-invalid @enderror"
                                        id="account_type" name="account_type">
                                        <option value="" selected disabled>{{ __('Select account type') }}</option>
                                        <option value="savings"
                                            {{ old('account_type', $userBankDetail->account_type) == 'savings' ? 'selected' : '' }}>
                                            Savings</option>
                                        <option value="current"
                                            {{ old('account_type', $userBankDetail->account_type) == 'current' ? 'selected' : '' }}>
                                            Current</option>
                                        <option value="salary"
                                            {{ old('account_type', $userBankDetail->account_type) == 'salary' ? 'selected' : '' }}>
                                            Salary</option>
                                        <option value="fixed_deposit"
                                            {{ old('account_type', $userBankDetail->account_type) == 'fixed_deposit' ? 'selected' : '' }}>
                                            Fixed Deposit</option>
                                        <option value="nri"
                                            {{ old('account_type', $userBankDetail->account_type) == 'nri' ? 'selected' : '' }}>
                                            NRI</option>
                                        <option value="recurring_deposit"
                                            {{ old('account_type', $userBankDetail->account_type) == 'recurring_deposit' ? 'selected' : '' }}>
                                            Recurring Deposit</option>
                                        <option value="demat"
                                            {{ old('account_type', $userBankDetail->account_type) == 'demat' ? 'selected' : '' }}>
                                            Demat</option>
                                        <option value="others"
                                            {{ old('account_type', $userBankDetail->account_type) == 'others' ? 'selected' : '' }}>
                                            Others</option>
                                    </select>
                                    @error('account_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="bank_name" class="form-label">{{ __('Bank Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                        id="bank_name" name="bank_name"
                                        value="{{ old('bank_name', $userBankDetail->bank_name) }}"
                                        placeholder="{{ __('Enter bank name') }}">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="ifsc_code" class="form-label">{{ __('IFSC Code') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror"
                                        id="ifsc_code" name="ifsc_code"
                                        value="{{ old('ifsc_code', $userBankDetail->ifsc_code) }}"
                                        placeholder="{{ __('Enter IFSC code') }}">
                                    @error('ifsc_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="branch" class="form-label">{{ __('Branch') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('branch') is-invalid @enderror"
                                        id="branch" name="branch"
                                        value="{{ old('branch', $userBankDetail->branch) }}"
                                        placeholder="{{ __('Enter branch name') }}">
                                    @error('branch')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- UPI Fields -->
                        <div id="upiFields"
                            class="{{ old('method', $userBankDetail->method) == 'upi' ? '' : 'd-none' }}">
                            <h5>UPI Details</h5>
                            <hr>
                            <div class="mb-4 col-md-6">
                                <label for="upi_id" class="form-label">{{ __('UPI ID') }}</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control @error('upi_id') is-invalid @enderror"
                                    id="upi_id" name="upi_id" value="{{ old('upi_id', $userBankDetail->upi_id) }}"
                                    placeholder="{{ __('example@upi') }}">
                                @error('upi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Binance Fields -->
                        <div id="binanceFields"
                            class="{{ old('method', $userBankDetail->method) == 'binance' ? '' : 'd-none' }}">
                            <h5>Binance Details</h5>
                            <hr>
                            <div class="mb-4 col-md-6">
                                <label for="binance_id" class="form-label">{{ __('Binance ID') }}</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control @error('binance_id') is-invalid @enderror"
                                    id="binance_id" name="binance_id"
                                    value="{{ old('binance_id', $userBankDetail->binance_id) }}"
                                    placeholder="{{ __('Enter Binance ID') }}">
                                @error('binance_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">{{ __('Save Details') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--/ Bank Details -->
    </div>
@endsection

@section('script')
    {{-- <script src="{{asset('assets/js/app-user-list.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            function toggleFields() {
                $("#bankFields, #upiFields, #binanceFields").addClass("d-none");

                let method = $("#method").val();
                if (method === "bank") $("#bankFields").removeClass("d-none");
                if (method === "upi") $("#upiFields").removeClass("d-none");
                if (method === "binance") $("#binanceFields").removeClass("d-none");
            }

            $("#method").on("change", toggleFields);
            toggleFields(); // Run on page load
        });
    </script>
@endsection
