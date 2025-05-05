<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb navigation -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                
                <li>
                    <div class="flex items-center">
                       
                        <a href="{{ route('daily_activities.index') }}" class="text-gray-700 hover:text-indigo-600 text-sm font-medium">
                            Children Daily Board
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="text-gray-500 text-sm font-medium">Create Post</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <!-- Page header -->
        <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
            <h2 class="text-2xl font-bold text-gray-800">Create New Activity Post</h2>
            <p class="text-gray-600 mt-1">Share activities, events, and important moments with parents</p>
        </div>
        
        <!-- Form card -->
        <div class="bg-white rounded-lg shadow-sm">
            <form action="{{ route('daily_activities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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

                <!-- Activity Type & Class Group -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Activity Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Activity Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="e.g. Art Project: Autumn Leaves">
                    </div>
                
                
                <!-- Activity Type & Date/Time -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Activity Type -->
                    
                    
                    <!-- Date -->
                    <div>
                        <label for="post_date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="post_date" id="post_date" value="{{ old('post_date', date('Y-m-d')) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    
                    <!-- Time -->
                    <div>
                        <label for="post_time" class="block text-sm font-medium text-gray-700">Time</label>
                        <input type="time" name="post_time" id="post_time" value="{{ old('post_time', date('H:i')) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
                
                <!-- Description -->
                <div>
                    <label for="post_desc" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                        <textarea id="post_desc" name="post_desc" rows="5" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Describe the activity, what children learned, and any other important details...">{{ old('post_desc') }}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Write a detailed description of the activity. This will be visible to parents.
                    </p>
                </div>
                
                <!-- Image Upload with preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Activity Photo</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <div id="preview" class="hidden mb-3">
                                <img id="image-preview" class="mx-auto h-48 object-cover rounded" alt="Image preview">
                            </div>
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
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
                        </div>
                    </div>
                </div>
                
                <!-- Optional: Tags
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700">Tags (Optional)</label>
                    <div class="mt-1">
                        <input type="text" name="tags" id="tags" value="{{ old('tags') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="art, outdoor, learning, music (separate with commas)">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Add relevant tags to help with filtering and searching.
                    </p>
                </div> -->
                
                <!-- Action Buttons -->
              
                </div>
                <div class="flex justify-center space-x-3 pt-5">
                    <a href="{{ route('daily_activities.index') }}" class="py-2 px-6 w-32 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-center">
                        Go Back
                    </a>
                    <button type="submit" class="py-2 px-6 w-32 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-center">
                        Create Post
                    </button>
            </form>
        </div>
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
</x-app-layout>