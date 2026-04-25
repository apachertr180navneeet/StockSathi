<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Date</th>
                <th>Expense No</th>
                <th>Category</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->expense_date)->format('d M Y') }}</td>
                <td><span class="fw-bold">{{ $item->expense_no }}</span></td>
                <td>{{ $item->expenseAccount->name }}</td>
                <td>{{ $item->paymentAccount->name }}</td>
                <td>{{ number_format($item->amount, 2) }}</td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger deleteBtn" data-id="{{ $item->id }}">
                        <i class="mdi mdi-trash-can"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">No expenses found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">
    {{ $expenses->links() }}
</div>
