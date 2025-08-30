@extends('layouts.master')

@section('title', __('Create Vendor'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.vendors.index') }}">{{ __('Vendors') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.vendors.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row p-5">
                        <h3>{{ __('Add New Vendor') }}</h3>

                        <div class="mb-4 col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                name="name" required value="{{ old('name') }}" placeholder="Enter name" autofocus />
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="Enter email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4 form-password-toggle">
                            <label class="form-label" for="password">{{ __('Password') }}</label><span
                                class="text-danger">*</span>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" required />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4 form-password-toggle">
                            <label class="form-label" for="password">{{ __('Transaction Password') }}</label><span
                                class="text-danger">*</span>
                            <div class="input-group input-group-merge">
                                <input type="password" id="transaction_password"
                                    class="form-control @error('transaction_password') is-invalid @enderror" name="transaction_password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="transaction_password" required />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('transaction_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 col-md-6">
                            <label for="shop_name" class="form-label">{{ __('Shop Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('shop_name') is-invalid @enderror" type="text" id="shop_name"
                                name="shop_name" required value="{{ old('shop_name') }}" placeholder="Enter shop name" autofocus />
                            @error('shop_name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="certificate_type" class="form-label">{{ __('Certificate Type') }}</label>
                            <select class="form-select select2 @error('certificate_type') is-invalid @enderror" id="certificate_type"
                                name="certificate_type">
                                <option value="">{{ __('Select certificate type') }}</option>
                                <option value="id" {{ old('certificate_type') == 'id' ? 'selected' : '' }}>ID</option>
                                <option value="aadhar_card" {{ old('certificate_type') == 'aadhar_card' ? 'selected' : '' }}>Aadhar Card</option>
                                <option value="passport" {{ old('certificate_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                            </select>
                            @error('certificate_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="certificate_front" class="form-label">{{ __('Certificate Front') }}</label><span
                                class="text-danger">*</span>
                            <input type="file" accept="image/*"
                                class="form-control @error('certificate_front') is-invalid @enderror"
                                id="certificate_front" name="certificate_front" required />
                            @error('certificate_front')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="certificate_back" class="form-label">{{ __('Certificate Back') }}</label><span
                                class="text-danger">*</span>
                            <input type="file" accept="image/*"
                                class="form-control @error('certificate_back') is-invalid @enderror" id="certificate_back"
                                name="certificate_back" required />
                            @error('certificate_back')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Add Vendor') }}</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            //
        });
    </script>


@endsection
