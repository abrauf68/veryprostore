@extends('layouts.master')

@section('title', __('Wallet'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Wallet') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <!-- Card Border Shadow -->
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="icon-base ti ti-briefcase icon-28px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($totalCost) }}</h4>
                        </div>
                        <p class="mb-1">Total Investment</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-success"><i
                                        class="icon-base ti ti-wallet icon-28px"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($totalProfit) }}</h4>
                        </div>
                        <p class="mb-1">Total Profit</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="icon-base ti ti-coin icon-28px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($totalAmount) }}</h4>
                        </div>
                        <p class="mb-1">Total Amount</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info"><i
                                        class="icon-base ti ti-building-bank icon-28px"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($totalWithdraw) }}</h4>
                        </div>
                        <p class="mb-1">Total Withdraw</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i
                                        class="icon-base ti ti-credit-card icon-28px"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($pendingWithdraw) }}</h4>
                        </div>
                        <p class="mb-1">Pending Withdraw</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="icon-base ti ti-cash icon-28px"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($remainingAmount) }}</h4>
                        </div>
                        <p class="mb-1">Remaining Amount</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widhdraw List Table -->
        <div class="card mt-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Recent Withdraws</h4>
                @canany(['create withdraw'])
                    <a href="{{ route('dashboard.withdraw.create') }}"
                        class="add-new btn btn-primary waves-effect waves-light float-end">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                            class="d-none d-sm-inline-block">{{ __('Withdraw Now') }}</span>
                    </a>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Withdrawal ID') }}</th>
                            <th>{{ __('Method') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Status') }}</th>
                            {{-- @canany(['delete withdraw', 'update withdraw', 'view withdraw'])<th>{{ __('Action') }}</th>@endcan --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($withdrawalRequests as $index => $withdraw)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $withdraw->withdrawal_id }}</td>
                                <td>{{ ucfirst($withdraw->method) }}</td>
                                <td>{{ \App\Helpers\Helper::formatCurrency($withdraw->amount) }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'primary',
                                            'inprogress' => 'warning',
                                            'success' => 'success',
                                            'canceled' => 'danger',
                                            'failed' => 'danger',
                                        ];
                                    @endphp

                                    <span
                                        class="badge me-4 bg-label-{{ $statusColors[$withdraw->status] ?? 'secondary' }}">
                                        {{ ucfirst($withdraw->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script src="{{asset('assets/js/app-user-list.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            //
        });
    </script>
@endsection
