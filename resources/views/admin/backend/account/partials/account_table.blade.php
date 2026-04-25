<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Current Balance</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($accounts as $item)
            <tr>
                <td><span class="fw-bold">{{ $item->code }}</span></td>
                <td>{{ $item->name }}</td>
                <td>
                    <span class="badge {{ 
                        $item->type == 'Asset' ? 'bg-info' : (
                        $item->type == 'Liability' ? 'bg-danger' : (
                        $item->type == 'Revenue' ? 'bg-success' : (
                        $item->type == 'Expense' ? 'bg-warning' : 'bg-primary'))) 
                    }}">
                        {{ $item->type }}
                    </span>
                </td>
                <td>{{ number_format($item->current_balance, 2) }}</td>
                <td>
                    <span class="badge {{ $item->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $item->status }}
                    </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('edit.account', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                        <i class="mdi mdi-pencil"></i>
                    </a>
                    @if(!$item->is_system)
                    <button type="button" class="btn btn-sm btn-outline-danger deleteBtn" data-id="{{ $item->id }}" title="Delete">
                        <i class="mdi mdi-trash-can"></i>
                    </button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">No accounts found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
