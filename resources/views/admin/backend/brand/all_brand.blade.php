@extends('admin.admin_master')

@section('admin')
<div class="content mt-4 px-3">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h4 class="fs-22 fw-bold text-dark m-0">Brand Management</h4>
                <p class="text-muted mb-0 small">Manage your inventory brands, import data, and view deleted records.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('sample.brand') }}" class="btn btn-soft-info btn-sm fw-medium px-3 border-0" style="background-color: #e0f2f1; color: #00796b;">
                    <i class="fas fa-download me-1"></i> Sample
                </a>
                <button class="btn btn-soft-warning btn-sm fw-medium px-3 border-0" style="background-color: #fff3e0; color: #ef6c00;" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-upload me-1"></i> Import
                </button>
                <a href="{{ route('add.brand') }}" class="btn btn-primary btn-sm fw-medium px-3 shadow-sm">
                    <i class="fas fa-plus me-1"></i> Add Brand
                </a>
                <a href="{{ route('trash.brand') }}" class="btn btn-soft-secondary btn-sm fw-medium px-3 border-0" style="background-color: #f5f5f5; color: #616161;">
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
                                <input type="text" id="search" class="form-control bg-transparent border-0 ps-2" placeholder="Search brands..." style="box-shadow: none;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="p-4" id="brandTable">
                    @include('admin.backend.brand.partials.brand_table')
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('import.brand') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-light border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" id="importModalLabel">Import Brands</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Choose CSV or Excel File</label>
                        <input type="file" name="import_file" class="form-control border-dashed p-3" accept=".csv,.xlsx,.xls" required style="border: 2px dashed #dee2e6;">
                        <small class="text-muted mt-2 d-block">Maximum file size: 2MB</small>
                    </div>
                    <div class="p-3 rounded-3" style="background-color: #e3f2fd;">
                        <div class="d-flex gap-2">
                            <i class="fas fa-info-circle text-primary mt-1"></i>
                            <div>
                                <strong class="text-primary d-block mb-1">Import Instructions:</strong>
                                <p class="small text-dark mb-2">File must have a column named <code>name</code>. Each brand name must be unique.</p>
                                <a href="{{ route('sample.brand') }}" class="fw-bold small text-decoration-none">
                                    <i class="fas fa-download me-1"></i> Download Sample CSV
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning px-4 fw-bold">
                        <i class="fas fa-upload me-1"></i> Start Import
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
                    $('#brandTable').html(data);
                });
            });

            // Status Toggle
            $(document).on('change', '.statusToggle', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('change-status/brand') }}/" + id,
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
                    title: 'Delete this brand?',
                    text: "You can restore it from the trash later.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#f43f5e',
                    confirmButtonText: 'Yes, delete it!'
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
