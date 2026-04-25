@extends('admin.admin_master')
@section('admin')

<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Add Product</h4>
            <a href="{{ route('all.product') }}" class="btn btn-dark btn-sm">Back</a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                    <form action="{{ route('store.product') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <!-- LEFT -->
                            <div class="col-xl-8">
                                <div class="row">

                                    <!-- Name -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Product Name: *</label>
                                        <input type="text" name="name"
                                            value="{{ old('name') }}"
                                            class="form-control" placeholder="Enter Name">

                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Code -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Code: *</label>
                                        <input type="text" name="code"
                                            value="{{ old('code') }}"
                                            class="form-control" placeholder="Enter Code">

                                        @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Barcode Symbology -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Barcode Symbology:</label>
                                        <select name="barcode_symbology" class="form-control form-select">
                                            <option value="C128" {{ old('barcode_symbology') == 'C128' ? 'selected' : '' }}>Code 128</option>
                                            <option value="C39" {{ old('barcode_symbology') == 'C39' ? 'selected' : '' }}>Code 39</option>
                                            <option value="EAN13" {{ old('barcode_symbology') == 'EAN13' ? 'selected' : '' }}>EAN-13</option>
                                            <option value="UPCA" {{ old('barcode_symbology') == 'UPCA' ? 'selected' : '' }}>UPC-A</option>
                                        </select>
                                    </div>

                                    <!-- Batch No -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Batch No:</label>
                                        <input type="text" name="batch_no"
                                            value="{{ old('batch_no') }}"
                                            class="form-control" placeholder="Enter Batch/Lot Number">
                                    </div>

                                    <!-- Expiry Date -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Expiry Date:</label>
                                        <input type="date" name="expiry_date"
                                            value="{{ old('expiry_date') }}"
                                            class="form-control">
                                    </div>

                                    <!-- Category -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Product Category : *</label>
                                        <select name="category_id" class="form-control form-select">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->category_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Brand -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Brand :</label>
                                        <select name="brand_id" class="form-control form-select">
                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('brand_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('brand_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Product Price:</label>
                                        <input type="text" name="price"
                                            value="{{ old('price') }}"
                                            class="form-control" placeholder="Enter product price">

                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Stock Alert -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Stock Alert:</label>
                                        <input type="number" name="stock_alert"
                                            value="{{ old('stock_alert') }}"
                                            class="form-control" placeholder="Enter Stock Alert">

                                        @error('stock_alert')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Notes -->
                                    <div class="col-md-12">
                                        <label class="form-label">Notes:</label>
                                        <textarea class="form-control" name="note" rows="3">{{ old('note') }}</textarea>
                                    </div>

                                </div>
                            </div>

                            <!-- RIGHT -->
                            <div class="col-xl-4">

                                <!-- Images -->
                                <div class="mb-3">
                                    <label class="form-label">Multiple Image:</label>
                                    <input name="image[]" multiple type="file" class="form-control">

                                    @error('image.*')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <h4 class="text-center">Add Stock :</h4>

                                <!-- Warehouse -->
                                <div class="mb-3">
                                    <label class="form-label">Warehouse :</label>
                                    <select name="warehouse_id" class="form-control form-select">
                                        <option value="">Select Warehouse</option>
                                        @foreach ($warehouses as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('warehouse_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('warehouse_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Supplier -->
                                <div class="mb-3">
                                    <label class="form-label">Supplier :</label>
                                    <select name="supplier_id" class="form-control form-select">
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('supplier_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('supplier_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Quantity -->
                                <div class="mb-3">
                                    <label class="form-label">Product Quantity:</label>
                                    <input type="number" name="product_qty"
                                        value="{{ old('product_qty') }}"
                                        class="form-control" placeholder="Enter Product Quantity">

                                    @error('product_qty')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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

@endsection
