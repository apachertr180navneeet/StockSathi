@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Designations</h4>
            <a href="{{ route('add.designation') }}" class="btn btn-primary btn-sm">
                + Add Designation
            </a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="search" class="form-control" placeholder="Search designations...">
                    </div>
                    <div class="col-md-4">
                        <select id="department_filter" class="form-select">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Data -->
                <div id="designationTable">
                    @include('admin.backend.hr.designation.partials.designation_table')
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

            function loadTable(search = '', department_id = '') {
                $.get("{{ route('all.designation') }}", {
                    search: search,
                    department_id: department_id
                }, function(data) {
                    $('#designationTable').html(data);
                });
            }

            // 🔍 Search
            $('#search').keyup(function() {
                clearTimeout(delayTimer);
                let search = $(this).val();
                let department_id = $('#department_filter').val();

                delayTimer = setTimeout(function() {
                    loadTable(search, department_id);
                }, 400);
            });

            // 🏢 Department Filter
            $('#department_filter').change(function() {
                let search = $('#search').val();
                let department_id = $(this).val();
                loadTable(search, department_id);
            });

            // 📄 Pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                let url = $(this).attr('href');
                let search = $('#search').val();
                let department_id = $('#department_filter').val();

                $.get(url, {
                    search: search,
                    department_id: department_id
                }, function(data) {
                    $('#designationTable').html(data);
                });
            });

            // 🗑 Delete
            $(document).on('click', '.deleteBtn', function() {

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete this designation?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ url('delete/designation') }}/" + id,
                            type: "GET",
                            success: function(res) {
                                if(res.status == 'success') {
                                    toastr.success(res.message);
                                    loadTable($('#search').val(), $('#department_filter').val());
                                } else {
                                    toastr.error(res.message);
                                }
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
