@extends('admin.admin_master')

@section('admin')
    <link href="{{ asset('backend/assets/css/brand.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <div class="content mt-3 px-2 px-md-3 px-lg-4">
        <div class="container-fluid">

            <div class="card-ui mt-3 p-3 p-md-4">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="page-header">All Brand</div>

                    <a href="{{ route('add.brand') }}" class="btn btn-primary btn-sm">
                        + Add Brand
                    </a>
                </div>

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
