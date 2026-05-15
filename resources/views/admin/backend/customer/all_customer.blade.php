@extends('admin.admin_master')

@section('admin')
<div class="content mt-4 px-3">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h4 class="fs-22 fw-bold text-dark m-0">Customer Management</h4>
                <p class="text-muted mb-0 small">Manage your customers, view details, and control their status.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('add.customer') }}" class="btn btn-primary btn-sm fw-medium px-3 shadow-sm">
                    <i class="fas fa-plus me-1"></i> Add Customer
                </a>
                <a href="{{ route('trash.customer') }}" class="btn btn-soft-secondary btn-sm fw-medium px-3 border-0" style="background-color: #f5f5f5; color: #616161;">
                    <i class="fas fa-trash-alt me-1"></i> View Trash
                </a>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-body p-0">

                <!-- Search Section -->
                <div class="p-4 border-bottom bg-white">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group border rounded-pill overflow-hidden bg-light" style="border-color: #eee !important;">
                                <span class="input-group-text bg-transparent border-0 pe-1">
                                    <i class="fas fa-search text-muted small"></i>
                                </span>
                                <input type="text" id="search" class="form-control bg-transparent border-0 ps-2" placeholder="Search customers..." style="box-shadow: none;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bulk Actions -->
                <div class="p-4 pb-0" id="bulkActions" style="display: none;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small" id="selectedCount">0 selected</span>
                        <button class="btn btn-danger btn-sm" id="bulkDeleteBtn"><i class="fas fa-trash-alt me-1"></i> Delete Selected</button>
                        <div class="dropdown">
                            <button class="btn btn-soft-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-toggle-on me-1"></i> Change Status
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item bulk-status-btn" href="#" data-status="1"><i class="fas fa-check-circle text-success me-2"></i>Active</a></li>
                                <li><a class="dropdown-item bulk-status-btn" href="#" data-status="0"><i class="fas fa-times-circle text-danger me-2"></i>Inactive</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="p-4" id="customerTable">
                    @include('admin.backend.customer.partials.customer_table')
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let delayTimer;

            function loadTable(search = '') {
                $.get("{{ route('all.customer') }}", {
                    search: search
                }, function(data) {
                    $('#customerTable').html(data);
                    $('#bulkActions').hide();
                });
            }

            // 🔍 Search with debouncing
            $('#search').keyup(function() {
                clearTimeout(delayTimer);
                let search = $(this).val();

                delayTimer = setTimeout(function() {
                    loadTable(search);
                }, 400);
            });

            // 📄 Pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                let url = $(this).attr('href');
                let search = $('#search').val();

                $.get(url, {
                    search: search
                }, function(data) {
                    $('#customerTable').html(data);
                });
            });

            // Select All
            $(document).on('change', '#selectAll', function() {
                $('.custCheckbox').prop('checked', $(this).prop('checked'));
                toggleBulkActions();
            });

            $(document).on('change', '.custCheckbox', function() {
                toggleBulkActions();
            });

            function toggleBulkActions() {
                let count = $('.custCheckbox:checked').length;
                if (count > 0) {
                    $('#bulkActions').show();
                    $('#selectedCount').text(count + ' selected');
                } else {
                    $('#bulkActions').hide();
                    $('#selectAll').prop('checked', false);
                }
            }

            // Bulk Delete
            $('#bulkDeleteBtn').on('click', function() {
                let ids = $('.custCheckbox:checked').map(function() { return $(this).val(); }).get();
                if (!ids.length) return;
                Swal.fire({
                    title: 'Delete ' + ids.length + ' customer(s)?',
                    text: "They can be restored from the trash later.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete all!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('bulk.delete.customer') }}",
                            type: "POST",
                            data: { ids: ids },
                            success: function(res) {
                                toastr.success(res.message);
                                loadTable($('#search').val());
                            }
                        });
                    }
                });
            });

            // Bulk Status Change
            $(document).on('click', '.bulk-status-btn', function(e) {
                e.preventDefault();
                let ids = $('.custCheckbox:checked').map(function() { return $(this).val(); }).get();
                let status = $(this).data('status');
                if (!ids.length) return;
                $.ajax({
                    url: "{{ route('bulk.status.customer') }}",
                    type: "POST",
                    data: { ids: ids, status: status },
                    success: function(res) {
                        toastr.success(res.message);
                        loadTable($('#search').val());
                    }
                });
            });

            // Status Toggle
            $(document).on('change', '.statusToggle', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('/change-status/customer') }}/" + id,
                    type: "POST",
                    success: function(res) {
                        toastr.success(res.message);
                    },
                    error: function() {
                        toastr.error('Something went wrong!');
                    }
                });
            });

            // 🗑 Delete
            $(document).on('click', '.deleteBtn', function() {

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete this customer?',
                    text: "You can restore it from the trash later.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#f43f5e',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ url('/delete/customer') }}/" + id,
                            type: "POST",
                            data: {
                                _method: "DELETE"
                            },

                            success: function(res) {
                                toastr.success(res.message);
                                loadTable($('#search').val());
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
