<div class="table-responsive">
    <table class="table table-centered table-nowrap mb-0">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $item)
            <tr>
                <td>{{ $item->employee_id }}</td>
                <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                <td>{{ $item->department->name ?? 'N/A' }}</td>
                <td>{{ $item->designation->name ?? 'N/A' }}</td>
                <td>
                    @if($item->status == 'active')
                        <span class="badge bg-success-subtle text-success px-2 py-1">Active</span>
                    @elseif($item->status == 'on_leave')
                        <span class="badge bg-warning-subtle text-warning px-2 py-1">On Leave</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger px-2 py-1">Terminated</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('details.employee', $item->id) }}" class="btn btn-sm btn-soft-info me-1">
                        <i class="ri-eye-line"></i>
                    </a>
                    <a href="{{ route('edit.employee', $item->id) }}" class="btn btn-sm btn-soft-primary me-1">
                        <i class="ri-edit-line"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-soft-danger deleteBtn" data-id="{{ $item->id }}">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No employees found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {!! $employees->links('pagination::bootstrap-5') !!}
</div>
