<div class="table-responsive">
    <table class="table table-bordered nowrap w-100">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Supplier Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Deleted At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supplier as $key => $item)
                <tr>
                    <td>{{ $supplier->firstItem() + $key }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->deleted_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <button class="btn btn-info btn-sm restoreBtn" data-id="{{ $item->id }}">Restore</button>
                        <button class="btn btn-danger btn-sm parmanentDeleteBtn" data-id="{{ $item->id }}">Delete Forever</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No Trashed Suppliers Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {!! $supplier->links('pagination::bootstrap-5') !!}
</div>
