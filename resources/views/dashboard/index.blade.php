@extends('layouts.master')

@section('title', 'Dashboard')

@section('css')
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item active">{{ __('Dashboard') }}</li> --}}
@endsection

@section('content')
    <div class="row g-6">
        <!-- View sales -->
        <div class="col-xl-5">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-7">
                        <div class="card-body text-nowrap">
                            <h5 class="card-title mb-0">Welcome {{ Auth::user()->name }}! </h5>
                            <p class="mb-2">Here what's happening in <br>your account today.</p>
                            {{-- <h4 class="text-primary mb-1">$48.9k</h4> --}}
                            <a href="{{ route('dashboard.orders.index') }}" class="btn btn-primary">View Orders</a>
                        </div>
                    </div>
                    <div class="col-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/card-advance-sale.png') }}" height="140"
                                alt="view sales" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- View sales -->

        <!-- Statistics -->
        <div class="col-xl-7 col-md-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Statistics</h5>
                    <small class="text-body-secondary">All time stats</small>
                </div>
                <div class="card-body d-flex align-items-end">
                    <div class="w-100">
                        <div class="row gy-3">
                            <div class="col-md-4 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-primary me-4 p-2">
                                        <i class="icon-base ti ti-shopping-cart icon-lg"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ $totalOrders }}</h5>
                                        <small>Total Orders</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-info me-4 p-2">
                                        <i class="icon-base ti ti-package icon-lg"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ $totalProducts }}</h5>
                                        <small>Total Products</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-success me-4 p-2">
                                        <i class="icon-base ti ti-currency-dollar icon-lg"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ \App\Helpers\Helper::formatCurrency($totalRevenue) }}</h5>
                                        <small>Total Revenue</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Statistics -->

        <div class="col-xxl-4 col-12">
            <div class="row g-6">
                <!-- Profit last month -->
                <div class="col-xl-6 col-sm-6">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h5 class="card-title mb-1">Profit</h5>
                            <p class="card-subtitle">Last Month</p>
                        </div>
                        <div class="card-body">
                            <div id="profitLastMonth"></div>
                            <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                <h4 class="mb-0">624k</h4>
                                <small class="text-success">+8.24%</small>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Profit last month -->

                <!-- Popular Product -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title m-0 me-2">
                                <h5 class="mb-1">Popular Products</h5>
                                <p class="card-subtitle">Total {{ $totalProducts }} Products</p>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (isset($popularProducts) && count($popularProducts) > 0)
                                <ul class="p-0 m-0">
                                    @foreach ($popularProducts as $popularProduct)
                                        <li class="d-flex mb-6">
                                            <div class="me-4">
                                                <img src="{{ asset($popularProduct->main_image) }}" alt="User" class="rounded"
                                                    width="46" />
                                            </div>
                                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0">{{ $popularProduct->name }}</h6>
                                                    <small class="text-body d-block">SKU: #{{ $popularProduct->sku }}</small>
                                                </div>
                                                <div class="user-progress d-flex align-items-center gap-1">
                                                    <p class="mb-0">{{ \App\Helpers\Helper::formatCurrency($popularProduct->price) }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No Products Available</p>
                            @endif
                        </div>
                    </div>
                </div>
                <!--/ Popular Product -->
            </div>
        </div>

        <!-- Invoice table -->
        <div class="col-xxl-8">
            <!-- Orders List Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="datatables-users table border-top custom-datatables">
                        <thead>
                            <tr>
                                <th>{{ __('Sr.') }}</th>
                                <th>{{ __('Order No') }}</th>
                                <th>{{ __('Order By') }}</th>
                                <th>{{ __('Total') }}</th>
                                <th>{{ __('Status') }}</th>
                                @canany(['delete order', 'update order', 'view order'])<th>{{ __('Action') }}</th>@endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $order->order_no }}</td>
                                    <td>{{ $order->billing->first_name . ' ' . $order->billing->last_name }}</td>
                                    <td>{{ \App\Helpers\Helper::formatCurrency($order->total) }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'paid' => 'primary',
                                                'shipped' => 'info',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                            ];
                                        @endphp

                                        <span
                                            class="badge me-4 bg-label-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    @canany(['delete order', 'update order', 'view order'])
                                        <td class="d-flex">
                                            @canany(['delete order'])
                                                <form action="{{ route('dashboard.orders.destroy', $order->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <a href="#" type="submit"
                                                        class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delete Order') }}">
                                                        <i class="ti ti-trash ti-md"></i>
                                                    </a>
                                                </form>
                                            @endcan
                                            @canany(['update order'])
                                                <span class="text-nowrap">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1 edit-order-btn"
                                                        data-bs-toggle="modal" data-bs-target="#editOrderModal"
                                                        data-id="{{ $order->id }}" data-status="{{ $order->status }}"
                                                        title="{{ __('Edit Order') }}">
                                                        <i class="ti ti-edit ti-md"></i>
                                                    </a>
                                                </span>
                                            @endcan

                                            @canany(['view order'])
                                                <span class="text-nowrap">
                                                    <a href="{{ route('dashboard.orders.show', $order->id) }}"
                                                        class="btn btn-icon btn-text-warning waves-effect waves-light rounded-pill me-1"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('View Order Details') }}">
                                                        <i class="ti ti-eye ti-md"></i>
                                                    </a>
                                                </span>
                                            @endcan
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /Invoice table -->
    </div>
@endsection

@section('script')
    <!-- Page JS -->
    <script src="{{ asset('assets/js/app-ecommerce-dashboard.js') }}"></script>
@endsection
