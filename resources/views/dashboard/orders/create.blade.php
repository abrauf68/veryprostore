@extends('layouts.master')

@section('title', __('Create Order'))

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.orders.index') }}">{{ __('Orders') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.orders.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row p-5">
                        <h3>{{ __('Add New Order') }}</h3>
                        <div class="mb-4 col-md-12">
                            <label class="form-label" for="vendor_id">{{ __('Select A Vendor') }}<span
                                    class="text-danger">*</span></label><br>
                            <small>Select a vendor to make an order for his products.</small>
                            <select id="vendor_id" name="vendor_id"
                                class="select2 form-select @error('vendor_id') is-invalid @enderror">
                                <option value="" selected disabled>{{ __('Select Vendor') }}</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        {{ $vendor->id == request('vendor_id') ? 'selected' : '' }}>
                                        {{ $vendor->name . ' (' . $vendor->userShop->shop_name . ')' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vendor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Products Section (hidden until vendor selected) --}}
                    <div id="products-section" class="row d-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>{{ __('Select Products') }}</h4>
                            <h4 class="text-end">Total: <span id="totalAmountShown">0</span></h4>
                        </div>
                        <div id="product-wrapper">
                            <div class="row mb-3 product-row">
                                <div class="col-md-6">
                                    <select name="products[]" class="form-select select2 product-select"></select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="quantities[]" class="form-control quantity-input"
                                        placeholder="Quantity" min="1">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="addMore" class="add-new btn btn-primary">
                            <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                            <span class="d-none d-sm-inline-block">{{ __('Add More') }}</span>
                        </button>
                        <input type="text" name="subtotal" id="totalAmount" class="form-control" hidden>
                    </div>


                    {{-- Billing Section (hidden until vendor selected) --}}
                    <div id="billing-section" class="row p-5 d-none">
                        <h4>{{ __('Billing Details') }}</h4>
                        <div class="mb-4 col-md-4">
                            <label for="first_name" class="form-label">{{ __('First Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('first_name') is-invalid @enderror" type="text"
                                id="first_name" name="first_name" required placeholder="{{ __('Enter first name') }}"
                                autofocus value="{{ old('first_name') }}" />
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="last_name" class="form-label">{{ __('Last Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('last_name') is-invalid @enderror" type="text"
                                id="last_name" name="last_name" required placeholder="{{ __('Enter last name') }}"
                                value="{{ old('last_name') }}" />
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="company_name" class="form-label">{{ __('Company Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('company_name') is-invalid @enderror" type="text"
                                id="company_name" name="company_name" required placeholder="{{ __('Enter company name') }}"
                                value="{{ old('company_name') }}" />
                            @error('company_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label class="form-label" for="country">{{ __('Country') }}</label><span
                                class="text-danger">*</span>
                            <select id="country" name="country"
                                class="select2 form-select @error('country') is-invalid @enderror">
                                <option value="" selected disabled>{{ __('Select Country') }}</option>
                                @if (isset($countries) && count($countries) > 0)
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->name }}"
                                            {{ $country->name == old('country') ? 'selected' : '' }}>
                                            {{ $country->name }} ({{ $country->code }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="city" class="form-label">{{ __('City') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('city') is-invalid @enderror" type="text" id="city"
                                name="city" required placeholder="{{ __('Enter city') }}"
                                value="{{ old('city') }}" />
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="state" class="form-label">{{ __('State') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('state') is-invalid @enderror" type="text"
                                id="state" name="state" required placeholder="{{ __('Enter state') }}"
                                value="{{ old('state') }}" />
                            @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="zip" class="form-label">{{ __('Zip') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('zip') is-invalid @enderror" type="text" id="zip"
                                name="zip" required placeholder="{{ __('Enter zip') }}"
                                value="{{ old('zip') }}" />
                            @error('zip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="phone" class="form-label">{{ __('Phone') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                id="phone" name="phone" required placeholder="{{ __('Enter phone') }}"
                                value="{{ old('phone') }}" />
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="email" class="form-label">{{ __('email') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                id="email" name="email" required placeholder="{{ __('Enter email') }}"
                                value="{{ old('email') }}" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="address_line1" class="form-label">{{ __('Address') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('address_line1') is-invalid @enderror" type="text"
                                id="address_line1" name="address_line1" required placeholder="{{ __('Enter address') }}"
                                value="{{ old('address_line1') }}" />
                            @error('address_line1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 col-md-12">
                            <label for="notes" class="form-label">{{ __('Notes') }}</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                                placeholder="{{ __('Enter order notes') }}" cols="10" rows="5">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-2 d-none" id="submitBtnWrapper">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Add Order') }}</button>
                    </div>
                </form>

            </div>
            <!-- /Account -->
        </div>
    </div>
@endsection

@section('script')
    <!-- Vendors JS -->
    <script>
        $(document).ready(function() {
            let productOptions = ''; // store options
            let productPrices = {}; // store product id => price

            $('#submitBtnWrapper').hide();

            function toggleRemoveButtons() {
                let rows = $('#product-wrapper .product-row');
                if (rows.length <= 1) {
                    rows.find('.remove-product').hide();
                } else {
                    rows.find('.remove-product').show();
                }
            }

            function calculateTotal() {
                let total = 0;
                $('#product-wrapper .product-row').each(function() {
                    let productId = $(this).find('.product-select').val();
                    let qty = parseInt($(this).find('.quantity-input').val()) || 0;

                    if (productId && productPrices[productId]) {
                        total += productPrices[productId] * qty;
                    }
                });
                $('#totalAmount').val(total.toFixed(2));
                $('#totalAmountShown').text(total.toFixed(2));
            }

            $('#vendor_id').change(function() {
                let vendorId = $(this).val();

                if (vendorId) {
                    $('#products-section, #billing-section, #submitBtnWrapper').removeClass('d-none')
                        .show();

                    $.ajax({
                        url: "{{ route('dashboard.vendors.products') }}",
                        type: "GET",
                        data: {
                            vendor_id: vendorId
                        },
                        success: function(data) {
                            productOptions = '<option value="">Select Product</option>';
                            console.log(data);
                            productPrices = {};
                            $.each(data, function(key, product) {
                                productOptions += '<option value="' + product.id +
                                    '">' + product.name + ' (' + parseFloat(product
                                        .price) +
                                    ')</option>';
                                productPrices[product.id] = parseFloat(product.price);
                            });

                            $('#product-wrapper .product-select').html(productOptions)
                                .select2();
                            toggleRemoveButtons();
                            calculateTotal();
                        }
                    });

                } else {
                    $('#products-section, #billing-section, #submitBtnWrapper').addClass('d-none');
                }
            });

            // Auto-trigger if value exists (from query string or old value)
            if ($('#vendor_id').val()) {
                $('#vendor_id').trigger('change');
            }

            $('#addMore').click(function() {
                if (!productOptions) {
                    alert("Please select a vendor first.");
                    return;
                }

                let newRow = `
                <div class="row mb-3 product-row">
                    <div class="col-md-6">
                        <select name="products[]" class="form-select select2 product-select">
                            ${productOptions}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="quantities[]" class="form-control quantity-input" placeholder="Quantity" min="1">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-product">Remove</button>
                    </div>
                </div>`;
                $('#product-wrapper').append(newRow);

                $('#product-wrapper .product-select').last().select2();
                toggleRemoveButtons();
            });

            $(document).on('click', '.remove-product', function() {
                $(this).closest('.product-row').remove();
                toggleRemoveButtons();
                calculateTotal();
            });

            // recalc on change
            $(document).on('change keyup', '.product-select, .quantity-input', function() {
                calculateTotal();
            });

            toggleRemoveButtons();
        });
    </script>




@endsection
