@extends('admin.admin_master')

@section('admin')
    <style>
        /* 🌈 Background */
        body {
            background: #f4f6fb;
        }

        /* 💎 Card */
        .card-ui {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        /* Header */
        .page-header {
            font-size: 22px;
            font-weight: 600;
        }

        /* Input */
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        /* Upload Box */
        .drop-zone {
            border: 2px dashed #4f46e5;
            border-radius: 14px;
            padding: 35px;
            text-align: center;
            background: #fafbff;
            cursor: pointer;
            transition: 0.3s;
        }

        .drop-zone:hover {
            background: #eef2ff;
        }

        /* Preview wrapper */
        .preview-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        /* 🔥 Image container (IMPORTANT FIX) */
        .img-box {
            position: relative;
            display: inline-block;
        }

        /* Image */
        .preview-img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #eee;
        }

        /* ❌ Remove button (PERFECT POSITION) */
        .remove-btn {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ef4444;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 26px;
            height: 26px;
            cursor: pointer;
            font-size: 14px;
            line-height: 26px;
        }

        /* Button */
        .btn-primary {
            border-radius: 10px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            border: none;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .card-ui {
                padding: 18px;
            }
        }
    </style>

    <div class="content mt-4">
        <div class="container-fluid">

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
                    <div class="mb-4">
                        <label class="mb-2">Brand Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter brand name">
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label class="mb-2">Brand Image</label>

                        <div class="drop-zone" id="dropArea">

                            <input type="file" name="image" id="image" hidden>

                            <!-- Upload Text -->
                            <div id="dropText">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                <p class="mb-0 fw-semibold">Upload Brand Image</p>
                                <small class="text-muted">Click or drag & drop</small>
                            </div>

                            <!-- Preview -->
                            <div class="preview-wrapper d-none" id="previewWrapper">

                                <div class="img-box">
                                    <img id="preview" class="preview-img">
                                    <button type="button" id="removeImage" class="remove-btn">×</button>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="text-end">
                        <button class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save me-1"></i> Save Brand
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const dropArea = document.getElementById('dropArea');
            const fileInput = document.getElementById('image');
            const preview = document.getElementById('preview');
            const dropText = document.getElementById('dropText');
            const removeBtn = document.getElementById('removeImage');
            const previewWrapper = document.getElementById('previewWrapper');

            // Click upload
            dropArea.addEventListener('click', function(e) {
                if (e.target !== removeBtn) {
                    fileInput.click();
                }
            });

            // File select
            fileInput.addEventListener('change', function(e) {
                showPreview(e.target.files[0]);
            });

            // Drag
            dropArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropArea.style.background = "#eef2ff";
            });

            dropArea.addEventListener('dragleave', function() {
                dropArea.style.background = "#fafbff";
            });

            dropArea.addEventListener('drop', function(e) {
                e.preventDefault();
                dropArea.style.background = "#fafbff";

                let file = e.dataTransfer.files[0];
                if (file) {
                    fileInput.files = e.dataTransfer.files;
                    showPreview(file);
                }
            });

            // Preview
            function showPreview(file) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;

                    previewWrapper.classList.remove('d-none');
                    dropText.style.display = "none";
                };

                reader.readAsDataURL(file);
            }

            // Remove image
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();

                fileInput.value = "";
                preview.src = "";

                previewWrapper.classList.add('d-none');
                dropText.style.display = "block";
            });

        });
    </script>
@endsection
