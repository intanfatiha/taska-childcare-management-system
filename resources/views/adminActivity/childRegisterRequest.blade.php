<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-6">Parent Children Registration</h2>

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

                                <!-- Parent Name -->
                                <td class="border px-4 py-2">
                                    @if($enrollment->father && $enrollment->mother)
                                        {{ $enrollment->father->father_name }} & {{ $enrollment->mother->mother_name }}
                                    @elseif($enrollment->guardian)
                                        {{ $enrollment->guardian->guardian_name }}
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
                                        <button onclick="openModal('approve', {{ $enrollment->id }}, '{{ $enrollment->father->father_email ?? '' }}', '{{ $enrollment->mother->mother_email ?? '' }}', '{{ $enrollment->guardian->guardian_email ?? '' }}')" 
                                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-1 px-4 rounded text-sm">
                                        Approve
                                    </button>

                                    <button onclick="openModal('reject', {{ $enrollment->id }})" 
                                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-4 rounded text-sm">
                                        Reject
                                    </button>
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

    <!-- Approve/Reject Modal -->
    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6">
        <h2 id="modalTitle" class="text-xl font-bold mb-4"></h2>
        <form id="modalForm" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="enrollment_id" id="enrollmentId" value="">
            <div id="modalContent" class="mb-4"></div>
            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">Cancel</button>
                <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded">Submit</button>
            </div>
        </form>
    </div>
</div>

    <!-- JavaScript -->
    <script>
       function openModal(action, enrollmentId, fatherEmail = '', motherEmail = '', guardianEmail = '') {
        console.log('openModal called with action:', action, 'enrollmentId:', enrollmentId);

        const modalOverlay = document.getElementById('modalOverlay');
        const modalTitle = document.getElementById('modalTitle');
        const modalForm = document.getElementById('modalForm');
        const modalContent = document.getElementById('modalContent');
        const enrollmentIdInput = document.getElementById('enrollmentId');

        if (action === 'approve') {
            modalTitle.textContent = 'Approve Enrollment';
            modalForm.action = `{{ url('admin/approve-registration') }}/${enrollmentId}`;
            modalContent.innerHTML = `
                <label for="father_email" class="block text-gray-700 font-semibold mb-2">Father Email:</label>
                <input type="email" name="father_email" class="w-full border rounded px-3 py-2 mb-4" placeholder="${fatherEmail}" required>
                <label for="mother_email" class="block text-gray-700 font-semibold mb-2">Mother Email:</label>
                <input type="email" name="mother_email" class="w-full border rounded px-3 py-2 mb-4" placeholder="${motherEmail}" required>
                <label for="guardian_email" class="block text-gray-700 font-semibold mb-2">Guardian Email (if necessary):</label>
                <input type="email" name="guardian_email" class="w-full border rounded px-3 py-2 mb-4" placeholder="${guardianEmail}">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password:</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2 mb-4" placeholder="Enter password" required>
            `;
        } else if (action === 'reject') {
            modalTitle.textContent = 'Reject Enrollment';
            modalForm.action = `{{ url('admin/reject-registration') }}/${enrollmentId}`;
            modalContent.innerHTML = `
                 <label for="father_email" class="block text-gray-700 font-semibold mb-2">Father Email:</label>
                <input type="email" name="father_email" class="w-full border rounded px-3 py-2 mb-4" placeholder="${fatherEmail}" required>
                <label for="mother_email" class="block text-gray-700 font-semibold mb-2">Mother Email:</label>
                <input type="email" name="mother_email" class="w-full border rounded px-3 py-2 mb-4" placeholder="${motherEmail}" required>
                <label for="guardian_email" class="block text-gray-700 font-semibold mb-2">Guardian Email (if necessary):</label>
                <input type="email" name="guardian_email" class="w-full border rounded px-3 py-2 mb-4" placeholder="${guardianEmail}">
                <label for="reason" class="block text-gray-700 font-semibold mb-2">Reason for Rejection:</label>
                <textarea name="reason" rows="4" class="w-full border rounded px-3 py-2" placeholder="Enter reason for rejection"></textarea>
            `;
        }

        enrollmentIdInput.value = enrollmentId;
        modalOverlay.classList.remove('hidden');
    }

    function closeModal() {
        const modalOverlay = document.getElementById('modalOverlay');
        modalOverlay.classList.add('hidden');
    }
    </script>
</x-app-layout>