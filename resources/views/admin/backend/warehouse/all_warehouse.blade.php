@extends('admin.admin_master')

@section('admin')
    <link href="{{ asset('backend/assets/css/warehouse.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <div class="content mt-4">
        <div class="container-fluid">

            <div class="card-ui mt-4">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="page-header">All Warehouse</div>

                    <a href="{{ route('add.warehouse') }}" class="btn btn-primary btn-sm">
                        + Add Warehouse
                    </a>
                </div>

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
@endsection

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
