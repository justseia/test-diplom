@extends('backend.layouts.default')

@section('page_title', 'Education diseases')

@section('style')
    <style>
        #uploadTrigger:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }
        .image-preview {
            max-width: 100px;
            max-height: 100px;
            margin-right: 10px;
        }
    </style>
@stop

@section('content')
    <div class="card">
        <div class="d-flex justify-content-start align-items-center m-3">
            <a href="{{ route('education.index') }}" class="text-secondary mr-2">
                <i class="fa fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="h4"> {{ $diseases->title }}: diseases and images</h2>
        </div>
        <h6 class="ml-3">Diseases information:</h6>
        <form method="POST" action="{{ route('education.store') }}" enctype="multipart/form-data" id="educationForm">
            @csrf
            <input type="hidden" name="id" value="{{ $diseases->id }}">
            <textarea name="diseases" cols="30" rows="10" style="width: 100%; margin: 15px">{{ $diseases->diseases }}</textarea>
            <div class="ml-3 mb-3">
                <h6>Images:</h6>
                <div class="d-flex flex-wrap" id="imagePreviewContainer">
                    @foreach ($diseases_images as $image)
                        <div class="p-2">
                            <img src="{{ asset('storage/' . $image->url) }}" alt="Image" class="image-preview">
                        </div>
                    @endforeach
                </div>
                <div class="p-2">
                    <div class="border bg-light d-flex justify-content-center align-items-center"
                         style="width: 100px; height: 100px; cursor: pointer;" id="uploadTrigger">
                        <span>+</span>
                        <input type="file" name="images[]" id="fileInput" style="display: none;" multiple/>
                    </div>
                </div>
            </div>
            <div class="d-grid">
                <button class="btn btn-success bradius float-right" type="button" id="saveButton">Save</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Trigger file input when "+" icon is clicked
            document.getElementById('uploadTrigger').addEventListener('click', function () {
                document.getElementById('fileInput').click();
            });

            // Submit form when save button is clicked
            document.getElementById('saveButton').addEventListener('click', function () {
                document.getElementById('educationForm').submit();
            });

            let uploadedFiles = []; // Array to store uploaded files

            // Function to display uploaded images as thumbnails
            function displayImagePreview(file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                    const imgElement = document.createElement('img');
                    imgElement.classList.add('image-preview');
                    imgElement.src = e.target.result;
                    imagePreviewContainer.appendChild(imgElement);
                };
                reader.readAsDataURL(file);
            }

            // Handle file input change event
            document.getElementById('fileInput').addEventListener('change', function (event) {
                const files = event.target.files;
                for (let i = 0; i < files.length; i++) {
                    uploadedFiles.push(files[i]); // Add file to the array
                    displayImagePreview(files[i]);
                }
            });
        });
    </script>
@stop
