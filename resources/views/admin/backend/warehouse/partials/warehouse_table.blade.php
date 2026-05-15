<div class="table-responsive">
    <table class="table table-bordered nowrap w-100">
        <thead>
            <tr>
                <th width="5%">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                    </div>
                </th>
                <th>Sl</th>
                <th>Warehouse Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($warehouse as $key => $item)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input whCheckbox" type="checkbox" value="{{ $item->id }}">
                        </div>
                    </td>
                    <td>{{ $warehouse->firstItem() + $key }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->city }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input statusToggle" type="checkbox" data-id="{{ $item->id }}" {{ $item->status == 1 ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('edit.warehouse', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $item->id }}">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No Warehouse Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-3">
    {!! $warehouse->links('pagination::bootstrap-5') !!}
</div>
