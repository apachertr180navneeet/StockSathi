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

        });
    </script>
@endsection
