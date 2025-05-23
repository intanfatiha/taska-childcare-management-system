<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
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

                    <form action="{{ route('attendances.update', ['childId' => $child->id, 'date' => $date]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Child Information Display -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center space-x-4">
                                @if($child->child_photo)
                                    <img src="{{ asset('storage/' . $child->child_photo) }}" 
                                         alt="{{ $child->child_name }}" 
                                         class="w-16 h-16 object-cover rounded-full border-2 border-blue-300">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-400 text-2xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-semibold text-blue-800">{{ $child->child_name }}</h3>
                                    <p class="text-sm text-blue-600">Child ID: {{ $child->id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="child_id" value="{{ $child->id }}">
                        <input type="hidden" name="attendance_date" value="{{ $date }}">

                        <!-- Child Name (Read-only display) -->
                        <div class="mb-4">
                            <label for="child_name" class="block text-sm font-medium text-gray-700">Child Name</label>
                            <input type="text" 
                                   id="child_name" 
                                   name="child_name" 
                                   class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" 
                                   value="{{ $child->child_name }}" 
                                   readonly>
                        </div>

                        <!-- Attendance Status -->
                        <div class="mb-4">
                            <label for="attendance_status" class="block text-sm font-medium text-gray-700">Attendance Status</label>
                            <select id="attendance_status" 
                                    name="attendance_status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    required>
                                <option value="attend" {{ (optional($attendance)->attendance_status == 'attend') ? 'selected' : '' }}>
                                    Present
                                </option>
                                <option value="absent" {{ (optional($attendance)->attendance_status == 'absent') ? 'selected' : '' }}>
                                    Absent
                                </option>
                            </select>
                        </div>

                        <!-- Time In -->
                        <div class="mb-4">
                            <label for="time_in" class="block text-sm font-medium text-gray-700">Time In</label>
                            <div class="flex items-center space-x-2">
                                <input type="time" 
                                       id="time_in" 
                                       name="time_in" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                       value="{{ optional($attendance)->time_in ? date('H:i', strtotime($attendance->time_in)) : '' }}">
                                <button type="button" 
                                        id="set-current-time-in" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md text-sm transition">
                                    <i class="fas fa-clock mr-1"></i>Now
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Leave empty if child is absent</p>
                        </div>

                        <!-- Time Out -->
                        <div class="mb-4">
                            <label for="time_out" class="block text-sm font-medium text-gray-700">Time Out</label>
                            <div class="flex items-center space-x-2">
                                <input type="time" 
                                       id="time_out" 
                                       name="time_out" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                       value="{{ optional($attendance)->time_out ? date('H:i', strtotime($attendance->time_out)) : '' }}">
                                <button type="button" 
                                        id="set-current-time-out" 
                                        class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-2 rounded-md text-sm transition">
                                    <i class="fas fa-clock mr-1"></i>Now
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Leave empty if child hasn't left yet</p>
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" 
                                   id="date" 
                                   name="date" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                   value="{{ $date }}" 
                                   required>
                        </div>

                        

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between">
                            <div class="flex space-x-3">
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-md transition duration-200 flex items-center">
                                    <i class="fas fa-save mr-2"></i>Update Attendance
                                </button>
                                <a href="{{ route('attendances.index') }}" 
                                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-md transition duration-200 flex items-center">
                                    <i class="fas fa-times mr-2"></i>Cancel
                                </a>
                            </div>
                            
                            @if($attendance)
                                <div class="text-sm text-gray-500">
                                    <p>Last updated: {{ $attendance->updated_at->format('M j, Y g:i A') }}</p>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for "Now" buttons -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to get current time in HH:MM format
            function getCurrentTime() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                return `${hours}:${minutes}`;
            }

            // Set current time for Time In
            document.getElementById('set-current-time-in').addEventListener('click', function() {
                document.getElementById('time_in').value = getCurrentTime();
                
                // Visual feedback
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check mr-1"></i>Set';
                this.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                this.classList.add('bg-green-500', 'hover:bg-green-600');
                
                // Reset after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('bg-green-500', 'hover:bg-green-600');
                    this.classList.add('bg-blue-500', 'hover:bg-blue-600');
                }, 2000);
            });

            // Set current time for Time Out
            document.getElementById('set-current-time-out').addEventListener('click', function() {
                document.getElementById('time_out').value = getCurrentTime();
                
                // Visual feedback
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check mr-1"></i>Set';
                this.classList.remove('bg-purple-500', 'hover:bg-purple-600');
                this.classList.add('bg-green-500', 'hover:bg-green-600');
                
                // Reset after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('bg-green-500', 'hover:bg-green-600');
                    this.classList.add('bg-purple-500', 'hover:bg-purple-600');
                }, 2000);
            });

            // Auto-clear time fields when status is set to absent
            document.getElementById('attendance_status').addEventListener('change', function() {
                if (this.value === 'absent') {
                    document.getElementById('time_in').value = '';
                    document.getElementById('time_out').value = '';
                }
            });
        });
    </script>

    <!-- Add Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</x-app-layout>