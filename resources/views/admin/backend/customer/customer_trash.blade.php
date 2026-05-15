@extends('admin.admin_master')

@section('admin')
<div class="content mt-4 px-3">
    <div class="container-fluid">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <h4 class="fs-20 fw-semibold m-0">Customer Trash</h4>
            <a href="{{ route('all.customer') }}" class="btn btn-dark btn-sm">Back to Customers</a>
        </div>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body p-4">

                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="search" class="form-control border-start-0 ps-0" placeholder="Search trashed customers...">
                    </div>
                </div>

                <div class="mb-3" id="bulkTrashActions" style="display: none;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small" id="selectedTrashCount">0 selected</span>
                        <button class="btn btn-info btn-sm" id="bulkRestoreBtn"><i class="fas fa-undo me-1"></i> Restore Selected</button>
                        <button class="btn btn-danger btn-sm" id="bulkForceDeleteBtn"><i class="fas fa-trash me-1"></i> Delete Permanently</button>
                    </div>
                </div>

                <div id="customerTrashTable">
                    @include('admin.backend.customer.partials.customer_trash_table')
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
                $.get("{{ route('trash.customer') }}", {
                    search: search
                }, function(data) {
                    $('#customerTrashTable').html(data);
                    $('#bulkTrashActions').hide();
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
                    $('#customerTrashTable').html(data);
                });
            });

            // Select All (Trash)
            $(document).on('change', '#selectAllTrash', function() {
                $('.trashCheckbox').prop('checked', $(this).prop('checked'));
                toggleTrashBulkActions();
            });

            $(document).on('change', '.trashCheckbox', function() {
                toggleTrashBulkActions();
            });

            function toggleTrashBulkActions() {
                let count = $('.trashCheckbox:checked').length;
                if (count > 0) {
                    $('#bulkTrashActions').show();
                    $('#selectedTrashCount').text(count + ' selected');
                } else {
                    $('#bulkTrashActions').hide();
                    $('#selectAllTrash').prop('checked', false);
                }
            }

            // Bulk Restore
            $('#bulkRestoreBtn').on('click', function() {
                let ids = $('.trashCheckbox:checked').map(function() { return $(this).val(); }).get();
                if (!ids.length) return;
                Swal.fire({
                    title: 'Restore ' + ids.length + ' customer(s)?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0277bd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, restore all!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('bulk.restore.customer') }}",
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

            // Bulk Force Delete
            $('#bulkForceDeleteBtn').on('click', function() {
                let ids = $('.trashCheckbox:checked').map(function() { return $(this).val(); }).get();
                if (!ids.length) return;
                Swal.fire({
                    title: 'Permanently delete ' + ids.length + ' customer(s)?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete forever!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('bulk.force.delete.customer') }}",
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

            $(document).on('click', '.restoreBtn', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Restore this customer?',
                    icon: 'question',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('/restore/customer') }}/" + id,
                            type: "POST",
                            success: function(res) {
                                toastr.success(res.message);
                                loadTable($('#search').val());
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.parmanentDeleteBtn', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Permanently delete this customer?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('/parmanent/delete/customer') }}/" + id,
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
