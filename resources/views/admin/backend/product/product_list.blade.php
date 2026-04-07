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

<div class="content">
    <div class="container-xxl">

        <!-- SAME HEADER AS BRAND -->
        <div class="py-3 d-flex justify-content-between align-items-center flex-wrap">

            <h4 class="fs-18 fw-semibold m-0">All Product</h4>

            <a href="{{ route('add.product') }}" class="btn btn-primary btn-sm">
                + Add Product
            </a>

        </div>

        <!-- TABLE -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header"></div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered nowrap w-100">

                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name</th>
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

                                            <td>{{ $item['warehouse']['name'] }}</td>

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

    </div>
</div>

@endsection


@push('scripts')
<script>
    
</script>
@endpush