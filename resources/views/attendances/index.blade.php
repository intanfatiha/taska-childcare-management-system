<x-app-layout>
    <div class="flex justify-between items-center">
        <h2 class="text-4xl font-bold mb-6">
            {{ __('Attendance Management') }}
        </h2>
        <!-- <a href="{{ route('attendances.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            Add Attendance
        </a> -->
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
<div class="bg-purple-100 border border-purple-400 text-purple-700 px-4 py-5 rounded-lg shadow-md">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <svg class="h-10 w-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l-2 0l9 -9l9 9l-2 0M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
            </svg>
        </div>
        <div class="ml-4">
            <h3 class="text-lg font-medium">
                @if(auth()->user()->role === 'staff')
                    Total Children
                @elseif(auth()->user()->role === 'admin')
                    Total Children
                @endif
            </h3>
            <p class="text-2xl font-bold">
                @if(auth()->user()->role === 'staff')
                    {{ $totalChildren }}
                @elseif(auth()->user()->role === 'admin')
                    {{ $totalChildren }}
                @endif
            </p>
        </div>
    </div>
</div>
        <!-- Staff Dashboard -->
      @if(auth()->user()->role === 'staff')
            <!-- Total children Card -->
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-5 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                    
                        <svg class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m0 0L3 10m6-7l6 7" />
                                        </svg>                    
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium"> Total Assigned Children</h3>
                        <p class="text-2xl font-bold">{{ $totalAssignedChildren}}</p>
                    </div>
                </div>
            </div>
      @endif

    


        <!-- Total Attend Card -->
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-5 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                <svg class="h-10 w-10 text-green-500" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M15 19l2 2l4 -4" /></svg>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m0 0a9 9 0 11-6.32 15.9M13 7h.01" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium"> Present Today</h3>
                    <p class="text-2xl font-bold">{{ $totalAttend }}</p>
                </div>
            </div>
        </div>

        <!-- Total Absence Card -->
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-5 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                <svg class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 21h-7a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6.5" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 0M15 12h.01M9 12h.01M12 15h.01" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium"> Absence Today</h3>
                    <p class="text-2xl font-bold">{{ $totalAbsent}}</p>
                </div>
            </div>
        </div>
    </div> 

    
    

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Date Filter with Check In and Check Out Buttons -->
                    <form method="GET" action="{{ route('attendances.index') }}" class="mb-6 flex items-center justify-between">
                        <!-- Date Filter -->
                        <div class="flex flex-col">
                            <label for="date" class="text-sm font-medium text-gray-700 mb-1">Filter by Date</label>
                            <input type="date" name="date" id="date"
                                value="{{ request('date', now()->format('Y-m-d')) }}"
                                class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                onchange="this.form.submit()">
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

                    <!-- Attendance Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="bg-gray-50">
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Picture
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Time In
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Time Out
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Overtime
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($children as $child)
                @php
                    $attendance = $child->attendances->first();
                @endphp
                <tr class="hover:bg-blue-50 border-b border-gray-200 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($child->child_photo)
                            <img src="{{ asset('storage/' . $child->child_photo) }}" alt="Child Photo" class="w-16 h-16 object-cover rounded-full border-4 border-blue-300 shadow-md" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                        @else
                            <div class="h-10 w-10 bg-gray-200 rounded-lg"></div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $child->child_name ?? 'No Name' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
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
                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance?->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('g:i A') : '-' }}</td>                   
                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance?->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('g:i A') : '-' }}</td>                    
                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->attendance_date ?? $date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
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
                    </td>                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('attendances.edit', ['childId' => $child->id, 'date' => $date]) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
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


    
</x-app-layout>