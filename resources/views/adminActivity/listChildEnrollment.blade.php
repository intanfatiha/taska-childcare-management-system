<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Enrolled Children</h1>
                <p class="text-gray-600 mt-1">Manage and view all enrolled children in the system</p>
            </div> 

            <!-- Stats Cards (Optional - can be added later) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="text-sm font-medium text-gray-500">Total Enrolled</div>
                    <div class="text-2xl font-bold text-indigo-600">{{ $children->total() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="text-sm font-medium text-gray-500">This Page</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $children->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="text-sm font-medium text-gray-500">Page {{ $children->currentPage() }}</div>
                    <div class="text-2xl font-bold text-gray-900">of {{ $children->lastPage() }}</div>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block bg-white rounded-lg shadow-sm border overflow-hidden">
                <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-lg">
    <thead>
        <tr class="bg-gradient-to-r from-purple-500 to-blue-500 text-white">
            <th class="px-4 py-3 text-center">#</th>
            <th class="px-4 py-3 text-center">Child</th>
            <th class="px-4 py-3 text-center">Age</th>
            <th class="px-4 py-3 text-center">Parents</th>
            <th class="px-4 py-3 text-center">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($children as $index => $child)
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $children->firstItem() + $index }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12">
                        @if($child->child_photo)
                            <img src="{{ asset('storage/' . $child->child_photo) }}" 
                                 alt="{{ $child->child_name }}" 
                                 class="h-12 w-12 rounded-full object-cover border-2 border-gray-200"
                                 onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                        @else
                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $child->child_name }}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $child->child_age }} y/o
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                @php
                    $parentRecord = $child->parentRecord;
                    $father = $parentRecord->father->father_name ?? null;
                    $mother = $parentRecord->mother->mother_name ?? null;
                    $guardian = $parentRecord->guardian->guardian_name ?? null;
                @endphp

                @if($father || $mother)
                    {{ $father }}{{ $father && $mother ? ' & ' : '' }}{{ $mother }}
                @elseif($guardian)
                    {{ $guardian }}
                @else
                    <span class="text-gray-400">No Data</span>
                @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                @if($child->enrollment)
                    <a href="{{ route('adminActivity.show', ['adminActivity' => $child->enrollment->id]) }}" 
                       class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                        View Details
                    </a>
                @else
                    <span class="text-gray-400">No Enrollment</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="px-6 py-12 text-center">
                <div class="text-gray-400">
                    <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <p class="text-lg font-medium">No children found</p>
                    <p class="text-sm">There are no enrolled children to display.</p>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4">
                @forelse($children as $index => $child)
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <div class="flex items-start space-x-4">
                        <!-- Child Photo -->
                        <div class="flex-shrink-0">
                            @if($child->child_photo)
                                <img src="{{ asset('storage/' . $child->child_photo) }}" 
                                     alt="{{ $child->child_name }}" 
                                     class="h-16 w-16 rounded-full object-cover border-2 border-gray-200"
                                     onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Child Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-medium text-gray-900 truncate">{{ $child->child_name }}</h3>
                                <span class="text-sm text-gray-500 ml-2">#{{ $children->firstItem() + $index }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $child->child_age }} years old
                                    </span>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500">Parents:</p>
                                    <p class="text-sm text-gray-900">
                                        @php
                                            $enrollment = $child->enrollment;
                                        @endphp
                                        @if($enrollment)
                                            @if($enrollment->father && $enrollment->mother)
                                                {{ $enrollment->father->father_name }} & {{ $enrollment->mother->mother_name }}
                                            @elseif($enrollment->guardian)
                                                {{ $enrollment->guardian->guardian_name }}
                                            @else
                                                <span class="text-gray-400">No Data</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">No Data</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            <div class="mt-4">
                                <a href="{{ route('adminActivity.show', ['adminActivity' => $child->enrollment->id]) }}" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors w-full justify-center">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-lg shadow-sm border p-8 text-center">
                    <div class="text-gray-400">
                        <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <p class="text-lg font-medium text-gray-900 mb-1">No children found</p>
                        <p class="text-sm text-gray-500">There are no enrolled children to display.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($children->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-lg shadow-sm border px-4 py-3">
                    {{ $children->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>