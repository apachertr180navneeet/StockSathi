@extends('admin.admin_master')

@section('admin')
    <link href="{{ asset('backend/assets/css/supplier.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <div class="content mt-3 px-2 px-md-3 px-lg-4">
        <div class="container-fluid">

            <div class="card-ui">

                <!-- HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="page-header">All Supplier</div>

                    <a href="{{ route('add.supplier') }}" class="btn btn-primary btn-sm">
                        + Add Supplier
                    </a>
                </div>

                <!-- SEARCH -->
                <div class="mb-3">
                    <input type="text" id="search" class="form-control search-box" placeholder="Search supplier...">
                </div>

                <!-- DATA -->
                <div id="supplierTable">
                    @include('admin.backend.supplier.partials.supplier_table')
                </div>

            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            // CSRF (safe way)
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
                    $('#supplierTable').html(data); // 👈 CHANGE ID ACCORDING TO FILE
                    hideLoader();
                });
            });

            // 🔄 LOAD TABLE
            function loadTable(search = '') {

                showLoader();

                $.get("{{ route('all.supplier') }}", {
                    search: search
                }, function(data) {
                    $('#supplierTable').html(data); // 👈 IMPORTANT
                    hideLoader();
                });
            }

            // 🗑 DELETE
            $(document).on('click', '.deleteBtn', function() {

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete this supplier?',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {

                    if (result.isConfirmed) {

                        showLoader();

                        $.ajax({
                            url: "{{ url('delete/supplier') }}/" + id,
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
