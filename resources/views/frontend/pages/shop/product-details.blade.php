@extends('frontend.layouts.master')

@section('title', 'Checkout')

@section('css')
@endsection

@section('content')
    <!-- Start of Main -->
    <main class="main mb-10 pb-1">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav container">
            <ul class="breadcrumb bb-no">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Products</li>
            </ul>
            <ul class="product-nav list-style-none">
                @if (isset($previous))
                    <li class="product-nav-prev">
                        <a href="{{ route('frontend.product.show', $previous->slug) }}">
                            <i class="w-icon-angle-left"></i>
                        </a>
                        <span class="product-nav-popup">
                            <img src="{{ asset($previous->main_image) }}" alt="{{ $previous->name }}" width="110"
                                height="110" />
                            <span class="product-name">{{ $previous->name }}</span>
                        </span>
                    </li>
                @endif
                @if (isset($next))
                    <li class="product-nav-next">
                        <a href="{{ route('frontend.product.show', $next->slug) }}">
                            <i class="w-icon-angle-right"></i>
                        </a>
                        <span class="product-nav-popup">
                            <img src="{{ asset($next->main_image) }}" alt="{{ $next->name }}" width="110"
                                height="110" />
                            <span class="product-name">{{ $next->name }}</span>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of Page Content -->
        <div class="page-content">
            <div class="container">
                <div class="row gutter-lg">
                    <div class="main-content">
                        <div class="product product-single row mb-2">
                            <div class="col-md-6 mb-6">
                                <div class="product-gallery product-gallery-sticky">
                                    <div class="swiper-container product-single-swiper swiper-theme nav-inner"
                                        data-swiper-options="{
                                            'navigation': {
                                                'nextEl': '.swiper-button-next',
                                                'prevEl': '.swiper-button-prev'
                                            }
                                        }">
                                        <div class="swiper-wrapper row cols-1 gutter-no">
                                            <div class="swiper-slide">
                                                <figure class="product-image">
                                                    <img src="{{ asset($product->main_image) }}"
                                                        data-zoom-image="{{ asset($product->main_image) }}"
                                                        alt="{{ $product->name }}" width="800" height="900">
                                                </figure>
                                            </div>
                                            @if (isset($product->productImages) && count($product->productImages) > 0)
                                                @foreach ($product->productImages as $image)
                                                    <div class="swiper-slide">
                                                        <figure class="product-image">
                                                            <img src="{{ asset($image->image) }}"
                                                                data-zoom-image="{{ asset($image->image) }}"
                                                                alt="{{ $product->name }}" width="800" height="900">
                                                        </figure>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button class="swiper-button-next"></button>
                                        <button class="swiper-button-prev"></button>
                                        <a href="#" class="product-gallery-btn product-image-full"><i
                                                class="w-icon-zoom"></i></a>
                                        <div class="product-label-group">
                                            <label class="product-label label-hot">Hot</label>
                                            <label class="product-label label-discount">50% Off</label>
                                        </div>
                                    </div>
                                    <div class="product-thumbs-wrap swiper-container"
                                        data-swiper-options="{
                                            'navigation': {
                                                'nextEl': '.swiper-button-next',
                                                'prevEl': '.swiper-button-prev'
                                            }
                                        }">
                                        <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                                            <div class="product-thumb swiper-slide">
                                                <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}"
                                                    width="800" height="900">
                                            </div>
                                            @if (isset($product->productImages) && count($product->productImages) > 0)
                                                @foreach ($product->productImages as $image)
                                                    <div class="product-thumb swiper-slide">
                                                        <img src="{{ asset($image->image) }}" alt="{{ $product->name }}"
                                                            width="800" height="900">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button class="swiper-button-next"></button>
                                        <button class="swiper-button-prev"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 mb-md-6">
                                <div class="product-details" data-sticky-options="{'minWidth': 767}">
                                    <h1 class="product-title">{{ $product->name }}</h1>
                                    <div class="product-bm-wrapper">
                                        <div class="product-meta">
                                            <div class="product-categories">
                                                Category:
                                                <span class="product-category"><a
                                                        href="#">{{ $product->category->name }}</a></span>
                                            </div>
                                            <div class="product-sku">
                                                SKU: <span>{{ $product->sku }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="product-divider">

                                    <div class="product-price">
                                        <ins
                                            class="new-price">{{ \App\Helpers\Helper::formatCurrency($product->price) }}</ins>
                                        {{-- <del class="old-price">$60.00</del> --}}
                                    </div>

                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: 80%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="#product-tab-reviews" class="rating-reviews">(3 Reviews)</a>
                                    </div>

                                    <div class="product-short-desc">
                                        {!! $product->short_description !!}
                                    </div>

                                    <hr class="product-divider">

                                    <div class="fix-bottom product-sticky-content sticky-content">
                                        <form action="{{ route('frontend.cart.add.direct') }}" method="POST">
                                            @csrf
                                            <input type="text" value="{{ $product->id }}" name="product_id" hidden>
                                            <div class="product-form container">
                                                <div class="product-qty-form">
                                                    <div class="input-group">
                                                        <input class="quantity form-control" name="quantity"
                                                            type="number" min="1" max="10000000">
                                                        <button type="button" class="quantity-plus w-icon-plus"></button>
                                                        <button type="button"
                                                            class="quantity-minus w-icon-minus"></button>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-cart">
                                                    <i class="w-icon-cart"></i>
                                                    <span>Add to Cart</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="social-links-wrapper">
                                        <div class="social-links">
                                            <div class="social-icons social-no-color border-thin">
                                                <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                                <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                                <a href="#"
                                                    class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                                <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                                <a href="#"
                                                    class="social-icon social-youtube fab fa-linkedin-in"></a>
                                            </div>
                                        </div>
                                        <span class="divider d-xs-show"></span>
                                        <div class="product-link-wrapper d-flex">
                                            <a href="#"
                                                class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                                            <a href="#"
                                                class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab tab-nav-boxed tab-nav-underline product-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#product-tab-description" class="nav-link active">Description</a>
                                </li>
                                @if ($product->vendor_id)
                                    <li class="nav-item">
                                        <a href="#product-tab-vendor" class="nav-link">Vendor Info</a>
                                    </li>
                                @endif
                                {{-- <li class="nav-item">
                                    <a href="#product-tab-reviews" class="nav-link">Customer Reviews (3)</a>
                                </li> --}}
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="product-tab-description">
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-5">
                                            <h4 class="title tab-pane-title font-weight-bold mb-2">Detail</h4>
                                            {!! $product->description !!}
                                        </div>
                                    </div>
                                    <div class="row cols-md-3">
                                        <div class="mb-3">
                                            <h5 class="sub-title font-weight-bold"><span class="mr-3">1.</span>Free
                                                Shipping &amp; Return</h5>
                                            <p class="detail pl-5">We offer free shipping for products on orders
                                                above 50$ and offer free delivery for all orders in US.</p>
                                        </div>
                                        <div class="mb-3">
                                            <h5 class="sub-title font-weight-bold"><span>2.</span>Free and Easy
                                                Returns</h5>
                                            <p class="detail pl-5">We guarantee our products and you could get back
                                                all of your money anytime you want in 30 days.</p>
                                        </div>
                                        <div class="mb-3">
                                            <h5 class="sub-title font-weight-bold"><span>3.</span>Special Financing
                                            </h5>
                                            <p class="detail pl-5">Get 20%-50% off items over 50$ for a month or
                                                over 250$ for a year with our special credit card.</p>
                                        </div>
                                    </div>
                                </div>
                                @if ($product->vendor_id)
                                    <div class="tab-pane" id="product-tab-vendor">
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-4">
                                                <figure class="vendor-banner br-sm">
                                                    <img src="{{ asset('frontAssets/images/products/vendor-banner.jpg') }}"
                                                        alt="Vendor Banner" width="610" height="295"
                                                        style="background-color: #353B55;" />
                                                </figure>
                                            </div>
                                            <div class="col-md-6 pl-2 pl-md-6 mb-4">
                                                <div class="vendor-user">
                                                    <figure class="vendor-logo mr-4">
                                                        <a href="#">
                                                            <img src="{{ asset('frontAssets/images/products/vendor-logo.jpg') }}"
                                                                alt="Vendor Logo" width="80" height="80" />
                                                        </a>
                                                    </figure>
                                                    <div>
                                                        <div class="vendor-name"><a
                                                                href="#">{{ $product->vendor->name }}</a></div>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: 90%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <a href="#" class="rating-reviews">(32 Reviews)</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="vendor-info list-style-none">
                                                    <li class="store-name">
                                                        <label>Store Name:</label>
                                                        <span
                                                            class="detail">{{ $product->vendor->userShop->shop_name }}</span>
                                                    </li>
                                                    <li class="store-address">
                                                        <label>Address:</label>
                                                        <span class="detail">Steven Street, El Carjon, CA 92020, United
                                                            States (US)</span>
                                                    </li>
                                                    <li class="store-phone">
                                                        <label>Email:</label>
                                                        <a href="#mailto:">{{ $product->vendor->email }}</a>
                                                    </li>
                                                </ul>
                                                <a href="vendor-dokan-store.html"
                                                    class="btn btn-dark btn-link btn-underline btn-icon-right">Visit
                                                    Store<i class="w-icon-long-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- <div class="tab-pane" id="product-tab-reviews">
                                    <div class="row mb-4">
                                        <div class="col-xl-4 col-lg-5 mb-4">
                                            <div class="ratings-wrapper">
                                                <div class="avg-rating-container">
                                                    <h4 class="avg-mark font-weight-bolder ls-50">3.3</h4>
                                                    <div class="avg-rating">
                                                        <p class="text-dark mb-1">Average Rating</p>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: 60%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <a href="#" class="rating-reviews">(3 Reviews)</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ratings-value d-flex align-items-center text-dark ls-25">
                                                    <span class="text-dark font-weight-bold">66.7%</span>Recommended<span
                                                        class="count">(2 of 3)</span>
                                                </div>
                                                <div class="ratings-list">
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 100%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark>70%</mark>
                                                        </div>
                                                    </div>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 80%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark>30%</mark>
                                                        </div>
                                                    </div>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 60%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark>40%</mark>
                                                        </div>
                                                    </div>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 40%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark>0%</mark>
                                                        </div>
                                                    </div>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 20%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark>0%</mark>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-7 mb-4">
                                            <div class="review-form-wrapper">
                                                <h3 class="title tab-pane-title font-weight-bold mb-1">Submit Your
                                                    Review</h3>
                                                <p class="mb-3">Your email address will not be published. Required
                                                    fields are marked *</p>
                                                <form action="#" method="POST" class="review-form">
                                                    <div class="rating-form">
                                                        <label for="rating">Your Rating Of This Product :</label>
                                                        <span class="rating-stars">
                                                            <a class="star-1" href="#">1</a>
                                                            <a class="star-2" href="#">2</a>
                                                            <a class="star-3" href="#">3</a>
                                                            <a class="star-4" href="#">4</a>
                                                            <a class="star-5" href="#">5</a>
                                                        </span>
                                                        <select name="rating" id="rating" required=""
                                                            style="display: none;">
                                                            <option value="">Rate…</option>
                                                            <option value="5">Perfect</option>
                                                            <option value="4">Good</option>
                                                            <option value="3">Average</option>
                                                            <option value="2">Not that bad</option>
                                                            <option value="1">Very poor</option>
                                                        </select>
                                                    </div>
                                                    <textarea cols="30" rows="6" placeholder="Write Your Review Here..." class="form-control"
                                                        id="review"></textarea>
                                                    <div class="row gutter-md">
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                placeholder="Your Name" id="author">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                placeholder="Your Email" id="email_1">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" class="custom-checkbox"
                                                            id="save-checkbox">
                                                        <label for="save-checkbox">Save my name, email, and website
                                                            in this browser for the next time I comment.</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-dark">Submit
                                                        Review</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab tab-nav-boxed tab-nav-outline tab-nav-center">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a href="#show-all" class="nav-link active">Show All</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#helpful-positive" class="nav-link">Most Helpful
                                                    Positive</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#helpful-negative" class="nav-link">Most Helpful
                                                    Negative</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#highest-rating" class="nav-link">Highest Rating</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#lowest-rating" class="nav-link">Lowest Rating</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="show-all">
                                                <ul class="comments list-style-none">
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="assets/images/agents/1-100x100.png"
                                                                    alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                        1:54 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                        <span class="ratings" style="width: 60%;"></span>
                                                                        <span class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>pellentesque habitant morbi tristique senectus
                                                                    et. In dictum non consectetur a erat.
                                                                    Nunc ultrices eros in cursus turpis massa
                                                                    tincidunt ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                        class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="assets/images/products/default/review-img-1.jpg"
                                                                                    width="60" height="60"
                                                                                    alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                    data-zoom-image="assets/images/products/default/review-img-1-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="assets/images/agents/2-100x100.png"
                                                                    alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                        1:52 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                        <span class="ratings" style="width: 80%;"></span>
                                                                        <span class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>Nullam a magna porttitor, dictum risus nec,
                                                                    faucibus sapien.
                                                                    Ultrices eros in cursus turpis massa tincidunt
                                                                    ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                        class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="assets/images/products/default/review-img-2.jpg"
                                                                                    width="60" height="60"
                                                                                    alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                    data-zoom-image="assets/images/products/default/review-img-2.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="assets/images/products/default/review-img-3.jpg"
                                                                                    width="60" height="60"
                                                                                    alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                    data-zoom-image="assets/images/products/default/review-img-3.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="assets/images/agents/3-100x100.png"
                                                                    alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                        1:21 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                        <span class="ratings" style="width: 60%;"></span>
                                                                        <span class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>In fermentum et sollicitudin ac orci phasellus. A
                                                                    condimentum vitae
                                                                    sapien pellentesque habitant morbi tristique
                                                                    senectus et. In dictum
                                                                    non consectetur a erat. Nunc scelerisque viverra
                                                                    mauris in aliquam sem fringilla.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                        class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (0)
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (1)
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane" id="helpful-positive">
                                                <ul class="comments list-style-none">
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="assets/images/agents/1-100x100.png"
                                                                    alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                        1:54 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                        <span class="ratings" style="width: 60%;"></span>
                                                                        <span class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>pellentesque habitant morbi tristique senectus
                                                                    et. In dictum non consectetur a erat.
                                                                    Nunc ultrices eros in cursus turpis massa
                                                                    tincidunt ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                        class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="assets/images/products/default/review-img-1.jpg"
                                                                                    width="60" height="60"
                                                                                    alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                    data-zoom-image="assets/images/products/default/review-img-1.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="assets/images/agents/2-100x100.png"
                                                                    alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                        1:52 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                        <span class="ratings" style="width: 80%;"></span>
                                                                        <span class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>Nullam a magna porttitor, dictum risus nec,
                                                                    faucibus sapien.
                                                                    Ultrices eros in cursus turpis massa tincidunt
                                                                    ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                        class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="assets/images/products/default/review-img-2.jpg"
                                                                                    width="60" height="60"
                                                                                    alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                    data-zoom-image="assets/images/products/default/review-img-2-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="assets/images/products/default/review-img-3.jpg"
                                                                                    width="60" height="60"
                                                                                    alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                    data-zoom-image="assets/images/products/default/review-img-3-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane" id="helpful-negative">
                                                <ul class="comments list-style-none">
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="assets/images/agents/3-100x100.png"
                                                                    alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                        1:21 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                        <span class="ratings" style="width: 60%;"></span>
                                                                        <span class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>In fermentum et sollicitudin ac orci phasellus. A
                                                                    condimentum vitae
                                                                    sapien pellentesque habitant morbi tristique
                                                                    senectus et. In dictum
                                                                    non consectetur a erat. Nunc scelerisque viverra
                                                                    mauris in aliquam sem fringilla.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                        class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (0)
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (1)
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane" id="highest-rating">
                                                <ul class="comments list-style-none">
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="assets/images/agents/2-100x100.png"
                                                                    alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                        1:52 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                        <span class="ratings" style="width: 80%;"></span>
                                                                        <span class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>Nullam a magna porttitor, dictum risus nec,
                                                                    faucibus sapien.
                                                                    Ultrices eros in cursus turpis massa tincidunt
                                                                    ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                        class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="assets/images/products/default/review-img-2.jpg"
                                                                                    width="60" height="60"
                                                                                    alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                    data-zoom-image="assets/images/products/default/review-img-2-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="assets/images/products/default/review-img-3.jpg"
                                                                                    width="60" height="60"
                                                                                    alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                    data-zoom-image="assets/images/products/default/review-img-3-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane" id="lowest-rating">
                                                <ul class="comments list-style-none">
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <figure class="comment-avatar">
                                                                <img src="assets/images/agents/1-100x100.png"
                                                                    alt="Commenter Avatar" width="90" height="90">
                                                            </figure>
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#">John Doe</a>
                                                                    <span class="comment-date">March 22, 2021 at
                                                                        1:54 pm</span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                        <span class="ratings" style="width: 60%;"></span>
                                                                        <span class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p>pellentesque habitant morbi tristique senectus
                                                                    et. In dictum non consectetur a erat.
                                                                    Nunc ultrices eros in cursus turpis massa
                                                                    tincidunt ante in nibh mauris cursus mattis.
                                                                    Cras ornare arcu dui vivamus arcu felis bibendum
                                                                    ut tristique.</p>
                                                                <div class="comment-action">
                                                                    <a href="#"
                                                                        class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                        <i class="far fa-thumbs-down"></i>Unhelpful
                                                                        (0)
                                                                    </a>
                                                                    <div class="review-image">
                                                                        <a href="#">
                                                                            <figure>
                                                                                <img src="assets/images/products/default/review-img-3.jpg"
                                                                                    width="60" height="60"
                                                                                    alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                    data-zoom-image="assets/images/products/default/review-img-3-800x900.jpg" />
                                                                            </figure>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <section class="related-product-section">
                            <div class="title-link-wrapper mb-4">
                                <h4 class="title">Related Products</h4>
                                <a href="{{ route('frontend.shop') }}"
                                    class="btn btn-dark btn-link btn-slide-right btn-icon-right">More
                                    Products<i class="w-icon-long-arrow-right"></i></a>
                            </div>
                            <div class="swiper-container swiper-theme"
                                data-swiper-options="{
                                    'spaceBetween': 20,
                                    'slidesPerView': 2,
                                    'breakpoints': {
                                        '576': {
                                            'slidesPerView': 3
                                        },
                                        '768': {
                                            'slidesPerView': 4
                                        },
                                        '992': {
                                            'slidesPerView': 3
                                        }
                                    }
                                }">
                                <div class="swiper-wrapper row cols-lg-3 cols-md-4 cols-sm-3 cols-2">
                                    @if (isset($related) && count($related) > 0)
                                        @foreach ($related as $relatedProduct)
                                            <div class="swiper-slide product">
                                                <figure class="product-media">
                                                    <a href="{{ route('frontend.product.show', $relatedProduct->slug) }}">
                                                        <img src="{{ asset($relatedProduct->main_image) }}"
                                                            alt="Product" width="300" height="338" />
                                                    </a>
                                                    <div class="product-action-vertical">
                                                        <a href="#"
                                                            class="btn-product-icon btn-cart w-icon-cart add-to-cart"
                                                            title="Add to cart"
                                                            data-product-id="{{ $relatedProduct->id }}"
                                                            data-product-quantity="1"></a>
                                                        <a href="#"
                                                            class="btn-product-icon btn-wishlist w-icon-heart"
                                                            title="Add to wishlist"></a>
                                                        <a href="#"
                                                            class="btn-product-icon btn-compare w-icon-compare"
                                                            title="Add to Compare"></a>
                                                    </div>
                                                    <div class="product-action">
                                                        <a href="#" class="btn-product btn-quickview"
                                                            title="Quick View"
                                                            data-product-id="{{ $relatedProduct->id }}">Quick
                                                            View</a>
                                                    </div>
                                                </figure>
                                                <div class="product-details">
                                                    <h4 class="product-name"><a
                                                            href="{{ route('frontend.product.show', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a>
                                                    </h4>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 100%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <a href="{{ route('frontend.product.show', $relatedProduct->slug) }}"
                                                            class="rating-reviews">(3 reviews)</a>
                                                    </div>
                                                    <div class="product-pa-wrapper">
                                                        <div class="product-price">
                                                            {{ \App\Helpers\Helper::formatCurrency($relatedProduct->price) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- End of Main Content -->
                    <aside class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper">
                        <div class="sidebar-overlay"></div>
                        <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                        <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
                        <div class="sidebar-content scrollable">
                            <div class="sticky-sidebar">
                                <div class="widget widget-icon-box mb-6">
                                    <div class="icon-box icon-box-side">
                                        <span class="icon-box-icon text-dark">
                                            <i class="w-icon-truck"></i>
                                        </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title">Free Shipping & Returns</h4>
                                            <p>For all orders over $99</p>
                                        </div>
                                    </div>
                                    <div class="icon-box icon-box-side">
                                        <span class="icon-box-icon text-dark">
                                            <i class="w-icon-bag"></i>
                                        </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title">Secure Payment</h4>
                                            <p>We ensure secure payment</p>
                                        </div>
                                    </div>
                                    <div class="icon-box icon-box-side">
                                        <span class="icon-box-icon text-dark">
                                            <i class="w-icon-money"></i>
                                        </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title">Money Back Guarantee</h4>
                                            <p>Any back within 30 days</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Widget Icon Box -->

                                <div class="widget widget-banner mb-9">
                                    <div class="banner banner-fixed br-sm">
                                        <figure>
                                            <img src="{{ asset('frontAssets/images/shop/banner3.jpg') }}" alt="Banner"
                                                width="266" height="220" style="background-color: #1D2D44;" />
                                        </figure>
                                        <div class="banner-content">
                                            <div class="banner-price-info font-weight-bolder text-white lh-1 ls-25">
                                                40<sup class="font-weight-bold">%</sup><sub
                                                    class="font-weight-bold text-uppercase ls-25">Off</sub>
                                            </div>
                                            <h4 class="banner-subtitle text-white font-weight-bolder text-uppercase mb-0">
                                                Ultimate Sale</h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Widget Banner -->

                                <div class="widget widget-products">
                                    <div class="title-link-wrapper mb-2">
                                        <h4 class="title title-link font-weight-bold">More Products</h4>
                                    </div>

                                    <div class="swiper nav-top">
                                        <div class="swiper-container swiper-theme nav-top"
                                            data-swiper-options = "{
                                                'slidesPerView': 1,
                                                'spaceBetween': 20,
                                                'navigation': {
                                                    'prevEl': '.swiper-button-prev',
                                                    'nextEl': '.swiper-button-next'
                                                }
                                            }">
                                            <div class="swiper-wrapper">
                                                <div class="widget-col swiper-slide">
                                                    @if (isset($related) && count($related) > 0)
                                                        @foreach ($related as $relatedProduct)
                                                            <div class="product product-widget">
                                                                <figure class="product-media">
                                                                    <a href="{{ route('frontend.product.show', $relatedProduct->slug) }}">
                                                                        <img src="{{ asset($relatedProduct->main_image) }}"
                                                                            alt="Product" width="100" height="113" />
                                                                    </a>
                                                                </figure>
                                                                <div class="product-details">
                                                                    <h4 class="product-name">
                                                                        <a href="{{ route('frontend.product.show', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a>
                                                                    </h4>
                                                                    <div class="ratings-container">
                                                                        <div class="ratings-full">
                                                                            <span class="ratings" style="width: 100%;"></span>
                                                                            <span class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-price">{{ \App\Helpers\Helper::formatCurrency($relatedProduct->price) }}</div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- <button class="swiper-button-next"></button>
                                            <button class="swiper-button-prev"></button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- End of Sidebar -->
                </div>
            </div>
        </div>
        <!-- End of Page Content -->
    </main>
    <!-- End of Main -->

    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" role="dialog" aria-labelledby="quickViewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                    <div class="product product-single product-popup">
                        <div class="row gutter-lg">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <div class="product-gallery product-gallery-sticky">
                                    <div class="swiper-container product-single-swiper swiper-theme nav-inner">
                                        <div class="swiper-wrapper row cols-1 gutter-no" id="quickViewImages">
                                            <!-- Images will be populated here -->
                                        </div>
                                        <button class="swiper-button-next"></button>
                                        <button class="swiper-button-prev"></button>
                                    </div>
                                    <div class="product-thumbs-wrap swiper-container" id="quickViewThumbs">
                                        <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                                            <!-- Thumbnails will be populated here -->
                                        </div>
                                        <button class="swiper-button-next"></button>
                                        <button class="swiper-button-prev"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 overflow-hidden p-relative">
                                <div class="product-details scrollable pl-0">
                                    <h2 class="product-title" id="quickViewTitle"></h2>
                                    <div class="product-bm-wrapper">
                                        <div class="product-meta">
                                            <div class="product-categories">
                                                Category: <span class="product-category" id="quickViewCategory"></span>
                                            </div>
                                            <div class="product-sku">
                                                SKU: <span id="quickViewSKU"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="product-divider">
                                    <div class="product-price" id="quickViewPrice"></div>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" id="quickViewRating"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="#" class="rating-reviews" id="quickViewReviews"></a>
                                    </div>
                                    <div class="product-short-desc" id="quickViewDescription">
                                        <!-- Description will be populated here -->
                                    </div>
                                    <div class="product-form">
                                        <div class="product-qty-form">
                                            <div class="input-group">
                                                <input class="quantity form-control" type="number" min="1"
                                                    max="10000000">
                                                <button class="quantity-plus w-icon-plus"></button>
                                                <button class="quantity-minus w-icon-minus"></button>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-cart">
                                            <i class="w-icon-cart"></i>
                                            <span>Add to Cart</span>
                                        </button>
                                    </div>
                                    <div class="social-links-wrapper">
                                        <div class="social-links">
                                            <div class="social-icons social-no-color border-thin">
                                                <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                                <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                                <a href="#"
                                                    class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                                <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                                <a href="#"
                                                    class="social-icon social-youtube fab fa-linkedin-in"></a>
                                            </div>
                                        </div>
                                        <span class="divider d-xs-show"></span>
                                        <div class="product-link-wrapper d-flex">
                                            <a href="#"
                                                class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                                            <a href="#"
                                                class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Quick View Modal -->
@endsection

@section('script')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS (ensure it includes modal functionality) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Include Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Your custom script -->
    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
            console.log("Form is submitting...");
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle Quick View button click
            $('.btn-quickview').on('click', function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');

                // Fetch product details via AJAX
                $.ajax({
                    url: '/product/' + productId + '/quick-view',
                    method: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            var product = response.product;

                            // Populate Quick View modal
                            $('#quickViewTitle').text(product.name);
                            $('#quickViewCategory').html('<a href="' + (product.category_slug ?
                                    '/shop/' + product.category_slug : '#') + '">' + product
                                .category + '</a>');
                            $('#quickViewSKU').text(product.sku);
                            $('#quickViewPrice').text(product.price);
                            $('#quickViewRating').css('width', product.rating + '%');
                            $('#quickViewReviews').text('(' + product.reviews + ' Reviews)');
                            $('#quickViewDescription').html(
                                '<ul class="list-type-check list-style-none">' +
                                (product.description ? product.description.split('\n').map(
                                        line => '<li>' + line + '</li>').join('') :
                                    '<li>No description available.</li>') +
                                '</ul>'
                            );

                            // Populate images
                            var imagesHtml = '';
                            var thumbsHtml = '';
                            product.images.forEach(function(image) {
                                imagesHtml += `
                            <div class="swiper-slide">
                                <figure class="product-image">
                                    <img src="${image.full}" data-zoom-image="${image.full}" alt="${product.name}" width="800" height="900">
                                </figure>
                            </div>`;
                                thumbsHtml += `
                            <div class="product-thumb swiper-slide">
                                <img src="${image.thumb}" alt="Product Thumb" width="103" height="116">
                            </div>`;
                            });
                            $('#quickViewImages').html(imagesHtml);
                            $('#quickViewThumbs .product-thumbs').html(thumbsHtml);

                            // Show the modal
                            $('#quickViewModal').modal('show');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Something went wrong! Please try again.');
                    }
                });
            });

            // Initialize Swiper after modal is shown
            $('#quickViewModal').on('shown.bs.modal', function() {
                if (typeof Swiper !== 'undefined') {
                    const mainSwiper = $('.product-single-swiper')[0]?.swiper;
                    const thumbSwiper = $('.product-thumbs-wrap')[0]?.swiper;
                    if (mainSwiper) mainSwiper.destroy(true, true);
                    if (thumbSwiper) thumbSwiper.destroy(true, true);

                    new Swiper('.product-single-swiper', {
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        slidesPerView: 1,
                        spaceBetween: 0,
                    });
                    new Swiper('.product-thumbs-wrap', {
                        slidesPerView: 4,
                        spaceBetween: 10,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
                }
            });

            // Clean up modal content when hidden
            $('#quickViewModal').on('hidden.bs.modal', function() {
                $('#quickViewTitle').text('');
                $('#quickViewCategory').html('');
                $('#quickViewSKU').text('');
                $('#quickViewPrice').text('');
                $('#quickViewRating').css('width', '0%');
                $('#quickViewReviews').text('');
                $('#quickViewDescription').html('');
                $('#quickViewImages').html('');
                $('#quickViewThumbs .product-thumbs').html('');
            });

            //Add to Cart
            $(".add-to-cart").on("click", function(e) {
                e.preventDefault();

                let productId = $(this).data("product-id");
                let quantity = $(this).data("product-quantity") || 1;

                $.ajax({
                    url: "{{ route('frontend.cart.add') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error("Something went wrong. Try again.");
                    }
                });
            });
        });
    </script>
@endsection
