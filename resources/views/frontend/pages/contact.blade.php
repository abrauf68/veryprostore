@extends('frontend.layouts.master')

@section('title', 'Contact Us')

@section('css')
@endsection

@section('content')
    <!-- Start of Main -->
    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">Contact Us</h1>
            </div>
        </div>
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav mb-10 pb-1">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content contact-us">
            <div class="container">
                <section class="content-title-section mb-10">
                    <h3 class="title title-center mb-3">Contact Information</h3>
                    <p class="text-center">
                        Have questions or need support? Our team is ready to assist you with orders, products, and services.
                    </p>
                </section>

                <!-- End of Contact Title Section -->

                <section class="contact-information-section mb-10">
                    <div class=" swiper-container swiper-theme "
                        data-swiper-options="{
                            'spaceBetween': 20,
                            'slidesPerView': 1,
                            'breakpoints': {
                                '480': {
                                    'slidesPerView': 2
                                },
                                '768': {
                                    'slidesPerView': 3
                                },
                                '992': {
                                    'slidesPerView': 4
                                }
                            }
                        }">
                        <div class="swiper-wrapper row cols-xl-4 cols-md-3 cols-sm-2 cols-1">
                            <div class="swiper-slide icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-email">
                                    <i class="w-icon-envelop-closed"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">E-mail Address</h4>
                                    <p><a
                                            href="mailto:{{ \App\Helpers\Helper::getCompanyEmail() }}">{{ \App\Helpers\Helper::getCompanyEmail() }}</a>
                                    </p>
                                </div>
                            </div>
                            <div class="swiper-slide icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-headphone">
                                    <i class="w-icon-headphone"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">Phone Number</h4>
                                    <p>+66 9 5491 0493</p>
                                </div>
                            </div>
                            <div class="swiper-slide icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-map-marker">
                                    <i class="w-icon-map-marker"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">Address</h4>
                                    <p>{{ \App\Helpers\Helper::getCompanyCity() }},
                                        {{ \App\Helpers\Helper::getCompanyZip() }},
                                        {{ \App\Helpers\Helper::getCompanyCountry() }}</p>
                                </div>
                            </div>
                            <div class="swiper-slide icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-fax">
                                    <i class="w-icon-fax"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">Fax</h4>
                                    <p>+66 9 5491 0493</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- End of Contact Information section -->

                <hr class="divider mb-10 pb-1">

                <section class="contact-section">
                    <div class="row gutter-lg pb-3">
                        <div class="col-lg-6 mb-8">
                            <h4 class="title mb-3">People usually ask these</h4>
                            <div class="accordion accordion-bg accordion-gutter-md accordion-border">

                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse1" class="collapse">How can I cancel my order?</a>
                                    </div>
                                    <div id="collapse1" class="card-body expanded">
                                        <p class="mb-0">
                                            Orders can be canceled within 24 hours of purchase. After that, please contact
                                            our support team for assistance.
                                        </p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse2" class="expand">Why is my registration delayed?</a>
                                    </div>
                                    <div id="collapse2" class="card-body collapsed">
                                        <p class="mb-0">
                                            Registration may take extra time if verification is required. You’ll receive an
                                            email once your account is approved.
                                        </p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse3" class="expand">What do I need to buy products?</a>
                                    </div>
                                    <div id="collapse3" class="card-body collapsed">
                                        <p class="mb-0">
                                            All you need is a free account with us. Simply sign in, add items to your cart,
                                            and complete checkout securely.
                                        </p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse4" class="expand">How can I track an order?</a>
                                    </div>
                                    <div id="collapse4" class="card-body collapsed">
                                        <p class="mb-0">
                                            Once your order ships, you’ll get a tracking number by email. You can also track
                                            it directly in your account dashboard.
                                        </p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a href="#collapse5" class="expand">How can I get money back?</a>
                                    </div>
                                    <div id="collapse5" class="card-body collapsed">
                                        <p class="mb-0">
                                            If you are not satisfied, request a return within 7 days. Refunds are processed
                                            once items are received in original condition.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 mb-8">
                            <h4 class="title mb-3">Send Us a Message</h4>
                            <form class="form contact-us-form" action="{{ route('frontend.contact.store') }}"
                                method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Your Name</label>
                                    <input type="text" id="name" name="name" required
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Your Email</label>
                                    <input type="email" id="email" name="email" required
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="message">Your Message</label>
                                    <textarea id="message" name="message" required cols="30" rows="5"
                                        class="form-control @error('message') is-invalid @enderror"></textarea>
                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-dark btn-rounded">Send Now</button>
                            </form>
                        </div>
                    </div>
                </section>
                <!-- End of Contact Section -->
            </div>

            <!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
            {{-- <div class="google-map contact-google-map" id="googlemaps"></div> --}}
            <!-- End Map Section -->
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
@endsection

@section('script')

@endsection
