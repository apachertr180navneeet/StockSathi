@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Supplier</h4>
            <a href="{{ route('add.supplier') }}" class="btn btn-primary btn-sm">
                + Add Supplier
            </a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

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
