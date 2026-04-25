@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Chart of Accounts</h4>
            <a href="{{ route('add.account') }}" class="btn btn-primary btn-sm">
                + Add Account
            </a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Search and Filter -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <input type="text" id="search" class="form-control" placeholder="Search accounts by name or code...">
                    </div>
                    <div class="col-md-4">
                        <select id="type_filter" class="form-control">
                            <option value="">All Types</option>
                            <option value="Asset">Asset</option>
                            <option value="Liability">Liability</option>
                            <option value="Equity">Equity</option>
                            <option value="Revenue">Revenue</option>
                            <option value="Expense">Expense</option>
                        </select>
                    </div>
                </div>

                <!-- Data -->
                <div id="accountTable">
                    @include('admin.backend.account.partials.account_table')
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

            function loadTable() {
                let search = $('#search').val();
                let type = $('#type_filter').val();

                $.get("{{ route('all.account') }}", {
                    search: search,
                    type: type
                }, function(data) {
                    $('#accountTable').html(data);
                });
            }

            // 🔍 Search
            $('#search').keyup(function() {
                clearTimeout(delayTimer);
                delayTimer = setTimeout(function() {
                    loadTable();
                }, 400);
            });

            // 🎭 Filter
            $('#type_filter').change(function() {
                loadTable();
            });

            // 🗑 Delete
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete this account?',
                    text: 'Account with transactions cannot be deleted.',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('delete/account') }}/" + id,
                            type: "POST",
                            data: {
                                _method: "DELETE"
                            },
                            success: function(res) {
                                if(res.status == 'success') {
                                    toastr.success(res.message);
                                    loadTable();
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
