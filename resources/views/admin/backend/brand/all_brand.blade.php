@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Brand</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('sample.brand') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-download me-1"></i> Sample
                </a>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-upload me-1"></i> Import
                </button>
                <a href="{{ route('add.brand') }}" class="btn btn-primary btn-sm">
                    + Add Brand
                </a>
                <a href="{{ route('trash.brand') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-trash me-1"></i> Trash
                </a>
            </div>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Search -->
                <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Search brands...">
                </div>

                <!-- Data -->
                <div id="brandTable">
                    @include('admin.backend.brand.partials.brand_table')
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
            <form action="{{ route('import.brand') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Brands</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Choose CSV or Excel File</label>
                        <input type="file" name="import_file" class="form-control" accept=".csv,.xlsx,.xls" required>
                    </div>
                    <div class="alert alert-info mb-0">
                        <strong>Note:</strong> File must have a column named <code>name</code>. The brand name must be unique.
                        <a href="{{ route('sample.brand') }}" class="d-block mt-1">
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let delayTimer;

            function loadTable(search = '') {
                $.get("{{ route('all.brand') }}", {
                    search: search
                }, function(data) {
                    $('#brandTable').html(data);
                });
            }

            // 🔍 Search
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
                    $('#brandTable').html(data);
                });
            });

            // 🗑 Delete
            $(document).on('click', '.deleteBtn', function() {

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete this brand?',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ url('delete/brand') }}/" + id,
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
