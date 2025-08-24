@extends('frontend.layouts.master')

@section('title', 'Account Under Review!')

@section('css')
@endsection

@section('breadcrumb-items')
@endsection

@section('content')
    <!-- Start of Main -->
    <main class="main">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb bb-no">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Account Under Review</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of Page Content -->
        <div class="page-content error-404">
    <div class="container text-center">
        <div class="banner">
            <img src="{{ asset('frontAssets/images/under-review.png') }}"
                 alt="Account Under Review"
                 width="300"
                 height="460"
                 class="mx-auto d-block" />
            <div class="banner-content text-center">
                <h2 class="banner-title">
                    Your account is pending for admin approval
                </h2>
                <p class="text-light">Please wait a while, you will be notified once your account is approved.</p>
                <a href="{{ route('frontend.home') }}" class="btn btn-dark btn-rounded btn-icon-right">
                    Go Back Home <i class="w-icon-long-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

        <!-- End of Page Content -->
    </main>
    <!-- End of Main -->
@endsection

@section('script')
@endsection
