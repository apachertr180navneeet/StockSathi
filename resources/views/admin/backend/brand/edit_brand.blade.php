@extends('admin.admin_master')

@section('admin')

<style>

/* 🌈 Background */
body {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
}

/* 💎 Card */
.card {
    border-radius: 16px;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* Input */
.form-control {
    border-radius: 10px;
    padding: 10px 14px;
}

/* 🔥 Drop Zone */
.drop-zone {
    border: 2px dashed #6366f1;
    border-radius: 14px;
    padding: 40px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
    position: relative;
}

.drop-zone:hover {
    background: rgba(99,102,241,0.05);
}

.drop-zone.dragover {
    background: rgba(99,102,241,0.1);
}

/* Upload text */
.drop-content {
    transition: 0.3s;
}

/* Preview wrapper */
.preview-wrapper {
    display: flex;
    justify-content: center;
    position: relative;
}

/* Image */
.preview-img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e5e7eb;
}

/* Remove button */
.remove-btn {
    position: absolute;
    top: -5px;
    right: calc(50% - 65px);
    background: #ef4444;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    cursor: pointer;
}

/* Button */
.btn-primary {
    border-radius: 10px;
    background: linear-gradient(135deg,#4f46e5,#6366f1);
}

/* Animation */
.fade-in {
    animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
    from {opacity:0; transform:translateY(8px);}
    to {opacity:1; transform:translateY(0);}
}

</style>

<div class="content">
    <div class="container-xxl">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3 fade-in">
            <div>
                <h4 class="mb-0 fw-semibold">Edit Brand</h4>
                <small class="text-muted">Update brand</small>
            </div>

            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('all.brand') }}">
                        <i class="fas fa-list me-1"></i> Brand
                    </a>
                </li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">

                <div class="card p-4 fade-in">

                    <h5 class="mb-4">Edit Brand Details</h5>

                    <form action="{{ route('update.brand') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{ $brand->id }}">

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label">Brand Name</label>
                            <input type="text" name="name"
                                   value="{{ old('name', $brand->name) }}"
                                   class="form-control">
                        </div>

                        <!-- 🔥 Drag Drop -->
                        <div class="mb-4">
                            <label class="form-label">Brand Image</label>

                            <div id="dropArea" class="drop-zone">

                                <input type="file" name="image" id="image" hidden>

                                <!-- Upload text -->
                                <div id="dropContent" class="drop-content" style="display:none;">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                    <p>Drag & Drop Image</p>
                                    <small>or click to upload</small>
                                </div>

                                <!-- Preview -->
                                <div id="previewWrapper" class="preview-wrapper">
                                    <img id="showImage"
                                         src="{{ $brand->image ? asset($brand->image) : url('upload/no_image.jpg') }}"
                                         class="preview-img">

                                    <button type="button" id="removeImage" class="remove-btn">×</button>
                                </div>

                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('all.brand') }}" class="btn btn-light">← Back</a>

                            <button class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Update
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
</div>

@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('image');
    const preview = document.getElementById('showImage');
    const previewWrapper = document.getElementById('previewWrapper');
    const dropContent = document.getElementById('dropContent');
    const removeBtn = document.getElementById('removeImage');

    // Click upload
    dropArea.addEventListener('click', function(e) {
        if (e.target !== removeBtn) {
            fileInput.click();
        }
    });

    // Change
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            previewImage(e.target.files[0]);
        }
    });

    // Drag
    dropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropArea.classList.add('dragover');
    });

    dropArea.addEventListener('dragleave', function() {
        dropArea.classList.remove('dragover');
    });

    dropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        dropArea.classList.remove('dragover');

        let file = e.dataTransfer.files[0];
        if (file) {
            fileInput.files = e.dataTransfer.files;
            previewImage(file);
        }
    });

    function previewImage(file) {
        let reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            previewWrapper.style.display = "flex";
            dropContent.style.display = "none";
        };

        reader.readAsDataURL(file);
    }

    // Remove
    removeBtn.addEventListener('click', function(e) {
        e.stopPropagation();

        fileInput.value = "";
        preview.src = "{{ url('upload/no_image.jpg') }}";

        previewWrapper.style.display = "none";
        dropContent.style.display = "block";
    });

});
</script>
@endsection