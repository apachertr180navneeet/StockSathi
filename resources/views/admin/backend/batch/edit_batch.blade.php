@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Edit Product Batch</h4>
            <a href="{{ route('all.batch') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('update.batch') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $batch->id }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product <span class="text-danger">*</span></label>
                            <select name="product_id" class="form-select select2" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $batch->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} ({{ $product->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batch No <span class="text-danger">*</span></label>
                            <input type="text" name="batch_no" class="form-control" value="{{ $batch->batch_no }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control"
                                value="{{ $batch->expiry_date ? date('Y-m-d', strtotime($batch->expiry_date)) : '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="qty" class="form-control" min="0" step="0.01"
                                value="{{ $batch->qty }}" required>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Update Batch</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
