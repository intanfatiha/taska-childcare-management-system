<x-app-layout>
    
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold mb-6">
                {{ __('Generate Report') }}
            </h2>
         
        </div>
  


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Children Attendance</h2>

                    <!-- Buttons -->
                    <div class="space-x-2">
                        <a href="" class="btn btn-primary btn-sm">PDF/Print</a>
                        <a href="" class="btn btn-primary btn-sm">Excel</a>
                    </div>
                </div>

                <!-- Date Selector and Apply Button -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex space-x-4 items-center">
                        <label for="select-date" class="text-sm font-semibold">Select Date:</label>
                        <input type="date" id="select-date" name="selected_date" class="form-input border-gray-300 rounded-lg">
                    </div>
                    <button class="btn btn-success btn-sm">Apply Filter</button>
                </div>

                <!-- Error or Success Messages -->
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">Name</th>
                                <th class="border px-4 py-2 text-left">Time In</th>
                                <th class="border px-4 py-2 text-left">Time Out</th>
                                <th class="border px-4 py-2 text-left">Date</th>
                                <th class="border px-4 py-2 text-left">Attend/Absent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Add dynamic rows here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
