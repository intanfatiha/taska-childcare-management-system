<x-app-layout>
    <div class="mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="py-19">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"></div>
                <div>
                    <!-- Logo and Title -->
                    <a href="/"><img src="{{ asset('assets/ppuk_logo.png') }}" alt="Tuition Centre Logo" style="width: 120px; height: auto;" class="mx-auto"></a>
                    <h1 class="text-3xl font-bold mb-3 text-center">LITTLECARE: TASKA HIKMAH CHILDCARE</h1>
                    <h2 class="text-2xl font-semibold mb-4 text-center border-b pb-10">NEW CHILD REGISTRATION FORM</h2>
                </div>
                <form method="POST" action="{{ route('enrollment.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Hidden Parent/Guardian Info -->
                    <input type="hidden" name="registration_type" value="{{ $registration_type }}">
                    @if($registration_type === 'parents' && $parentRecord)
                        <input type="hidden" name="registration_type" value="parents">

                        <input type="hidden" name="father_id" value="{{ $parentRecord->father_id }}">
                        <input type="hidden" name="father_name" value="{{ $parentRecord->father->father_name }}">
                        <input type="hidden" name="father_email" value="{{$parentRecord->father->father_email }}">
                        <input type="hidden" name="father_phoneno" value="{{ $parentRecord->father->father_phoneNo }}">
                        <input type="hidden" name="father_ic" value="{{ $parentRecord->father->father_ic }}">
                        <input type="hidden" name="father_address" value="{{ $parentRecord->father->father_address }}">
                        <input type="hidden" name="father_nationality" value="{{$parentRecord->father->father_nationality }}">
                        <input type="hidden" name="father_race" value="{{ $parentRecord->father->father_race }}">
                        <input type="hidden" name="father_religion" value="{{ $parentRecord->father->father_religion }}">
                        <input type="hidden" name="father_occupation" value="{{ $parentRecord->father->father_occupation }}">
                        <input type="hidden" name="father_income" value="{{ $parentRecord->father->father_monthly_income }}">
                        <input type="hidden" name="father_staff_number" value="{{ $parentRecord->father->father_staff_number }}">
                        <input type="hidden" name="father_ptj" value="{{ $parentRecord->father->father_ptj }}">
                        <input type="hidden" name="father_office_number" value="{{ $parentRecord->father->father_office_number }}">
                
                        <input type="hidden" name="mother_id" value="{{ $parentRecord->mother_id }}">
                        <input type="hidden" name="mother_name" value="{{ $parentRecord->mother->mother_name }}">
                        <input type="hidden" name="mother_email" value="{{ $parentRecord->mother->mother_email }}">
                        <input type="hidden" name="mother_phoneno" value="{{$parentRecord->mother->mother_phoneNo }}">
                        <input type="hidden" name="mother_ic" value="{{ $parentRecord->mother->mother_ic }}">
                        <input type="hidden" name="mother_address" value="{{ $parentRecord->mother->mother_address }}">
                        <input type="hidden" name="mother_nationality" value="{{ $parentRecord->mother->mother_nationality }}">
                        <input type="hidden" name="mother_race" value="{{ $parentRecord->mother->mother_race }}">
                        <input type="hidden" name="mother_religion" value="{{ $parentRecord->mother->mother_religion }}">
                        <input type="hidden" name="mother_occupation" value="{{ $parentRecord->mother->mother_occupation }}">
                        <input type="hidden" name="mother_income" value="{{$parentRecord->mother->mother_monthly_income }}">
                        <input type="hidden" name="mother_staff_number" value="{{ $parentRecord->mother->mother_staff_number }}">
                        <input type="hidden" name="mother_ptj" value="{{ $parentRecord->mother->mother_ptj }}">
                        <input type="hidden" name="mother_office_number" value="{{ $parentRecord->mother->mother_office_number }}">
                    @endif
                    @if($guardian)
                        <input type="hidden" name="guardian_id" value="{{ $guardian->id }}">
                        <input type="hidden" name="guardian_name" value="{{ $guardian->guardian_name }}">
                        <input type="hidden" name="guardian_relation" value="{{ $guardian->guardian_relation }}">
                        <input type="hidden" name="guardian_email" value="{{ $guardian->guardian_email }}">
                        <input type="hidden" name="guardian_phoneNo" value="{{ $guardian->guardian_phoneNo }}">
                        <input type="hidden" name="guardian_ic" value="{{ $guardian->guardian_ic }}">
                        <input type="hidden" name="guardian_address" value="{{ $guardian->guardian_address }}">
                        <input type="hidden" name="guardian_nationality" value="{{ $guardian->guardian_nationality }}">
                        <input type="hidden" name="guardian_race" value="{{ $guardian->guardian_race }}">
                        <input type="hidden" name="guardian_religion" value="{{ $guardian->guardian_religion }}">
                        <input type="hidden" name="guardian_occupation" value="{{ $guardian->guardian_occupation }}">
                        <input type="hidden" name="guardian_monthly_income" value="{{ $guardian->guardian_monthly_income }}">
                        <input type="hidden" name="guardian_staff_number" value="{{ $guardian->guardian_staff_number }}">
                        <input type="hidden" name="guardian_ptj" value="{{ $guardian->guardian_ptj }}">
                        <input type="hidden" name="guardian_office_number" value="{{ $guardian->guardian_office_number }}">

                       
                    @endif

                    <!-- Child Information (same as registration.blade.php) -->
                    <div class="container mx-auto p-6 bg-white shadow-lg border border-gray-300 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-sky-700 flex items-center" style="background-color: #FFD3B6; padding: 5px; border-radius: 5px;">
                            <svg class="w-5 h-5 mr-2" fill="black" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg> Child's Information
                        </h3>
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block mb-1">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="child_name" value="{{ old('child_name') }}" class="border rounded px-2 py-1.5 w-full" required>
                                    @error('child_name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Birth Date <span class="text-red-500">*</span></label>
                                    <input type="date" id="child_birth_date" name="child_birth_date" value="{{ old('child_birth_date') }}" class="border rounded px-2 py-1.5 w-full" required>
                                    @error('child_birth_date')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Child Gender <span class="text-red-500">*</span></label>
                                    <select name="child_gender" class="border rounded px-2 py-1.5 w-full" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('child_gender') == 'Male' ? 'selected':''}}>Male</option>
                                        <option value="Female" {{ old('child_gender') == 'Female' ? 'selected':''}}>Female</option>
                                    </select>
                                    @error('child_gender')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Age (Year old)<span class="text-red-500">*</span></label>
                                    <input type="text" id="child_age" name="child_age" value="{{ old('child_age') }}" class="border rounded px-2 py-1.5 w-full" required>
                                    @error('child_age')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Number of Siblings <span class="text-red-500">*</span></label>
                                    <input type="number" name="child_siblings_count" value="{{ old('child_siblings_count') }}" class="border rounded px-2 py-1.5 w-full" min="0">
                                    @error('child_siblings_count')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Child Position <span class="text-red-500">*</span></label>
                                    <input type="number" name="child_position" value="{{ old('child_position') }}" class="border rounded px-2 py-1.5 w-full" required>
                                    @error('child_position')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Address <span class="text-red-500">*</span></label>
                                    <input type="text" name="child_address" value="{{ old('child_address') }}" class="border rounded px-2 py-1.5 w-full" required>
                                    @error('child_address')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Allergies (if any)</label>
                                    <input type="text" name="child_allergies" value="{{ old('child_allergies') }}" class="border rounded px-2 py-1.5 w-full">
                                    @error('child_allergies')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Medical Conditions (if any)</label>
                                    <input type="text" name="child_medical_conditions" value="{{ old('child_medical_conditions') }}" class="border rounded px-2 py-1.5 w-full">
                                    @error('child_medical_conditions')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Previous Childcare/School (if any)</label>
                                    <input type="text" name="child_previous_childcare" value="{{ old('child_previous_childcare') }}" class="border rounded px-2 py-1.5 w-full">
                                    @error('child_previous_childcare')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block mb-1">Child Passport Photo <span class="text-red-500">*</span></label>
                                    <input type="file" name="child_photo" accept="image/*" class="border rounded px-2 py-1.5 w-full" required>
                                    @error('child_photo')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Birth Certificate / MyKid <span class="text-red-500">*</span></label>
                                    <input type="file" name="birth_cert" accept="image/*" class="border rounded px-2 py-1.5 w-full" required>
                                    @error('birth_cert')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Immunization Record <span class="text-red-500">*</span></label>
                                    <input type="file" name="immunization_record" accept="image/*" class="border rounded px-2 py-1.5 w-full" required>
                                    @error('immunization_record')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-blue-500 text-black px-6 py-2 rounded hover:bg-blue-600"> Submit </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
              
        document.getElementById('child_birth_date').addEventListener('change', function() {
            const birthDate = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            const d = today.getDate() - birthDate.getDate();

            // If birthday hasn't occurred yet this year, subtract one year
            if (m < 0 || (m === 0 && d < 0)) {
                age--;
            }

            // If less than 1 year old, show in decimal (months/12)
            if (age < 1) {
                const months = (today.getFullYear() - birthDate.getFullYear()) * 12 + (today.getMonth() - birthDate.getMonth());
                // If birthday day hasn't occurred yet this month, subtract one month
                let adjMonths = months;
                if (today.getDate() < birthDate.getDate()) {
                    adjMonths--;
                }
                const decimalAge = Math.max(0, (adjMonths / 12)).toFixed(1);
                document.getElementById('child_age').value = decimalAge;
            } else {
                document.getElementById('child_age').value = age;
            }
        });

    </script>
</x-app-layout>