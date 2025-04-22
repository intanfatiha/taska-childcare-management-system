<x-app-layout>
   
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Announcement') }}
            </h2>
            <a href="{{ route('announcements.create') }}" class="btn btn-primary btn-sm">
                Create Announcement
            </a>
        </div>
  

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Display Success Message -->
            @if(session('message'))
                <div class="alert alert-success mb-4">
                    {{ session('message') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($announcements as $announcement)

                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold">{{ $announcement->title }}</h3>
                            <span class="badge {{ $announcement->announcement_type === 'Event' ? 'badge-accent' : 'badge-info' }}">
                                {{ $announcement->announcement_type }}
                            </span>
                        </div>

                        <div class="mt-4 space-y-2 text-gray-600">
                            <!-- Date -->
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($announcement->announcement_date)->format('d/m/Y') }}</span>
                            </div>

                            <!-- Time -->
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($announcement->announcement_time)->format('g:i a') }}</span>
                            </div>

                            <!-- Location -->
                            @if($announcement-> announcement_location)
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $announcement->announcement_location }}</span>
                            </div>
                            @endif

                            <!-- Description -->
                            <div class="mt-4">
                                <p>Description: {{ $announcement->activity_description }}</p>

                            </div>
                        </div>

                         <!-- Buttons -->
                         <div class="mt-4 flex justify-end gap-4">
                            <!-- Edit Button -->
                            <a href="{{ route('announcements.edit', $announcement->id) }}" class="text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                            </a>

                            <form method="POST" action="{{ route('announcements.destroy', $announcement->id) }}" onsubmit="return confirm('Are you sure you want to delete this?');">
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
                    <div class="text-center py-8 text-gray-500">
                        No announcements available.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
