@extends('frontend.layouts.master')

@section('title', 'Cart')

@section('css')
@endsection

@section('content')
    <!-- Start of Main -->
    <main class="main cart">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb shop-breadcrumb bb-no">
                    <li class="active"><a href="cart.html">Shopping Cart</a></li>
                    <li><a href="checkout.html">Checkout</a></li>
                    <li><a href="order.html">Order Complete</a></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        @if (isset($cart->items) && count($cart->items) > 0)
            <div class="page-content">
                <div class="container">
                    <div class="row gutter-lg mb-10">
                        <div class="col-lg-8 pr-lg-4 mb-6">
                            <form action="{{ route('frontend.cart.update') }}" method="POST">
                                @csrf
                                <table class="shop-table cart-table">
                                    <thead>
                                        <tr>
                                            <th class="product-name"><span>Product</span></th>
                                            <th></th>
                                            <th class="product-price"><span>Price</span></th>
                                            <th class="product-quantity"><span>Quantity</span></th>
                                            <th class="product-subtotal"><span>Subtotal</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart->items as $item)
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <div class="p-relative">
                                                        <a href="#">
                                                            <figure>
                                                                <img src="{{ $item->product->main_image }}" alt="product"
                                                                    width="300" height="338">
                                                            </figure>
                                                        </a>
                                                        <form action="{{ route('frontend.cart.remove', $item->id) }}"
                                                            method="GET">
                                                            @csrf
                                                            <button type="submit" class="btn btn-close"><i
                                                                    class="fas fa-times"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="product-name">
                                                    <a href="#">{{ $item->product->name }}</a>
                                                </td>
                                                <td class="product-price">
                                                    <span
                                                        class="amount">{{ \App\Helpers\Helper::formatCurrency($item->product->price) }}</span>
                                                </td>
                                                <td class="product-quantity">
                                                    <div class="input-group">
                                                        <input class="quantity form-control" type="number" min="1"
                                                            max="100000" name="items[{{ $item->id }}][quantity]"
                                                            value="{{ $item->quantity }}">
                                                        <button type="button" class="quantity-plus w-icon-plus"></button>
                                                        <button type="button" class="quantity-minus w-icon-minus"></button>
                                                    </div>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span
                                                        class="amount">{{ \App\Helpers\Helper::formatCurrency($item->price) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="cart-action mb-6">
                                    <a href="#" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto">
                                        <i class="w-icon-long-arrow-left"></i>Continue Shopping
                                    </a>
                                    <a href="{{ route('frontend.cart.clear') }}"
                                        class="btn btn-rounded btn-default btn-clear">
                                        Clear Cart
                                    </a>
                                    <button type="submit" class="btn btn-rounded btn-update" name="update_cart">
                                        Update Cart
                                    </button>
                                </div>
                            </form>


                            {{-- <form class="coupon">
                                <h5 class="title coupon-title font-weight-bold text-uppercase">Coupon Discount</h5>
                                <input type="text" class="form-control mb-4" placeholder="Enter coupon code here..."
                                    required />
                                <button class="btn btn-dark btn-outline btn-rounded">Apply Coupon</button>
                            </form> --}}
                        </div>
                        <div class="col-lg-4 sticky-sidebar-wrapper">
                            <div class="sticky-sidebar">
                                <div class="cart-summary mb-4">
                                    <h3 class="cart-title text-uppercase">Cart Totals</h3>
                                    <div class="cart-subtotal d-flex align-items-center justify-content-between">
                                        <label class="ls-25">Subtotal</label>
                                        <span>{{ \App\Helpers\Helper::formatCurrency($subtotal) }}</span>
                                    </div>

                                    <hr class="divider">

                                    <div class="cart-subtotal d-flex align-items-center justify-content-between">
                                        <label class="ls-25">Discount</label>
                                        <span>0.00</span>
                                    </div>

                                    <hr class="divider mb-6">
                                    <div class="order-total d-flex justify-content-between align-items-center">
                                        <label>Total</label>
                                        <span class="ls-50">{{ \App\Helpers\Helper::formatCurrency($subtotal) }}</span>
                                    </div>
                                    <a href="{{ route('frontend.checkout') }}"
                                        class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                                        Proceed to checkout<i class="w-icon-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div style="display: flex; flex-direction:column; justify-content:center; align-items:center">
                <p>No Items in Cart</p>
                <div class="cart-action mb-6">
                    <a href="{{ route('frontend.shop') }}"
                        class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i
                            class="w-icon-long-arrow-left"></i>Continue Shopping</a>
                </div>
            </div>
        @endif
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.querySelectorAll("input.quantity").forEach(function(input) {
                    let correctValue = input.getAttribute("value");
                    if (correctValue && correctValue !== "1") {
                        input.value = correctValue;
                    }
                });
            }, 500); // run after Wolmart.initQtyInput
        });
    </script>
@endsection
