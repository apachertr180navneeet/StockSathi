<div class="table-responsive">
    <table class="table table-hover align-middle table-bordered nowrap w-100 mb-0">
        <thead class="table-light">
            <tr>
                <th width="5%" class="border-bottom-0">Sl</th>
                <th class="border-bottom-0">Brand Image</th>
                <th class="border-bottom-0">Brand Name</th>
                <th class="border-bottom-0">Deleted At</th>
                <th width="15%" class="border-bottom-0">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brand as $key => $item)
                <tr>
                    <td>{{ $brand->firstItem() + $key }}</td>
                    <td>
                        <img src="{{ $item->image ? asset($item->image) : url('upload/no_image.jpg') }}" 
                             style="width: 50px; height: 50px; object-fit:cover; border-radius: 10px; border: 1px solid #eee; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    </td>
                    <td class="fw-medium text-dark">{{ $item->name }}</td>
                    <td class="text-muted small">{{ $item->deleted_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-soft-info btn-sm border-0 restoreBtn" 
                                    style="background-color: #e3f2fd; color: #0277bd; transition: all 0.2s;" data-id="{{ $item->id }}" title="Restore">
                                <i class="fas fa-undo"></i>
                            </button>
                            <button class="btn btn-soft-danger btn-sm border-0 parmanentDeleteBtn" 
                                    style="background-color: #ffebee; color: #c62828; transition: all 0.2s;" data-id="{{ $item->id }}" title="Delete Forever">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <div class="mb-3">
                            <i class="fas fa-trash-alt fs-1 text-light"></i>
                        </div>
                        <p class="mb-0 fw-medium text-dark">No Trashed Brands Found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-0 pt-4 border-top">
    <div class="px-1">
        {!! $brand->links() !!}
    </div>
</div>
