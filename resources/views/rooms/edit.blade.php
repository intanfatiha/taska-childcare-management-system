<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Room') }}
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
                <form action="{{route('rooms.update', $room->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Room Name</span>
                        </label>
                        <input type="text" name="name" class="input input-bordered w-full" placeholder="Enter room name" value="{{ old('name'), $room->name  }}">
                    </div>
                    @error('name')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Photo Field -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Photo</span>
                        </label>
                        <img src="{{ asset('uploads/rooms/'.$room->photo) }}" style="width:200px;">
                        <input type="file" name="photo" class="file-input file-input-bordered w-full" value="{{ old('photo'), $room->photo }}">
                    </div>
                    @error('photo')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Capacity Field -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Capacity</span>
                        </label>
                        <input type="number" name="capacity" class="input input-bordered w-full" placeholder="Enter capacity" value="{{ old('capacity', $room->capacity) }}">
                    </div>
                    @error('capacity')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Submit Button -->
                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary">Update Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>