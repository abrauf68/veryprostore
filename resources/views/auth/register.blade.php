@extends('layouts.authentication.master')
@section('title', 'Registration')

@section('css')
@endsection

@section('content')
    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-4 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/illustrations/auth-register-illustration-light.png') }}" alt="auth-register-cover"
                class="my-5 auth-illustration" data-app-light-img="illustrations/auth-register-illustration-light.png"
                data-app-dark-img="illustrations/auth-register-illustration-dark.png" />

            <img src="{{ asset('assets/img/illustrations/bg-shape-image-light.png') }}" alt="auth-register-cover"
                class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png"
                data-app-dark-img="illustrations/bg-shape-image-dark.png" />
        </div>
    </div>
    <!-- /Left Text -->

    <!-- Register -->
    <div class="d-flex col-12 col-lg-8 align-items-center justify-content-center authentication-bg p-5">
        <div class="mx-auto mt-12 pt-5">

            <form id="formAuthentication" class="mb-6" action="{{ route('register.attempt') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Account Details -->
                <div id="accountDetailsValidation" class="content mt-4">
                    <div class="content-header mb-6">
                        <h4 class="mb-0">Personal Information</h4>
                        <p class="mb-0">Enter Your Personal Information</p>
                    </div>
                    <div class="row g-6">
                        <div class="col-sm-6 form-control-validation">
                            <label for="name" class="form-label">{{ __('Name') }}</label><span
                                class="text-danger">*</span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" id="name" name="name"
                                placeholder="{{ __('Enter your name') }}" autofocus required />
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-control-validation">
                            <label for="email" class="form-label">{{ __('Email') }}</label><span
                                class="text-danger">*</span>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="{{ __('Enter your email') }}"
                                required />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-password-toggle form-control-validation">
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
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-password-toggle form-control-validation">
                            <label class="form-label" for="confirm_password">{{ __('Confirm Password') }}</label><span
                                class="text-danger">*</span>
                            <div class="input-group input-group-merge">
                                <input type="password" id="confirm_password"
                                    class="form-control @error('confirm_password') is-invalid @enderror"
                                    name="confirm_password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="confirm_password" required />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-password-toggle form-control-validation">
                            <label class="form-label"
                                for="transaction_password">{{ __('Transaction Password') }}</label><span
                                class="text-danger">*</span>
                            <div class="input-group input-group-merge">
                                <input type="password" id="transaction_password"
                                    class="form-control @error('transaction_password') is-invalid @enderror"
                                    name="transaction_password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="transaction_password" required />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('transaction_password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-password-toggle form-control-validation">
                            <label class="form-label"
                                for="confirm_transaction_password">{{ __('Confirm Transaction Password') }}</label><span
                                class="text-danger">*</span>
                            <div class="input-group input-group-merge">
                                <input type="password" id="confirm_transaction_password"
                                    class="form-control @error('confirm_transaction_password') is-invalid @enderror"
                                    name="confirm_transaction_password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="confirm_transaction_password" required />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('confirm_transaction_password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Personal Info -->
                <div id="personalInfoValidation" class="content mt-4">
                    <div class="content-header mb-6">
                        <h4 class="mb-0">Shop Information</h4>
                        <p class="mb-0">Enter Your Shop Information</p>
                    </div>
                    <div class="row g-6">
                        <div class="col-sm-6 form-control-validation">
                            <label for="shop_name" class="form-label">{{ __('Shop Name') }}</label><span
                                class="text-danger">*</span>
                            <input type="text" class="form-control @error('shop_name') is-invalid @enderror"
                                value="{{ old('shop_name') }}" id="shop_name" name="shop_name"
                                placeholder="{{ __('Enter your shop name') }}" required />
                            @error('shop_name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-control-validation">
                            <label class="form-label" for="certificate_type">Certificate Type <span
                                    class="text-danger">*</span></label>
                            <select id="certificate_type" name="certificate_type"
                                class="select2 form-select @error('certificate_type') is-invalid @enderror">
                                <option value="" selected disabled>Select Certificate Type</option>
                                <option value="id">ID</option>
                                <option value="aadhar_card">Aadhar Card</option>
                                <option value="passport">Passport</option>
                            </select>
                            @error('certificate_type')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-control-validation">
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
                        <div class="col-sm-6 form-control-validation">
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
                        <div class="col-sm-6 form-control-validation">
                            <label for="invitation_code" class="form-label">{{ __('Invitation Code') }}</label><span
                                class="text-danger">*</span>
                            <input type="text" class="form-control @error('invitation_code') is-invalid @enderror"
                                value="{{ old('invitation_code') }}" id="invitation_code" name="invitation_code"
                                placeholder="{{ __('Enter invitation code') }}" required />
                            @error('invitation_code')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-12 mb-2 form-control-validation">
                            <div class="form-check mb-8 ms-2">
                                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                                    id="terms-conditions" name="terms" required
                                    {{ old('terms') == 'on' ? 'checked' : '' }} />
                                <label class="form-check-label" for="terms-conditions">
                                    {{ __('I agree to') }} <a
                                        href="javascript:void(0);">{{ __('privacy policy & terms') }}</a>
                                </label>
                            </div>
                            @error('terms')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Billing Links -->
                {{-- <div class="mb-6">
                    <label for="name" class="form-label">{{__('Name')}}</label><span class="text-danger">*</span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" id="name" name="name" placeholder="{{__('Enter your name')}}" autofocus required />
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="email" class="form-label">{{__('Email')}}</label><span class="text-danger">*</span>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email') }}" placeholder="{{__('Enter your email')}}" required/>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-6 form-password-toggle">
                    <label class="form-label" for="password">{{__('Password')}}</label><span class="text-danger">*</span>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" required/>
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-6 form-password-toggle">
                    <label class="form-label" for="confirm-password">{{__('Confirm Password')}}</label><span class="text-danger">*</span>
                    <div class="input-group input-group-merge">
                        <input type="password" id="confirm-password" class="form-control @error('confirm-password') is-invalid @enderror" name="confirm-password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="confirm-password" required/>
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                    </div>
                    @error('confirm-password')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="mb-6 mt-8">
                    <div class="form-check mb-8 ms-2">
                        <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms-conditions" name="terms" required  {{ old('terms') == 'on' ? 'checked' : '' ; }}/>
                        <label class="form-check-label" for="terms-conditions">
                            {{__('I agree to')}} <a href="javascript:void(0);">{{__('privacy policy & terms')}}</a>
                        </label>
                    </div>
                    @error('terms')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-6">
                    @if (config('captcha.version') === 'v3')
                        {!! \App\Helpers\Helper::renderRecaptcha('formAuthentication', 'register') !!}
                    @elseif(config('captcha.version') === 'v2')
                        <div class="form-field-block">
                            {!! app('captcha')->display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                            @endif
                        </div>
                    @endif
                </div> --}}
                <button type="submit" class="btn btn-primary d-grid w-100">{{ __('Sign up') }}</button>
            </form>

            <p class="text-center">
                <span>{{ __('Already have an account?') }}</span>
                <a href="{{ route('login') }}">
                    <span>{{ __('Sign in instead') }}</span>
                </a>
            </p>

            {{-- <div class="divider my-6">
                <div class="divider-text">{{ __('or') }}</div>
            </div>

            <div class="d-flex justify-content-center">
                <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-facebook me-1_5">
                    <i class="tf-icons ti ti-brand-facebook-filled"></i>
                </a>

                <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-twitter me-1_5">
                    <i class="tf-icons ti ti-brand-twitter-filled"></i>
                </a>

                <a href="{{ route('auth.github.login') }}"
                    class="btn btn-sm btn-icon rounded-pill btn-text-github me-1_5">
                    <i class="tf-icons ti ti-brand-github-filled"></i>
                </a>

                <a href="{{ route('auth.google.login') }}" class="btn btn-sm btn-icon rounded-pill btn-text-google-plus">
                    <i class="tf-icons ti ti-brand-google-filled"></i>
                </a>
            </div> --}}
        </div>
    </div>
    <!-- /Register -->
@endsection

@section('script')
    {!! NoCaptcha::renderJs() !!}
@endsection
