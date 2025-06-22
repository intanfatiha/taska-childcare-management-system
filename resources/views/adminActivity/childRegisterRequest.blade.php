<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           <!-- Header Section with Gradient -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
                <div>
                    <h2 class="text-3xl font-bold text-indigo-800">
                        {{ __('Parent-Children Registration') }}
                    </h2>
                    <p class="text-gray-600 mt-1">Manage registration requests</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                <!-- Alerts -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session('message'))
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                        <p class="text-sm text-green-700">{{ session('message') }}</p>
                    </div>
                @endif

                <!-- 'rejected' => ['label' => 'Rejected', 'color' => 'red'] -->
                <!-- Filter Tabs -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex gap-1">
                        @php
                            $tabs = [
                                'pending' => ['label' => 'Pending', 'color' => 'blue'],
                                'approved' => ['label' => 'Approved', 'color' => 'green'], 
                                
                            ];
                                $activeStatus = $status ?? request('status') ?? 'pending';

                        @endphp
                        @foreach ($tabs as $key => $tab)
                            <a href="{{ route('childrenRegisterRequest', ['status' => $key]) }}"
                               class="px-4 py-2 text-sm font-medium rounded-md transition-colors
                               {{ $status === $key 
                                   ? 'bg-' . $tab['color'] . '-500 text-gray-900' 
                                   : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                                {{ $tab['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parent/Guardian</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Child</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($parentRecords as $index => $record)
                                @php 
                                    $enrollment = $record->enrollment;
                                    $status_class = match($enrollment->status ?? 'pending') {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-green-100 text-green-800', 
                                        'rejected' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $parentRecords->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">
                                            @if($record->father && $record->mother)
                                                {{ $record->father->father_name }} & {{ $record->mother->mother_name }}
                                            @elseif($record->guardian)
                                                {{ $record->guardian->guardian_name }}
                                            @else
                                                <span class="text-gray-400">No data</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $record->child->child_name ?? 'No child registered' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500 capitalize">
                                        {{ $enrollment->registration_type ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $status_class }}">
                                            {{ ucfirst($enrollment->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                           <a href="{{ route('adminActivity.show', ['adminActivity' => $record->enrollment_id]) }}"
                                               class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                 <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>  
                                                <!-- View -->
                                            </a>
                                            @if(($enrollment->status ?? 'pending') === 'pending')
                                                <button onclick="openModal('approve', {{ $record->id }},
                                                    '{{ addslashes($record->father->father_email ?? '') }}',
                                                    '{{ addslashes($record->mother->mother_email ?? '') }}',
                                                    '{{ addslashes($record->guardian->guardian_email ?? '') }}',
                                                    '{{ addslashes($enrollment->registration_type ?? '') }}',
                                                    '{{ addslashes($record->father->father_name ?? '') }}',
                                                    '{{ addslashes($record->mother->mother_name ?? '') }}',
                                                    '{{ addslashes($record->guardian->guardian_name ?? '') }}',
                                                    '{{ addslashes($record->father->father_ic ?? '') }}',
                                                    '{{ addslashes($record->mother->mother_ic ?? '') }}',
                                                    '{{ addslashes($record->guardian->guardian_ic ?? '') }}')"
                                                    class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                    Approve
                                                </button>
                                                <button onclick="openModal('reject', {{ $record->id }},
                                                    '{{ addslashes($record->father->father_email ?? '') }}',
                                                    '{{ addslashes($record->mother->mother_email ?? '') }}',
                                                    '{{ addslashes($record->guardian->guardian_email ?? '') }}',
                                                    '{{ addslashes($enrollment->registration_type ?? '') }}',
                                                    '{{ addslashes($record->father->father_name ?? '') }}',
                                                    '{{ addslashes($record->mother->mother_name ?? '') }}',
                                                    '{{ addslashes($record->guardian->guardian_name ?? '') }}')"
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Reject
                                                </button>
                                            @endif
                                            
                                            <!-- <form action="{{ route('adminActivity.destroy', $record->id) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this registration?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                 <button type="submit" class="flex items-center text-red-600 hover:text-red-800 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                            <path d="M4 7h16" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                   
                                    </button>
                                            </form> -->
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                        <div class="text-sm">No registration records found.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($parentRecords->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $parentRecords->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="p-6">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 mb-4"></h3>
                <form id="modalForm" method="POST">
                    @csrf
                    <input type="hidden" name="enrollment_id" id="enrollmentId">
                    <div id="modalContent" class="mb-6"></div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal()" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                            Cancel
                        </button>
                        <button type="submit" id="submitButton"
                                class="px-4 py-2 text-sm font-medium text-white rounded-md">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(action, enrollmentId, fatherEmail = '', motherEmail = '', guardianEmail = '', 
                          registrationType = '', fatherName = '', motherName = '', guardianName = '', 
                          fatherIc = '', motherIc = '', guardianIc = '') {
            const modal = document.getElementById('modalOverlay');
            const title = document.getElementById('modalTitle');
            const form = document.getElementById('modalForm');
            const content = document.getElementById('modalContent');
            const submitBtn = document.getElementById('submitButton');
            const enrollmentIdInput = document.getElementById('enrollmentId');

            enrollmentIdInput.value = enrollmentId;

            if (action === 'approve') {
                title.textContent = 'Approve Registration';
                form.action = `{{ route('adminActivity.approveRegistration', '') }}/${enrollmentId}`;
                submitBtn.className = 'px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700';
                submitBtn.textContent = 'Approve';

                let passwordFields = '';
                if (registrationType === 'parents') {
                    passwordFields = `
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Generated Passwords:</label>
                            <div class="bg-gray-50 p-3 rounded text-sm">
                                <div>Father: ${fatherIc}</div>
                                <div>Mother: ${motherIc}</div>
                            </div>
                        </div>
                    `;
                } else if (registrationType === 'guardian') {
                    passwordFields = `
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Generated Password:</label>
                            <div class="bg-gray-50 p-3 rounded text-sm">Guardian: ${guardianIc}</div>
                        </div>
                    `;
                }

                content.innerHTML = `
                    <div class="space-y-4">
                        <div class="bg-green-50 p-3 rounded text-sm text-green-700">
                            Login credentials will be sent via email upon approval.
                        </div>
                        ${fatherEmail ? `
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Father Email</label>
                                <input type="email" name="father_email" value="${fatherEmail}" 
                                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                            </div>
                        ` : ''}
                        ${motherEmail ? `
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mother Email</label>
                                <input type="email" name="mother_email" value="${motherEmail}" 
                                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                            </div>
                        ` : ''}
                        ${guardianEmail ? `
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Email</label>
                                <input type="email" name="guardian_email" value="${guardianEmail}" 
                                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                            </div>
                        ` : ''}
                        ${passwordFields}
                        <input type="hidden" name="father_name" value="${fatherName}">
                        <input type="hidden" name="mother_name" value="${motherName}">
                        <input type="hidden" name="guardian_name" value="${guardianName}">
                        <input type="hidden" name="father_ic" value="${fatherIc}">
                        <input type="hidden" name="mother_ic" value="${motherIc}">
                        <input type="hidden" name="guardian_ic" value="${guardianIc}">
                        <input type="hidden" name="registration_type" value="${registrationType}">
                        <input type="hidden" name="role" value="parents">
                    </div>
                `;
            } else if (action === 'reject') {
                title.textContent = 'Reject Registration';
                form.action = `{{ route('adminActivity.rejectRegistration', '') }}/${enrollmentId}`;
                submitBtn.className = 'px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700';
                submitBtn.textContent = 'Reject';

                content.innerHTML = `
                    <div class="space-y-4">
                        <div class="bg-red-50 p-3 rounded text-sm text-red-700">
                            Rejection notification will be sent to all email addresses.
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Rejection *</label>
                            <textarea name="rejectReason" rows="3" required
                                      class="w-full border border-gray-300 rounded px-3 py-2 text-sm"
                                      placeholder="Enter reason for rejection..."></textarea>
                        </div>
                        <input type="hidden" name="father_email" value="${fatherEmail}">
                        <input type="hidden" name="mother_email" value="${motherEmail}">
                        <input type="hidden" name="guardian_email" value="${guardianEmail}">
                        <input type="hidden" name="father_name" value="${fatherName}">
                        <input type="hidden" name="mother_name" value="${motherName}">
                        <input type="hidden" name="guardian_name" value="${guardianName}">
                        <input type="hidden" name="registration_type" value="${registrationType}">
                    </div>
                `;
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Form submission loading state
        document.getElementById('modalForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitButton');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';
        });
    </script>
</x-app-layout>