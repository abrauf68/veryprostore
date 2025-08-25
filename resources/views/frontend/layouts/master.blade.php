<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ \App\Helpers\Helper::getCompanyName() }} - @yield('title')</title>
    @include('frontend.layouts.meta')
    @include('frontend.layouts.css')
    @yield('css')
    <style>
        .invalid-feedback {
            color: red;
        }
    </style>
</head>

<body class="home">
    <div class="page-wrapper">
        <h1 class="d-none">Wolmart - Responsive Marketplace HTML Template</h1>
        @include('frontend.layouts.header')

        <!-- Start of Main-->
        @yield('content')
        <!-- End of Main -->

        @include('frontend.layouts.footer')
    </div>
    <!-- End of Page-wrapper-->

    <!-- Start of Scroll Top -->
    <a id="scroll-top" class="scroll-top" href="#top" title="Top" role="button">
        <i class="w-icon-angle-up"></i> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">
            <circle id="progress-indicator" fill="transparent" stroke="#000000" stroke-miterlimit="10" cx="35"
                cy="35" r="34" style="stroke-dasharray: 16.4198, 400;"></circle>
        </svg>
    </a>
    <!-- End of Scroll Top -->

    @if (request()->routeIs('home'))
        <!-- Start of Newsletter popup -->
        <div class="newsletter-popup mfp-hide">
            <div class="newsletter-content">
                <h4 class="text-uppercase font-weight-normal ls-25">
                    Get Up to <span class="text-primary">25% Off</span>
                </h4>
                <h2 class="ls-25">Sign up to Wolmart</h2>
                <p class="text-light ls-10">
                    Subscribe to the Wolmart market newsletter to receive updates on special offers.
                </p>
                <form action="#" method="get" class="input-wrapper input-wrapper-inline input-wrapper-round">
                    <input type="email" class="form-control email font-size-md" name="email" id="email2"
                        placeholder="Your email address" required>
                    <button class="btn btn-dark" type="submit">SUBMIT</button>
                </form>
                <div class="form-checkbox d-flex align-items-center">
                    <input type="checkbox" class="custom-checkbox" id="hide-newsletter-popup"
                        name="hide-newsletter-popup" required>
                    <label for="hide-newsletter-popup" class="font-size-sm text-light">
                        Don't show this popup again.
                    </label>
                </div>
            </div>
        </div>
        <!-- End of Newsletter popup -->
    @else
        <style>
            html{
                overflow: auto !important;
            }
            .mfp-newsletter{
                display: none;
            }
        </style>
    @endif

    @include('frontend.layouts.script')
</body>

</html>
