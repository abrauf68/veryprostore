@extends('frontend.layouts.master')

@section('title', 'Checkout')

@section('css')
@endsection

@section('content')
    <!-- Start of Main -->
    <main class="main checkout">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb shop-breadcrumb bb-no">
                    <li class="passed"><a href="{{ route('frontend.cart.view') }}">Shopping Cart</a></li>
                    <li class="active"><a href="{{ route('frontend.checkout') }}">Checkout</a></li>
                    <li><a href="javascript:void(0)">Order Complete</a></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->


        @if (isset($cart->items) && count($cart->items) > 0)
            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                    @if (!Auth::check())
                        <div class="login-toggle">
                            Returning customer? <a href="#"
                                class="show-login font-weight-bold text-uppercase text-dark">Login</a>
                        </div>
                        <form class="login-content" action="{{ route('login.attempt') }}" method="POST">
                            @csrf
                            <p>If you have shopped with us before, please enter your details below.
                                If you are a new customer, please proceed to the Billing section.</p>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Username or email *</label>
                                        <input type="text" class="form-control form-control-md" name="email_username"
                                            required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Password *</label>
                                        <input type="text" class="form-control form-control-md" name="password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group checkbox">
                                <input type="checkbox" class="custom-checkbox" id="remember" name="remember">
                                <label for="remember" class="mb-0 lh-2">Remember me</label>
                                {{-- <a href="#" class="ml-3">Forget your password?</a> --}}
                            </div>
                            <button type="submit" class="btn btn-rounded btn-login">Login</button>
                        </form>
                    @endif
                    {{-- <div class="coupon-toggle">
                        Have a coupon? <a href="#" class="show-coupon font-weight-bold text-uppercase text-dark">Enter
                            your
                            code</a>
                    </div>
                    <div class="coupon-content mb-4">
                        <p>If you have a coupon code, please apply it below.</p>
                        <div class="input-wrapper-inline">
                            <input type="text" name="coupon_code" class="form-control form-control-md mr-1 mb-2"
                                placeholder="Coupon code" id="coupon_code">
                            <button type="submit" class="btn button btn-rounded btn-coupon mb-2" name="apply_coupon"
                                value="Apply coupon">Apply Coupon</button>
                        </div>
                    </div> --}}
                    <form class="form checkout-form" action="#" method="post">
                        <div class="row mb-9">
                            <div class="col-lg-7 pr-lg-4 mb-4">
                                <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                                    Billing Details
                                </h3>
                                <div class="row gutter-sm">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>First name *</label>
                                            <input type="text" class="form-control form-control-md" name="first_name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Last name *</label>
                                            <input type="text" class="form-control form-control-md" name="last_name"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Company name (optional)</label>
                                    <input type="text" class="form-control form-control-md" name="company_name">
                                </div>
                                <div class="form-group">
                                    <label>Country / Region *</label>
                                    <div class="select-box">
                                        <select name="country" class="form-control form-control-md">
                                            <option value="" selected disabled>Select Country</option>
                                            @if (isset($countries) && count($countries) > 0)
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->name }}">{{ $country->name }}
                                                        ({{ $country->code }})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Street address *</label>
                                    <input type="text" placeholder="House number and street name"
                                        class="form-control form-control-md mb-2" name="address_line1" required>
                                    <input type="text" placeholder="Apartment, suite, unit, etc. (optional)"
                                        class="form-control form-control-md" name="address_line2" required>
                                </div>
                                <div class="row gutter-sm">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Town / City *</label>
                                            <input type="text" class="form-control form-control-md" name="city"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>ZIP *</label>
                                            <input type="text" class="form-control form-control-md" name="zip"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State *</label>
                                            <input type="text" class="form-control form-control-md" name="state"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone *</label>
                                            <input type="text" class="form-control form-control-md" name="phone"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-7">
                                    <label>Email address *</label>
                                    <input type="email" class="form-control form-control-md" name="email" required>
                                </div>
                                {{-- <div class="form-group checkbox-toggle pb-2">
                                    <input type="checkbox" class="custom-checkbox" id="shipping-toggle"
                                        name="shipping-toggle">
                                    <label for="shipping-toggle">Ship to a different address?</label>
                                </div>
                                <div class="checkbox-content">
                                    <div class="row gutter-sm">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label>First name *</label>
                                                <input type="text" class="form-control form-control-md"
                                                    name="firstname" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label>Last name *</label>
                                                <input type="text" class="form-control form-control-md"
                                                    name="lastname" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Company name (optional)</label>
                                        <input type="text" class="form-control form-control-md" name="company-name">
                                    </div>
                                    <div class="form-group">
                                        <label>Country / Region *</label>
                                        <div class="select-box">
                                            <select name="country" class="form-control form-control-md">
                                                <option value="default" selected="selected">United States
                                                    (US)
                                                </option>
                                                <option value="uk">United Kingdom (UK)</option>
                                                <option value="us">United States</option>
                                                <option value="fr">France</option>
                                                <option value="aus">Australia</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Street address *</label>
                                        <input type="text" placeholder="House number and street name"
                                            class="form-control form-control-md mb-2" name="street-address-1" required>
                                        <input type="text" placeholder="Apartment, suite, unit, etc. (optional)"
                                            class="form-control form-control-md" name="street-address-2" required>
                                    </div>
                                    <div class="row gutter-sm">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Town / City *</label>
                                                <input type="text" class="form-control form-control-md" name="town"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label>Postcode *</label>
                                                <input type="text" class="form-control form-control-md"
                                                    name="postcode" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country (optional)</label>
                                                <input type="text" class="form-control form-control-md" name="zip"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="form-group mt-3">
                                    <label for="notes">Order notes (optional)</label>
                                    <textarea class="form-control mb-0" id="notes" name="notes" cols="30" rows="4"
                                        placeholder="Notes about your order, e.g special notes for delivery"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-5 mb-4 sticky-sidebar-wrapper">
                                <div class="order-summary-wrapper sticky-sidebar">
                                    <h3 class="title text-uppercase ls-10">Your Order</h3>
                                    <div class="order-summary">
                                        <table class="order-table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">
                                                        <b>Product</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="bb-no">
                                                    <td class="product-name">Palm Print Jacket <i
                                                            class="fas fa-times"></i>
                                                        <span class="product-quantity">1</span>
                                                    </td>
                                                    <td class="product-total">$40.00</td>
                                                </tr>
                                                <tr class="bb-no">
                                                    <td class="product-name">Brown Backpack <i class="fas fa-times"></i>
                                                        <span class="product-quantity">1</span>
                                                    </td>
                                                    <td class="product-total">$60.00</td>
                                                </tr>
                                                <tr class="cart-subtotal bb-no">
                                                    <td>
                                                        <b>Subtotal</b>
                                                    </td>
                                                    <td>
                                                        <b>$100.00</b>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="order-total">
                                                    <th>
                                                        <b>Total</b>
                                                    </th>
                                                    <td>
                                                        <b>$100.00</b>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <div class="payment-methods" id="payment_method">
                                            <h4 class="title font-weight-bold ls-25 pb-0 mb-1">Payment Methods</h4>
                                            <div class="accordion payment-accordion">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#cash-on-delivery" class="collapse">Direct Bank
                                                            Transfor</a>
                                                    </div>
                                                    <div id="cash-on-delivery" class="card-body expanded">
                                                        <p class="mb-0">
                                                            Make your payment directly into our bank account.
                                                            Please use your Order ID as the payment reference.
                                                            Your order will not be shipped until the funds have cleared in
                                                            our
                                                            account.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#payment" class="expand">Check Payments</a>
                                                    </div>
                                                    <div id="payment" class="card-body collapsed">
                                                        <p class="mb-0">
                                                            Please send a check to Store Name, Store Street, Store Town,
                                                            Store
                                                            State / County, Store Postcode.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#delivery" class="expand">Cash on delivery</a>
                                                    </div>
                                                    <div id="delivery" class="card-body collapsed">
                                                        <p class="mb-0">
                                                            Pay with cash upon delivery.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card p-relative">
                                                    <div class="card-header">
                                                        <a href="#paypal" class="expand">Paypal</a>
                                                    </div>
                                                    <a href="https://www.paypal.com/us/webapps/mpp/paypal-popup"
                                                        class="text-primary paypal-que"
                                                        onclick="javascript:window.open('https://www.paypal.com/us/webapps/mpp/paypal-popup','WIPaypal',
                                                            'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700');
                                                            return false;">What
                                                        is PayPal?
                                                    </a>
                                                    <div id="paypal" class="card-body collapsed">
                                                        <p class="mb-0">
                                                            Pay via PayPal, you can pay with your credit cart if you
                                                            don't have a PayPal account.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group place-order pt-6">
                                            <button type="submit" class="btn btn-dark btn-block btn-rounded">Place
                                                Order</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End of PageContent -->
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
    </main>
    <!-- End of Main -->
@endsection

@section('script')

@endsection
