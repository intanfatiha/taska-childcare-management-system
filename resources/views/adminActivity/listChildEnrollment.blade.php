<x-app-layout> 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold mb-6">List of Enrolled Children</h1>

                <table class="table-auto w-full border-collapse border border-gray-300 ">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-center">#</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Picture</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Age</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Parents Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($children as $index => $child)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $children->firstItem() + $index }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if($child->child_photo)
                                    <div class="flex justify-center">
                                        <img src="{{ asset('storage/' . $child->child_photo) }}" alt="Child Photo" class="w-16 h-16 object-cover rounded-full border" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                    </div>
                                @else
                                    <div class="flex justify-center">
                                        <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="w-16 h-16 object-cover rounded-full border">
                                    </div>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $child->child_name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $child->child_age }} y/o</td>
                             <td class="border border-gray-300 px-4 py-2 text-center">
                                @php
                                    $enrollment = $child->enrollment;
                                @endphp
                                @if($enrollment)
                                    @if($enrollment->father && $enrollment->mother)
                                        {{ $enrollment->father->father_name }} & {{ $enrollment->mother->mother_name }}
                                    @elseif($enrollment->guardian)
                                        {{ $enrollment->guardian->guardian_name }}
                                    @else
                                        No Data
                                    @endif
                                @else
                                    No Data
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="{{ route('adminActivity.show', ['adminActivity' => $child->enrollment->id]) }}" class="text-blue-500 hover:underline">More Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">No children found.</td>
                        </tr>
                        
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $children->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>