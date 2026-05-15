<div class="table-responsive">
    <table class="table table-bordered nowrap w-100">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Brand Image</th>
                <th>Brand Name</th>
                <th>Deleted At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brand as $key => $item)
                <tr>
                    <td>{{ $brand->firstItem() + $key }}</td>
                    <td>
                        <img src="{{ $item->image ? asset($item->image) : url('upload/no_image.jpg') }}" style="width: 50px; height: 50px; object-fit:cover; border-radius: 4px;">
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->deleted_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <button class="btn btn-info btn-sm restoreBtn" data-id="{{ $item->id }}">Restore</button>
                        <button class="btn btn-danger btn-sm parmanentDeleteBtn" data-id="{{ $item->id }}">Delete Forever</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No Trashed Brands Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {!! $brand->links('pagination::bootstrap-5') !!}
</div>
