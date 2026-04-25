<div class="table-responsive">
    <table class="table table-bordered nowrap w-100">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Brand Image</th>
                <th>Brand Name</th>
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
                    <td>
                        <a href="{{ route('edit.brand', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $item->id }}">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">No Brand Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-3">
    {!! $brand->links('pagination::bootstrap-5') !!}
</div>
