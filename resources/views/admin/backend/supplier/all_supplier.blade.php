@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Supplier</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('sample.supplier') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-download me-1"></i> Sample
                </a>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-upload me-1"></i> Import
                </button>
                <a href="{{ route('add.supplier') }}" class="btn btn-primary btn-sm">
                    + Add Supplier
                </a>
                <a href="{{ route('trash.supplier') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-trash me-1"></i> Trash
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <div class="mb-3">
                    <input type="text" id="search" class="form-control search-box" placeholder="Search supplier...">
                </div>

                <div id="supplierTable">
                    @include('admin.backend.supplier.partials.supplier_table')
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('import.supplier') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Suppliers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Choose CSV or Excel File</label>
                        <input type="file" name="import_file" class="form-control" accept=".csv,.xlsx,.xls" required>
                    </div>
                    <div class="alert alert-info mb-0">
                        <strong>Note:</strong> File must have columns: <code>name</code>, <code>email</code>, <code>phone</code>, <code>address</code>. Supplier name must be unique.
                        <a href="{{ route('sample.supplier') }}" class="d-block mt-1">
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

            function showLoader() {
                $('#loader').show();
            }

            function hideLoader() {
                $('#loader').hide();
            }

            function loadTable(search = '') {
                $.get("{{ route('all.supplier') }}", {
                    search: search
                }, function(data) {
                    $('#supplierTable').html(data);
                });
            }

            $('#search').keyup(function() {
                clearTimeout(delayTimer);
                let search = $(this).val();
                delayTimer = setTimeout(function() {
                    loadTable(search);
                }, 400);
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let search = $('#search').val();
                $.get(url, { search: search }, function(data) {
                    $('#supplierTable').html(data);
                });
            });

            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete this supplier?',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('delete/supplier') }}/" + id,
                            type: "POST",
                            data: { _method: "DELETE" },
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
