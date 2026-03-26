@extends('admin.admin_master')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="content">
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Add Brand</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item active">Add Brand</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">Add Brand</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('store.brand') }}" method="post" class="row g-3" enctype="multipart/form-data">
                            @csrf

                            {{-- Brand Name --}}
                            <div class="col-md-12">
                                <label class="form-label">Brand Name</label>
                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror">

                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Brand Image --}}
                            <div class="col-md-6">
                                <label class="form-label">Brand Image</label>
                                <input type="file"
                                       name="image"
                                       id="image"
                                       class="form-control @error('image') is-invalid @enderror">

                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Preview --}}
                            <div class="col-md-6">
                                <label class="form-label"></label>
                                <img id="showImage"
                                     src="{{ url('upload/no_image.jpg') }}"
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