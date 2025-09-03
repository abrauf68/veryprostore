@extends('frontend.layouts.master')

@section('title', 'FAQs')

@section('css')
@endsection

@section('content')
    <!-- Start of Main -->
    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header" style="height: 180px;">
            <div class="container">
                <h1 class="page-title mb-0">FAQs</h1>
            </div>
        </div>
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav mb-10 pb-1">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>FAQs</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content faq">
            <div class="container">
                <section class="content-title-section">
                    <h3 class="title title-simple justify-content-center bb-no pb-0">Frequently Asked Questions</h3>
                    <p class="description text-center">
                        Find quick answers to common questions about shipping, payments, orders, and returns.
                    </p>
                </section>

                <!-- Shipping Section -->
                <section class="mb-6">
                    <h4 class="title title-center mb-5">Shipping Information</h4>
                    <div class="row">
                        <div class="col-md-6 mb-8">
                            <div class="accordion accordion-bg accordion-gutter-md accordion-border">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse1-1" class="collapse">What Shipping Methods are Available?</a>
                                    </div>
                                    <div id="collapse1-1" class="card-body expanded">
                                        <p class="mb-0">
                                            We offer standard, express, and same-day delivery (in select areas). Options are
                                            shown at checkout.
                                        </p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse1-2" class="expand">How Long Will it Take to Get My Package?</a>
                                    </div>
                                    <div id="collapse1-2" class="card-body collapsed">
                                        <p class="mb-0">
                                            Standard shipping takes 3–7 business days. Express delivery usually arrives in
                                            1–3 business days.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-8">
                            <div class="accordion accordion-bg accordion-gutter-md accordion-border">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse1-3" class="collapse">Do You Ship Internationally?</a>
                                    </div>
                                    <div id="collapse1-3" class="card-body expanded">
                                        <p class="mb-0">
                                            Yes, we ship worldwide. International shipping costs and delivery times vary by
                                            location.
                                        </p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse1-4" class="expand">Can I Get Free Shipping?</a>
                                    </div>
                                    <div id="collapse1-4" class="card-body collapsed">
                                        <p class="mb-0">
                                            Free shipping is available on orders over the minimum amount shown at checkout
                                            or during promotions.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Payment Section -->
                <section class="mb-10">
                    <h4 class="title title-center mb-5">Payment</h4>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="accordion accordion-bg accordion-gutter-md accordion-border">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse2-1" class="collapse">What Payment Methods are Accepted?</a>
                                    </div>
                                    <div id="collapse2-1" class="card-body expanded">
                                        <p class="mb-0">
                                            We accept credit/debit cards, PayPal, bank transfers, and other secure online
                                            payment options.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="accordion accordion-bg accordion-gutter-md accordion-border">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse2-2" class="collapse">Is Buying Online Safe?</a>
                                    </div>
                                    <div id="collapse2-2" class="card-body expanded">
                                        <p class="mb-0">
                                            Yes, our site uses SSL encryption and trusted gateways to ensure your data and
                                            payments are always secure.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Orders & Returns Section -->
                <section class="mb-10">
                    <h4 class="title title-center mb-5">Orders & Returns</h4>
                    <div class="row">
                        <div class="col-md-6 mb-8">
                            <div class="accordion accordion-bg accordion-gutter-md accordion-border">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse3-1" class="collapse">How do I Place an Order?</a>
                                    </div>
                                    <div id="collapse3-1" class="card-body expanded">
                                        <p class="mb-0">
                                            Simply browse products, add them to your cart, and follow the checkout steps to
                                            complete your purchase.
                                        </p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse3-3" class="expand">Do I Need an Account to Place an Order?</a>
                                    </div>
                                    <div id="collapse3-3" class="card-body collapsed">
                                        <p class="mb-0">
                                            You can check out as a guest, but creating an account makes tracking and
                                            managing orders easier.
                                        </p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse3-5" class="expand">How Can I Return a Product?</a>
                                    </div>
                                    <div id="collapse3-5" class="card-body collapsed">
                                        <p class="mb-0">
                                            Items can be returned within 7 days of delivery. Please ensure products are
                                            unused and in original packaging.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-8">
                            <div class="accordion accordion-bg accordion-gutter-md accordion-border">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse3-2" class="collapse">How Can I Change My Order?</a>
                                    </div>
                                    <div id="collapse3-2" class="card-body expanded">
                                        <p class="mb-0">
                                            You can update or cancel your order within 24 hours of purchase by contacting
                                            customer service.
                                        </p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse3-4" class="expand">How do I Track My Order?</a>
                                    </div>
                                    <div id="collapse3-4" class="card-body collapsed">
                                        <p class="mb-0">
                                            After shipping, you’ll receive a tracking link via email. You can also track
                                            your order in your account.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
@endsection

@section('script')

@endsection
