@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Bin Management</h4>
            <a href="{{ route('all.rack') }}" class="btn btn-secondary btn-sm">← Manage Racks</a>
        </div>

        <!-- Add Bin -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Add New Bin</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('store.bin') }}" method="POST">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rack <span class="text-danger">*</span></label>
                            <select name="rack_id" class="form-select" required>
                                <option value="">Select Rack</option>
                                @foreach($racks as $rack)
                                    <option value="{{ $rack->id }}">{{ $rack->name }} ({{ $rack->warehouse->name ?? '' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bin Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Bin A1-01" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="submit" class="btn btn-primary w-100">Add Bin</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bins List -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Bin Name</th>
                                <th>Rack</th>
                                <th>Warehouse</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allBins as $key => $bin)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $bin->name }}</td>
                                    <td>{{ $bin->rack->name ?? 'N/A' }}</td>
                                    <td>{{ $bin->rack->warehouse->name ?? 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm edit-bin-btn"
                                            data-id="{{ $bin->id }}"
                                            data-name="{{ $bin->name }}"
                                            data-rack="{{ $bin->rack_id }}"
                                            data-bs-toggle="modal" data-bs-target="#editBinModal">Edit</button>
                                        <a href="{{ route('delete.bin', $bin->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
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

<!-- Edit Bin Modal -->
<div class="modal fade" id="editBinModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Bin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('update.bin') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="edit_bin_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rack</label>
                        <select name="rack_id" id="edit_bin_rack" class="form-select">
                            <option value="">Select Rack</option>
                            @foreach($racks as $rack)
                                <option value="{{ $rack->id }}">{{ $rack->name }} ({{ $rack->warehouse->name ?? '' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bin Name</label>
                        <input type="text" name="name" id="edit_bin_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Bin</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.edit-bin-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('edit_bin_id').value = this.dataset.id;
            document.getElementById('edit_bin_name').value = this.dataset.name;
            document.getElementById('edit_bin_rack').value = this.dataset.rack;
        });
    });
</script>
@endpush
@endsection
