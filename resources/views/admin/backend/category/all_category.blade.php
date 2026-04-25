@extends('admin.admin_master')

@section('admin')

<style>
    /* Same CSS as Brand */
    @media (max-width: 768px) {
        .table td, .table th {
            white-space: nowrap;
            font-size: 12px;
        }

        .btn-sm {
            padding: 4px 6px;
            font-size: 11px;
        }
    }

    @media (max-width: 576px) {
        .py-3 {
            gap: 10px;
        }

        .btn-sm {
            font-size: 12px;
            padding: 6px 10px;
        }
    }
</style>

<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Product Category</h4>
            <button type="button" class="btn btn-primary btn-sm"
                data-bs-toggle="modal" data-bs-target="#standard-modal">
                + Add Category
            </button>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered nowrap w-100">

                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Category Name</th>
                                        <th>Category Slug</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($category as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->category_name }}</td>
                                            <td>{{ $item->category_slug }}</td>
                                            <td>

                                                <!-- SAME BUTTON STYLE -->
                                                <button type="button"
                                                    class="btn btn-success btn-sm editBtn"
                                                    data-id="{{ $item->id }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#category">
                                                    Edit
                                                </button>

                                                <a href="{{ route('delete.category', $item->id) }}"
                                                    class="btn btn-danger btn-sm" id="delete">
                                                    Delete
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
            </div>
        </div>

    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="standard-modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('store.category') }}" method="post">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="category_name" class="form-control">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="category">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('update.category') }}" method="post">
                @csrf

                <input type="hidden" name="cat_id" id="cat_id">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="category_name" id="cat" class="form-control">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {

       

        // Edit Category
        $(document).on('click', '.editBtn', function () {
            let id = $(this).data('id');

            let url = "{{ route('edit.category', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    $('#cat').val(data.category_name);
                    $('#cat_id').val(data.id);
                }
            });
        });

    });
</script>
@endpush
