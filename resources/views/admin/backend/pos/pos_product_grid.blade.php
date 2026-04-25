@if($products->isEmpty())
    <div class="col-12 text-center my-5">
        <h4 class="text-muted">No products found.</h4>
    </div>
@else
    @foreach ($products as $item)
        <div class="col-md-3 col-sm-4 col-6 mb-3">
            <div class="card h-100 product-card shadow-sm border-0" 
                 style="cursor: pointer; transition: transform 0.2s;"
                 onclick="addToCart({{ $item->id }}, '{{ $item->name }}', {{ $item->selling_price }}, {{ $item->product_qty }})">
                <div class="card-body p-2 text-center">
                    <div style="height: 100px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 5px; margin-bottom: 10px;">
                        @if($item->images->count() > 0)
                            <img src="{{ asset('upload/product/' . $item->images->first()->photo_name) }}" alt="{{ $item->name }}" style="max-height: 90px; max-width: 100%;">
                        @else
                            <i class="mdi mdi-image-outline text-muted" style="font-size: 40px;"></i>
                        @endif
                    </div>
                    <h6 class="mb-1 text-truncate" title="{{ $item->name }}" style="font-size: 13px;">{{ $item->name }}</h6>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="text-primary fw-bold">₹{{ $item->selling_price }}</span>
                        <span class="badge {{ $item->product_qty > 0 ? 'bg-success' : 'bg-danger' }}">{{ $item->product_qty }} In Stock</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
