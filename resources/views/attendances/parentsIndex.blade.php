<x-app-layout>

     <div class="relative overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-purple-50 rounded-3xl p-4 mb-6 border border-gray-200 w-full">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 opacity-5"></div>
    <div class="relative flex flex-col sm:flex-row justify-start items-start sm:items-center gap-4 sm:gap-6">
        <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl blur-xl opacity-30 animate-pulse"></div>
            <div class="relative flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-lg">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 mb-1">
                {{ __('My Children\'s Attendance') }}
            </h2>
          
        </div>
    </div>
</div>

    <!-- Attendance Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Children Card -->
      

        
              <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-105 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-purple-400 to-purple-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl">
                        
                                        
                         <svg class= "h-10 w-10 text-white"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-baby-bottle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 10h14" /><path d="M12 2v2" /><path d="M12 4a5 5 0 0 1 5 5v11a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2v-11a5 5 0 0 1 5 -5z" />
                        </svg>              
                    </div>

                    <!-- Text Content -->
                    <div>
                        <div class="text-sm font-medium text-gray-500">My Children</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $totalChildren }}</div>
                    </div>
                </div>

                </div>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-105 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-teal-400 to-teal-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl">
                        <svg class="h-10 w-10 text-white" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M15 19l2 2l4 -4" /></svg>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m0 0a9 9 0 11-6.32 15.9M13 7h.01" />
                    </svg>
                    </div>

                    <!-- Text Content -->
                    <div>
                        <div class="text-sm font-medium text-gray-500">Present Today</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $presentToday }}</div>
                    </div>
                </div>

                </div>
            </div>

        </div>

          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-105 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-red-400 to-red-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-xl">
                          <svg class="h-10 w-10 text-white" fill="none" width="24"  height="24" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M13 21h-7a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6.5" />
                            <path d="M16 3v4" />
                            <path d="M8 3v4" />
                            <path d="M4 11h16" />
                            <path d="M22 22l-5 -5" />
                            <path d="M17 22l5 -5" />
                        </svg>  
                    </div>

                    <!-- Text Content -->
                    <div>
                        <div class="text-sm font-medium text-gray-500">Absent Today</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $absentToday }}</div>
                    </div>
                </div>

                </div>
            </div>

        </div>      
    </div>

    

     <form method="GET" action="{{ route('attendances.parentsIndex') }}" class="mb-6 flex items-center justify-between">
                        <!-- Date Filter -->
                        <div class="flex flex-col">
                            <label for="date" class="text-sm font-medium text-gray-700 mb-1">Filter by Date</label>
                            <input type="date" name="date" id="date"
                                value="{{ request('date', now()->format('Y-m-d')) }}"
                                class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                onchange="this.form.submit()">
                        </div>

                        
                    </form>


    <!-- Attendance Table -->
    <div class="overflow-x-auto">
    <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-lg">
            <thead>
                <tr class="bg-gradient-to-r from-purple-500 to-blue-500 text-white">
                    <th class="px-4 py-3 text-center">Picture</th>
                    <th class="px-4 py-3 text-center">Name</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Date</th>
                    <th class="px-4 py-3 text-center">Time In</th>
                    <th class="px-4 py-3 text-center">Time Out</th>
                    <th class="px-4 py-3 text-center">Overtime</th>

                </tr>
            </thead>
           <tbody>
            @foreach ($myChildren as $child)
                @php
                    $attendance = \App\Models\Attendance::where('children_id', $child->id)
                        ->where('attendance_date', $filterDate)
                        ->first();
                @endphp
                <tr class="hover:bg-blue-50 border-b border-gray-200 transition-colors">
                    <!-- Picture -->
                   <td class="px-6 py-4 whitespace-nowrap flex justify-center items-center">
                        @if($child->child_photo)
                            <img src="{{ asset('storage/' . $child->child_photo) }}" alt="Child Photo" class="w-16 h-16 object-cover rounded-full border-4 border-blue-300 shadow-md">
                        @else
                            <span class="inline-block h-12 w-12 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                        @endif
                    </td>

                    <!-- Name -->
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $child->child_name }}</td>
                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if ($attendance && $attendance->attendance_status === 'attend')
                            <span class="bg-green-500 text-white px-4 py-1 rounded-full text-sm font-bold">Present</span>
                        @elseif ($attendance && $attendance->attendance_status === 'absent')
                            <span class="bg-red-500 text-white px-4 py-1 rounded-full text-sm font-bold">Absent</span>
                        @else
                            <span class="bg-gray-300 text-gray-700 px-4 py-1 rounded-full text-sm font-bold">No Record</span>
                        @endif
                    </td>
                    <!-- Date -->
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        {{ $attendance ? \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') : '-' }}
                    </td>
                    <!-- Time In -->
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        {{ $attendance?->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('g:i A') : '-' }}
                    </td>
                    <!-- Time Out -->
                    <td class="px-6 py-4 whitespace-nowrap  text-center">
                        {{ $attendance?->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('g:i A') : '-' }}
                    </td>
                    <!-- Overtime -->
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        {{ ($attendance && $attendance->attendance_overtime > 0) ? $attendance->attendance_overtime . ' min' : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</x-app-layout>