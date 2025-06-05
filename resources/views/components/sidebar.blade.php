<!-- resources/views/components/sidebar.blade.php -->
<div class="absolute left-4 top-0 h-[86vh] w-70 bg-gradient-to-br from-purple-50 to-white shadow-2xl relative overflow-hidden text-black-800 m-3 rounded-3xl">
    <!-- Logo Section -->
    <div class="p-4 bg-gradient-to-r from-gray-100 to-blue-50 mx-3 mt-3 rounded-2xl">
        <div class="flex items-center space-x-3">
            <!-- <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center shadow-lg transform transition-transform duration-200 hover:scale-105"> -->
                <!-- <span class="text-xl">👶</span> -->
                            <img src="{{ asset('assets/ppuk_logo.png') }}" alt="Logo" class="h-8 w-8">

            <!-- </div> -->
            <div>
                <h1 class="text-gray-800 font-bold text-base">TASKA HIKMAH</h1>
                <p class="text-gray-500 text-xs font-medium"></p>
            </div>
        </div> 
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-2 overflow-y-auto h-full pb-28">
        @if(auth()->user()->role === 'admin')
            <!-- Dashboard -->
            <a href="{{ route('adminHomepage') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('adminHomepage') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('adminHomepage') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('adminHomepage') ? 'text-white' : 'text-purple-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                </div>
                <span class="font-semibold text-base {{ request()->routeIs('adminHomepage') ? 'text-white' : 'text-gray-700' }}">Dashboard</span>
            </a>

            <!-- Attendance -->
            <a href="{{ route('attendances.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('attendances.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('attendances.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">

                     <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5  {{ request()->routeIs('attendances.*') ? 'text-white' : 'text-purple-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" />
                        <path d="M16 3v4" />
                        <path d="M8 3v4" />
                        <path d="M4 11h16" />
                        <path d="M15 19l2 2l4 -4" />
                    </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('attendances.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Attendance</span>
            </a>

            <!-- Children Daily Board -->
            <a href="{{ route('daily_activities.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('daily_activities.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('daily_activities.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <span class="text-xl"></span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 {{ request()->routeIs('daily_activities.*') ? 'text-white' : 'text-purple-600 group-hover:text-purple-700' }}"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                        <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                        <path d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                        <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                    </svg>

                </div>
                <span class="font-medium {{ request()->routeIs('daily_activities.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Children Daily Board</span>
            </a>

            <!-- Live Camera -->
            <a href="{{ route('camera-footages.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('camera-footages.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('camera-footages.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('camera-footages.*') ? 'text-white' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg> -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('camera-footages.*') ? 'text-white' : 'text-purple-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                        <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('camera-footages.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Live Camera</span>
            </a>

            <!-- Announcements -->
            <a href="{{ route('announcements.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('announcements.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('announcements.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg> -->

                     <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-purple-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8a3 3 0 0 1 0 6" />
                        <path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5" />
                        <path d="M12 8h0l4.524 -3.77a.9 .9 0 0 1 1.476 .692v12.156a.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8" />
                    </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Announcement</span>
            </a>

            <!-- Payment -->
            <a href="{{ route('payments.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('payments.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('payments.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('payments.*') ? 'text-white' : 'text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg> -->

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('payments.*') ? 'text-white' : 'text-purple-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 20h-8a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v4.5" />
                            <path d="M9 17h4" />
                            <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                            <path d="M19 21v1m0 -8v1" />
                        </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('payments.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Payment</span>
            </a>
       
 

            <!-- Reports Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" 
                        class="group w-full flex items-center justify-between p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] hover:bg-white hover:shadow-md"
                        :class="{ 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg': open }">
                    <div class="flex items-center space-x-3">
                        <div class="p-1.5 rounded-lg transition-colors duration-200"
                             :class="open ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100'">
                            <svg class="w-5 h-5 text-purple-500" :class="open ? 'text-white' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-600 group-hover:text-gray-800" :class="open ? 'text-white' : ''">Reports</span>
                    </div>
                    <svg class="w-4 h-4 transform transition-transform duration-300 text-gray-400" 
                         :class="{ 'rotate-180': open, 'text-white': open }" 
                         fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
                
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="mt-2 ml-6 space-y-1 bg-white rounded-xl p-2 shadow-lg border border-gray-100">
                    <a href="{{ route('generateReports.index') }}" 
                       class="group flex items-center space-x-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-purple-50 transform hover:scale-[1.02] {{ request()->routeIs('generateReports.index') ? 'bg-purple-100 text-purple-700 shadow-sm' : '' }}">
                        <div class="w-1.5 h-1.5 bg-purple-400 rounded-full group-hover:bg-purple-600 transition-colors duration-200"></div>
                        <span class="text-xs font-medium text-gray-600 group-hover:text-purple-700">Attendance Report</span>
                    </a>
                    <a href="{{ route('generateReports.payment') }}" 
                       class="group flex items-center space-x-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-purple-50 transform hover:scale-[1.02] {{ request()->routeIs('generateReports.payment') ? 'bg-purple-100 text-purple-700 shadow-sm' : '' }}">
                        <div class="w-1.5 h-1.5 bg-purple-400 rounded-full group-hover:bg-purple-600 transition-colors duration-200"></div>
                        <span class="text-xs font-medium text-gray-600 group-hover:text-purple-700">Payment Report</span>
                    </a>
                </div>
            </div>
             @endif

              @if(auth()->user()->role === 'staff')
            <!-- Dashboard -->
            <a href="{{ route('adminHomepage') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('adminHomepage') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('adminHomepage') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('adminHomepage') ? 'text-white' : 'text-purple-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"/>
                    </svg> -->

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('adminHomepage') ? 'text-white' : 'text-purple-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                </div>
                <span class="font-semibold text-base {{ request()->routeIs('adminHomepage') ? 'text-white' : 'text-gray-700' }}">Dashboard</span>
            </a>

            <!-- Attendance -->
            <a href="{{ route('attendances.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('attendances.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('attendances.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('attendances.*') ? 'text-white' : 'text-purple-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg> -->

                     <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5  {{ request()->routeIs('attendances.*') ? 'text-white' : 'text-purple-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" />
                        <path d="M16 3v4" />
                        <path d="M8 3v4" />
                        <path d="M4 11h16" />
                        <path d="M15 19l2 2l4 -4" />
                    </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('attendances.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Attendance</span>
            </a>

            <!-- Children Daily Board -->
            <a href="{{ route('daily_activities.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('daily_activities.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('daily_activities.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-yellow-100' }} transition-colors duration-200">
                    <span class="text-xl"></span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 {{ request()->routeIs('daily_activities.*') ? 'text-white' : 'text-purple-600 group-hover:text-purple-700' }}"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                        <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                        <path d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                        <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                    </svg>

                </div>
                <span class="font-medium {{ request()->routeIs('daily_activities.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Children Daily Board</span>
            </a>

            <!-- Live Camera -->
            <a href="{{ route('camera-footages.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('camera-footages.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('camera-footages.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('camera-footages.*') ? 'text-white' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg> -->

                    <svg class="w-5 h-5 {{ request()->routeIs('camera-footages.*') ? 'text-white' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>


                </div>
                <span class="font-medium {{ request()->routeIs('camera-footages.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Live Camera</span>
            </a>

            <!-- Announcements -->
            <a href="{{ route('announcements.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('announcements.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('announcements.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg> -->

                     <svg class="w-5 h-5 {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Announcement</span>
            </a>

            <!-- Payment -->
            <a href="{{ route('payments.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('payments.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('payments.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('payments.*') ? 'text-white' : 'text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg> -->

                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('payments.*') ? 'text-white' : 'text-purple-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 20h-8a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v4.5" />
                            <path d="M9 17h4" />
                            <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                            <path d="M19 21v1m0 -8v1" />
                        </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('payments.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Payment</span>
            </a>
            <!-- </div> -->
             @endif

               @if(auth()->user()->role === 'parents')
            <!-- Dashboard -->
            <a href="{{ route('adminHomepage') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('adminHomepage') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('adminHomepage') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('adminHomepage') ? 'text-white' : 'text-purple-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"/>
                    </svg> -->

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('adminHomepage') ? 'text-white' : 'text-purple-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                </div>
                <span class="font-semibold text-base {{ request()->routeIs('adminHomepage') ? 'text-white' : 'text-gray-700' }}">Dashboard</span>
            </a>

            <!-- Attendance -->
            <a href="{{ route('attendances.parentsIndex') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('attendances.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('attendances.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('attendances.*') ? 'text-white' : 'text-purple-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg> -->

                     <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('attendances.*') ? 'text-white' : 'text-purple-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" />
                        <path d="M16 3v4" />
                        <path d="M8 3v4" />
                        <path d="M4 11h16" />
                        <path d="M15 19l2 2l4 -4" />
                    </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('attendances.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Attendance</span>
            </a>

            <!-- Children Daily Board -->
            <a href="{{ route('daily_activities.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('daily_activities.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('daily_activities.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <span class="text-xl"></span>
                    
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 {{ request()->routeIs('daily_activities.*') ? 'text-white' : 'text-purple-600 group-hover:text-purple-700' }}"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                        <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                        <path d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                        <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                    </svg>

                </div>
                <span class="font-medium {{ request()->routeIs('daily_activities.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Children Daily Board</span>
            </a>

            <!-- Live Camera -->
            <a href="{{ route('camera-footages.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('camera-footages.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('camera-footages.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('camera-footages.*') ? 'text-white' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg> -->

                     <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('camera-footages.*') ? 'text-white' : 'text-purple-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                        <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('camera-footages.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Live Camera</span>
            </a>

            <!-- Announcements -->
            <a href="{{ route('announcements.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('announcements.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('announcements.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg> -->

                     <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-purple-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8a3 3 0 0 1 0 6" />
                        <path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5" />
                        <path d="M12 8h0l4.524 -3.77a.9 .9 0 0 1 1.476 .692v12.156a.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8" />
                    </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Announcement</span>
            </a>

            <!-- Payment -->
            <a href="{{ route('payments.index') }}"
               class="group flex items-center space-x-3 p-3 rounded-xl transition-all duration-300 transform hover:scale-[1.02] {{ request()->routeIs('payments.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'hover:bg-white hover:shadow-md' }}">
                <div class="p-1.5 rounded-lg {{ request()->routeIs('payments.*') ? 'bg-white bg-opacity-20' : 'group-hover:bg-purple-100' }} transition-colors duration-200">
                    <!-- <svg class="w-5 h-5 {{ request()->routeIs('payments.*') ? 'text-white' : 'text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg> -->

                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('payments.*') ? 'text-white' : 'text-purple-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 20h-8a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v4.5" />
                            <path d="M9 17h4" />
                            <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                            <path d="M19 21v1m0 -8v1" />
                        </svg>
                </div>
                <span class="font-medium {{ request()->routeIs('payments.*') ? 'text-white' : 'text-gray-600 group-hover:text-gray-800' }}">Payment</span>
            </a>
            <!-- </div> -->
             @endif



       </nav>
</div>

    
