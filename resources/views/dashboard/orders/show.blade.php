@extends('layouts.master')

@section('title', __('Order Details'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.orders.index') }}">{{ __('Orders') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Details') }}</li>
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-12 col-md-12 col-12 mb-md-0 mb-6">
                <div class="card invoice-preview-card p-sm-12 p-6">
                    <div class="card-body invoice-preview-header rounded">
                        <div
                            class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column align-items-xl-center align-items-md-start align-items-sm-center align-items-start">
                            <div class="mb-xl-0 mb-6 text-heading">
                                <div class="d-flex svg-illustration mb-6 gap-2 align-items-center">
                                    <span class="app-brand-logo">
                                        <img width="200px" src="{{ asset(\App\Helpers\Helper::getLogoLight()) }}" alt="{{env('APP_NAME')}}">
                                    </span>
                                    {{-- <span class="app-brand-text fw-bold fs-4 ms-50">{{\App\Helpers\Helper::getCompanyName()}}</span> --}}
                                </div>
                                <p class="mb-2">{{ \App\Helpers\Helper::getCompanyAddress() }}</p>
                                <p class="mb-2">{{ \App\Helpers\Helper::getCompanyCity() }}, {{ \App\Helpers\Helper::getCompanyZip() }}, {{ \App\Helpers\Helper::getCompanyCountry() }}</p>
                                <p class="mb-0">{{ \App\Helpers\Helper::getCompanyPhone() }}</p>
                            </div>
                            <div>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'paid' => 'primary',
                                        'shipped' => 'info',
                                        'completed' => 'success',
                                        'cancelled' => 'danger',
                                    ];
                                @endphp

                                <span class="badge mb-3 me-4 bg-label-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <h5 class="mb-6">#{{ $order->order_no }}</h5>
                                <div class="mb-1 text-heading">
                                    <span>Order Placed:</span>
                                    <span class="fw-medium">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                @if ($order->status == 'completed')
                                    <div class="text-heading">
                                        <span>Completed At:</span>
                                        <span class="fw-medium">{{ $order->created_at->copy()->addDays(2)->format('M d, Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="row">
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
                                <h6>Billing:</h6>
                                <p class="mb-1">{{ $order->billing->first_name.' '.$order->billing->last_name }}</p>
                                <p class="mb-1">{{ $order->billing->company_name }}</p>
                                <p class="mb-1">{{ $order->billing->city }} {{ $order->billing->zip }}, {{ $order->billing->state }}, {{ $order->billing->country }}</p>
                                <p class="mb-1">{{ $order->billing->phone }}</p>
                                <p class="mb-0">{{ $order->billing->email }}</p>
                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                {{-- <h6>Bill To:</h6> --}}
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-4"><strong>Total Due:</strong></td>
                                            <td class="fw-medium">{{ \App\Helpers\Helper::formatCurrency($order->total) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4"><strong>Payment Method:</strong></td>
                                            <td>{{ $order->paymentMethod->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4"><strong>Country:</strong></td>
                                            <td>{{ $order->billing->country }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if (isset($order->orderItems) && count($order->orderItems) > 0)
                        <div class="table-responsive border border-bottom-0 border-top-0 rounded">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $index => $item)
                                        <tr>
                                            <td class="text-nowrap">{{ $index + 1 }}</td>
                                            <td class="text-nowrap">{{ $item->product->name }}</td>
                                            <td>{{ \App\Helpers\Helper::formatCurrency($item->price) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ \App\Helpers\Helper::formatCurrency($item->total) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table m-0 table-borderless">
                            <tbody>
                                <tr>
                                    <td class="align-top pe-6 ps-0 py-6 text-body">
                                        {{-- <p class="mb-1">
                                            <span class="me-2 h6">Vendor:</span>
                                            <span>Alfie Solomons</span>
                                        </p>
                                        <span>Thanks for your business</span> --}}
                                    </td>
                                    <td class="px-0 py-6 w-px-100">
                                        <p class="mb-2">Subtotal:</p>
                                        <p class="mb-2">Discount:</p>
                                        <p class="mb-2 border-bottom pb-2">Tax:</p>
                                        <p class="mb-0">Total:</p>
                                    </td>
                                    <td class="text-end px-0 py-6 w-px-100 fw-medium text-heading">
                                        <p class="fw-medium mb-2">{{ \App\Helpers\Helper::formatCurrency($order->subtotal) }}</p>
                                        <p class="fw-medium mb-2">{{ \App\Helpers\Helper::formatCurrency(0) }}</p>
                                        <p class="fw-medium mb-2 border-bottom pb-2">0%</p>
                                        <p class="fw-medium mb-0">{{ \App\Helpers\Helper::formatCurrency($order->total) }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- <hr class="mt-0 mb-6" />
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-medium text-heading">Note:</span>
                                <span>It was a pleasure working with you and your team. We hope you will keep us in mind for
                                    future freelance projects. Thank You!</span>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <!-- /Invoice -->
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('script')
@endsection
