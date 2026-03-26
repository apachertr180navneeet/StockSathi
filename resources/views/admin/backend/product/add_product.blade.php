@extends('admin.admin_master')
@section('admin')

<div class="content d-flex flex-column flex-column-fluid">
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid my-0">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h2 class="fs-22 fw-semibold m-0">Add Product</h2>
                </div>

                <div class="text-end">
                    <a href="{{ route('all.product') }}" class="btn btn-dark">Back</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

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

                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label">Status :</label>
                                    <select name="status" class="form-control form-select">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>

                                    @error('status')
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
</div>

@endsection