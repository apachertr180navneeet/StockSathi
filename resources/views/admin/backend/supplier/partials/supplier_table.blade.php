<div class="row g-3">

@foreach ($supplier as $item)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">

        <div class="grid-card">

            <div class="d-flex justify-content-between">

                <div>
                    <div class="fw-semibold">{{ $item->name }}</div>
                    <small class="text-muted">{{ $item->email }}</small>
                </div>

                <div class="d-flex gap-1">
                    <a href="{{ route('edit.supplier', $item->id) }}" class="action-btn">
                        <i class="fa fa-pen"></i>
                    </a>

                    <a href="{{ route('delete.supplier', $item->id) }}" class="action-btn">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>

            </div>

            <div class="mt-2 small text-muted">
                📞 {{ $item->phone }} <br>
                📍 {{ \Illuminate\Support\Str::limit($item->address, 40) }}
            </div>

        </div>

    </div>
@endforeach

</div>

<div class="pagination-wrapper">
    {!! $supplier->links('pagination::bootstrap-5') !!}
</div>