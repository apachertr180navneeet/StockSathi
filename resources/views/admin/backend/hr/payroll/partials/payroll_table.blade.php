<div class="table-responsive">
    <table class="table table-centered table-nowrap mb-0">
        <thead class="table-light">
            <tr>
                <th>Employee</th>
                <th>Month/Year</th>
                <th>Net Salary</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payrolls as $item)
            <tr>
                <td>{{ $item->employee->first_name }} {{ $item->employee->last_name }}</td>
                <td>{{ date('F', mktime(0, 0, 0, $item->month, 1)) }} {{ $item->year }}</td>
                <td>{{ number_format($item->net_salary, 2) }}</td>
                <td>
                    <span class="badge {{ $item->payment_status == 'Paid' ? 'bg-success' : 'bg-warning' }}">
                        {{ $item->payment_status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('details.payroll', $item->id) }}" class="btn btn-sm btn-soft-info me-1">
                        <i class="ri-eye-line"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-soft-danger deleteBtn" data-id="{{ $item->id }}">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No payroll records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $payrolls->links('vendor.pagination.bootstrap-5') }}
</div>
