<!-- Bank Details -->
<div class="card mb-6">
    <h5 class="card-header">{{ __('Bank Details') }}</h5>
    <div class="card-body">
        <small class="card-text text-uppercase text-muted small">{{ __('Payment Method') }}</small>
        <ul class="list-unstyled my-3 py-1">
            <li class="d-flex align-items-center mb-4">
                <i class="ti ti-wallet ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Method') }}:</span>
                <span class="text-capitalize">{{ $vendor->userBankDetail->method ?? '-' }}</span>
            </li>
        </ul>

        <small class="card-text text-uppercase text-muted small">{{ __('Bank Information') }}</small>
        <ul class="list-unstyled my-3 py-1">
            <li class="d-flex align-items-center mb-4">
                <i class="ti ti-user ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Account Name') }}:</span>
                <span>{{ $vendor->userBankDetail->account_name ?? '-' }}</span>
            </li>

            <li class="d-flex align-items-center mb-4">
                <i class="ti ti-hash ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Account Number') }}:</span>
                <span>{{ $vendor->userBankDetail->account_number ?? '-' }}</span>
            </li>

            <li class="d-flex align-items-center mb-4">
                <i class="ti ti-cards ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Account Type') }}:</span>
                <span class="text-capitalize">{{ $vendor->userBankDetail->account_type ?? '-' }}</span>
            </li>

            <li class="d-flex align-items-center mb-4">
                <i class="ti ti-building-bank ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Bank Name') }}:</span>
                <span>{{ $vendor->userBankDetail->bank_name ?? '-' }}</span>
            </li>

            <li class="d-flex align-items-center mb-4">
                <i class="ti ti-key ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('IFSC Code') }}:</span>
                <span>{{ $vendor->userBankDetail->ifsc_code ?? '-' }}</span>
            </li>

            <li class="d-flex align-items-center mb-2">
                <i class="ti ti-map-pin ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Branch') }}:</span>
                <span>{{ $vendor->userBankDetail->branch ?? '-' }}</span>
            </li>
        </ul>

        <small class="card-text text-uppercase text-muted small">{{ __('UPI Information') }}</small>
        <ul class="list-unstyled my-3 py-1">
            <li class="d-flex align-items-center mb-2">
                <i class="ti ti-qrcode ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('UPI ID') }}:</span>
                <span>{{ $vendor->userBankDetail->upi_id ?? '-' }}</span>
            </li>
        </ul>

        <small class="card-text text-uppercase text-muted small">{{ __('Binance Information') }}</small>
        <ul class="list-unstyled my-3 py-1">
            <li class="d-flex align-items-center mb-2">
                <i class="ti ti-coin ti-lg"></i>
                <span class="fw-medium mx-2">{{ __('Binance ID') }}:</span>
                <span>{{ $vendor->userBankDetail->binance_id ?? '-' }}</span>
            </li>
        </ul>
    </div>
</div>
<!--/ Bank Details -->
