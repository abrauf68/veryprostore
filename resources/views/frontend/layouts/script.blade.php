<!-- Plugin JS File -->
<script src="{{ asset('frontAssets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('frontAssets/vendor/jquery.plugin/jquery.plugin.min.js') }}"></script>
<script src="{{ asset('frontAssets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('frontAssets/vendor/zoom/jquery.zoom.js') }}"></script>
<script src="{{ asset('frontAssets/vendor/jquery.countdown/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('frontAssets/vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('frontAssets/vendor/skrollr/skrollr.min.js') }}"></script>

<!-- Swiper JS -->
<script src="{{ asset('frontAssets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('frontAssets/js/main.min.js') }}"></script>
@yield('script')

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Override Wolmart.Minipopup.open to inject Laravel routes
    const originalOpen = Wolmart.Minipopup.open;
    Wolmart.Minipopup.open = function(options) {
        options.actionTemplate = `
            <a href="{{ route('frontend.cart.view') }}" class="btn btn-rounded btn-sm">View Cart</a>
            <a href="#" class="btn btn-dark btn-rounded btn-sm">Checkout</a>
        `;
        return originalOpen.call(this, options);
    };
});
</script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    toastr.options = {
        "closeButton": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "2000"
    };
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('message'))
        toastr.info("{{ session('message') }}");
    @endif

    @if ($errors->any())
        toastr.error("{{ $errors->first() }}");
    @endif
</script>
