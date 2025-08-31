@extends('layouts.master')

@section('title', __('Vendors'))

@section('css')
    <style>
        .edit-loader {
            width: 100%;
        }

        .edit-loader .sk-chase {
            display: block;
            margin: 0 auto;
        }

        .modal-card{
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
    </style>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Vendors') }}</li>
@endsection
{{-- @dd($totalArchivedVendors) --}}
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6 mb-6">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-heading">{{ __('Vendors') }}</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2">{{ $totalVendors }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Total Vendors') }}</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-users ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-heading">{{ __('Deactivated Vendors') }}</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2">
                                        {{ $totalDeactivatedVendors }}
                                    </h4>
                                </div>
                                <small class="mb-0">{{ __('Total Deactive Vendors') }} </small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="ti ti-user-off ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-heading">{{ __('Active Vendors') }}</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2">{{ $totalActiveVendors }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Total Active Vendors') }}</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ti ti-user-check ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-heading">{{ __('Archived Vendors') }}</span>
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="mb-0 me-2">{{ $totalArchivedVendors }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Total Archived Vendors') }}</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="ti ti-archive ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vendors List Table -->
        <div class="card">
            <div class="card-header">
                @canany(['create vendor'])
                    <a href="{{ route('dashboard.vendors.create') }}" class="add-new btn btn-primary waves-effect waves-light">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                            class="d-none d-sm-inline-block">{{ __('Add New Vendor') }}</span>
                    </a>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Username') }}</th>
                            <th>{{ __('Shop Name') }}</th>
                            <th>{{ __('Total Products') }}</th>
                            <th>{{ __('Status') }}</th>
                            @canany(['delete vendor', 'update vendor', 'view vendor'])<th>{{ __('Action') }}</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $index => $vendor)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->username }}</td>
                                <td>{{ $vendor->userShop ? $vendor->userShop->shop_name : 'N/A' }}</td>
                                <td>{{ $vendor->products ? count($vendor->products) : '0' }}</td>
                                <td>
                                    <span
                                        class="badge me-4 bg-label-{{ $vendor->is_active == 'active' ? 'success' : 'danger' }}">{{ ucfirst($vendor->is_active) }}</span>
                                </td>
                                @canany(['delete vendor', 'update vendor', 'view vendor'])
                                    <td class="d-flex">
                                        @canany(['delete vendor'])
                                            <form action="{{ route('dashboard.vendors.destroy', $vendor->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="#" type="submit"
                                                    class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Vendor User') }}">
                                                    <i class="ti ti-trash ti-md"></i>
                                                </a>
                                            </form>
                                        @endcan
                                        @canany(['update vendor'])
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.vendors.edit', $vendor->id) }}"
                                                    class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Edit Vendor') }}">
                                                    <i class="ti ti-edit ti-md"></i>
                                                </a>
                                            </span>
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.orders.create', ['vendor_id' => $vendor->id]) }}"
                                                    class="btn btn-icon btn-text-info waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Add Order') }}">
                                                    <i class="ti ti-circle-plus ti-md"></i>
                                                </a>
                                            </span>
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.user.status.update', $vendor->id) }}"
                                                    class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $vendor->is_active == 'active' ? __('Deactivate Vendor') : __('Activate Vendor') }}">
                                                    @if ($vendor->is_active == 'active')
                                                        <i class="ti ti-toggle-right ti-md text-success"></i>
                                                    @else
                                                        <i class="ti ti-toggle-left ti-md text-danger"></i>
                                                    @endif
                                                </a>
                                            </span>
                                        @endcan
                                        @canany(['view vendor'])
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.vendors.show', $vendor->id) }}"
                                                    class="btn btn-icon btn-text-warning waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('View Vendor Details') }}">
                                                    <i class="ti ti-eye ti-md"></i>
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
            <!-- Offcanvas to add new user -->
            @include('dashboard.users.sections.add-offcanvas')
            <!-- Offcanvas to edit user -->
            @include('dashboard.users.sections.edit-offcanvas')
        </div>
    </div>
    <!-- Modal to view user details -->
    @can(['view user'])
        @include('dashboard.users.sections.view-modal')
    @endcan
@endsection

