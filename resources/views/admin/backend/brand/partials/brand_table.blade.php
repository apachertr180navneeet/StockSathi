<div class="brand-section">

    <div class="row g-3">

        @forelse($brand as $item)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                <div class="brand-card">

                    <div class="d-flex justify-content-between align-items-start">

                        <!-- LEFT -->
                        <div class="d-flex align-items-center gap-2">

                            <img src="{{ $item->image ? asset($item->image) : url('upload/no_image.jpg') }}"
                                class="brand-img">

                            <div>
                                <div class="brand-name">{{ $item->name }}</div>
                                <small class="text-muted">Brand</small>
                            </div>

                        </div>

                        <!-- ACTIONS -->
                        <div class="d-flex gap-1">
                            <a href="{{ route('edit.brand', $item->id) }}" class="action-btn edit">
                                <i class="fa fa-pen"></i>
                            </a>

                            <button class="action-btn delete deleteBtn" data-id="{{ $item->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                    </div>

                </div>

            </div>
        @empty
            <div class="col-12 text-center text-muted py-4">
                No Brand Found
            </div>
        @endforelse

    </div>

</div>

{{-- Pagination --}}
<div class="pagination-wrapper mt-3">
    {!! $brand->links('pagination::bootstrap-5') !!}
</div>
