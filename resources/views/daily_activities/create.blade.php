<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Children Daily Board') }}
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
                <form action="{{ route('daily_activities.store') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                  
                      <!-- Photo Field -->
                      <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Photo</span>
                        </label>
                        <input type="file" name="activity_photo" class="file-input file-input-bordered w-full" value="{{ old('activity_photo') }}">
                    </div>
                    @error('activity_photo')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                       <!-- Activity Description Field -->
                       <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Activity Description</span>
                        </label>
                        <textarea name="post_desc" class="textarea textarea-bordered w-full" placeholder="Describe the activity" rows="4">{{ old('post_desc') }}</textarea>
                    </div>
                    @error('post_desc')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Date and Time Fields -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Date & Time</span>
                        </label>
                        <div class="flex gap-4">
                            <!-- Date Field -->
                            <input type="date" name="post_date" class="input input-bordered w-1/2" value="{{ old('post_date') }}">

                            <!-- Time Field -->
                            <input type="time" name="post_time" class="input input-bordered w-1/2" value="{{ old('post_time') }}">
                        </div>
                    </div>
                    @error('post_date')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror
                    @error('post_time')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror
                 

                    <!-- Submit Button -->
                    <div class="form-control mt-6">
                        <div class="flex gap-4">
                        <button type="submit" class="btn btn-primary">Create Post</button>
                        <a href="{{ route('daily_activities.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</x-app-layout>
