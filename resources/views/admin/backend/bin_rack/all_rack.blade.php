@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Rack Management</h4>
            <a href="{{ route('all.bin') }}" class="btn btn-secondary btn-sm">Manage Bins →</a>
        </div>

        <!-- Add Rack -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Add New Rack</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('store.rack') }}" method="POST">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                            <select name="warehouse_id" class="form-select" required>
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rack Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Rack A1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="submit" class="btn btn-primary w-100">Add Rack</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Racks List -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Rack Name</th>
                                <th>Warehouse</th>
                                <th>Total Bins</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allRacks as $key => $rack)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $rack->name }}</td>
                                    <td>{{ $rack->warehouse->name ?? 'N/A' }}</td>
                                    <td><span class="badge bg-info">{{ $rack->bins->count() }}</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm edit-rack-btn"
                                            data-id="{{ $rack->id }}"
                                            data-name="{{ $rack->name }}"
                                            data-warehouse="{{ $rack->warehouse_id }}"
                                            data-bs-toggle="modal" data-bs-target="#editRackModal">Edit</button>
                                        <a href="{{ route('delete.rack', $rack->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
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

<!-- Edit Rack Modal -->
<div class="modal fade" id="editRackModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Rack</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('update.rack') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="edit_rack_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Warehouse</label>
                        <select name="warehouse_id" id="edit_rack_warehouse" class="form-select">
                            <option value="">Select Warehouse</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rack Name</label>
                        <input type="text" name="name" id="edit_rack_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Rack</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.edit-rack-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('edit_rack_id').value = this.dataset.id;
            document.getElementById('edit_rack_name').value = this.dataset.name;
            document.getElementById('edit_rack_warehouse').value = this.dataset.warehouse;
        });
    });
</script>
@endpush
@endsection
