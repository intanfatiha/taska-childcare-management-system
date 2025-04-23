<x-app-layout>
    <!-- <div class="py-12 bg-gradient-to-r from-blue-100 to-purple-100"> -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6 border-4 border-blue-300"> -->
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
                            <input type="date" class="border-2 border-blue-300 rounded-md p-1" value="{{ date('Y-m-d') }}">
                        </div>
                        <div>
                            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition mr-2">
                                <i class="fas fa-save mr-1"></i> Save Attendance
                            </button>
                            <!-- <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition">
                                <i class="fas fa-print mr-1"></i> Print
                            </button> -->
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg shadow-md mb-6 border-2 border-blue-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-blue-700">Attendance Sheet</h2>
                        <!-- <div class="flex items-center">
                            <span class="mr-2 text-gray-700">Class:</span>
                            <select class="border-2 border-blue-300 rounded-md p-1">
                                <option>All Classes</option>
                                <option>Toddlers</option>
                                <option>Preschool</option>
                                <option>Kindergarten</option>
                            </select>
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
                            <th class="px-4 py-3 text-center">Time Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($children as $index => $child)
                        <tr class="hover:bg-blue-50 border-b border-gray-200 transition-colors">
                            <td class="px-4 py-3 text-center">{{ $children->firstItem() + $index }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center">
                                    @if($child->child_photo)
                                        <div class="w-16 h-16 relative">
                                            <img src="{{ asset('storage/' . $child->child_photo) }}" alt="{{ $child->child_name }}" 
                                                class="w-16 h-16 object-cover rounded-full border-4 border-blue-300 shadow-md" 
                                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                        </div>
                                    @else
                                        <div class="w-16 h-16 relative">
                                            <img src="{{ asset('images/no-image.png') }}" alt="No Image" 
                                                class="w-16 h-16 object-cover rounded-full border-4 border-blue-300 shadow-md">
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center font-medium text-blue-800">{{ $child->child_name }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status[{{ $child->id }}]" value="attend" class="form-radio h-5 w-5 text-green-600">
                                        <span class="ml-2 text-green-700 font-medium">Present</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status[{{ $child->id }}]" value="absent" class="form-radio h-5 w-5 text-red-600">
                                        <span class="ml-2 text-red-700 font-medium">Absent</span>
                                    </label>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <input type="time" class="border-2 border-blue-300 rounded-md p-1 bg-blue-50" 
                                    name="time_in[{{ $child->id }}]" value="{{ old('time_in.' . $child->id) }}">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <input type="time" class="border-2 border-blue-300 rounded-md p-1 bg-blue-50" 
                                    name="time_out[{{ $child->id }}]">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-10">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg class="w-16 h-16 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-xl font-medium">No children found.</p>
                                    <p class="text-sm">Please add children to the system or adjust your search filters.</p>
                                </div>
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

               
            <!-- </div>
        </div> -->
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
</x-app-layout>