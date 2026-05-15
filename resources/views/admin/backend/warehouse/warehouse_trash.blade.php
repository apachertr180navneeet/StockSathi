@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Warehouse Trash</h4>
            <a href="{{ route('all.warehouse') }}" class="btn btn-dark btn-sm">Back to Warehouses</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Search trashed warehouses...">
                </div>

                <div id="warehouseTrashTable">
                    @include('admin.backend.warehouse.partials.warehouse_trash_table')
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
                $.get("{{ route('trash.warehouse') }}", {
                    search: search
                }, function(data) {
                    $('#warehouseTrashTable').html(data);
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
                    $('#warehouseTrashTable').html(data);
                });
            });

            $(document).on('click', '.restoreBtn', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Restore this warehouse?',
                    icon: 'question',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('restore/warehouse') }}/" + id,
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
                    title: 'Permanently delete this warehouse?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('parmanent/delete/warehouse') }}/" + id,
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
