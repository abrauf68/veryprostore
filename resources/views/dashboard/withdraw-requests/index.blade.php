@extends('layouts.master')

@section('title', __('Withdraw Requests'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Withdraw Requests') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Widhdraw List Table -->
        <div class="card mt-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Recent Withdraw Requests</h4>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Withdrawal ID') }}</th>
                            <th>{{ __('Withdraw By') }}</th>
                            <th>{{ __('Method') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Status') }}</th>
                            @canany(['update withdraw request'])<th>{{ __('Action') }}</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($withdrawalRequests as $index => $withdraw)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $withdraw->withdrawal_id }}</td>
                                <td>{{ $withdraw->user->name }}</td>
                                <td>{{ ucfirst($withdraw->method) }}</td>
                                <td>{{ \App\Helpers\Helper::formatCurrency($withdraw->amount) }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'primary',
                                            'inprogress' => 'warning',
                                            'success' => 'success',
                                            'canceled' => 'danger',
                                            'failed' => 'danger',
                                        ];
                                    @endphp

                                    <span class="badge me-4 bg-label-{{ $statusColors[$withdraw->status] ?? 'secondary' }}">
                                        {{ ucfirst($withdraw->status) }}
                                    </span>
                                </td>
                                @canany(['update withdraw request'])
                                    <td class="d-flex">
                                        @canany(['update withdraw request'])
                                            <span class="text-nowrap">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1 edit-withdraw-btn"
                                                    data-bs-toggle="modal" data-bs-target="#editRequestModal"
                                                    data-id="{{ $withdraw->id }}" data-status="{{ $withdraw->status }}"
                                                    title="{{ __('Edit Withdraw Request') }}">
                                                    <i class="ti ti-edit ti-md"></i>
                                                </a>
                                            </span>
                                        @endcan
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Withdraw Modal -->
    <div class="modal fade" id="editRequestModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-simple modal-edit-user">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-6">
                        <h4 class="mb-2">Edit Withdraw Request Status</h4>
                        {{-- <p>Updating user details will receive a privacy audit.</p> --}}
                    </div>
                    <form id="editRequestForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="withdraw_id" id="withdraw_id">

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Withdraw Request Status') }}</label>
                            <select name="status" id="status" class="form-select select2" required>
                                <option value="pending">{{ __('Pending') }}</option>
                                <option value="inprogress">{{ __('Inprogress') }}</option>
                                <option value="success">{{ __('Success') }}</option>
                                <option value="canceled">{{ __('Canceled') }}</option>
                                <option value="failed">{{ __('Failed') }}</option>
                            </select>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-3">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Edit Withdraw Modal -->
@endsection

@section('script')
    {{-- <script src="{{asset('assets/js/app-user-list.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            $('.edit-withdraw-btn').on('click', function() {
                let withdrawId = $(this).data('id');
                let status = $(this).data('status');

                // Set hidden input
                $('#withdraw_id').val(withdrawId);

                // Set dropdown selected value
                $('#status').val(status);

                // Build form action URL using route name
                let actionUrl = "{{ route('dashboard.withdraw-requests.update', ':id') }}";
                actionUrl = actionUrl.replace(':id', withdrawId);

                $('#editRequestForm').attr('action', actionUrl);
            });
        });
    </script>
@endsection
