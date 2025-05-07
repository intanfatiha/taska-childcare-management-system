

<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
                <h2 class="text-2xl font-bold text-indigo-800">
                    {{ __('Update Announcement') }}
                </h2>
                <p class="text-gray-600 mt-1">Update important information with your organization</p>
            </div>

            <!-- Success Message Alert -->
            @if(session('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p>{{ session('message') }}</p>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                <form action="{{ route('announcements.update', $announcements->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Title Field -->
                    <div class="mb-5">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Announcement Title</label>
                        <input type="text" name="announcement_title" id="announcement_title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                        placeholder="Enter announcement title" value="{{ old('announcement_title', $announcements->announcement_title) }}" required>
                        @error('announcement_title')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Announcement Type Field -->
                    <div class="mb-5">
                        <label for="announcement_type" class="block text-sm font-medium text-gray-700 mb-1">Announcement Type</label>
                        <select name="announcement_type" id="announcement_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select a type</option>
                            <option value="Event" {{ old('announcement_type', $announcements->announcement_type) == 'Event' ? 'selected' : '' }}>Event</option>
                            <option value="Notice" {{ old('announcement_type', $announcements->announcement_type) == 'Notice' ? 'selected' : '' }}>Notice</option>
                            <option value="Update" {{ old('announcement_type', $announcements->announcement_type) == 'Update' ? 'selected' : '' }}>Update</option>
                            <option value="Other" {{ old('announcement_type', $announcements->announcement_type) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('announcement_type')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date and Time Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label for="announcement_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" name="announcement_date" id="announcement_date" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                value="{{ old('announcement_date', $announcements->announcement_date) }}">
                            @error('announcement_date')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="announcement_time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                            <input type="time" name="announcement_time" id="announcement_time" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                value="{{ old('announcement_time', $announcements->announcement_time) }}">
                            @error('announcement_time')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Location Field -->
                    <div class="mb-5">
                        <label for="announcement_location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" name="announcement_location" id="announcement_location" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            placeholder="Enter location (optional)"value="{{ old('announcement_location', $announcements->announcement_location) }}">
                        @error('announcement_location')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="mb-5">
                        <label for="activity_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="activity_description" id="activity_description" rows="4" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            placeholder="Describe the announcement in detail">{{ old('activity_description', $announcements->activity_description) }}</textarea>
                        @error('activity_description')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Form Buttons -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <a href="{{ route('announcements.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                            Update Announcement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>