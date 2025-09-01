@extends('layouts.master')

@section('title', __('Edit Product'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">{{ __('Products') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row p-5">
                        <h3>{{ __('Add New Product') }}</h3>
                        <div class="mb-4 col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                name="name" required placeholder="{{ __('Enter name') }}" autofocus
                                value="{{ old('name', $product->name) }}" />
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="slug" class="form-label">{{ __('Slug') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('slug') is-invalid @enderror" type="text" id="slug"
                                name="slug" value="{{ old('slug', $product->slug) }}" required placeholder="{{ __('Enter slug') }}" />
                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="cost_price" class="form-label">{{ __('Cost Price') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('cost_price') is-invalid @enderror" type="number" step="any" id="cost_price"
                                name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" required placeholder="{{ __('Enter cost price') }}" />
                            @error('cost_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="price" class="form-label">{{ __('Retail Price') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('price') is-invalid @enderror" type="number" step="any" id="price"
                                name="price" value="{{ old('price', $product->price) }}" required placeholder="{{ __('Enter price') }}" />
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="stock" class="form-label">{{ __('Stock') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('stock') is-invalid @enderror" type="number" step="any" id="stock"
                                name="stock" value="{{ old('stock', $product->stock) }}" required placeholder="{{ __('Enter stock') }}" />
                            @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="short_description" class="form-label">{{ __('Short Description') }}</label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description"
                                placeholder="{{ __('Enter short description') }}" cols="10" rows="5">{{ old('short_description', $product->short_description) }}</textarea>
                            @error('short_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                placeholder="{{ __('Enter description') }}" cols="30" rows="10">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label class="form-label" for="category_id">{{ __('Category') }}</label>
                            <select id="category_id" name="category_id" class="select2 form-select @error('category_id') is-invalid @enderror">
                                <option value="" selected disabled>{{ __('Select Category') }}</option>
                                @if (isset($categories) && count($categories) > 0)
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == old('category_id', $product->category_id) ? 'selected' : '' }}>{{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-4">
                            <label class="form-label" for="vendor_id">{{ __('Vendor') }}</label>
                            <select id="vendor_id" name="vendor_id" class="select2 form-select @error('vendor_id') is-invalid @enderror">
                                <option value="" selected disabled>{{ __('Select Vendor') }}</option>
                                @if (isset($vendors) && count($vendors) > 0)
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ $vendor->id == old('vendor_id', $product->vendor_id) ? 'selected' : '' }}>{{ $vendor->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('vendor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="is_popular" class="form-label">{{ __('Popular') }}</label>
                            <select class="form-select select2 @error('is_popular') is-invalid @enderror"
                                id="is_popular" name="is_popular">
                                <option value="1" {{ old('is_popular', $product->is_popular) == '1' ? 'selected' : '' }}>Popular
                                </option>
                                <option value="0" selected {{ old('is_popular', $product->is_popular) == '0' ? 'selected' : '' }}>UnPopular
                                </option>
                            </select>
                            @error('is_popular')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="main_image" class="form-label">{{ __('Main Image') }}</label>
                            <input class="form-control @error('main_image') is-invalid @enderror" type="file"
                                id="main_image" name="main_image" accept="image/*" />
                            @error('main_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if ($product->main_image)
                                <img src="{{ asset($product->main_image) }}" alt="Main Image" width="150">
                            @endif

                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="images" class="form-label">{{ __('Gallery Images') }}</label>
                            <input class="form-control @error('images') is-invalid @enderror" type="file"
                                id="images" name="images[]" accept="image/*" multiple/>
                            @error('images')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Edit Product') }}</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
@endsection

@section('script')
    <!-- Vendors JS -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: '#description',
                height: 500,
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
                toolbar: `undo redo | formatselect | fontselect fontsizeselect |
                          bold italic underline strikethrough forecolor backcolor |
                          alignleft aligncenter alignright alignjustify |
                          bullist numlist outdent indent | link image media table |
                          removeformat | code fullscreen`,
                menubar: 'file edit view insert format tools table help',
                branding: false,
                content_style: "body { font-family:Helvetica,Arial,sans-serif; font-size:14px }"
            });

            // Generate slug from name
            $('#name').on('keyup change', function() {
                let name = $(this).val();
                let slug = name.toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#slug').val(slug);
            });

            // Handle form submission manually to validate TinyMCE
            $('form').on('submit', function(e) {
                tinymce.triggerSave(); // sync content to <textarea>
                const $details = $('#description');
                const detailsContent = $details.val().trim();

                // Remove previous validation state
                $details.removeClass('is-invalid');
                $details.next('.invalid-feedback').remove();

                if (!detailsContent) {
                    e.preventDefault();

                    // Add Bootstrap invalid class
                    $details.addClass('is-invalid');

                    // Append validation message
                    $details.after(`
                        <div class="invalid-feedback">
                            {{ __('The description field is required.') }}
                        </div>
                    `);

                    // Optional: focus editor
                    tinymce.get('description').focus();
                }
            });
        });
    </script>
@endsection
