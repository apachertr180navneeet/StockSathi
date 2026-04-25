<div class="table-responsive">
    <table class="table table-centered table-nowrap mb-0">
        <thead class="table-light">
            <tr>
                <th>Date</th>
                <th>Employee</th>
                <th>Status</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $item)
            <tr>
                <td>{{ $item->date->format('d M, Y') }}</td>
                <td>{{ $item->employee->first_name }} {{ $item->employee->last_name }}</td>
                <td>
                    <span class="badge {{ $item->status == 'Present' ? 'bg-success' : ($item->status == 'Absent' ? 'bg-danger' : 'bg-warning') }}">
                        {{ $item->status }}
                    </span>
                </td>
                <td>{{ $item->check_in_time ? $item->check_in_time->format('h:i A') : '-' }}</td>
                <td>{{ $item->check_out_time ? $item->check_out_time->format('h:i A') : '-' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-soft-danger deleteBtn" data-id="{{ $item->id }}">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No attendance records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {!! $attendances->links('pagination::bootstrap-5') !!}
</div>
