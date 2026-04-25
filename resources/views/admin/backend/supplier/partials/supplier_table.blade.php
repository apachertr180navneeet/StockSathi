<div class="table-responsive">
    <table class="table table-bordered nowrap w-100">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Supplier Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($supplier as $key => $item)
                <tr>
                    <td>{{ $supplier->firstItem() + $key }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td title="{{ $item->address }}">
                        {{ \Illuminate\Support\Str::limit($item->address, 30, '...') }}
                    </td>
                    <td>
                        <a href="{{ route('edit.supplier', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $item->id }}">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No Supplier Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-3">
    {!! $supplier->links('pagination::bootstrap-5') !!}
</div>
