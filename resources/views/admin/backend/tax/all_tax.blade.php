@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Tax Management</h4>
            <a href="{{ route('add.tax') }}" class="btn btn-primary btn-sm">
                + Add Tax
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Search taxes...">
                </div>

                <div id="taxTable">
                    @include('admin.backend.tax.partials.tax_table')
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

            function loadTable(search = '') {
                $.get("{{ route('all.tax') }}", {
                    search: search
                }, function(data) {
                    $('#taxTable').html(data);
                });
            }

            $('#search').keyup(function() {
                loadTable($(this).val());
            });

            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete this tax setting?',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('delete/tax') }}/" + id,
                            type: "POST",
                            data: {
                                _method: "DELETE"
                            },
                            success: function(res) {
                                toastr.success(res.message);
                                loadTable();
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
