<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Rate</th>
                <th>Type</th>
                <th>Linked Account</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($taxes as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ number_format($item->rate, 2) }}{{ $item->type == 'Percentage' ? '%' : '' }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->account ? $item->account->name : 'Not Linked' }}</td>
                <td>
                    <span class="badge {{ $item->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $item->status }}
                    </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('edit.tax', $item->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="mdi mdi-pencil"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger deleteBtn" data-id="{{ $item->id }}">
                        <i class="mdi mdi-trash-can"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">No taxes found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
