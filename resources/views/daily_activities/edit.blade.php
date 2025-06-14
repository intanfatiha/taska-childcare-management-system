<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Page header -->
        <div class="mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
            <h2 class="text-2xl font-bold text-indigo-800">
                {{ __('Update Activity Post') }}
            </h2>
            <p class="text-gray-600 mt-1">Update the activity details to keep parents informed.</p>
        </div>

        <!-- Form card -->
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
            <form action="{{ route('daily_activities.update', $daily_activity->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

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

                <!-- Activity Title -->
                <div>
                    <label for="post_title" class="block text-sm font-medium text-gray-700">Activity Title</label>
                    <input type="text" name="post_title" id="post_title" value="{{ old('post_title', $daily_activity->post_title) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="e.g. Art Project: Autumn Leaves">
                </div>

                <!-- Date and Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="post_date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="post_date" id="post_date" value="{{ old('post_date', \Carbon\Carbon::parse($daily_activity->post_date)->format('Y-m-d')) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="post_time" class="block text-sm font-medium text-gray-700">Time</label>
                        <input type="time" name="post_time" id="post_time" value="{{ old('post_time', \Carbon\Carbon::parse($daily_activity->post_time)->format('H:i')) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="post_desc" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="post_desc" name="post_desc" rows="5" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Describe the activity, what children learned, and any other important details...">{{ old('post_desc', $daily_activity->post_desc) }}</textarea>
                </div>

                <!-- Image Upload with Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Activity Photo</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            @if ($daily_activity->activity_photo)
                                <img src="{{ asset('uploads/dailyActivityBoards/' . $daily_activity->activity_photo) }}" class="mx-auto h-48 object-cover rounded mb-3" alt="Current Activity Photo">
                            @endif
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="activity_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a new photo</span>
                                    <input id="activity_photo" name="activity_photo" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF up to 10MB
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{route('daily_activities.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                        Update Post
                    </button>
                </div>

               
            </form>
        </div>
    </div>
</x-app-layout>