@section('script')
    {{-- <script src="{{asset('assets/js/app-user-list.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            $('.edit-loader').hide();
            $('#editUserForm').show();
            // Event listener for edit modal opening
            $('#offcanvasEditUser').on('show.bs.offcanvas', function(event) {
                $('.edit-loader').show();
                $('#editUserForm').hide();
                var button = $(event.relatedTarget);
                var userId = button.data('user-id');
                fetchUserData(userId);
            });
            $('#modalCenter').on('show.bs.modal', function(event) {
                $('.edit-loader').show();
                $('#user-info').hide();
                var button = $(event.relatedTarget);
                var userId = button.data('user-id');
                fetchUserData(userId);
            });
            var editUserRoute = "{{ route('dashboard.user.edit', ':userId') }}";
            var updateUserRoute = "{{ route('dashboard.user.update', ':userId') }}";

            function fetchUserData(userId) {
                var url = editUserRoute.replace(':userId', userId);
                $.ajax({
                    url: url, // Adjust API URL as necessary
                    type: 'GET',
                    success: function(data) {
                        if (data.success) {
                            var user = data.user;
                            // Check if it's the edit offcanvas or the view modal
                            var isEdit = $('#offcanvasEditUser').hasClass('show');
                            var isModal = $('#modalCenter').hasClass('show');
                            if (isEdit) {
                                $('#edit_first_name').val(user.first_name);
                                $('#edit_last_name').val(user.last_name);
                                $('#edit_email').val(user.email);
                                $('#edit-user-role').val(user.role).trigger('change');

                                $('.edit-loader').hide();
                                $('#editUserForm').show();
                                // ✅ Set form action dynamically using the route variable
                                var updateUrl = updateUserRoute.replace(':userId', user.id);
                                $('#editUserForm').attr('action', updateUrl);
                            }
                            if (isModal) {
                                // ✅ Update Modal User Info
                                var profileImage = user.profile_image
                                    ? '{{ asset("") }}' + user.profile_image
                                    : '{{ asset("assets/img/default/user.png") }}';
                                $('#user-info img').attr('src', profileImage);
                                $('#user-info .user-info h5').text(user.full_name ? user.full_name :
                                    'N/A');
                                $('#user-info .user-info span.badge').text(user.role ? user.role.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) :
                                    'N/A');

                                var userDetails = `
                                    <li class="mb-2"><span class="h6">{{ __('Username') }}:</span> <span>${user.username ? user.username : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Email') }}:</span> <span>${user.email ? user.email : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Status') }}:</span> <span>${user.is_active ? user.is_active.replace(/\b\w/g, c => c.toUpperCase()) : 'Inactive'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Designation') }}:</span> <span>${user.designation ? user.designation : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Contact') }}:</span> <span>${user.phone_number ? user.phone_number : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Language') }}:</span> <span>${user.language ? user.language : 'N/A'}</span></li>
                                    <li class="mb-2"><span class="h6">{{ __('Country') }}:</span> <span>${user.country ? user.country : 'N/A'}</span></li>
                                    `;
                                $('#user-info .info-container ul').html(userDetails);

                                // Update Social Media Links
                                var socialLinks = '';
                                if (user.facebook_url) {
                                    socialLinks += `<a href="${user.facebook_url}" target="_blank" style="color: inherit;"><i class="fab fa-facebook fa-lg"></i></a>`;
                                }
                                if (user.linkedin_url) {
                                    socialLinks += `<a href="${user.linkedin_url}" target="_blank" style="color: inherit;"><i class="fab fa-linkedin fa-lg"></i></a>`;
                                }
                                if (user.skype_url) {
                                    socialLinks += `<a href="${user.skype_url}" target="_blank" style="color: inherit;"><i class="fab fa-skype fa-lg"></i></a>`;
                                }
                                if (user.instagram_url) {
                                    socialLinks += `<a href="${user.instagram_url}" target="_blank" style="color: inherit;"><i class="fab fa-instagram fa-lg"></i></a>`;
                                }
                                if (user.github_url) {
                                    socialLinks += `<a href="${user.github_url}" target="_blank" style="color: inherit;"><i class="fab fa-github fa-lg"></i></a>`;
                                }

                                $('#modalSocialIcons').html(socialLinks); // Update social icons container

                                $('.edit-loader').hide();
                                $('#user-info').show();
                            }

                        }
                    },
                    error: function(xhr, status, error) {
                        $('.edit-loader').hide();
                        $('#editUserForm').show();
                        $('#user-info').show();
                        console.error('Error fetching user data:', error);
                    }
                });
            }

            $("#addNewUserForm").on("submit", function() {
                $("#addUserBtn").prop("disabled", true); // Disable button
                $("#addUserLoader").removeClass("d-none"); // Show spinner
            });

            $("#editUserForm").on("submit", function() {
                $("#editUserBtn").prop("disabled", true); // Disable button
                $("#editUserLoader").removeClass("d-none"); // Show spinner
            });
        });
    </script>
@endsection
