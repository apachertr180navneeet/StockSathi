<div class="table-responsive">
    <table class="table table-centered table-nowrap mb-0">
        <thead class="table-light">
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->description ?? 'N/A' }}</td>
                <td>
                    @if($item->status == 1)
                        <span class="badge bg-success-subtle text-success px-2 py-1">Active</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger px-2 py-1">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('edit.department', $item->id) }}" class="btn btn-sm btn-soft-primary me-1">
                        <i class="ri-edit-line"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-soft-danger deleteBtn" data-id="{{ $item->id }}">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No departments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $departments->links('vendor.pagination.bootstrap-5') }}
</div>
