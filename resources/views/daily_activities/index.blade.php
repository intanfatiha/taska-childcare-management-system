<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Children Daily Board') }}
            </h2>
            <a href="{{ route('daily_activities.create') }}" class="btn btn-primary btn-sm">
                Create Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-1 lg:px-10">
            <!-- Loop to display posts -->
            @forelse ($daily_activities as $activity)
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <div class="flex justify-between items-start">
                        <!-- Post creator -->
                        <div>
                            <p class="text-sm text-gray-600">Created by: Admin</p>
                        </div>
                        <!-- Post date and time -->
                        <div>
                            <!-- <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($activity->created_at)->format('d.m.Y g:i a') }}</p> -->
                            <p class="text-sm text-gray-600">
                                Posted on: {{ \Carbon\Carbon::parse($activity->post_date)->format('d.m.Y') }} 
                                at {{ \Carbon\Carbon::parse($activity->post_time)->format('g:i a') }}
                            </p>
                            <!-- <p class="text-xs text-gray-500">
                                Created: {{ \Carbon\Carbon::parse($activity->created_at)->format('d.m.Y g:i a') }}
                            </p> -->
                        </div>
                    </div>

                    <!-- Image section -->
                    <div class="max-w-2xl mx-auto">
                        <div class="w-[400px] h-[400px] mb-4 overflow-hidden rounded-lg mx-auto">
                            <img src="{{ asset('uploads/dailyActivityBoards/' . $activity->activity_photo) }}" 
                                 alt="Activity Photo" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-2">
                        <p class="text-gray-700">{{ $activity->post_desc }}</p>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex justify-between mt-4">
                        <!-- Edit button -->
                        <a href="{{ route('daily_activities.edit', $activity->id) }}" class="text-blue-500 hover:text-blue-700 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                        </a>
                      
                        <!-- Delete button -->
                        <form action="{{ route('daily_activities.destroy', $activity->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600">No activities available.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

