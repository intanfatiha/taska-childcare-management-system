<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page header -->
        <div class="mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
            <h2 class="text-2xl font-bold text-indigo-800">
                {{ __('Create New Activity Post') }}
            </h2>
            <p class="text-gray-600 mt-1">Share activities, events, and important moments with parents</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
            <form action="{{ route('daily_activities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Form errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Title Field -->
                <div class="mb-5">
                    <label for="post_title" class="block text-sm font-medium text-gray-700 mb-1">Activity Title</label>
                    <input type="text" name="post_title" id="post_title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                    placeholder="Enter post title" value="{{ old('post_title') }}" required>
                    @error('post_title')
                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date and Time Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="post_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" name="post_date" id="post_date" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            value="{{ old('post_date') }}">
                        @error('post_date')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="post_time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                        <input type="time" name="post_time" id="post_time" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            value="{{ old('post_time') }}">
                        @error('post_time')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description Field -->
                <div class="mb-5">
                    <label for="post_desc" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="post_desc" id="post_desc" rows="4" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                        placeholder="Write a detailed description of the activity. This will be visible to parents.">{{ old('post_desc') }}</textarea>
                    @error('post_desc')
                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Upload with preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Activity Photo</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <div id="preview" class="hidden mb-3">
                                <img id="image-preview" class="mx-auto h-48 object-cover rounded" alt="Image preview">
                            </div>

                            <div class="flex text-sm text-gray-600">
                                <label for="activity_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a photo</span>
                                    <input id="activity_photo" name="activity_photo" type="file" class="sr-only" accept="image/*" onchange="previewImage()">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF up to 10MB
                            </p>
                            @error('activity_photo')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('daily_activities.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                        Create Post
                    </button>
                </div>
            </form>
        </div>

        <script>
            // Image preview functionality
            function previewImage() {
                const preview = document.getElementById('preview');
                const imagePreview = document.getElementById('image-preview');
                const fileInput = document.getElementById('activity_photo');
                const file = fileInput.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }

                    reader.readAsDataURL(file);
                }
            }

            // Drag and drop functionality
            const dropArea = document.querySelector('.border-dashed');
            const fileInput = document.getElementById('activity_photo');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.classList.add('border-indigo-300', 'bg-indigo-50');
            }

            function unhighlight() {
                dropArea.classList.remove('border-indigo-300', 'bg-indigo-50');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length) {
                    fileInput.files = files;
                    previewImage();
                }
            }
        </script>
    </div>
</x-app-layout>
