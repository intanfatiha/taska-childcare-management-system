<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-purple-600">
            <i class="fas fa-child mr-2"></i>Children's Attendance
        </h1>

        <form method="POST" action="{{ route('attendances.store') }}">
            @csrf
            <!-- Date selector and controls -->
            <div class="mb-6 bg-yellow-100 p-4 rounded-lg shadow-md border-2 border-yellow-300">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="flex items-center mb-2 md:mb-0">
                        <span class="mr-2 text-gray-700">Today's Date:</span>
                        <input type="date" class="border-2 border-blue-300 rounded-md p-1" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition mr-2">
                            <i class="fas fa-save mr-1"></i> Save Attendance
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded-lg shadow-md mb-6 border-2 border-blue-200">
    <div class="flex justify-between items-end flex-wrap gap-4">
        <!-- Title -->
        <h2 class="text-xl font-bold text-blue-700">Attendance Sheet</h2>

        <!-- Search Bar
        <div class="flex flex-col">
            <label for="search" class="text-sm font-medium text-gray-700 mb-1">Search Child Name</label>
            <input type="text" name="search" id="search"
                value="{{ request('search') }}"
                placeholder="Enter child name"
                class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div> -->
    </div>
</div>


            <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-purple-500 to-blue-500 text-white">
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-center">Picture</th>
                        <th class="px-4 py-3 text-center">Name</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Time In</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($children as $index => $child)
                    @php
                        $attendance = $child->attendances->first(); // Get the attendance record for today
                    @endphp
                    <tr class="hover:bg-blue-50 border-b border-gray-200 transition-colors">
                        <td class="px-4 py-3 text-center">{{ $children->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center">
                                @if($child->child_photo)
                                    <img src="{{ asset('storage/' . $child->child_photo) }}" alt="{{ $child->child_name }}" 
                                        class="w-16 h-16 object-cover rounded-full border-4 border-blue-300 shadow-md" 
                                        onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" alt="No Image" 
                                        class="w-16 h-16 object-cover rounded-full border-4 border-blue-300 shadow-md">
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center font-medium text-blue-800">{{ $child->child_name }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="status[{{ $child->id }}]" value="attend" 
                                        class="form-radio h-5 w-5 text-green-600 status-radio"
                                        data-child-id="{{ $child->id }}"
                                        {{ (optional($attendance)->attendance_status === 'attend') ? 'checked' : '' }}>
                                    <span class="ml-2 text-green-700 font-medium">Present</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="status[{{ $child->id }}]" value="absent" 
                                        class="form-radio h-5 w-5 text-red-600 status-radio"
                                        data-child-id="{{ $child->id }}"
                                        {{ (optional($attendance)->attendance_status === 'absent') ? 'checked' : '' }}>
                                    <span class="ml-2 text-red-700 font-medium">Absent</span>
                                </label>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="time" class="border-2 border-blue-300 rounded-md p-1 bg-blue-50 time-in" 
                                name="time_in[{{ $child->id }}]" 
                                value="{{ optional($attendance)->time_in ? date('H:i', strtotime($attendance->time_in)) : '' }}"
                                {{ (optional($attendance)->attendance_status === 'absent') ? 'disabled' : '' }}
                                data-child-id="{{ $child->id }}">
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10">
                            <p class="text-gray-500">No children found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </form>

        <!-- Legend -->
        <div class="mt-6 flex justify-center space-x-6">
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-green-500 mr-2"></div>
                <span>Present</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-red-500 mr-2"></div>
                <span>Absent</span>
            </div>
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $children->links() }}
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Add Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get all status radio buttons
            const statusRadios = document.querySelectorAll('.status-radio');

            // Function to get current time in HH:MM format
            function getCurrentTime() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                return `${hours}:${minutes}`;
            }

            // Add event listeners to each radio button
            statusRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const childId = this.dataset.childId;
                    const timeInField = document.querySelector(`.time-in[data-child-id="${childId}"]`);

                    if (this.value === 'attend') {
                        // Enable time_in field and set current time if empty
                        timeInField.removeAttribute('disabled');
                        if (!timeInField.value) {
                            timeInField.value = getCurrentTime();
                        }
                    } else if (this.value === 'absent') {
                        // Disable and clear time_in field if "absent" is selected
                        timeInField.setAttribute('disabled', 'disabled');
                        timeInField.value = '';
                    }
                });
            });
        });
    </script>
</x-app-layout>