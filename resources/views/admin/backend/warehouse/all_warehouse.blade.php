@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Warehouse</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('sample.warehouse') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-download me-1"></i> Sample
                </a>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-upload me-1"></i> Import
                </button>
                <a href="{{ route('add.warehouse') }}" class="btn btn-primary btn-sm">
                    + Add Warehouse
                </a>
                <a href="{{ route('trash.warehouse') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-trash me-1"></i> Trash
                </a>
            </div>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Search -->
                <div class="position-relative mb-3">
                    <input type="text" id="search" class="form-control search-box" placeholder="Search warehouse...">
                </div>

                <!-- Bulk Actions -->
                <div class="mb-3" id="bulkActions" style="display: none;">
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

                <!-- Table -->
                <div id="warehouseTable">
                    @include('admin.backend.warehouse.partials.warehouse_table')
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('import.warehouse') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Warehouses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Choose CSV or Excel File</label>
                        <input type="file" name="import_file" class="form-control" accept=".csv,.xlsx,.xls" required>
                    </div>
                    <div class="alert alert-info mb-0">
                        <strong>Note:</strong> File must have columns: <code>name</code>, <code>email</code>, <code>phone</code>, <code>city</code>. Email must be unique.
                        <a href="{{ route('sample.warehouse') }}" class="d-block mt-1">
                            <i class="fas fa-download me-1"></i> Download Sample File
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-upload me-1"></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {

            // ✅ GLOBAL CSRF FIX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            let delayTimer;

            function showLoader() {
                $('#loader').show();
            }

            function hideLoader() {
                $('#loader').hide();
            }

            // 🔍 SEARCH
            $('#search').keyup(function() {
                clearTimeout(delayTimer);
                let search = $(this).val();

                delayTimer = setTimeout(function() {
                    loadTable(search);
                }, 400);
            });

            // 📄 PAGINATION
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                let url = $(this).attr('href');
                let search = $('#search').val();

                showLoader();

                $.get(url, {
                    search: search
                }, function(data) {
                    $('#warehouseTable').html(data);
                    hideLoader();
                });
            });

            // 🔄 LOAD TABLE
            function loadTable(search = '') {
                showLoader();

                $.get("{{ route('all.warehouse') }}", {
                    search: search
                }, function(data) {
                    $('#warehouseTable').html(data);
                    $('#bulkActions').hide();
                    hideLoader();
                });
            }

            // 🗑 DELETE (FINAL FIX)
            $(document).on('click', '.deleteBtn', function() {

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete this warehouse?',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {

                    if (result.isConfirmed) {

                        showLoader();

                        $.ajax({
                            url: "{{ url('delete/warehouse') }}/" + id,
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}', // ✅ FIX
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

            // Select All
            $(document).on('change', '#selectAll', function() {
                $('.whCheckbox').prop('checked', $(this).prop('checked'));
                toggleBulkActions();
            });
            $(document).on('change', '.whCheckbox', function() { toggleBulkActions(); });
            function toggleBulkActions() {
                let count = $('.whCheckbox:checked').length;
                if (count > 0) { $('#bulkActions').show(); $('#selectedCount').text(count + ' selected'); }
                else { $('#bulkActions').hide(); $('#selectAll').prop('checked', false); }
            }

            // Bulk Delete
            $('#bulkDeleteBtn').on('click', function() {
                let ids = $('.whCheckbox:checked').map(function() { return $(this).val(); }).get();
                if (!ids.length) return;
                Swal.fire({
                    title: 'Delete ' + ids.length + ' warehouse(s)?',
                    icon: 'warning', showCancelButton: true,
                    confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete all!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('bulk.delete.warehouse') }}", type: "POST", data: { ids: ids },
                            success: function(res) { toastr.success(res.message); loadTable($('#search').val()); }
                        });
                    }
                });
            });

            // Bulk Status
            $(document).on('click', '.bulk-status-btn', function(e) {
                e.preventDefault();
                let ids = $('.whCheckbox:checked').map(function() { return $(this).val(); }).get();
                let status = $(this).data('status');
                if (!ids.length) return;
                $.ajax({
                    url: "{{ route('bulk.status.warehouse') }}", type: "POST", data: { ids: ids, status: status },
                    success: function(res) { toastr.success(res.message); loadTable($('#search').val()); }
                });
            });

            // Status Toggle
            $(document).on('change', '.statusToggle', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('change-status/warehouse') }}/" + id, type: "POST",
                    success: function(res) { toastr.success(res.message); },
                    error: function() { toastr.error('Something went wrong!'); }
                });
            });

        });
    </script>
@endsection
