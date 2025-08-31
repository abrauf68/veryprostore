@extends('layouts.master')

@section('title', __('Products'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Products') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Products List Table -->
        <div class="card">
            <div class="card-header">
                @canany(['create product'])
                    <a href="{{ route('dashboard.products.create') }}" class="add-new btn btn-primary waves-effect waves-light">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                            class="d-none d-sm-inline-block">{{ __('Add New Product') }}</span>
                    </a>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Category') }}</th>
                            {{-- <th>{{ __('Vendor') }}</th> --}}
                            @canany(['update product'])<th>{{ __('Status') }}</th>@endcan
                            @canany(['delete product', 'update product', 'view product', 'create warehouse', 'update
                            warehouse'])<th>{{ __('Action') }}</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}" height="35px"
                                        width="35px"></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                {{-- <td>{{ $product->vendor ? $product->vendor->name : "N/A" }}</td> --}}
                                @canany(['update product'])
                                    <td>
                                        <span
                                            class="badge me-4 bg-label-{{ $product->is_active == 'active' ? 'success' : 'danger' }}">{{ ucfirst($product->is_active) }}</span>
                                    </td>
                                @endcan
                                @canany(['delete product', 'update product', 'view product', 'create warehouse', 'update
                                    warehouse'])
                                    <td class="d-flex">
                                        @canany(['delete product'])
                                            <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="#" type="submit"
                                                    class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Delete Product') }}">
                                                    <i class="ti ti-trash ti-md"></i>
                                                </a>
                                            </form>
                                        @endcan
                                        @canany(['update product'])
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                                    class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Edit Product') }}">
                                                    <i class="ti ti-edit ti-md"></i>
                                                </a>
                                            </span>
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.products.status.update', $product->id) }}"
                                                    class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $product->is_active == 'active' ? __('Deactivate Product') : __('Activate Product') }}">
                                                    @if ($product->is_active == 'active')
                                                        <i class="ti ti-toggle-right ti-md text-success"></i>
                                                    @else
                                                        <i class="ti ti-toggle-left ti-md text-danger"></i>
                                                    @endif
                                                </a>
                                            </span>
                                        @endcan
                                        @canany(['view product'])
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.products.show', $product->id) }}"
                                                    class="btn btn-icon btn-text-warning waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('View Product Details') }}">
                                                    <i class="ti ti-eye ti-md"></i>
                                                </a>
                                            </span>
                                        @endcan
                                        @role('vendor')
                                            @canany(['create warehouse', 'update warehouse'])
                                                <span class="text-nowrap">
                                                    <form action="{{ route('dashboard.warehouse.update', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="btn btn-icon btn-text-success waves-effect waves-light rounded-pill me-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ __('Add Product to Warehouse') }}">
                                                            <i class="ti ti-circle-plus ti-md"></i>
                                                        </button>
                                                    </form>
                                                </span>
                                            @endcanany
                                        @endrole

                                    </td>
                                @endcan
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
