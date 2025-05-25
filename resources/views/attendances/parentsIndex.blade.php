<x-app-layout>
    <div class="flex justify-between items-center">
        <h2 class="text-4xl font-bold mb-6">
            {{ __('My Children\'s Attendance') }}
        </h2> 
    </div>

    <!-- Attendance Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Children Card -->
        <div class="bg-purple-100 border border-purple-400 text-purple-700 px-4 py-5 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium">Total Children</h3>
                    <p class="text-2xl font-bold">{{ $totalChildren }}</p>
                </div>
            </div>
        </div>

        <!-- Present Today Card -->
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-5 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 1 1 2 -2h12a2 2 0 0 1 2 2v6" />
                        <path d="M15 19l2 2l4 -4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium">Present Today</h3>
                    <p class="text-2xl font-bold">{{ $presentToday }}</p>
                </div>
            </div>
        </div>

        <!-- Absent Today Card -->
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-5 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 21h-7a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6.5" />
                        <path d="M22 22l-5 -5" />
                        <path d="M17 22l5 -5" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium">Absent Today</h3>
                    <p class="text-2xl font-bold">{{ $absentToday }}</p>
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
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Picture</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Out</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Overtime</th>

                </tr>
            </thead>
           <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($myChildren as $child)
                @php
                    $attendance = \App\Models\Attendance::where('children_id', $child->id)
                        ->where('attendance_date', $filterDate)
                        ->first();
                @endphp
                <tr>
                    <!-- Picture -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($child->child_photo)
                            <img src="{{ asset('storage/' . $child->child_photo) }}" alt="Child Photo" class="h-12 w-12 rounded-full object-cover">
                        @else
                            <span class="inline-block h-12 w-12 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                        @endif
                    </td>
                    <!-- Name -->
                    <td class="px-6 py-4 whitespace-nowrap">{{ $child->child_name }}</td>
                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($attendance && $attendance->attendance_status === 'attend')
                            <span class="bg-green-500 text-white px-4 py-1 rounded-full text-sm font-bold">Present</span>
                        @elseif ($attendance && $attendance->attendance_status === 'absent')
                            <span class="bg-red-500 text-white px-4 py-1 rounded-full text-sm font-bold">Absent</span>
                        @else
                            <span class="bg-gray-300 text-gray-700 px-4 py-1 rounded-full text-sm font-bold">No Record</span>
                        @endif
                    </td>
                    <!-- Date -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $attendance ? \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') : '-' }}
                    </td>
                    <!-- Time In -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $attendance?->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('g:i A') : '-' }}
                    </td>
                    <!-- Time Out -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $attendance?->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('g:i A') : '-' }}
                    </td>
                    <!-- Overtime -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ ($attendance && $attendance->attendance_overtime > 0) ? $attendance->attendance_overtime . ' min' : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</x-app-layout>