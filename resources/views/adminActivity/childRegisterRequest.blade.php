<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-6">Parent Children Registration</h2>

                <!-- Filter Buttons -->
                <div class="mb-4 flex gap-4">
                    <button id="pendingBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Pending</button>
                    <button id="registeredBtn" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-9 rounded">All</button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">#</th>
                                <th class="border px-4 py-2 text-left">Parent Name</th>
                                <th class="border px-4 py-2 text-left">Children</th>
                                <th class="border px-4 py-2 text-left">Details</th>
                                <th class="border px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody id="registrationTable">
                            @foreach($enrollments as $index => $enrollment)
                            <tr class="border-b hover:bg-gray-50">
                                <!-- Index Number -->
                                <td class="border px-4 py-2">{{ $enrollments->firstItem() + $index }}</td>

                                <!-- Father's Name -->
                                <td class="border px-4 py-2">

                                    @if($enrollment->father && $enrollment-> mother)
                                        {{ $enrollment->father->father_name}} & {{$enrollment->mother->mother_name}}
                                    @elseif($enrollment->guardian)
                                        {{$enrollment->guardian->guardian_name}}
                                    @else   
                                        No Data
                                    @endif
                                
                                </td>

                                <!-- Children Names -->
                                <td class="border px-4 py-2">
                                    @if($enrollment->child->isNotEmpty())
                                        {{ $enrollment->child->pluck('child_name')->implode(', ') }}
                                    @else
                                        No children registered
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="border px-4 py-2">
                                    <a href="{{ route('adminActivity.show', ['adminActivity' => $enrollment->id]) }}" class="text-blue-500 hover:text-blue-700 underline">View Details</a>
                                </td>
                                <td>
                                    <div class="mt-1 flex justify-center gap-4">
                                        <!-- Approve Button -->
                                       

                                        <a href="{{ route('adminActivity.approveForm', ['enrollmentId' => $enrollment->id]) }}">
                                            <button class="bg-green-500 hover:bg-green-600 text-white font-semibold py-1 px-4 rounded text-sm">
                                                Approve
                                            </button>
                                        </a>


                                        <!-- Reject Button -->
                                        <a href="{{ route('adminActivity.rejection') }}">
                                            <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-4 rounded text-sm">
                                                Reject
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $enrollments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
