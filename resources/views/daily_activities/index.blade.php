

<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section with improved layout -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-blue-50 to-purple-50 p-6 rounded-lg shadow-sm">
            <div>
                <h2 class="text-3xl font-bold text-indigo-800">
                    {{ __('Children Daily Board') }}
                </h2>
                <p class="text-gray-600 mt-1">See what your children are doing today at our center</p>
            </div>
            
            <!-- Action buttons for admins -->
            @if(auth()->user()->role === 'admin')
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('daily_activities.create') }}" class="btn bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create New Post
                </a>
               
                <!-- <a href="" class="btn bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
                    </svg>
                    Manage Posts
                </a> -->
            </div>
            @endif
        </div>

        <form method="GET" action="{{ route('daily_activities.index') }}" id="filterForm">
    <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4">
        <!-- Filter Type Selection -->
        <div class="flex flex-col">
            <label for="filter_type" class="text-sm font-medium text-gray-700 mb-1">Filter By</label>
            <select name="filter_type" id="filter_type" class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="all" {{ request('filter_type') == 'all' ? 'selected' : '' }}>All</option>
                <option value="date" {{ request('filter_type') == 'date' ? 'selected' : '' }}>Date</option>
                <option value="month" {{ request('filter_type') == 'month' ? 'selected' : '' }}>Month</option>
                <option value="year" {{ request('filter_type') == 'year' ? 'selected' : '' }}>Year</option>
            </select>
        </div>

        <!-- Date Filter -->
        <div id="date_filter" class="flex flex-col {{ request('filter_type') == 'date' ? '' : 'hidden' }}">
            <label for="date" class="text-sm font-medium text-gray-700 mb-1">Select Date</label>
            <input type="date" name="date" id="date" 
                value="{{ request('date', now()->format('Y-m-d')) }}"
                class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <!-- Month Filter -->
        <div id="month_filter" class="flex flex-col {{ request('filter_type') == 'month' ? '' : 'hidden' }}">
            <label for="month" class="text-sm font-medium text-gray-700 mb-1">Select Month</label>
            <input type="month" name="month" id="month" 
                value="{{ request('month', now()->format('Y-m')) }}"
                class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <!-- Year Filter -->
        <div id="year_filter" class="flex flex-col {{ request('filter_type') == 'year' ? '' : 'hidden' }}">
            <label for="year" class="text-sm font-medium text-gray-700 mb-1">Select Year</label>
            <input type="number" name="year" id="year" min="2000" max="2050" step="1"
                value="{{ request('year', now()->format('Y')) }}"
                class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>
</form>



        <!-- Calendar View Toggle -->
        <div class="mb-6 flex justify-end">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <button type="button" id="gridViewButton" class="bg-white py-2 px-4 text-sm font-medium text-indigo-700 border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:bg-indigo-50">
                    Grid View
                </button>
                <button type="button" id="timelineViewButton" class="bg-white py-2 px-4 text-sm font-medium text-gray-700 border border-gray-200 rounded-r-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:bg-indigo-50">
                    Timeline View
                </button>
            </div>
        </div>

       

        <div id="timelineView" class="hidden">
        @forelse ($daily_activities as $activity)
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <div class="flex justify-between items-start">
                        <!-- Post creator -->
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Created by: Teacher {{ explode(' ', $activity->user->name ?? 'Unknown')[0] }}
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

                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
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
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-600">No activities available.</p>
            @endforelse
        </div>



        <div id="gridView"class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Activities Display Section with improved cards -->
       
            @forelse ($daily_activities as $activity)
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                   
                    <div class="relative">
                        <img src="{{ asset('uploads/dailyActivityBoards/' . $activity->activity_photo) }}" 
                             alt="Activity Photo" 
                             class="w-full h-56 object-cover">
                        
