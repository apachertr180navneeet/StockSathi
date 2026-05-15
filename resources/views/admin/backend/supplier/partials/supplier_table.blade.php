<div class="table-responsive">
    <table class="table table-hover align-middle table-bordered nowrap w-100 mb-0">
        <thead class="table-light">
            <tr>
                <th width="5%">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                    </div>
                </th>
                <th width="5%">Sl</th>
                <th>Supplier Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Balance</th>
                <th width="10%">Status</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($supplier as $key => $item)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input supCheckbox" type="checkbox" value="{{ $item->id }}">
                        </div>
                    </td>
                    <td>{{ $supplier->firstItem() + $key }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td title="{{ $item->address }}">
                        {{ \Illuminate\Support\Str::limit($item->address, 30, '...') }}
                    </td>
                    <td>&#8377;{{ number_format($item->purchases_sum_due_amount ?? 0, 2) }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input statusToggle" type="checkbox" data-id="{{ $item->id }}" {{ $item->status == 1 ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('edit.supplier', $item->id) }}" class="btn btn-soft-success btn-sm border-0" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-soft-danger btn-sm border-0 deleteBtn" data-id="{{ $item->id }}" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">No Supplier Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-3">
    {!! $supplier->links('pagination::bootstrap-5') !!}
</div>
