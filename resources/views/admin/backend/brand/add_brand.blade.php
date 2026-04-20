@extends('admin.admin_master')

@section('admin')
<link href="{{ asset('backend/assets/css/brand.css') }}" rel="stylesheet" type="text/css" id="app-style" />

<div class="content mt-3 px-2 px-md-3 px-lg-4">
    <div class="container-fluid">

        <div class="page-container">

            <div class="card-ui">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="page-header">Add Brand</div>

                    <a href="{{ route('all.brand') }}" class="btn btn-light btn-sm">
                        ← Back
                    </a>
                </div>

                <form action="{{ route('store.brand') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Brand Name -->
                    <div class="mb-3">
                        <label class="mb-1">Brand Name</label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Enter brand name">

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label class="mb-1">Brand Image</label>

                        <input type="file"
                               name="image"
                               id="image"
                               class="form-control @error('image') is-invalid @enderror">

                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <!-- Preview -->
                        <div class="preview-box">
                            <img id="showImage"
                                 src="{{ url('upload/no_image.jpg') }}"
                                 class="preview-img">

                            <small class="text-muted">Image preview</small>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('all.brand') }}" class="btn btn-light">
                            Cancel
                        </a>

                        <button class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Brand
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$(document).ready(function () {
    $('#image').change(function (e) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    });
});
</script>

@endsection