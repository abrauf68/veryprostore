<!-- Shop Details -->
<div class="card mb-6">
    <h5 class="card-header">{{ __('Shop Details') }}</h5>
    <div class="card-body">
        <small class="card-text text-uppercase text-muted small">{{ __('Information') }}</small>
        <ul class="list-unstyled my-3 py-1">
            <li class="d-flex align-items-center mb-4">
                <i class="ti ti-building-store ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Shop Name') }}:</span>
                <span>{{ $vendor->userShop->shop_name ?? '-' }}</span>
            </li>

            <li class="d-flex align-items-center mb-4">
                <i class="ti ti-id ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Certificate Type') }}:</span>
                <span>
                    @if ($vendor->userShop->certificate_type == 'id')
                        ID
                    @elseif ($vendor->userShop->certificate_type == 'aadhar_card')
                        Aadhar Card
                    @elseif ($vendor->userShop->certificate_type == 'passport')
                        Passport
                    @else
                        -
                    @endif
                </span>
            </li>

            <li class="d-flex align-items-center mb-4">
                <i class="ti ti-id-badge ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Certificate Front') }}:</span>
                @if ($vendor->userShop->certificate_front)
                    <a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ asset($vendor->userShop->certificate_front) }}">
                        {{ __('View') }}
                    </a>
                @else
                    <span>-</span>
                @endif
            </li>

            <li class="d-flex align-items-center mb-2">
                <i class="ti ti-id-badge-2 ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Certificate Back') }}:</span>
                @if ($vendor->userShop->certificate_back)
                    <a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ asset($vendor->userShop->certificate_back) }}">
                        {{ __('View') }}
                    </a>
                @else
                    <span>-</span>
                @endif
            </li>
        </ul>
    </div>
</div>
<!--/ Shop Details -->
