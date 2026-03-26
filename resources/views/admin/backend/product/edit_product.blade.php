@extends('admin.admin_master')
@section('admin')

<div class="content d-flex flex-column flex-column-fluid">
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid my-0">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h2 class="fs-22 fw-semibold m-0">Edit Product</h2>
                </div>

                <div class="text-end">
                    <a href="{{ route('all.product') }}" class="btn btn-dark">Back</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('update.product') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $editData->id }}">

                        <div class="row">

                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="row">

                                        <!-- NAME -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Product Name: <span class="text-danger">*</span></label>
                                            <input type="text" name="name"
                                                class="form-control"
                                                value="{{ old('name', $editData->name) }}">

                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- CODE -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Code: <span class="text-danger">*</span></label>
                                            <input type="text" name="code"
                                                class="form-control"
                                                value="{{ old('code', $editData->code) }}">

                                            @error('code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- CATEGORY -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Product Category : <span class="text-danger">*</span></label>
                                            <select name="category_id" class="form-control form-select">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('category_id', $editData->category_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- BRAND -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Brand : <span class="text-danger">*</span></label>
                                            <select name="brand_id" class="form-control form-select">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('brand_id', $editData->brand_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('brand_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- PRICE -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Product Price:</label>
                                            <input type="text" name="price"
                                                class="form-control"
                                                value="{{ old('price', $editData->price) }}">

                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- STOCK ALERT -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stock Alert:</label>
                                            <input type="number" name="stock_alert"
                                                class="form-control"
                                                value="{{ old('stock_alert', $editData->stock_alert) }}">

                                            @error('stock_alert')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- NOTES -->
                                        <div class="col-md-12">
                                            <label class="form-label">Notes:</label>
                                            <textarea class="form-control" name="note" rows="3">{{ old('note', $editData->note) }}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT SIDE -->
                            <div class="col-xl-4">
                                <div class="card">

                                    <label class="form-label">Multiple Image:</label>
                                    <div class="mb-3">
                                        <input name="image[]" multiple type="file"
                                            class="form-control">
                                    </div>

                                    @error('image.*')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="row" id="preview_img">
                                        @foreach ($editData->images as $img)
                                            <div class="col-md-3 mb-2">
                                                <img src="{{ asset($img->image) }}" class="img-thumbnail">

                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="remove_image[]" value="{{ $img->id }}">
                                                    <label class="form-check-label">Remove</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div>

                                    <div class="col-md-12 mb-3">
                                        <h4 class="text-center">Add Stock :</h4>
                                    </div>

                                    <!-- WAREHOUSE -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Warehouse :</label>
                                        <select name="warehouse_id" class="form-control form-select">
                                            <option value="">Select Warehouse</option>
                                            @foreach ($warehouses as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('warehouse_id', $editData->warehouse_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('warehouse_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- SUPPLIER -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Supplier :</label>
                                        <select name="supplier_id" class="form-control form-select">
                                            <option value="">Select Supplier</option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('supplier_id', $editData->supplier_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('supplier_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- QTY -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Product Quantity:</label>
                                        <input type="number" name="product_qty"
                                            class="form-control"
                                            value="{{ old('product_qty', $editData->product_qty) }}">

                                        @error('product_qty')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- STATUS (UNCHANGED UI) -->
                                    <div class="col-md-12">
                                        <label class="form-label">Status :</label>
                                        <select name="status" class="form-control form-select">
                                            <option selected="">Select Status</option>
                                            <option value="Received"
                                                {{ old('status', $editData->status) == 'Received' ? 'selected' : '' }}>
                                                Received</option>
                                            <option value="Pending"
                                                {{ old('status', $editData->status) == 'Pending' ? 'selected' : '' }}>
                                                Pending</option>
                                        </select>

                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <!-- BUTTON -->
                            <div class="col-xl-12">
                                <div class="d-flex mt-5 justify-content-start">
                                    <button class="btn btn-primary me-3" type="submit">Save</button>
                                    <a class="btn btn-secondary" href="{{ route('all.product') }}">Cancel</a>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection