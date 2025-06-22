<x-app-layout>
    <div class="bg-gray-100 min-h-screen p-6">
        <!-- Header -->
        <div class="bg-blue-800 text-white p-4 flex justify-between items-center rounded-md">
            <h1 class="text-lg font-bold">TASKA HIKMAH ENROLLMENT RECORDS</h1>
        </div>

        <!-- Breadcrumb
        <div class="text-gray-500 text-sm mt-4">
            <a href="{{ route('adminHomepage') }}" class="text-black-500 hover:underline">Home</a>
            <span class="mx-2">></span>
            <a href="{{ route('childrenRegisterRequest') }}" class="text-black-500 hover:underline">Parent Children Registration</a>
            <span class="mx-2">></span>
            <span class="text-gray-500">View Details</span>
        </div> -->

        <!-- Main Content -->
        <div class="bg-white shadow-md rounded-md mt-4 p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-700">Registration Details</h2>
                @if($enrollment->status === 'pending')
                    <span class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-bold uppercase">{{ $enrollment->status }}</span>
                @elseif($enrollment->status === 'approved')
                    <span class="bg-green-500 text-white px-4 py-1 rounded-full text-sm font-bold uppercase">{{ $enrollment->status }}</span>
                @elseif($enrollment->status === 'rejected')
                    <span class="bg-red-500 text-white px-4 py-1 rounded-full text-sm font-bold uppercase">{{ $enrollment->status }}</span>
                @endif
            </div>

            <p class="text-gray-500 mt-2">
                <strong>Registration ID:</strong> REG-20240318-{{ $enrollment->id ?? 'N/A' }} |
                <strong>Submitted:</strong> {{ $enrollment->created_at ? $enrollment->created_at->format('F d, Y h:i A') : 'N/A' }}
            </p>

            <!-- Child Information -->
            <div class="bg-gray-100 p-3 mt-6 rounded-md font-bold text-gray-700">Children Information</div>

            @foreach($enrollment->child as $child)
                <div class="bg-gray-50 p-3 rounded-md mb-4">
                    <p class="text-gray-600"><strong>Child's Name:</strong> {{ $child->child_name ?? 'N/A' }}</p>
                    <p class="text-gray-600"><strong>Date of Birth:</strong> {{ $child->child_birthdate ?? 'N/A' }}</p>
                    <p class="text-gray-600"><strong>Age:</strong> {{ $child->child_age ?? 'N/A' }}</p>
                    <p class="text-gray-600"><strong>Address:</strong> {{ $child->child_address ?? 'N/A' }}</p>
                    <p class="text-gray-600"><strong>Sibling Number:</strong> {{ $child->child_sibling_number ?? 'N/A' }}</p>
                    <p class="text-gray-600"><strong>Number in Sibling:</strong> {{ $child->child_numberInSibling ?? 'N/A' }}</p>
                    <p class="text-gray-600"><strong>Allergies:</strong> {{ $child->child_allergies ?? 'N/A' }}</p>
                    <p class="text-gray-600"><strong>Medical Conditions:</strong> {{ $child->child_medical_conditions ?? 'N/A' }}</p>
                    <p class="text-gray-600"><strong>Previous Childcare:</strong> {{ $child->child_previous_childcare ?? 'N/A' }}</p>

                    {{-- Parent Info --}}
                    @php
                        $parentRecord = \App\Models\ParentRecord::where('enrollment_id', $enrollment->id)
                            ->where('child_id', $child->id)
                            ->first();
                    @endphp

                    @if($parentRecord)
                        @if($parentRecord->father)
                            <div class="bg-gray-100 p-3 mt-4 rounded-md font-bold text-gray-700">Parent Information - Father</div>
                            <div class="mt-2 space-y-2">
                                <p class="text-gray-600"><strong>Father Name:</strong> {{ $parentRecord->father->father_name }}</p>
                                <p class="text-gray-600"><strong>Email Address:</strong> {{ $parentRecord->father->father_email }}</p>
                                <p class="text-gray-600"><strong>Phone Number:</strong> {{ $parentRecord->father->father_phoneNo }}</p>
                                <p class="text-gray-600"><strong>IC:</strong> {{ $parentRecord->father->father_ic }}</p>
                                <p class="text-gray-600"><strong>Address:</strong> {{ $parentRecord->father->father_address }}</p>
                                <p class="text-gray-600"><strong>Nationality & Race:</strong> {{ $parentRecord->father->father_nationality }} / {{ $parentRecord->father->father_race }}</p>
                                <p class="text-gray-600"><strong>Religion:</strong> {{ $parentRecord->father->father_religion }}</p>
                                <p class="text-gray-600"><strong>Occupation:</strong> {{ $parentRecord->father->father_occupation }}</p>
                                <p class="text-gray-600"><strong>Monthly Income:</strong> {{ $parentRecord->father->father_monthly_income }}</p>
                                <p class="text-gray-600"><strong>Staff Number:</strong> {{ $parentRecord->father->father_staff_number }}</p>
                                <p class="text-gray-600"><strong>PTJ:</strong> {{ $parentRecord->father->father_ptj }}</p>
                                <p class="text-gray-600"><strong>Office Number:</strong> {{ $parentRecord->father->father_office_number }}</p>
                            </div>
                        @endif

                        @if($parentRecord->mother)
                            <div class="bg-gray-100 p-3 mt-4 rounded-md font-bold text-gray-700">Parent Information - Mother</div>
                            <div class="mt-2 space-y-2">
                                <p class="text-gray-600"><strong>Mother Name:</strong> {{ $parentRecord->mother->mother_name }}</p>
                                <p class="text-gray-600"><strong>Email Address:</strong> {{ $parentRecord->mother->mother_email }}</p>
                                <p class="text-gray-600"><strong>Phone Number:</strong> {{ $parentRecord->mother->mother_phoneNo }}</p>
                                <p class="text-gray-600"><strong>IC:</strong> {{ $parentRecord->mother->mother_ic }}</p>
                                <p class="text-gray-600"><strong>Address:</strong> {{ $parentRecord->mother->mother_address }}</p>
                                <p class="text-gray-600"><strong>Nationality & Race:</strong> {{ $parentRecord->mother->mother_nationality }} / {{ $parentRecord->mother->mother_race }}</p>
                                <p class="text-gray-600"><strong>Religion:</strong> {{ $parentRecord->mother->mother_religion }}</p>
                                <p class="text-gray-600"><strong>Occupation:</strong> {{ $parentRecord->mother->mother_occupation }}</p>
                                <p class="text-gray-600"><strong>Monthly Income:</strong> {{ $parentRecord->mother->mother_monthly_income }}</p>
                                <p class="text-gray-600"><strong>Staff Number:</strong> {{ $parentRecord->mother->mother_staff_number }}</p>
                                <p class="text-gray-600"><strong>PTJ:</strong> {{ $parentRecord->mother->mother_ptj }}</p>
                                <p class="text-gray-600"><strong>Office Number:</strong> {{ $parentRecord->mother->mother_office_number }}</p>
                            </div>
                        @endif

                        @if($parentRecord->guardian)
                            <div class="bg-gray-100 p-3 mt-4 rounded-md font-bold text-gray-700">Parent Information - Guardian</div>
                            <div class="mt-2 space-y-2">
                                <p class="text-gray-600"><strong>Guardian Name:</strong> {{ $parentRecord->guardian->guardian_name }}</p>
                                <p class="text-gray-600"><strong>Relation:</strong> {{ $parentRecord->guardian->guardian_relation }}</p>
                                <p class="text-gray-600"><strong>Email Address:</strong> {{ $parentRecord->guardian->guardian_email }}</p>
                                <p class="text-gray-600"><strong>Phone Number:</strong> {{ $parentRecord->guardian->guardian_phoneNo }}</p>
                                <p class="text-gray-600"><strong>IC:</strong> {{ $parentRecord->guardian->guardian_ic }}</p>
                                <p class="text-gray-600"><strong>Address:</strong> {{ $parentRecord->guardian->guardian_address }}</p>
                                <p class="text-gray-600"><strong>Nationality & Race:</strong> {{ $parentRecord->guardian->guardian_nationality }} / {{ $parentRecord->guardian->guardian_race }}</p>
                                <p class="text-gray-600"><strong>Religion:</strong> {{ $parentRecord->guardian->guardian_religion }}</p>
                                <p class="text-gray-600"><strong>Occupation:</strong> {{ $parentRecord->guardian->guardian_occupation }}</p>
                                <p class="text-gray-600"><strong>Monthly Income:</strong> {{ $parentRecord->guardian->guardian_monthly_income }}</p>
                                <p class="text-gray-600"><strong>Staff Number:</strong> {{ $parentRecord->guardian->guardian_staff_number ?? '-' }}</p>
                                <p class="text-gray-600"><strong>PTJ:</strong> {{ $parentRecord->guardian->guardian_ptj ?? '-' }}</p>
                                <p class="text-gray-600"><strong>Office Number:</strong> {{ $parentRecord->guardian->guardian_office_number ?? '-' }}</p>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-600">No parent/guardian record found for this child.</p>
                    @endif
 
                    <!-- Child Documents -->
                    <p class="text-gray-600"><strong>Birth Certification:</strong></p>
                    @if ($child->child_birth_cert)
                        <div class="flex items-center space-x-4">
                            <a href="{{ asset('storage/' . $child->child_birth_cert) }}" target="_blank" class="bg-green-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-green-600">View</a>
                            <a href="{{ asset('storage/' . $child->child_birth_cert) }}" download class="bg-blue-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-blue-600">Download</a>
                        </div>
                    @else
                        <p class="text-gray-600">No birth certificate available.</p>
                    @endif

                    <p class="text-gray-600"><strong>Immunization Record:</strong></p>
                    @if ($child->child_immunization_record)
                        <div class="flex items-center space-x-4">
                            <a href="{{ asset('storage/' . $child->child_immunization_record) }}" target="_blank" class="bg-green-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-green-600">View</a>
                            <a href="{{ asset('storage/' . $child->child_immunization_record) }}" download class="bg-blue-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-blue-600">Download</a>
                        </div>
                    @else
                        <p class="text-gray-600">No immunization record available.</p>
                    @endif

                    <p class="text-gray-600"><strong>Passport Photo:</strong></p>
                    @if ($child->child_photo)
                        <div class="flex items-center space-x-4">
                            <a href="{{ asset('storage/' . $child->child_photo) }}" target="_blank" class="bg-green-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-green-600">View</a>
                            <a href="{{ asset('storage/' . $child->child_photo) }}" download class="bg-blue-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-blue-600">Download</a>
                        </div>
                    @else
                        <p class="text-gray-600">No passport photo available.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
