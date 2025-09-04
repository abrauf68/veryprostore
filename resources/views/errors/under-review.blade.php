@extends('layouts.master')

@section('title', 'Account Under Review!')

@section('css')
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item active">{{ __('Dashboard') }}</li> --}}
@endsection

@section('content')
    <div class="row g-6">
        <div class="misc-wrapper text-center">
            <h1 class="mb-2 mx-2 text-danger" style="line-height: 6rem; font-size: 6rem">🚫</h1>
            <h4 class="mb-2 mx-2">{{ __('Your account is pending for admin approval') }}</h4>
            <p class="mb-6 mx-2">
                {{ __('Please wait a while, you will be notified once your account is approved.') }}
            </p>
            <div class="d-flex justify-content-center">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn btn-danger mb-10 mx-4">{{ __('Logout') }}</a>
                <a href="#" class="btn btn-primary mb-10">{{ __('Contact Support') }}</a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            <div class="mt-4">
                <img src="{{ asset('assets/img/illustrations/page-misc-error.png') }}" alt="Account Deactivated"
                    width="225" class="img-fluid" />
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
