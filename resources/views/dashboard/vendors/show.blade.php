@extends('layouts.master')

@section('title', __('Vendor Details'))

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.vendors.index') }}">{{ __('Vendors') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Details') }}</li>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-account-settings.css') }}" />
    <style>
        .edit-loader {
            width: 100%;
        }

        .edit-loader .sk-chase {
            display: block;
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold py-3 mb-0">{{ __('Details') }}</h4>
            <button id="exportPdf" class="btn btn-primary">
                <i class="ti ti-file-type-pdf me-2"></i> Export PDF
            </button>
        </div> --}}
        <div id="pdfContainer">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-6">
                                <div class="user-profile-header-banner">
                                    <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image"
                                        class="rounded-top" />
                                </div>
                                <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                        <img src="{{ asset($profile->profile_image ?? 'assets/img/default/user.png') }}"
                                            alt="user image" class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
                                    </div>
                                    <div class="flex-grow-1 mt-3 mt-lg-5">
                                        <div
                                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                            <div class="user-profile-info">
                                                <h4 class="mb-2 mt-lg-6">{{ $vendor->name }}</h4>
                                                <ul
                                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                                                    @if ($profile->designation)
                                                        <li class="list-inline-item d-flex gap-2 align-items-center">
                                                            <i class="ti ti-palette ti-lg"></i><span
                                                                class="fw-medium">{{ $profile->designation->name }}</span>
                                                        </li>
                                                    @endif
                                                    @if ($profile->country)
                                                        <li class="list-inline-item d-flex gap-2 align-items-center">
                                                            <i class="ti ti-map-pin ti-lg"></i><span
                                                                class="fw-medium">{{ $profile->country->name }}</span>
                                                        </li>
                                                    @endif
                                                    <li class="list-inline-item d-flex gap-2 align-items-center">
                                                        <i class="ti ti-calendar ti-lg"></i><span class="fw-medium">
                                                            {{ __('Joined') }}
                                                            {{ $profile->created_at->format('F Y') }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Navbar pills -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-align-top">
                                <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-2 gap-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link profile-tab" href="#" data-target="#profile-section" data-query="profile">
                                            <i class="ti-sm ti ti-user-check me-1_5"></i>
                                            {{ __('Profile') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link profile-tab" href="#" data-target="#shop-details-section"
                                            data-query="shop-details">
                                            <i class="ti-sm ti ti-building-store me-1_5"></i>
                                            {{ __('Shop Details') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link profile-tab" href="#" data-target="#bank-details-section"
                                            data-query="bank-details">
                                            <i class="ti-sm ti ti-building-bank me-1_5"></i>
                                            {{ __('Bank Details') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--/ Navbar pills -->
                    <div class="row">
                        <div class="col-md-5">
                            <!-- About User -->
                            <div class="card mb-6">
                                <div class="card-body">
                                    <small class="card-text text-uppercase text-muted small"></small>
                                    <ul class="list-unstyled my-3 py-1">
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-user ti-lg"></i><span
                                                class="fw-medium mx-2">{{ __('Full Name') }}:</span>
                                            <span>{{ $vendor->name }}</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-at ti-lg"></i><span
                                                class="fw-medium mx-2">{{ __('Username') }}:</span>
                                            <span>{{ $vendor->username }}</span>
                                            <i class="ti ti-copy ti-lg mx-2 copy-icon" style="cursor: pointer;"
                                                data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                                title="{{ __('Copy') }}"></i>
                                        </li>
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-{{ $vendor->is_active == 'active' ? 'check' : 'lock' }} ti-lg"></i>
                                            <span class="fw-medium mx-2">{{ __('Status') }}:</span>
                                            <span>{{ ucfirst($vendor->is_active) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-crown ti-lg"></i><span
                                                class="fw-medium mx-2">{{ __('Role') }}:</span>
                                            <span>{{ $vendor->roles->first() ? ucfirst(str_replace('_', ' ', $vendor->roles->first()->name)) : 'No Role' }}</span>
                                        </li>
                                        @if ($profile->designation)
                                            <li class="d-flex align-items-center mb-4">
                                                <i class="ti ti-briefcase ti-lg"></i><span
                                                    class="fw-medium mx-2">{{ __('Designation') }}:</span>
                                                <span>{{ $profile->designation->name }}</span>
                                            </li>
                                        @endif
                                        @if ($profile->country)
                                            <li class="d-flex align-items-center mb-4">
                                                <i class="ti ti-world ti-lg"></i><span
                                                    class="fw-medium mx-2">{{ __('Country') }}:</span>
                                                <span>{{ $profile->country->name }}</span>
                                            </li>
                                        @endif
                                        @if ($profile->language)
                                            <li class="d-flex align-items-center mb-2">
                                                <i class="ti ti-language ti-lg"></i><span
                                                    class="fw-medium mx-2">{{ __('Language') }}:</span>
                                                <span>{{ $profile->language->name }}</span>
                                            </li>
                                        @endif
                                        @if ($profile->gender)
                                            <li class="d-flex align-items-center mb-2">
                                                <i class="ti ti-gender-bigender ti-lg"></i><span
                                                    class="fw-medium mx-2">{{ __('Gender') }}:</span>
                                                <span>{{ $profile->gender->name }}</span>
                                            </li>
                                        @endif
                                        @if ($profile->maritalStatus)
                                            <li class="d-flex align-items-center mb-2">
                                                <i class="ti ti-heart ti-lg"></i><span
                                                    class="fw-medium mx-2">{{ __('Marital Status') }}:</span>
                                                <span>{{ $profile->maritalStatus->name }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                    <small class="card-text text-uppercase text-muted small">{{ __('Contacts') }}</small>
                                    <ul class="list-unstyled my-3 py-1">
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-phone-call ti-lg"></i><span
                                                class="fw-medium mx-2">{{ __('Contact') }}:</span>
                                            <span>{{ $profile->phone_number }}</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-mail ti-lg"></i><span
                                                class="fw-medium mx-2">{{ __('Email') }}:</span>
                                            <span>{{ $vendor->email }}</span>
                                        </li>
                                    </ul>
                                    <small class="card-text text-uppercase text-muted small">{{ __('BIO') }}</small>
                                    <ul class="list-unstyled mb-0 mt-3 pt-1">
                                        <li class="d-flex flex-wrap mb-4">
                                            <span class="fw-medium me-2">{{ $profile->bio }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--/ About User -->
                            <!-- Profile Social -->
                            <div class="card mb-6">
                                <div class="card-body">
                                    <small class="card-text text-uppercase text-muted small">{{ __('Social') }}</small>
                                    <ul class="list-unstyled mb-0 mt-3 pt-1 d-flex flex-wrap justify-content-between">
                                        @if ($profile->facebook_url)
                                            <li class="d-flex align-items-end mb-4">
                                                <a href="{{ $profile->facebook_url }}" style="color: inherit;">
                                                    <i class="fab fa-facebook fa-lg"></i>
                                                    <span class="fw-medium mx-2">{{ __('Facebook') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($profile->linkedin_url)
                                            <li class="d-flex align-items-end mb-4">
                                                <a href="{{ $profile->linkedin_url }}" style="color: inherit;">
                                                    <i class="fab fa-linkedin fa-lg"></i>
                                                    <span class="fw-medium mx-2">{{ __('Linkedin') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($profile->skype_url)
                                            <li class="d-flex align-items-end mb-4">
                                                <a href="{{ $profile->skype_url }}" style="color: inherit;">
                                                    <i class="fab fa-skype fa-lg"></i>
                                                    <span class="fw-medium mx-2">{{ __('Skype') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($profile->instagram_url)
                                            <li class="d-flex align-items-end mb-4">
                                                <a href="{{ $profile->instagram_url }}" style="color: inherit;">
                                                    <i class="fab fa-instagram fa-lg"></i>
                                                    <span class="fw-medium mx-2">{{ __('Instagram') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($profile->github_url)
                                            <li class="d-flex align-items-end mb-4">
                                                <a href="{{ $profile->github_url }}" style="color: inherit;">
                                                    <i class="fab fa-github fa-lg"></i>
                                                    <span class="fw-medium mx-2">{{ __('Github') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if (
                                            !$profile->github_url &&
                                                !$profile->instagram_url &&
                                                !$profile->skype_url &&
                                                !$profile->linkedin_url &&
                                                !$profile->facebook_url)
                                            <li class="d-flex align-items-end mb-4">
                                                <a style="color: inherit;">
                                                    <i class="ti ti-link-off"></i>
                                                    <span class="fw-medium mx-2">{{ __('No Social Links') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!--/ Profile Social -->
                        </div>
                        <div class="col-xl-7 col-lg-7 col-md-7 vendor-show">
                            <div class="edit-loader">
                                <div class="sk-chase sk-primary">
                                    <div class="sk-chase-dot"></div>
                                    <div class="sk-chase-dot"></div>
                                    <div class="sk-chase-dot"></div>
                                    <div class="sk-chase-dot"></div>
                                    <div class="sk-chase-dot"></div>
                                    <div class="sk-chase-dot"></div>
                                </div>
                            </div>
                            <div id="profile-section" style="display: none;">
                                @include('dashboard.vendors.sections.activity')
                            </div>
                            <div id="shop-details-section" style="display: none;">
                                @include('dashboard.vendors.sections.shop-details')
                            </div>
                            <div id="bank-details-section" style="display: none;">
                                @include('dashboard.vendors.sections.bank-details')
                            </div>
                        </div>

                        <h4>Assigned Products to {{ $vendor->name }}</h4>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-datatable table-responsive">
                                    <table class="datatables-users table border-top custom-datatables">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Sr.') }}</th>
                                                <th>{{ __('Image') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('SKU') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($vendor->products) && count($vendor->products) > 0)
                                                @foreach ($vendor->products as $index => $product)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td><img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}" height="35px" width="35px"></td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->sku }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <h4>Assigned Orders to {{ $vendor->name }}</h4>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-datatable table-responsive">
                                    <table class="datatables-users table border-top custom-datatables">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Sr.') }}</th>
                                                <th>{{ __('Order No') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Total') }}</th>
                                                <th>{{ __('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($orders) && count($orders) > 0)
                                                @foreach ($orders as $index => $order)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $order->order_no }}</td>
                                                        <td>{{ $order->billing->first_name . ' ' . $order->billing->last_name }}</td>
                                                        <td>{{ \App\Helpers\Helper::formatCurrency($order->total) }}</td>
                                                        <td>
                                                            @php
                                                                $statusColors = [
                                                                    'pending' => 'warning',
                                                                    'paid' => 'primary',
                                                                    'shipped' => 'info',
                                                                    'completed' => 'success',
                                                                    'cancelled' => 'danger',
                                                                ];
                                                            @endphp

                                                            <span class="badge me-4 bg-label-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            function activateTabFromURL() {
                var urlParams = new URLSearchParams(window.location.search);
                var activeTab = urlParams.get('tab') || 'profile'; // Default to 'company'

                var tabMapping = {
                    'profile': '#profile-section',
                    'shop-details': '#shop-details-section',
                    'bank-details': '#bank-details-section',
                };

                var activeTabSelector = tabMapping[activeTab] || '#profile-section';

                $('.vendor-show > div').hide(); // Hide all sections initially

                setTimeout(function() {
                    $('.edit-loader').fadeOut(); // Hide loader
                    $(activeTabSelector).fadeIn(); // Show the selected section
                    $('a.profile-tab').removeClass('active');
                    $('a[data-target="' + activeTabSelector + '"]').addClass('active');
                }, 100); // 1-second delay to simulate loading effect
            }

            activateTabFromURL(); // Load the correct tab immediately on page load

            $('a.profile-tab').on('click', function(e) {
                e.preventDefault();

                $('.edit-loader').fadeIn(); // Show loader on tab switch
                $('a.profile-tab').removeClass('active');
                $('.vendor-show > div').hide();

                $(this).addClass('active');

                var target = $(this).data('target');
                var queryValue = $(this).data('query');

                setTimeout(function() {
                    $('.edit-loader').fadeOut();
                    $(target).fadeIn();
                }, 100); // Shorter delay for smoother experience

                var newURL = window.location.pathname + '?tab=' + queryValue;
                window.history.pushState({
                    path: newURL
                }, '', newURL);
            });

            window.addEventListener('popstate', activateTabFromURL);

            function toggleFields() {
                $("#bankFields, #upiFields, #binanceFields").addClass("d-none");

                let method = $("#method").val();
                if (method === "bank") $("#bankFields").removeClass("d-none");
                if (method === "upi") $("#upiFields").removeClass("d-none");
                if (method === "binance") $("#binanceFields").removeClass("d-none");
            }

            $("#method").on("change", toggleFields);
            toggleFields(); // Run on page load
        });
    </script>
    <script>
        const jsPDF = window.jspdf.jsPDF;

        document.getElementById('exportPdf').addEventListener('click', function() {
            const originalElement = document.getElementById('pdfContainer');

            // Create a clone for PDF export with added styling
            const tempContainer = document.createElement('div');
            tempContainer.style.position = 'absolute';
            tempContainer.style.left = '-9999px';
            tempContainer.style.width = '210mm'; // A4 width
            document.body.appendChild(tempContainer);

            // Clone the original content
            const elementClone = originalElement.cloneNode(true);

            // Create PDF content wrapper
            const pdfContent = document.createElement('div');
            pdfContent.style.padding = '20px';
            pdfContent.style.backgroundColor = '#fff';
            pdfContent.style.transform = 'scale(0.5)';
            pdfContent.style.transformOrigin = 'top left';
            pdfContent.style.width = '200%';

            // Header with title and date
            const headerWrapper = document.createElement('div');
            headerWrapper.style.textAlign = 'center';
            headerWrapper.style.marginBottom = '30px';
            headerWrapper.style.padding = '10px 0';
            headerWrapper.style.borderBottom = '2px solid #2d3436';

            const title = document.createElement('h1');
            title.textContent = 'Reports';
            title.style.margin = '0';
            title.style.color = '#2d3436';
            title.style.fontFamily = 'Arial, sans-serif';
            title.style.fontSize = '28px';

            const date = new Date();
            const textoptions = {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            };
            const formattedDate = date.toLocaleDateString('en-GB', textoptions);

            const dateEl = document.createElement('p');
            dateEl.textContent = formattedDate;
            dateEl.style.margin = '5px 0 0';
            dateEl.style.fontSize = '16px';
            dateEl.style.color = '#636e72';
            dateEl.style.fontFamily = 'Arial, sans-serif';

            headerWrapper.appendChild(title);
            headerWrapper.appendChild(dateEl);

            pdfContent.appendChild(headerWrapper);
            pdfContent.appendChild(elementClone);
            tempContainer.appendChild(pdfContent);

            const optionsCanvas = {
                useCORS: true,
                scale: 2,
                windowHeight: tempContainer.scrollHeight,
                onclone: (clonedDoc) => {
                    clonedDoc.querySelectorAll('canvas').forEach(canvas => {
                        canvas.style.display = 'block';
                    });
                }
            };

            this.innerHTML = '<i class="ti ti-loader me-2"></i> Generating PDF...';
            this.disabled = true;

            setTimeout(() => {
                html2canvas(tempContainer, optionsCanvas).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4'
                    });

                    const pageWidth = pdf.internal.pageSize.getWidth();
                    const pageHeight = pdf.internal.pageSize.getHeight();
                    const imgWidth = pageWidth;
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;

                    if (imgHeight <= pageHeight) {
                        // One page only
                        pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                    } else {
                        // Multi-page
                        let y = 0;
                        while (y < imgHeight) {
                            pdf.addImage(imgData, 'PNG', 0, -y, imgWidth, imgHeight);
                            y += pageHeight;
                            if (y < imgHeight) pdf.addPage();
                        }
                    }

                    pdf.save('user-report.pdf');

                    // Cleanup
                    tempContainer.remove();

                    this.innerHTML = '<i class="ti ti-file-type-pdf me-2"></i> Export PDF';
                    this.disabled = false;
                }).catch(error => {
                    console.error('Error generating PDF:', error);
                    tempContainer.remove();
                    this.innerHTML = '<i class="ti ti-file-type-pdf me-2"></i> Export PDF';
                    this.disabled = false;
                });
            }, 1000); // Wait for rendering
        });
    </script>
@endsection
