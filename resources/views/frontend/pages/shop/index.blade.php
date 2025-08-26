@extends('frontend.layouts.master')

@section('title', 'Shop Now')

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
                    <li>Shop Now</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of Page Content -->
        <div class="page-content mb-10">
            <div class="container">
                <!-- Start of Shop Banner -->
                <div class="shop-default-banner banner d-flex align-items-center mb-5 br-xs"
                    style="background-image: url({{ asset('frontAssets/images/shop/banner1.jpg') }}); background-color: #FFC74E;">
                    <div class="banner-content">
                        <h4 class="banner-subtitle font-weight-bold">Accessories Collection</h4>
                        <h3 class="banner-title text-white text-uppercase font-weight-bolder ls-normal">Smart Wrist
                            Watches</h3>
                        <a href="shop-banner-sidebar.html" class="btn btn-dark btn-rounded btn-icon-right">Discover
                            Now<i class="w-icon-long-arrow-right"></i></a>
                    </div>
                </div>
                <!-- End of Shop Banner -->

                <!-- Start of Shop Category -->
                @if (isset($categories) && count($categories))
                    <div class="shop-default-category category-ellipse-section mb-6">
                        <div class="swiper-container swiper-theme shadow-swiper"
                            data-swiper-options="{
                                'spaceBetween': 20,
                                'slidesPerView': 2,
                                'breakpoints': {
                                    '480': {
                                        'slidesPerView': 3
                                    },
                                    '576': {
                                        'slidesPerView': 4
                                    },
                                    '768': {
                                        'slidesPerView': 6
                                    },
                                    '992': {
                                        'slidesPerView': 7
                                    },
                                    '1200': {
                                        'slidesPerView': 8,
                                        'spaceBetween': 30
                                    }
                                }
                            }">
                            <div
                                class="swiper-wrapper row gutter-lg cols-xl-8 cols-lg-7 cols-md-6 cols-sm-4 cols-xs-3 cols-2">
                                @foreach ($categories as $category)
                                    <div class="swiper-slide category-wrap">
                                        <div class="category category-ellipse">
                                            <figure class="category-media">
                                                <a href="{{ route('frontend.shop', $category->slug) }}">
                                                    <img src="{{ $category->image ? asset($category->image) : 'frontAssets/images/categories/category-4.jpg' }}"
                                                        alt="Categroy" width="190" height="190"
                                                        style="background-color: #5C92C0;" />
                                                </a>
                                            </figure>
                                            <div class="category-content">
                                                <h4 class="category-name">
                                                    <a
                                                        href="{{ route('frontend.shop', $category->slug) }}">{{ $category->name }}</a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                @endif
                <!-- End of Shop Category -->

                <div class="shop-content toolbox-horizontal">
                    <!-- Start of Toolbox -->
                    <nav class="toolbox sticky-toolbox sticky-content fix-top">
                        <aside class="sidebar sidebar-fixed shop-sidebar">
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                            <div class="sidebar-content toolbox-left">
                                <!-- Start of Collapsible widget -->
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">All Categories</a>
                                    <ul class="filter-items">
                                        <li><a href="#">Accessories</a></li>
                                        <li><a href="#">Babies</a></li>
                                        <li><a href="#">Beauty</a></li>
                                        <li><a href="#">Decoration</a></li>
                                        <li><a href="#">Electronics</a></li>
                                        <li><a href="#">Fashion</a></li>
                                        <li><a href="#">Food</a></li>
                                        <li><a href="#">Furniture</a></li>
                                        <li><a href="#">Kitchen</a></li>
                                        <li><a href="#">Medical</a></li>
                                        <li><a href="#">Sports</a></li>
                                        <li><a href="#">Watches</a></li>
                                    </ul>
                                </div>
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Price</a>
                                    <ul class="filter-items">
                                        <li><a href="#">$0.00 - $100.00</a></li>
                                        <li><a href="#">$100.00 - $200.00</a></li>
                                        <li><a href="#">$200.00 - $300.00</a></li>
                                        <li><a href="#">$300.00 - $500.00</a></li>
                                        <li><a href="#">$500.00+</a></li>
                                        <li>
                                            <form class="price-range">
                                                <input type="number" name="min_price" class="min_price text-center"
                                                    placeholder="$min"><span class="delimiter">-</span><input type="number"
                                                    name="max_price" class="max_price text-center" placeholder="$max"><a
                                                    href="#" class="btn btn-primary btn-rounded">Go</a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Size</a>
                                    <ul class="filter-items item-check">
                                        <li><a href="#">Extra Large</a></li>
                                        <li><a href="#">Large</a></li>
                                        <li><a href="#">Medium</a></li>
                                        <li><a href="#">Small</a></li>
                                    </ul>
                                </div>
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Brand</a>
                                    <ul class="filter-items item-check">
                                        <li><a href="#">Elegant Auto Group</a></li>
                                        <li><a href="#">Green Grass</a></li>
                                        <li><a href="#">Node Js</a></li>
                                        <li><a href="#">NS8</a></li>
                                        <li><a href="#">Red</a></li>
                                        <li><a href="#">Skysuite Tech</a></li>
                                        <li><a href="#">Sterling</a></li>
                                    </ul>
                                </div>
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Color</a>
                                    <ul class="filter-items item-check">
                                        <li><a href="#">Black</a></li>
                                        <li><a href="#">Blue</a></li>
                                        <li><a href="#">Brown</a></li>
                                        <li><a href="#">Green</a></li>
                                        <li><a href="#">Grey</a></li>
                                        <li><a href="#">Orange</a></li>
                                        <li><a href="#">Yellow</a></li>
                                    </ul>
                                </div>
                                <!-- End of Collapsible Widget -->
                            </div>
                        </aside>
                        <div class="toolbox-left">
                            <div class="toolbox-item toolbox-sort select-menu">
                                <a href="#"
                                    class="btn btn-primary btn-outline btn-rounded left-sidebar-toggle
                                        btn-icon-left d-block d-lg-none"><i
                                        class="w-icon-category"></i><span>Filters</span></a>
                                <select name="orderby" class="form-control">
                                    <option value="default" selected="selected">Default sorting</option>
                                    <option value="popularity">Sort by popularity</option>
                                    <option value="rating">Sort by average rating</option>
                                    <option value="date">Sort by latest</option>
                                    <option value="price-low">Sort by pric: low to high</option>
                                    <option value="price-high">Sort by price: high to low</option>
                                </select>
                            </div>
                        </div>
                        <div class="toolbox-right">
                            <div class="toolbox-item toolbox-show select-box">
                                <select name="count" class="form-control">
                                    <option value="12">Show 12</option>
                                    <option value="24">Show 24</option>
                                    <option value="36">Show 36</option>
                                </select>
                            </div>
                            <div class="toolbox-item toolbox-layout">
                                <a href="shop-horizontal-filter.html" class="icon-mode-grid btn-layout active">
                                    <i class="w-icon-grid"></i>
                                </a>
                                <a href="shop-list.html" class="icon-mode-list btn-layout">
                                    <i class="w-icon-list"></i>
                                </a>
                            </div>
                        </div>
                    </nav>
                    <!-- End of Toolbox -->

                    <!-- Start of Selected Items -->
                    <div class="selected-items mb-3">
                        <a href="#" class="filter-clean text-primary">Clean All</a>
                    </div>
                    <!-- End of Selected Items -->

                    @if (isset($products) && count($products) > 0)
                        <!-- Start of Product Wrapper -->
                        <div class="product-wrapper row cols-lg-4 cols-md-3 cols-sm-2 cols-2">
                            @foreach ($products as $product)
                                <div class="product-wrap">
                                    <div class="product text-center">
                                        <figure class="product-media">
                                            <a href="{{ route('frontend.product.show', $product->slug) }}">
                                                <img src="{{ asset($product->main_image) }}" alt="Product"
                                                    width="300" height="338" />
                                            </a>
                                            <div class="product-action-horizontal">
                                                <a href="#"
                                                    class="btn-product-icon btn-cart w-icon-cart add-to-cart"
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-quantity="1"
                                                    title="Add to cart">
                                                </a>
                                                <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                    title="Wishlist"></a>
                                                <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                                    title="Compare"></a>
                                                <a href="#" class="btn-product-icon btn-quickview w-icon-search"
                                                    title="Quick View" data-product-id="{{ $product->id }}"></a>
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            @if (isset($product->category))
                                                <div class="product-cat">
                                                    <a
                                                        href="{{ route('frontend.shop', $product->category->slug) }}">{{ $product->category->name }}</a>
                                                </div>
                                            @endif
                                            <h3 class="product-name">
                                                <a href="{{ route('frontend.product.show', $product->slug) }}">{{ $product->name }}</a>
                                            </h3>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="{{ route('frontend.product.show', $product->slug) }}" class="rating-reviews">(3 reviews)</a>
                                            </div>
                                            <div class="product-pa-wrapper">
                                                <div class="product-price">
                                                    {{ \App\Helpers\Helper::formatCurrency($product->price) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- End of Product Wrapper -->

                        <!-- Start of Pagination -->
                        {{-- <div class="toolbox toolbox-pagination justify-content-between">
                            <p class="showing-info mb-2 mb-sm-0">
                                Showing<span>1-12 of 60</span>Products
                            </p>
                            <ul class="pagination">
                                <li class="prev disabled">
                                    <a href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                        <i class="w-icon-long-arrow-left"></i>Prev
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="next">
                                    <a href="#" aria-label="Next">
                                        Next<i class="w-icon-long-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
                        <!-- Quick View Modal -->
                        <div class="modal fade" id="quickViewModal" tabindex="-1" role="dialog"
                            aria-labelledby="quickViewModalLabel" aria-hidden="true">
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
                                                        <div
                                                            class="swiper-container product-single-swiper swiper-theme nav-inner">
                                                            <div class="swiper-wrapper row cols-1 gutter-no"
                                                                id="quickViewImages">
                                                                <!-- Images will be populated here -->
                                                            </div>
                                                            <button class="swiper-button-next"></button>
                                                            <button class="swiper-button-prev"></button>
                                                        </div>
                                                        <div class="product-thumbs-wrap swiper-container"
                                                            id="quickViewThumbs">
                                                            <div
                                                                class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
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
                                                                    Category: <span class="product-category"
                                                                        id="quickViewCategory"></span>
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
                                                            <a href="#" class="rating-reviews"
                                                                id="quickViewReviews"></a>
                                                        </div>
                                                        <div class="product-short-desc" id="quickViewDescription">
                                                            <!-- Description will be populated here -->
                                                        </div>
                                                        <div class="product-form">
                                                            <div class="product-qty-form">
                                                                <div class="input-group">
                                                                    <input class="quantity form-control" type="number"
                                                                        min="1" max="10000000">
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
                                                                    <a href="#"
                                                                        class="social-icon social-facebook w-icon-facebook"></a>
                                                                    <a href="#"
                                                                        class="social-icon social-twitter w-icon-twitter"></a>
                                                                    <a href="#"
                                                                        class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                                                    <a href="#"
                                                                        class="social-icon social-whatsapp fab fa-whatsapp"></a>
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
                        <!-- End of Pagination -->
                    @else
                        <p>No Products Available</p>
                    @endif
                </div>
            </div>
        </div>
        <!-- End of Page Content -->

        <!-- Start of Quick View -->
        <div class="product product-single product-popup">
            <div class="row gutter-lg">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="product-gallery product-gallery-sticky">
                        <div class="swiper-container product-single-swiper swiper-theme nav-inner">
                            <div class="swiper-wrapper row cols-1 gutter-no">
                                <div class="swiper-slide">
                                    <figure class="product-image">
                                        <img src="{{ asset('frontAssets/images/products/popup/1-440x494.jpg') }}"
                                            data-zoom-image="{{ asset('frontAssets/images/products/popup/1-800x900.jpg') }}"
                                            alt="Water Boil Black Utensil" width="800" height="900">
                                    </figure>
                                </div>
                                <div class="swiper-slide">
                                    <figure class="product-image">
                                        <img src="{{ asset('frontAssets/images/products/popup/2-440x494.jpg') }}"
                                            data-zoom-image="{{ asset('frontAssets/images/products/popup/2-800x900.jpg') }}"
                                            alt="Water Boil Black Utensil" width="800" height="900">
                                    </figure>
                                </div>
                                <div class="swiper-slide">
                                    <figure class="product-image">
                                        <img src="{{ asset('frontAssets/images/products/popup/3-440x494.jpg') }}"
                                            data-zoom-image="{{ asset('frontAssets/images/products/popup/3-800x900.jpg') }}"
                                            alt="Water Boil Black Utensil" width="800" height="900">
                                    </figure>
                                </div>
                                <div class="swiper-slide">
                                    <figure class="product-image">
                                        <img src="{{ asset('frontAssets/images/products/popup/4-440x494.jpg') }}"
                                            data-zoom-image="{{ asset('frontAssets/images/products/popup/4-800x900.jpg') }}"
                                            alt="Water Boil Black Utensil" width="800" height="900">
                                    </figure>
                                </div>
                            </div>
                            <button class="swiper-button-next"></button>
                            <button class="swiper-button-prev"></button>
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
                                    <img src="{{ asset('frontAssets/images/products/popup/1-103x116.jpg') }}"
                                        alt="Product Thumb" width="103" height="116">
                                </div>
                                <div class="product-thumb swiper-slide">
                                    <img src="{{ asset('frontAssets/images/products/popup/2-103x116.jpg') }}"
                                        alt="Product Thumb" width="103" height="116">
                                </div>
                                <div class="product-thumb swiper-slide">
                                    <img src="{{ asset('frontAssets/images/products/popup/3-103x116.jpg') }}"
                                        alt="Product Thumb" width="103" height="116">
                                </div>
                                <div class="product-thumb swiper-slide">
                                    <img src="{{ asset('frontAssets/images/products/popup/4-103x116.jpg') }}"
                                        alt="Product Thumb" width="103" height="116">
                                </div>
                            </div>
                            <button class="swiper-button-next"></button>
                            <button class="swiper-button-prev"></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 overflow-hidden p-relative">
                    <div class="product-details scrollable pl-0">
                        <h2 class="product-title">Electronics Black Wrist Watch</h2>
                        <div class="product-bm-wrapper">
                            <div class="product-meta">
                                <div class="product-categories">
                                    Category:
                                    <span class="product-category"><a href="#">Electronics</a></span>
                                </div>
                                <div class="product-sku">
                                    SKU: <span>MS46891340</span>
                                </div>
                            </div>
                        </div>

                        <hr class="product-divider">

                        <div class="product-price">$40.00</div>

                        <div class="ratings-container">
                            <div class="ratings-full">
                                <span class="ratings" style="width: 80%;"></span>
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                            <a href="#" class="rating-reviews">(3 Reviews)</a>
                        </div>

                        <div class="product-short-desc">
                            <ul class="list-type-check list-style-none">
                                <li>Ultrices eros in cursus turpis massa cursus mattis.</li>
                                <li>Volutpat ac tincidunt vitae semper quis lectus.</li>
                                <li>Aliquam id diam maecenas ultricies mi eget mauris.</li>
                            </ul>
                        </div>

                        <div class="product-form">
                            <div class="product-qty-form">
                                <div class="input-group">
                                    <input class="quantity form-control" type="number" min="1" max="10000000">
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
                                    <a href="#" class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                    <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                    <a href="#" class="social-icon social-youtube fab fa-linkedin-in"></a>
                                </div>
                            </div>
                            <span class="divider d-xs-show"></span>
                            <div class="product-link-wrapper d-flex">
                                <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                                <a href="#"
                                    class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Quick view -->
    </main>
    <!-- End of Main -->
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
            $(".add-to-cart").on("click", function (e) {
                e.preventDefault();

                let productId = $(this).data("product-id");
                let quantity  = $(this).data("product-quantity") || 1;

                $.ajax({
                    url: "{{ route('frontend.cart.add') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error("Something went wrong. Try again.");
                    }
                });
            });
        });


    </script>
@endsection
