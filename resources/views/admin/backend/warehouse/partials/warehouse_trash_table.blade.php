<div class="table-responsive">
    <table class="table table-bordered nowrap w-100">
        <thead>
            <tr>
                <th width="5%">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAllTrash">
                    </div>
                </th>
                <th>Sl</th>
                <th>Warehouse Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th>Deleted At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warehouse as $key => $item)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input trashCheckbox" type="checkbox" value="{{ $item->id }}">
                        </div>
                    </td>
                    <td>{{ $warehouse->firstItem() + $key }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->city }}</td>
                    <td>{{ $item->deleted_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <button class="btn btn-info btn-sm restoreBtn" data-id="{{ $item->id }}">Restore</button>
                        <button class="btn btn-danger btn-sm parmanentDeleteBtn" data-id="{{ $item->id }}">Delete Forever</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">No Trashed Warehouses Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {!! $warehouse->links('pagination::bootstrap-5') !!}
</div>
