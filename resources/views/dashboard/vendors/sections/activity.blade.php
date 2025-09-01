<div class="row">
    <div class="col-md-12">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Overall Orders Status</h5>
                    <p class="card-subtitle">Total {{ $totalOrders }} Orders Assigned to
                        {{ $vendor->name }}</p>
                </div>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    <li class="mb-6 d-flex justify-content-between align-items-center">
                        <div class="badge bg-label-warning rounded p-1_5">
                            <i class="ti ti-phone icon-md"></i>
                            <!-- This can be a contact-related icon -->
                        </div>
                        <div class="d-flex justify-content-between w-100 flex-wrap">
                            <h6 class="mb-0 ms-4">Pending</h6>
                            <div class="d-flex">
                                <p class="mb-0">{{ $pendingOrders }}</p>
                            </div>
                        </div>
                    </li>

                    <li class="mb-6 d-flex justify-content-between align-items-center">
                        <div class="badge bg-label-info rounded p-1_5">
                            <i class="ti ti-heart icon-md"></i> <!-- Icon for interested -->
                        </div>
                        <div class="d-flex justify-content-between w-100 flex-wrap">
                            <h6 class="mb-0 ms-4">Shipped</h6>
                            <div class="d-flex">
                                <p class="mb-0">{{ $shippedOrders }}</p>
                            </div>
                        </div>
                    </li>

                    <li class="mb-6 d-flex justify-content-between align-items-center">
                        <div class="badge bg-label-success rounded p-1_5">
                            <i class="ti ti-check icon-md"></i> <!-- Icon for converted -->
                        </div>
                        <div class="d-flex justify-content-between w-100 flex-wrap">
                            <h6 class="mb-0 ms-4">Completed</h6>
                            <div class="d-flex">
                                <p class="mb-0">{{ $completedOrders }}</p>
                            </div>
                        </div>
                    </li>

                    <li class="mb-6 d-flex justify-content-between align-items-center">
                        <div class="badge bg-label-danger rounded p-1_5">
                            <i class="ti ti-ban icon-md"></i> <!-- Icon for not interested -->
                        </div>
                        <div class="d-flex justify-content-between w-100 flex-wrap">
                            <h6 class="mb-0 ms-4">Cancelled</h6>
                            <div class="d-flex">
                                <p class="mb-0">{{ $cancelledOrders }}</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
