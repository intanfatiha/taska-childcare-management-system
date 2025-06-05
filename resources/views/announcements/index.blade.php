<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section with Gradient -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
                <div>
                    <h2 class="text-3xl font-bold text-indigo-800">
                        {{ __('Announcements') }}
                    </h2>
                    <p class="text-gray-600 mt-1">Stay updated with the latest information and events</p>
                </div>
                
                <!-- Action buttons for admins -->
                @if(auth()->user()->role === 'admin')
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('announcements.create') }}" class="btn bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Create New Announcement
                    </a>
                </div>
                @endif
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

            <!-- Event Type Filter -->
            <div class="mb-6">
                <form method="GET" action="{{ route('announcements.index') }}" class="flex items-center space-x-4">
                    <label for="event_type" class="text-sm font-medium text-gray-700">Filter by Event Type:</label>
                    <select name="event_type" id="event_type" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                        <option value="all" {{ $eventType === 'all' ? 'selected' : '' }}>All</option>
                        <option value="Event" {{ $eventType === 'Event' ? 'selected' : '' }}>Event</option>
                        <option value="Notice" {{ $eventType === 'Notice' ? 'selected' : '' }}>Notice</option>
                    </select>
                </form>
            </div>

            <!-- Announcements List -->
            <div class="space-y-6"> 
                @forelse($announcements as $announcement)
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition duration-200">
                        <div class="flex flex-col md:flex-row justify-between">
                            <div class="flex-1">
                                <!-- Title -->
                              <!-- Title -->
                                <div class="flex items-start justify-between">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $announcement->announcement_title }}</h3>
                                </div>
                                
                                <!-- Metadata Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <!-- Date -->
                                    <div class="flex items-center text-gray-600 font-bold ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($announcement->announcement_date)->format('d M Y') }}</span>
                                    </div>

                                    <!-- Time -->
                                    <div class="flex items-center text-gray-600 font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($announcement->announcement_time)->format('g:i a') }}</span>
                                    </div>

                                    <!-- Location -->
                                    @if($announcement->announcement_location)
                                    <div class="flex items-center text-gray-600 font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $announcement->announcement_location }}</span>
                                    </div>
                                    @endif
                                </div>

                                <!-- Description -->
                                <div class="mt-4 text-gray-700">
                                    <p class="leading-relaxed"><strong>Description:</strong> {{ $announcement->activity_description }}</p>
                                </div>
                            </div>
                            
                             <!-- Announcement Type Label for parents -->
                            @if(auth()->user()->role === 'parents')
                            <div class="relative">
                                <div class="absolute top-0 right-0 mt-4 md:mt-0 md:ml-6 flex md:flex-col justify-end gap-4">
                                    <span class="inline-flex items-center px-3 py-1 text-sm rounded-full 
                                        {{ $announcement->announcement_type === 'Event' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $announcement->announcement_type }}
                                    </span>
                                </div>
                            </div>
                            @endif

                            <!-- Announcement Type Label for admin/staff-->
                            @if(auth()->user()->role === 'admin')
                            <div class="mt-4 md:mt-0 md:ml-6 flex md:flex-col justify-end gap-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm rounded-full 
                                    {{ $announcement->announcement_type === 'Event' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $announcement->announcement_type }}
                                </span>

                                <!-- Action Buttons -->
                                
                               <div class="flex space-x-4">
    <!-- Edit Button -->
    <a href="{{ route('announcements.edit', $announcement->id) }}" class="flex items-center text-blue-600 hover:text-blue-800 transition">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
            <path d="M16 5l3 3" />
        </svg>
     
    </a>

    <!-- Delete Button -->
    <form method="POST" action="{{ route('announcements.destroy', $announcement->id) }}" onsubmit="return confirm('Are you sure you want to delete this announcement?');" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="flex items-center text-red-600 hover:text-red-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                <path d="M4 7h16" />
                <path d="M10 11v6" />
                <path d="M14 11v6" />
                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
            </svg>
         
        </button>
    </form>
</div>

                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="mt-4 text-xl text-gray-500">No announcements available</p>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('announcements.create') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                                Create your first announcement
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </div>

     <!-- Back to top button -->
     <button id="backToTop" class="fixed bottom-8 right-8 bg-indigo-600 text-white rounded-full p-3 shadow-lg opacity-0 transition-opacity duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7" />
        </svg>
    </button>

<script>
      // Show/hide back to top button
      window.onscroll = function() {
            const backToTopButton = document.getElementById('backToTop');
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                backToTopButton.classList.remove('opacity-0');
                backToTopButton.classList.add('opacity-100');
            } else {
                backToTopButton.classList.remove('opacity-100');
                backToTopButton.classList.add('opacity-0');
            }
        };

        // Scroll to top when button is clicked
        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
</script>

</x-app-layout>