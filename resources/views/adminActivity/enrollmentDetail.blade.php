<x-app-layout>
    <div class="bg-gray-100 min-h-screen p-6">
        <!-- Header -->
        <div class="bg-blue-800 text-white p-4 flex justify-between items-center rounded-md">
            <h1 class="text-lg font-bold">TASKA HIKMAH ENROLLMENT RECORDS</h1>
            <!-- <div class="flex items-center space-x-2">
                <span class="text-sm">Admin</span>
                <div class="w-8 h-8 bg-white text-blue-800 flex items-center justify-center rounded-full font-bold">A</div>
            </div> -->
        </div>
        
        <!-- Breadcrumb -->
        <div class="text-gray-500 text-sm mt-4">
            <a href="{{ route('adminHomepage') }}" class="text-black-500 hover:underline">Home</a>
            <span class="mx-2">></span>
            <a href="{{ route('childrenRegisterRequest') }}" class="text-black-500 hover:underline">Parent Children Registration</a>
            <span class="mx-2">></span>
            <span class="text-gray-500">View Details</span>
        </div>
        
        <!-- Main Content -->
        <div class="bg-white shadow-md rounded-md mt-4 p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-700">Registration Details</h2>
                <span class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-bold uppercase">{{ $enrollment->status}}</span>
            </div>
            
            <p class="text-gray-500 mt-2">
                <strong>Registration ID:</strong> REG-20240318-{{ $enrollment->id ?? 'N/A' }} |
                <strong>Submitted:</strong> {{ $enrollment->created_at ? $enrollment->created_at->format('F d, Y h:i A') : 'N/A' }}
            </p>
             <!-- Child Information -->
             <div class="bg-gray-100 p-3 mt-6 rounded-md font-bold text-gray-700">Child Information</div>
            <div class="mt-2 space-y-2">
                                                    
                <p class="text-gray-600"><strong>Child's Name:</strong> {{$enrollment->child->first()->child_name ?? 'N/A'}}</p>   <!-- since child relation id hasMany so using first() will retrieve the first collection first.  -->
                <p class="text-gray-600"><strong>Date of Birth:</strong> {{$enrollment->child->first()->child_birthdate ?? 'N/A'}}</p>
                <p class="text-gray-600"><strong>Age:</strong> {{$enrollment->child->first()->child_age ?? 'N/A'}}</p>
                <p class="text-gray-600"><strong>Address:</strong> {{$enrollment->child->first()->child_address ?? 'N/A'}}</p>
                <p class="text-gray-600"><strong>Sibling Number:</strong> {{$enrollment->child->first()->child_sibling_number ?? 'N/A'}}</p>
                <p class="text-gray-600"><strong>Number in Sibling:</strong> {{$enrollment->child->first()->child_numberInSibling ?? 'N/A'}}</p>
                <p class="text-gray-600"><strong>Allergies:</strong> {{$enrollment->child->first()->child_allergies ?? 'N/A'}}</p>
                <p class="text-gray-600"><strong>Medical Conditions:</strong> {{$enrollment->child->first()->child_medical_conditions ?? 'N/A'}}</p>
                <p class="text-gray-600"><strong>Previous Childcare:</strong> {{$enrollment->child->first()->child_previous_childcare ?? 'N/A'}}</p>
                
                <p class="text-gray-600"><strong>Birth Certification:</strong></p>
                    @if ($enrollment->child->first()->child_birth_cert)
                        <div class="flex items-center space-x-4">
                            <!-- View Link -->
                            <a href="{{ asset('storage/' . $enrollment->child->first()->child_birth_cert) }}" target="_blank"
                                class="bg-green-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-green-600">
                                View
                            </a>
                            <!-- Download Button -->
                            <a href="{{ asset('storage/' . $enrollment->child->first()->child_birth_cert) }}" download
                                class="bg-blue-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-blue-600">
                                Download
                            </a>
                        </div>
                    @else
                        <p class="text-gray-600">No birth certificate available.</p>
                    @endif

                    <p class="text-gray-600"><strong>Immunization Record:</strong></p>
                        @if ($enrollment->child->first()->child_immunization_record)
                            <div class="flex items-center space-x-4">
                               <!-- View Button -->
                                <a href="{{ asset('storage/' . $enrollment->child->first()->child_birth_cert) }}" target="_blank"
                                    class="bg-green-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-green-600">
                                    View
                                </a>
                                <!-- Download Button -->
                                <a href="{{ asset('storage/' . $enrollment->child->first()->child_birth_cert) }}" download
                                    class="bg-blue-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-blue-600">
                                    Download
                                </a>
                            </div>
                        @else
                            <p class="text-gray-600">No immunization record available.</p>
                        @endif

                        <p class="text-gray-600"><strong>Passport Photo:</strong></p>
                        @if ($enrollment->child->first()->child_photo)
                            <div class="flex items-center space-x-4">
                               <!-- View Button -->
                        
                                <a href="{{ asset('storage/' . $enrollment->child->first()->child_immunization_record) }}" target="_blank"
                                    class="bg-green-500 text-white px-1 py-1 w-32 text-center rounded hover:bg-green-600">
                                    View
                                </a>
                                <!-- Download Button -->
                                <a href="{{ asset('storage/' . $enrollment->child->first()->child_photo) }}" download
                                    class="bg-blue-500 text-white px-1 py-1 w-32  rounded text-center hover:bg-blue-600">
                                    Download
                                </a>
                            </div>
                        @else
                            <p class="text-gray-600">No passport photo available.</p>
                        @endif

            </div>
            
            @if($enrollment->registration_type==='parents')
            <!-- Parent Information -->
            <div class="bg-gray-100 p-3 mt-4 rounded-md font-bold text-gray-700">Parent Information - Father</div>
            <div class="mt-2 space-y-2">
                <p class="text-gray-600"><strong>Father Name:</strong>  {{ $enrollment->father->father_name}}</p>
                <p class="text-gray-600"><strong>Email Address</strong> {{ $enrollment->father->father_email}}</p>
                <p class="text-gray-600"><strong>Phone Number:</strong> {{ $enrollment->father->father_phoneNo}}</p>
                <p class="text-gray-600"><strong>IC:</strong> {{ $enrollment->father->father_ic}}</p>
                <p class="text-gray-600"><strong>Address:</strong> {{ $enrollment->father->father_address}}</p>
                <p class="text-gray-600"><strong>Nationality & Race:</strong> {{ $enrollment->father->father_nationality}} / {{ $enrollment->father->father_race}}</p>
                <p class="text-gray-600"><strong>Religion:</strong> {{ $enrollment->father->father_religion}}</p>
                <p class="text-gray-600"><strong>Occupation:</strong> {{ $enrollment->father->father_occupation}}</p>
                <p class="text-gray-600"><strong>Monthly Income:</strong> {{ $enrollment->father->father_monthly_income}}</p>
                <p class="text-gray-600"><strong>Staff Number:</strong> {{ $enrollment->father->father_staff_number}}</p>
                <p class="text-gray-600"><strong>PTJ:</strong> {{ $enrollment->father->father_ptj}}</p>
                <p class="text-gray-600"><strong>Office Number:</strong> {{ $enrollment->father->father_office_number}}</p>
            </div>

            <div class="bg-gray-100 p-3 mt-4 rounded-md font-bold text-gray-700">Parent Information - Mother</div>
            <div class="mt-2 space-y-2">
                <p class="text-gray-600"><strong>Mother Name:</strong>  {{ $enrollment->mother->mother_name}}</p>
                <p class="text-gray-600"><strong>Email Address</strong> {{ $enrollment->mother->mother_email}}</p>
                <p class="text-gray-600"><strong>Phone Number:</strong> {{ $enrollment->mother->mother_phoneNo}}</p>
                <p class="text-gray-600"><strong>IC:</strong> {{ $enrollment->mother->mother_ic}}</p>
                <p class="text-gray-600"><strong>Address:</strong> {{ $enrollment->mother->mother_address}}</p>
                <p class="text-gray-600"><strong>Nationality & Race:</strong> {{ $enrollment->mother->mother_nationality}} / {{ $enrollment->mother->mother_race}}</p>
                <p class="text-gray-600"><strong>Religion:</strong> {{ $enrollment->mother->mother_religion}}</p>
                <p class="text-gray-600"><strong>Occupation:</strong> {{ $enrollment->mother->mother_occupation}}</p>
                <p class="text-gray-600"><strong>Monthly Income:</strong> {{ $enrollment->mother->mother_monthly_income}}</p>
                <p class="text-gray-600"><strong>Staff Number:</strong> {{ $enrollment->mother->mother_staff_number}}</p>
                <p class="text-gray-600"><strong>PTJ:</strong> {{ $enrollment->mother->mother_ptj}}</p>
                <p class="text-gray-600"><strong>Office Number:</strong> {{ $enrollment->mother->mother_office_number}}</p>
            </div>
            
          
        @endif

        @if ($enrollment->registration_type==='guardian')
             <!-- Guardian Information -->
             <div class="bg-gray-100 p-3 mt-4 rounded-md font-bold text-gray-700">Parent Information - Father</div>
            <div class="mt-2 space-y-2">
                <p class="text-gray-600"><strong>Guardian Name:</strong>  {{ $enrollment->guardian->guardian_name}}</p>
                <p class="text-gray-600"><strong>Relation:</strong>  {{ $enrollment->guardian->guardian_relation}}</p>
                <p class="text-gray-600"><strong>Email Address</strong> {{ $enrollment->guardian->guardian_email}}</p>
                <p class="text-gray-600"><strong>Phone Number:</strong> {{ $enrollment->guardian->guardian_phoneNo}}</p>
                <p class="text-gray-600"><strong>IC:</strong> {{ $enrollment->guardian->guardian_ic}}</p>
                <p class="text-gray-600"><strong>Address:</strong> {{ $enrollment->guardian->guardian_address}}</p>
                <p class="text-gray-600"><strong>Nationality & Race:</strong> {{ $enrollment->guardian->guardian_nationality}} / {{ $enrollment->guardian->guardian_race}}</p>
                <p class="text-gray-600"><strong>Religion:</strong> {{ $enrollment->guardian->guardian_religion}}</p>
                <p class="text-gray-600"><strong>Occupation:</strong> {{ $enrollment->guardian->guardian_occupation}}</p>
                <p class="text-gray-600"><strong>Monthly Income:</strong> {{ $enrollment->guardian->guardian_monthly_income}}</p>
                <p class="text-gray-600"><strong>Staff Number:</strong> {{ $enrollment->guardian->guardian_staff_number}}</p>
                <p class="text-gray-600"><strong>PTJ:</strong> {{ $enrollment->guardian->guardian_ptj}}</p>
                <p class="text-gray-600"><strong>Office Number:</strong> {{ $enrollment->guardian->guardian_office_number}}</p>
            </div>
            @endif
            
           
   
            <!-- Action Buttons -->

            <a href="{{ route('childrenRegisterRequest') }}" class="bg-gray-400 text-white px-4 py-2 gap-2 rounded-md hover:bg-gray-500 inline-block text-center">
                Go Back
            </a>
            
        </div>
    </div>
</x-app-layout>
