@extends('admin.admin_master')

@section('admin')

<style>
    /* Product Image */
    .product-img {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .table td, .table th {
            white-space: nowrap;
            font-size: 12px;
        }

        .btn-sm {
            padding: 4px 6px;
            font-size: 11px;
        }

        .product-img {
            width: 45px;
            height: 30px;
        }
    }

    @media (max-width: 576px) {
        .py-3 {
            gap: 10px;
        }

        .btn-sm {
            font-size: 12px;
            padding: 6px 10px;
        }
    }
</style>

<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Product</h4>
            <a href="{{ route('add.product') }}" class="btn btn-primary btn-sm">
                + Add Product
            </a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered nowrap w-100">

                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Barcode</th>
                                        <th>Batch/Lot</th>
                                        <th>Expiry</th>
                                        <th>Warehouse</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>
                                                @php
                                                    $primaryImage = $item->images->first()->image ?? '/upload/no_image.jpg';
                                                @endphp
                                                <img src="{{ asset($primaryImage) }}" class="product-img">
                                            </td>

                                            <td>{{ $item->name }}</td>
                                            
                                            <td style="text-align: center;">
                                                @if($item->code)
                                                    <div style="margin-bottom: 2px;">
                                                    {!! DNS1D::getBarcodeHTML($item->code, $item->barcode_symbology ?? 'C128', 1.2, 33) !!}
                                                    </div>
                                                    <span style="font-size: 10px;">{{ $item->code }}</span>
                                                @endif
                                            </td>

                                            <td>{{ $item->batch_no ?? 'N/A' }}</td>
                                            
                                            <td>
                                                @if($item->expiry_date)
                                                    @if(strtotime($item->expiry_date) < time())
                                                        <span class="badge text-bg-danger">{{ date('d M Y', strtotime($item->expiry_date)) }}</span>
                                                    @else
                                                        {{ date('d M Y', strtotime($item->expiry_date)) }}
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td>{{ $item['warehouse']['name'] ?? 'N/A' }}</td>

                                            <td>₹{{ $item->price }}</td>

                                            <td>
                                                @if ($item->product_qty <= 3)
                                                    <span class="badge text-bg-danger">
                                                        {{ $item->product_qty }}
                                                    </span>
                                                @else
                                                    <span class="badge text-bg-secondary">
                                                        {{ $item->product_qty }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('details.product', $item->id) }}"
                                                    class="btn btn-info btn-sm">View</a>

                                                <a href="{{ route('edit.product', $item->id) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <a href="{{ route('delete.product', $item->id) }}"
                                                    class="btn btn-danger btn-sm" id="delete">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
            </div>
        </div>

    </div>
</div>

@endsection


@push('scripts')
<script>
    
</script>
@endpush
