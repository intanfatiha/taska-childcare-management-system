<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Announcement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form action="{{ route('announcements.update', $announcements->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Announcement Location Field -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Announcement Location</span>
                        </label>
                        <input
                            type="text"
                            name="announcement_location"
                            class="input input-bordered w-full"
                            placeholder="Enter announcement location"
                            value="{{ old('announcement_location', $announcements->announcement_location) }}">
                    </div>
                    @error('announcement_location')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Announcement Date Field -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Announcement Date</span>
                        </label>
                        <input
                            type="date"
                            name="announcement_date"
                            class="input input-bordered w-full"
                            value="{{ old('announcement_date', $announcements->announcement_date) }}">
                    </div>
                    @error('announcement_date')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Announcement Time Field -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Announcement Time</span>
                        </label>
                        <input
                            type="time"
                            name="announcement_time"
                            class="input input-bordered w-full"
                            value="{{ old('announcement_time', $announcements->announcement_time) }}">
                    </div>
                    @error('announcement_time')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Activity Description Field -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Activity Description</span>
                        </label>
                        <textarea
                            name="activity_description"
                            class="textarea textarea-bordered w-full"
                            placeholder="Describe the activity"
                            rows="4">{{ old('activity_description', $announcements->activity_description) }}</textarea>
                    </div>
                    @error('activity_description')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Announcement Type Field -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Announcement Type</span>
                        </label>
                        <input
                            type="text"
                            name="announcement_type"
                            class="input input-bordered w-full"
                            placeholder="Enter announcement type"
                            value="{{ old('announcement_type', $announcements->announcement_type) }}">
                    </div>
                    @error('announcement_type')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Submit Button -->
                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary">Update Announcement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
