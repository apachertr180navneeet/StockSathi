<div class="table-responsive">
    <table class="table table-hover align-middle table-bordered nowrap w-100 mb-0">
        <thead class="table-light">
            <tr>
                <th width="5%" class="border-bottom-0">Sl</th>
                <th class="border-bottom-0">Brand Image</th>
                <th class="border-bottom-0">Brand Name</th>
                <th width="10%" class="border-bottom-0">Status</th>
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
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input statusToggle" type="checkbox" data-id="{{ $item->id }}"
                                {{ $item->status == 1 ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('edit.brand', $item->id) }}" class="btn btn-soft-success btn-sm border-0" 
                               style="background-color: #e8f5e9; color: #2e7d32; transition: all 0.2s;" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-soft-danger btn-sm border-0 deleteBtn" 
                                    style="background-color: #ffebee; color: #c62828; transition: all 0.2s;" data-id="{{ $item->id }}" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <div class="mb-3">
                            <i class="fas fa-folder-open fs-1 text-light"></i>
                        </div>
                        <p class="mb-0 fw-medium text-dark">No Brands Found</p>
                        <small>Try adjusting your search or add a new brand.</small>
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
