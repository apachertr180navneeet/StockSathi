@extends('admin.admin_master')

@section('admin')
    <style>
        .card-ui {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .page-header {
            font-weight: 600;
            font-size: 22px;
        }

        .search-box {
            border-radius: 10px;
            padding-left: 40px;
        }

        .search-icon {
            position: absolute;
            top: 10px;
            left: 12px;
            color: #999;
        }

        .loader {
            display: none;
            text-align: center;
            padding: 20px;
        }

        /* Button styling */
        .btn i {
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .table-view {
                display: none;
            }

            .card-view {
                display: block;
            }

            .btn {
                padding: 6px 8px;
            }
        }

        @media (min-width: 769px) {
            .card-view {
                display: none;
            }
        }
    </style>

    <div class="content mt-4">
        <div class="container-fluid">

            <div class="card-ui mt-4 fade-in">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="page-header">All Brand</div>

                    <a href="{{ route('add.brand') }}" class="btn btn-primary btn-sm">
                        + Add Brand
                    </a>
                </div>

                <!-- Search -->
                <div class="position-relative mb-3">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="search" class="form-control search-box" placeholder="Search brands...">
                </div>

                <!-- Loader -->
                <div class="loader" id="loader">
                    <div class="spinner-border text-primary"></div>
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
                    $('#brandTable').html(data);
                    hideLoader();
                });
            });

            // 🔄 LOAD TABLE
            function loadTable(search = '') {

                showLoader();

                $.get("{{ route('all.brand') }}", {
                    search: search
                }, function(data) {
                    $('#brandTable').html(data);
                    hideLoader();
                });
            }

            // 🗑 DELETE
            $(document).on('click', '.deleteBtn', function() {

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete this brand?',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {

                    if (result.isConfirmed) {

                        showLoader();

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
