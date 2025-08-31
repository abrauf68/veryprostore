<!-- Shop Details -->
<div class="card mb-6">
    <h5 class="card-header">{{ __('Shop Details') }}</h5>
    <div class="card-body pt-1">
        <form id="formShopDetails" method="POST" action="{{ route('update.shop-details', $userShop->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <label for="shop_name" class="form-label">{{ __('Shop Name') }}</label><span
                            class="text-danger">*</span>
                        <input type="text" class="form-control @error('shop_name') is-invalid @enderror"
                            id="shop_name" name="shop_name" value="{{ old('shop_name', $userShop->shop_name) }}"
                            placeholder="{{ __('Enter shop name') }}">
                        @error('shop_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 col-sm-6">
                        <label class="form-label" for="certificate_type">Certificate Type <span
                                class="text-danger">*</span></label>
                        <select id="certificate_type" name="certificate_type"
                            class="select2 form-select @error('certificate_type') is-invalid @enderror">
                            <option value="" selected disabled>Select Certificate Type</option>
                            <option value="id" {{ old('certificate_type', $userShop->certificate_type) == 'id' ? 'selected' : '' }}>ID</option>
                            <option value="aadhar_card" {{ old('certificate_type', $userShop->certificate_type) == 'aadhar_card' ? 'selected' : '' }}>Aadhar Card</option>
                            <option value="passport" {{ old('certificate_type', $userShop->certificate_type) == 'passport' ? 'selected' : '' }}>Passport</option>
                        </select>
                        @error('certificate_type')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4 col-sm-6">
                        <label for="certificate_front" class="form-label">{{ __('Certificate Front') }}</label>
                        <input type="file" accept="image/*"
                            class="form-control @error('certificate_front') is-invalid @enderror" id="certificate_front"
                            name="certificate_front" />
                        @if (isset($userShop) && $userShop->certificate_front)
                            <a class="btn btn-link" target="_blank" href="{{ asset($userShop->certificate_front) }}">view</a>
                        @endif
                        @error('certificate_front')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4 col-sm-6">
                        <label for="certificate_back" class="form-label">{{ __('Certificate Back') }}</label>
                        <input type="file" accept="image/*"
                            class="form-control @error('certificate_back') is-invalid @enderror" id="certificate_back"
                            name="certificate_back" />
                        @if (isset($userShop) && $userShop->certificate_back)
                            <a class="btn btn-link" target="_blank" href="{{ asset($userShop->certificate_back) }}">view</a>
                        @endif
                        @error('certificate_back')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ __('Save Details') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--/ Shop Details -->
