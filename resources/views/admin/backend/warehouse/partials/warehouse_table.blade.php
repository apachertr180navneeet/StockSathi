{{-- 🔥 MODERN GRID VIEW (LIKE BRAND) --}}
<div class="brand-section">

    <div class="row g-3">

        @foreach ($warehouse as $item)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                <div class="brand-card">

                    <!-- TOP -->
                    <div class="d-flex justify-content-between">

                        <div>
                            <div class="fw-semibold">{{ $item->name }}</div>
                            <small class="text-muted">{{ $item->city }}</small>
                        </div>

                        <div class="d-flex gap-1">
                            <a href="{{ route('edit.warehouse', $item->id) }}"
                                class="action-btn edit">
                                <i class="fa fa-pen"></i>
                            </a>

                            <button class="action-btn delete deleteBtn"
                                data-id="{{ $item->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                    </div>

                    <!-- DETAILS -->
                    <div class="mt-2 small text-muted">
                        📧 {{ $item->email }} <br>
                        📞 {{ $item->phone }}
                    </div>

                </div>

            </div>
        @endforeach

    </div>

</div>

{{-- Pagination --}}
<div class="pagination-wrapper mt-3">
    {{ $warehouse->links('pagination::bootstrap-5') }}
</div>