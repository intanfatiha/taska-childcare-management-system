<x-app-layout>
    

 <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section with Gradient -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 mb-1">
                        {{ __('Attendance Management') }}
                    </h2>
                    <p class="text-gray-600 mt-1">Attendance tracking </p>
                </div>
                
                
            </div>


    <!-- Attendance Summary Cards -->
    <div class="grid grid-cols-3 gap-6 mb-6">


      

        @php
                        $userId = auth()->id();
                        $staff = App\Models\Staff::where('user_id', $userId)->first();
                        $totalAssignedChildren = $staff ? App\Models\StaffAssignment::where('primary_staff_id', $staff->id)->count() : 0;
                        $assignedChildren = $staff ? App\Models\StaffAssignment::where('primary_staff_id', $staff->id)->with('child')->get() : [];
        @endphp

    
<!-- Total Children Card -->


   <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-105 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-purple-400 to-purple-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl">
                         <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l-2 0l9 -9l9 9l-2 0M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
            </svg>
                    </div>

                    <!-- Text Content -->
                    <div class="text-sm font-medium text-gray-500">

                            @if(auth()->user()->role === 'staff')
                                Total Children
                            @elseif(auth()->user()->role === 'admin')
                                Total Children
                            @endif
                          
                        <div class="text-3xl font-bold text-gray-900">
                            @if(auth()->user()->role === 'staff')
                                {{ $totalChildren }}
                            @elseif(auth()->user()->role === 'admin')
                                {{ $totalChildren }}
                            @endif

                        </div>
                    </div>
                </div>

                </div>
            </div>

        </div>
        <!-- Staff Dashboard -->
      @if(auth()->user()->role === 'staff')
            <!-- Total children Card -->
       


              <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-105 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-blue-400 to-blue-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl">
                         <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m0 0L3 10m6-7l6 7" />
                                        </svg>      
                    </div>

                    <!-- Text Content -->
                    <div>
                        <div class="text-sm font-medium text-gray-500">Total Assigned Children</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $totalAssignedChildren }}</div>
                    </div>
                </div>

                </div>
            </div>

        </div>
      @endif

    


        <!-- Total Attend Card -->

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
                        <div class="text-3xl font-bold text-gray-900">{{ $totalAttend }}</div>
                    </div>
                </div>

                </div>
            </div>

        </div>


        <!-- Total Absence Card -->
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
                        <div class="text-sm font-medium text-gray-500">Absence Today</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $totalAbsent }}</div>
                    </div>
                </div>

                </div>
            </div>

        </div>



    </div> 
     <!-- Date Filter with Check In and Check Out Buttons -->
                    <form method="GET" action="{{ route('attendances.index') }}" class="mb-6 flex items-center justify-between">
                       <div class="flex items-end gap-6 flex-wrap">
                        <!-- Date Filter -->
                        <div class="flex flex-col">
                            <label for="date" class="text-sm font-medium text-gray-700 mb-1">Filter by Date</label>
                            <input type="date" name="date" id="date"
                                value="{{ request('date', now()->format('Y-m-d')) }}"
                                class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                onchange="this.form.submit()">
                        </div>

                        <!-- Search Bar
                        <div class="flex flex-col">
                            <label for="search" class="text-sm font-medium text-gray-700 mb-1">Search Child Name</label>
                            <input type="text" name="search" id="search"
                                value="{{ request('search') }}"
                                placeholder="Enter child name"
                                class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div> -->
                    </div>

                        <!-- Buttons -->
                        <div class="flex gap-4">
                            <a href="{{ route('attendances.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded">
                                Time In Attendance
                            </a>

                             <a href="{{ route('attendances.createTimeOut') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded">
                                Time Out Attendance
                            </a>
                        </div>
                    </form>
    
    <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-purple-500 to-blue-500 text-white">
                        
                        <th class="px-4 py-3 text-center">Picture</th>
                        <th class="px-4 py-3 text-center">Name</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Time In</th>
                        <th class="px-4 py-3 text-center">Time Out</th>
                        <th class="px-4 py-3 text-center">Date</th>
                        <th class="px-4 py-3 text-center">Overtime</th>
                        <th class="px-4 py-3 text-center">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($children as $child)
                @php
                    $attendance = $child->attendances->first();
                @endphp
                <tr class="hover:bg-blue-50 border-b border-gray-200 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center">
                            @if ($child->child_photo)
                                <img src="{{ asset('storage/' . $child->child_photo) }}"
                                    alt="Child Photo"
                                    class="w-16 h-16 object-cover rounded-full border-4 border-blue-300 shadow-md"
                                    onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $child->child_name ?? 'No Name' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @php
                            $status = optional($attendance)->attendance_status;
                        @endphp

                        @if($status === 'attend')
                            <span class="bg-green-500 text-white px-4 py-1 rounded-full text-sm font-bold ">
                                Attend
                            </span>
                        @elseif($status === 'absent')
                            <span class="bg-red-500 text-white px-4 py-1 rounded-full text-sm font-bold ">
                                Absent
                            </span>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $attendance?->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('g:i A') : '-' }}</td>                   
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $attendance?->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('g:i A') : '-' }}</td>                    
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $attendance->attendance_date ?? $date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @php
                            $overtimeMinutes = null;
                            if ($attendance && $attendance->time_out) {
                                $attendanceDate = \Carbon\Carbon::parse($attendance->attendance_date);
                                $dayOfWeek = $attendanceDate->format('l'); // e.g. 'Monday'
                                $closeTime = $dayOfWeek === 'Thursday' ? '16:00' : '17:30';
                                $close = \Carbon\Carbon::parse($attendance->attendance_date . ' ' . $closeTime);
                                $out = \Carbon\Carbon::parse($attendance->attendance_date . ' ' . $attendance->time_out);
                                if ($out->gt($close)) {
                                    $overtimeMinutes = $out->diffInMinutes($close);
                                }
                            }
                        @endphp
                        @if($overtimeMinutes)
                            <span class="text-red-600 font-bold">{{ $overtimeMinutes }} min</span>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>                    
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <a href="{{ route('attendances.edit', ['childId' => $child->id, 'date' => $date]) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center justify-center ">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                           
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
</table>
    

                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- <script>
let searchTimeout;
document.getElementById('search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        this.form.submit();
    }, 400); // 400ms debounce for better UX
});
</script> -->
    
</x-app-layout>