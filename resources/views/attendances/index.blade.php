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
    <div class="grid grid-cols-2 gap-6 mb-6">
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
                    <p class="text-2xl font-bold">8</p>
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
                    <p class="text-2xl font-bold">0</p>
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
                        <!-- <a href="{{ route('attendances.checkIn') }}" 
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded shadow w-28 text-center">
                                Check In
                            </a>

                            <a href="" 
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded shadow w-28 text-center">
                                Check Out
                            </a> -->
                            <a href="{{ route('attendances.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded">
                                Add Attendance
                            </a>
                        </div>
                    </form>



                    <!-- Attendance Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
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
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($children as $child)
                @php
                    $attendance = $child->attendances->first();
                @endphp
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($child->child_photo)
                            <img src="{{ asset('storage/' . $child->child_photo) }}" alt="Child Photo" class="w-16 h-16 object-cover rounded-full border" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
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
                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->time_in ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->time_out ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->attendance_date ?? $date }}</td>
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

<!-- <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-12 w-12 border-2 border-gray-300 rounded-lg flex items-center justify-center">
                                            <img src="{{ asset('uploads/images/kid.jpg') }}" 
                                                 alt="Profile" 
                                                 class="h-10 w-10 rounded-lg object-cover">
                                        </div>
                                    </td> -->