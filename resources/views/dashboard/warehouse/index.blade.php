@extends('layouts.master')

@section('title', __('Warehouse'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Warehouse') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Warehouse List Table -->
        <div class="card">
            {{-- <div class="card-header">
                @canany(['create product'])
                    <a href="{{route('dashboard.products.create')}}" class="add-new btn btn-primary waves-effect waves-light">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                            class="d-none d-sm-inline-block">{{ __('Add New Product') }}</span>
                    </a>
                @endcan
            </div> --}}
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Vendor') }}</th>
                            @canany(['delete warehouse', 'update warehouse', 'view warehouse'])<th>{{ __('Action') }}</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}" height="35px" width="35px"></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->vendor ? $product->vendor->name : "N/A" }}</td>
                                @canany(['delete warehouse', 'update warehouse', 'view warehouse'])
                                    <td class="d-flex">
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
                                        @canany(['delete warehouse'])
                                            <form action="{{ route('dashboard.warehouse.destroy', $product->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="#" type="submit"
                                                    class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Remove Product From Warehouse') }}">
                                                    <i class="ti ti-circle-minus ti-md"></i>
                                                </a>
                                            </form>
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
@endsection

@section('script')
    {{-- <script src="{{asset('assets/js/app-user-list.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            //
        });
    </script>
@endsection
