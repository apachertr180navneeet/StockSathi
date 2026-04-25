@extends('admin.admin_master')
@section('admin')

<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Product Details</h4>
            <a href="{{ route('all.product') }}" class="btn btn-dark btn-sm">Back</a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
            <div class="row">
            {{-- // Product Image     --}}
                <div class="col-md-4">
                    <h5 class="mb-3">Product Images</h5>
    <div class="d-flex flex-wrap">
        @forelse ($product->images as $image)
        <img src="{{ asset($image->image) }}" alt="image" class="me-2 mb-2" width="100" height="100" style="object-fit: cover; border: 1px solid #ddd; border-radius: 5px"> 
       @empty
           <p class="text-danger">No Image Available</p>
       @endforelse     

    </div> 

    @if($product->code)
    <h5 class="mt-4 mb-3">Product Barcode</h5>
    <div class="card p-3 border-0 shadow-sm" style="background: #f8f9fa;">
        <div class="text-center">
            <div class="mb-2 d-flex justify-content-center">
                {!! DNS1D::getBarcodeHTML($product->code, $product->barcode_symbology ?? 'C128', 2, 60) !!}
            </div>
            <span class="fw-bold fs-16">{{ $product->code }}</span>
            <br>
            <small class="text-muted">Symbology: {{ $product->barcode_symbology ?? 'C128' }}</small>
        </div>
    </div>
    @endif
        </div>

        {{-- // Product Details Data     --}}
    <div class="col-md-8">
        <h5 class="mb-3">Product Information</h5>
        <ul class="list-group">
            <li class="list-group-item"><strong>Name:</strong> {{ $product->name }} </li>
            <li class="list-group-item"><strong>Code:</strong> {{ $product->code }} </li>
            <li class="list-group-item"><strong>Batch/Lot No:</strong> {{ $product->batch_no ?? 'N/A' }} </li>
            <li class="list-group-item"><strong>Expiry Date:</strong> 
                @if($product->expiry_date)
                    @if(strtotime($product->expiry_date) < time())
                        <span class="badge text-bg-danger">{{ date('d M Y', strtotime($product->expiry_date)) }} (Expired)</span>
                    @else
                        <span class="badge text-bg-success">{{ date('d M Y', strtotime($product->expiry_date)) }}</span>
                    @endif
                @else
                    N/A
                @endif
            </li>
            <li class="list-group-item"><strong>Warehouse:</strong> {{ $product->warehouse->name }} </li>
            <li class="list-group-item"><strong>Supplier:</strong> {{ $product->supplier->name }} </li>
            <li class="list-group-item"><strong>Category:</strong> {{ $product->category->category_name }} </li>
            <li class="list-group-item"><strong>Brand:</strong> {{ $product->brand->name }} </li>
            <li class="list-group-item"><strong>Price:</strong> {{ $product->price }} </li>
            <li class="list-group-item"><strong>Stock Aleart:</strong> {{ $product->stock_alert }} </li>
            <li class="list-group-item"><strong>Product Qty:</strong> {{ $product->product_qty }} </li>
            <li class="list-group-item"><strong>Product Status:</strong> {{ $product->status }} </li>
            <li class="list-group-item"><strong>Product Note:</strong> {{ $product->note }} </li>
            <li class="list-group-item"><strong>Create On:</strong> 
             {{ \Carbon\Carbon::parse($product->created_at)->format('d F Y')  }} </li>

        </ul>

    </div>


            </div> 
            </div>
        </div>

    </div>
</div> 
 @endsection
