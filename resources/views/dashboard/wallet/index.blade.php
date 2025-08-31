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
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="icon-base ti ti-truck icon-28px"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($totalCost) }}</h4>
                        </div>
                        <p class="mb-1">Total Cost</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i
                                        class="icon-base ti ti-alert-triangle icon-28px"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($pendingAmount) }}</h4>
                        </div>
                        <p class="mb-1">Pending Amount</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-success"><i
                                        class="icon-base ti ti-git-fork icon-28px"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($totalProfit) }}</h4>
                        </div>
                        <p class="mb-1">Total Profit</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info"><i
                                        class="icon-base ti ti-clock icon-28px"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($totalWithdrawn) }}</h4>
                        </div>
                        <p class="mb-1">Total Withdrawn</p>
                    </div>
                </div>
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
