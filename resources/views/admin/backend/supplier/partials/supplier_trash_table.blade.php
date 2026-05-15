<div class="table-responsive">
    <table class="table table-hover align-middle table-bordered nowrap w-100 mb-0">
        <thead class="table-light">
            <tr>
                <th width="5%">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAllTrash">
                    </div>
                </th>
                <th width="5%">Sl</th>
                <th>Supplier Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Deleted At</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supplier as $key => $item)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input trashCheckbox" type="checkbox" value="{{ $item->id }}">
                        </div>
                    </td>
                    <td>{{ $supplier->firstItem() + $key }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->deleted_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-info btn-sm restoreBtn" data-id="{{ $item->id }}">Restore</button>
                            <button class="btn btn-danger btn-sm parmanentDeleteBtn" data-id="{{ $item->id }}">Delete Forever</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No Trashed Suppliers Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {!! $supplier->links('pagination::bootstrap-5') !!}
</div>
