@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="content">
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Brand</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Brand</h5>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('update.brand') }}" method="post" class="row g-3" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $brand->id }}">

                            <!-- Brand Name -->
                            <div class="col-md-12">
                                <label class="form-label">Brand Name</label>

                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name', $brand->name) }}"
                                       class="form-control @error('name') is-invalid @enderror">

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Image -->
                            <div class="col-md-6">
                                <label class="form-label">Brand Image</label>

                                <input type="file" 
                                       name="image" 
                                       id="image"
                                       class="form-control @error('image') is-invalid @enderror">

                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Preview -->
                            <div class="col-md-6">
                                <img id="showImage" 
                                     src="{{ asset($brand->image) }}"
                                     class="rounded-circle avatar-xl img-thumbnail float-start">
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Save Change</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Image Preview Script -->
<script>
$(document).ready(function() {
    $('#image').change(function(e) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    });
});
</script>

@endsection