<!--                         
                        @if(isset($activity->class_group))
                        <div class="absolute top-3 left-3 bg-indigo-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $activity->class_group }}
                        </div>
                        @endif -->
                        
                        <!-- Activity type badge -->
                        @if(isset($activity->activity_type))
                        <div class="absolute top-3 right-3 bg-amber-400 text-gray-800 text-xs px-2 py-1 rounded-full">
                            {{ $activity->activity_type }}
                        </div>
                        @endif
                    </div>
                    
                    <div class="p-5">
                        <!-- Title (new field) -->
                        @if(isset($activity->title))
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $activity->title }}</h3>
                        @else
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Daily Activity</h3>
                        @endif
                        
                        <!-- Description with better formatting -->
                        <p class="text-gray-600 mb-4">{{ $activity->post_desc }}</p>
                        
                        <!-- Date and admin info with improved layout -->
                        <div class="flex justify-between items-center text-sm text-gray-500 border-t pt-3">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($activity->post_date)->format('d.m.Y') }}
                                <span class="mx-1">•</span>
                                {{ \Carbon\Carbon::parse($activity->post_time)->format('g:i a') }}
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Teacher {{ explode(' ', $activity->user->name ?? 'Unknown')[0] }}
                            </div>
                        </div>
                        
                        <!-- Interactive elements and actions -->
                        <div class="mt-4 flex justify-between items-center">
                            <!-- Like/reaction button for parents
                            <div class="flex space-x-2">
                                <button class="flex items-center text-gray-500 hover:text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                </button>
                                <button class="flex items-center text-gray-500 hover:text-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                            </div> -->
                            
                            <!-- Admin controls -->
                            @if(auth()->user()->role === 'admin')
                            <div class="flex space-x-2">
                                <a href="{{ route('daily_activities.edit', $activity->id) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('daily_activities.destroy', $activity->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this post?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-gray-50 rounded-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-gray-600 mt-4">No activities have been posted yet.</p>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('daily_activities.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700">
                        Create the first post
                    </a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination with better styling -->
        <div class="mt-8">
            {{ $daily_activities->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Back to top button -->
    <button id="backToTop" class="fixed bottom-8 right-8 bg-indigo-600 text-white rounded-full p-3 shadow-lg opacity-0 transition-opacity duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7" />
        </svg>
    </button>

    <script>
         document.addEventListener('DOMContentLoaded', function () {
        const gridViewButton = document.getElementById('gridViewButton');
        const timelineViewButton = document.getElementById('timelineViewButton');
        const gridView = document.getElementById('gridView');
        const timelineView = document.getElementById('timelineView');
        const filterType = document.getElementById('filter_type');
        const dateFilter = document.getElementById('date');
        const monthFilter = document.getElementById('month');
        const yearFilter = document.getElementById('year');
        const filterForm = document.getElementById('filterForm');

        gridViewButton.addEventListener('click', function () {
            gridView.classList.remove('hidden');
            timelineView.classList.add('hidden');
            gridViewButton.classList.add('text-indigo-700');
            timelineViewButton.classList.remove('text-indigo-700');
        });

        timelineViewButton.addEventListener('click', function () {
            timelineView.classList.remove('hidden');
            gridView.classList.add('hidden');
            timelineViewButton.classList.add('text-indigo-700');
            gridViewButton.classList.remove('text-indigo-700');
        });

           // Listen for changes in the filter type dropdown
           filterType.addEventListener('change', function () {
            toggleDateFilter();
            filterForm.submit(); // Automatically submit the form
        });

          // Listen for changes in the date, month, and year inputs
          [dateFilter, monthFilter, yearFilter].forEach(input => {
            if (input) {
                input.addEventListener('change', function () {
                    filterForm.submit(); // Automatically submit the form
                });
            }
        });


         // Show/hide filters based on the selected filter type
         function toggleDateFilter() {
            const filterTypeValue = filterType.value;

            // Hide all filters first
            document.getElementById('date_filter').classList.add('hidden');
            document.getElementById('month_filter').classList.add('hidden');
            document.getElementById('year_filter').classList.add('hidden');

            // Show the selected filter
            if (filterTypeValue === 'date') {
                document.getElementById('date_filter').classList.remove('hidden');
            } else if (filterTypeValue === 'month') {
                document.getElementById('month_filter').classList.remove('hidden');
            } else if (filterTypeValue === 'year') {
                document.getElementById('year_filter').classList.remove('hidden');
            }
        }
    
    });

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

        // Simple filter functionality
        document.getElementById('classFilter').addEventListener('change', function() {
            // Implement filtering logic here
            console.log('Filter by class:', this.value);
        });

        document.getElementById('dateFilter').addEventListener('change', function() {
            // Implement date filtering logic here
            console.log('Filter by date range:', this.value);
        });

      



      
        
    </script>
</x-app-layout>
