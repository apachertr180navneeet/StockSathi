{{-- Desktop Table --}}
<div class="table-responsive table-view">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Brand</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($brand as $key => $item)
                <tr class="fade-in">
                    <td>{{ $brand->firstItem() + $key }}</td>

                    <!-- 🖼 Image -->
                    <td>
                        <img src="{{ $item->image ? asset($item->image) : url('upload/no_image.jpg') }}"
                             class="brand-img">
                    </td>

                    <!-- Name -->
                    <td>
                        <strong>{{ $item->name }}</strong>
                    </td>

                    <!-- Action -->
                    <td class="text-end">
                        <a href="{{ route('edit.brand', $item->id) }}"
                           class="btn btn-sm btn-outline-primary me-1"
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <button class="btn btn-sm btn-outline-danger deleteBtn"
                                data-id="{{ $item->id }}"
                                title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No Brand Found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


{{-- Mobile Card --}}
<div class="card-view">
    @forelse($brand as $item)
        <div class="card mb-2 shadow-sm border-0 fade-in">
            <div class="card-body d-flex align-items-center justify-content-between">

                <!-- Left (Image + Name) -->
                <div class="d-flex align-items-center gap-2">

                    <img src="{{ $item->image ? asset($item->image) : url('upload/no_image.jpg') }}"
                         class="brand-img">

                    <strong>{{ $item->name }}</strong>

                </div>

                <!-- Right (Actions) -->
                <div>
                    <a href="{{ route('edit.brand', $item->id) }}"
                       class="btn btn-sm btn-outline-primary me-1"
                       title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button class="btn btn-sm btn-outline-danger deleteBtn"
                            data-id="{{ $item->id }}"
                            title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>

            </div>
        </div>
    @empty
        <div class="text-center text-muted py-3">
            No Brand Found
        </div>
    @endforelse
</div>


{{-- Pagination --}}
<div class="d-flex justify-content-center mt-3">
    {!! $brand->links() !!}
</div>


{{-- 🎨 CSS --}}
<style>
.brand-img {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    transition: 0.3s;
}

/* 🔥 Hover zoom effect */
.brand-img:hover {
    transform: scale(1.2);
}

/* 📱 Mobile switch */
@media (max-width: 768px) {
    .table-view {
        display: none;
    }
}

@media (min-width: 769px) {
    .card-view {
        display: none;
    }
}
</style>