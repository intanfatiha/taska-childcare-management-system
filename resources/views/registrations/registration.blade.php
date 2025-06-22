
<x-guest-layout>
    <div class="min-h-screen bg-cover bg-center flex items-center justify-center px-4 md:px-12"
            style="background-color:rgb(238, 230, 245);">

    <div class="mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

        <div class="py-19">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg "></div>

                <div >
                    <!-- Logo and Title -->
                    <a href="/"><img src="{{ asset('assets/ppuk_logo.png') }}" alt="Tuition Centre Logo" style="width: 120px; height: auto;" class="mx-auto"></a>
                    <h1 class="text-3xl font-bold mb-3 text-center " > LITTLECARE: TASKA HIKMAH CHILDCARE</h1>
                    <h2 class="text-2xl font-semibold mb-4 text-center border-b pb-10">CHILDREN REGISTRATION FORM</h2>

                </div>
                     <form method="POST" action="{{ route('enrollment.store') }}"  enctype="multipart/form-data">
                        @csrf
                        <p class="mb-4 text-gray-600">Please complete the registeration form below.</p>

                        <!-- Registration Type
                        <label class="block mb-2">Registration Type</label>
                        <div class="flex space-x-4 mb-6">
                            <label class="inline-flex items-center">
                                <input type="radio" name="registration_type" value="parents" class="mr-2" checked onchange="toggleRegistrationType('parents')">
                                <span>Parents</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="registration_type" value="guardian" class="mr-2" onchange="toggleRegistrationType('guardian')">
                                <span>Guardian</span>
                            </label>
                        </div>
                        @error('registration_type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror -->

                        <!-- Choose Registration Type -->
                        <h2 class="text-lg font-semibold mb-3">Choose Registration Type</h2>
                        <div class="flex items-center justify-center space-x-6">
                            <!-- Parents Option -->
                            <label class="w-1/2 p-4 border border-gray-300 rounded-lg cursor-pointer hover:shadow-md">
                                <input type="radio" name="registration_type" value="parents" class="mr-2" checked onchange="toggleRegistrationType('parents')">
                                <span class="font-semibold text-gray-800">Parents</span>
                            </label>

                            <!-- Guardian Option -->
                            <label class="w-1/2 p-4 border border-gray-300 rounded-lg cursor-pointer hover:shadow-md">
                                <input type="radio" name="registration_type" value="guardian" class="mr-2" onchange="toggleRegistrationType('guardian')">
                                <span class="font-semibold text-gray-800">Guardian</span>
                            </label>
                        </div>

                        <br>

                        @error('registration_type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Parents Section -->

                        <div id="parents-section">
                        <div class="container mx-auto p-6 bg-white shadow-lg border border-gray-300 rounded-lg">
                            <!-- Father's Details -->

                            <h3 class="text-xl font-semibold mb-4 text-sky-700 flex items-center" style="background-color: #FFD3B6; padding: 5px; border-radius: 5px;"> <svg class="w-5 h-5 mr-2" fill="black" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg> Father's Information</h3>

                            <div class="grid grid-cols-2 gap-6 mb-6">
                                <!-- Left Column -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block mb-1">Name<span class="text-red-500">*</span></label>
                                        <input type="text" name="father_name" value="{{ old('father_name') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('father_name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Email<span class="text-red-500">*</span></label>
                                        <input type="email" name="father_email" value="{{ old('father_email') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('father_email')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Phone Number<span class="text-red-500">*</span></label>
                                        <input type="text" name="father_phoneno" value="{{ old('father_phoneno') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('father_phoneno')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">IC<span class="text-red-500">*</span></label>
                                        <input type="text" name="father_ic" value="{{ old('father_ic') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('father_ic')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Address<span class="text-red-500">*</span></label>
                                        <input type="text" name="father_address" value="{{ old('father_address') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('father_address')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Nationality<span class="text-red-500">*</span></label>
                                        <input type="text" name="father_nationality" value="{{ old('father_nationality') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('father_nationality')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block mb-1">Race<span class="text-red-500">*</span></label>
                                            <select name="father_race" class="border rounded px-2 py-1.5 w-full" required>
                                                <option value="">Select Race</option>
                                                <option value="Malay" {{ old('father_race') == 'Malay' ? 'selected' : '' }}>Malay</option>
                                                <option value="Chinese" {{ old('father_race') == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                                <option value="Indian" {{ old('father_race') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                                <option value="Others" {{ old('father_race') == 'Others' ? 'selected' : '' }}>Others</option>
                                            </select>
                                            @error('father_race')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                       <div>
                                        <label class="block mb-1">Religion<span class="text-red-500">*</span></label>
                                        <select name="father_religion" class="border rounded px-2 py-1.5 w-full" required>
                                            <option value="">Select Religion</option>
                                            <option value="Islam" {{ old('father_religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Christian" {{ old('father_religion') == 'Christian' ? 'selected' : '' }}>Christian</option>
                                            <option value="Hindu" {{ old('father_religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ old('father_religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Others" {{ old('father_religion') == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                        @error('father_religion')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    </div>

                                    <div>
                                        <label class="block mb-1">Occupation<span class="text-red-500">*</span></label>
                                        <input type="text" name="father_occupation" value="{{ old('father_occupation') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('father_occupation')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Monthly Income<span class="text-red-500">*</span></label>
                                        <input type="number" name="father_income" value="{{ old('father_income') }}"
                                            class="border rounded px-2 py-1.5 w-full" min="0" step="0.01" required>
                                        @error('father_income')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block mb-2">UTHM Staff<span class="text-red-500">*</span></label>
                                        <div class="flex space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="father_uthm_staff" value="yes" class="mr-2" onclick="toggleStaffFields(true, 'father')">
                                                <span>Yes</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="father_uthm_staff" value="no" class="mr-2" onclick="toggleStaffFields(false, 'father')">
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block mb-1">Staff Number</label>
                                        <input type="text" name="father_staff_number" id="father_staff_number"
                                            value="{{ old('father_staff_number') }}"
                                            class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" disabled>
                                        @error('father_staff_number')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">PTJ</label>
                                        <input type="text" name="father_ptj" id="father_ptj"
                                            value="{{ old('father_ptj') }}"
                                            class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" disabled>
                                        @error('father_ptj')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Office Number</label>
                                        <input type="text" name="father_office_number" id="father_office_number"
                                            value="{{ old('father_office_number') }}"
                                            class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" disabled>
                                        @error('father_office_number')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h3 class="text-xl font-semibold mb-4 text-sky-700 flex items-center" style="background-color: #FFD3B6; padding: 5px; border-radius: 5px;"> <svg class="w-5 h-5 mr-2" fill="black" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg> Mother's Information</h3>
                            <div class="grid grid-cols-2 gap-6 mb-6">

                                <div class="space-y-4">
                                    <div>
                                        <label class="block mb-1">Name<span class="text-red-500">*</span></label>
                                        <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('mother_name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Email<span class="text-red-500">*</span></label>
                                        <input type="email" name="mother_email" value="{{ old('mother_email') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('mother_email')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Phone Number<span class="text-red-500">*</span></label>
                                        <input type="text" name="mother_phoneno" value="{{ old('mother_phoneno') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('mother_phoneno')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">IC<span class="text-red-500">*</span></label>
                                        <input type="text" name="mother_ic" value="{{ old('mother_ic') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('mother_ic')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Address<span class="text-red-500">*</span></label> 
                                        <input type="text" name="mother_address" value="{{ old('mother_address') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('mother_address')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div>
                                        <label class="block mb-1">Nationality<span class="text-red-500">*</span></label>
                                        <input type="text" name="mother_nationality" value="{{ old('mother_nationality') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('mother_nationality')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">

                                    <div>
                                        <label class="block mb-1">Race<span class="text-red-500">*</span></label>
                                        <select name="mother_race" class="border rounded px-2 py-1.5 w-full" required>
                                            <option value="">Select Race</option>
                                            <option value="Malay" {{ old('mother_race') == 'Malay' ? 'selected' : '' }}>Malay</option>
                                            <option value="Chinese" {{ old('mother_race') == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                            <option value="Indian" {{ old('mother_race') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                            <option value="Others" {{ old('mother_race') == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                        @error('mother_race')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Religion<span class="text-red-500">*</span></label>
                                        <select name="mother_religion" class="border rounded px-2 py-1.5 w-full" required>
                                            <option value="">Select Religion</option>
                                            <option value="Islam" {{ old('mother_religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Christian" {{ old('mother_religion') == 'Christian' ? 'selected' : '' }}>Christian</option>
                                            <option value="Hindu" {{ old('mother_religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ old('mother_religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Others" {{ old('mother_religion') == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                        @error('mother_religion')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    </div>

                                    <div>
                                    <label class="block mb-1">Occupation<span class="text-red-500">*</span></label>
                                    <input type="text" name="mother_occupation" value="{{ old('mother_occupation') }}"
                                        class="border rounded px-2 py-1.5 w-full" required>
                                    @error('mother_occupation')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Monthly Income<span class="text-red-500">*</span></label>
                                        <input type="number" name="mother_income" value="{{ old('mother_income') }}"
                                            class="border rounded px-2 py-1.5 w-full" min="0" step="0.01" required>
                                        @error('mother_income')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                 </div>

                                <!-- Right Column -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block mb-2">UTHM Staff<span class="text-red-500">*</span></label>
                                        <div class="flex space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="mother_uthm_staff" value="yes" class="mr-2" onclick="toggleStaffFields(true,'mother')">
                                                <span>Yes</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="mother_uthm_staff" value="no" class="mr-2" onclick="toggleStaffFields(false,'mother')">
                                                <span>No</span>
                                            </label>
                                        </div>
                                            @error('mother_uthm_staff')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                    </div>

                                        <div>
                                            <label class="block mb-1">Staff Number</label>
                                            <input type="text" name="mother_staff_number" id="mother_staff_number" value="{{ old('mother_staff_number') }}"
                                                class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" >
                                            @error('mother_staff_number')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">PTJ</label>
                                            <input type="text" name="mother_ptj" id="mother_ptj" value="{{ old('mother_ptj') }}"
                                                class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" >
                                            @error('mother_ptj')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">Office Number</label>
                                            <input type="text" name="mother_office_number" id="mother_office_number" value="{{ old('mother_office_number') }}"
                                                class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" >
                                            @error('mother_office_number')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                </div>
                            </div>
                            </div>
                            </div>


                            <!-- Guardian Section -->
                            <div id="guardian-section" style="display: none;">
                            <div class="container mx-auto p-6 bg-white shadow-lg border border-gray-300 rounded-lg">

                            <h3 class="text-xl font-semibold mb-4 text-sky-700 flex items-center" style="background-color: #FFD3B6; padding: 5px; border-radius: 5px;"> <svg class="w-5 h-5 mr-2" fill="black" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                     </svg> Guardian's Information
                            </h3>

                                <div class="grid grid-cols-2 gap-6 mb-6">
                                    <div class="space-y-4">

                                        <div>
                                            <label class="block mb-1">Guardian Name<span class="text-red-500">*</span></label>
                                            <input type="text" name="guardian_name" value="{{ old('guardian_name') }}"
                                                class="border rounded px-2 py-1.5 w-full">
                                            @error('guardian_name')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">Relation with child<span class="text-red-500">*</span></label>
                                            <input type="text" name="guardian_relation" value="{{ old('guardian_relation') }}"
                                                class="border rounded px-2 py-1.5 w-full" required>
                                            @error('guardian_relation')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">Email<span class="text-red-500">*</span></label>
                                            <input type="email" name="guardian_email" value="{{ old('guardian_email') }}"
                                                class="border rounded px-2 py-1.5 w-full" required>
                                            @error('guardian_email')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">Phone Number<span class="text-red-500">*</span></label>
                                            <input type="text" name="guardian_phoneNo" value="{{ old('guardian_phoneNo') }}"
                                                class="border rounded px-2 py-1.5 w-full" required>
                                            @error('guardian_phoneNo')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">IC<span class="text-red-500">*</span></label>
                                            <input type="text" name="guardian_ic" value="{{ old('guardian_ic') }}"
                                                class="border rounded px-2 py-1.5 w-full" required>
                                            @error('guardian_ic')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">Address<span class="text-red-500">*</span></label>
                                            <input type="text" name="guardian_address" value="{{ old('guardian_address') }}"
                                                class="border rounded px-2 py-1.5 w-full" required>
                                            @error('guardian_address')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">Nationality<span class="text-red-500">*</span></label>
                                            <input type="text" name="guardian_nationality" value="{{ old('guardian_nationality') }}"
                                                class="border rounded px-2 py-1.5 w-full" required>
                                            @error('guardian_nationality')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">

                                        <div>
                                            <label class="block mb-1">Race<span class="text-red-500">*</span></label>
                                            <select name="guardian_race" class="border rounded px-2 py-1.5 w-full" >
                                                <option value="">Select Race</option>
                                                <option value="Malay" {{ old('guardian_race') == 'Malay' ? 'selected' : '' }}>Malay</option>
                                                <option value="Chinese" {{ old('guardian_race') == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                                <option value="Indian" {{ old('guardian_race') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                                <option value="Others" {{ old('guardian_race') == 'Others' ? 'selected' : '' }}>Others</option>
                                            </select>
                                            @error('guardian_race')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">Religion<span class="text-red-500">*</span></label>
                                            <select name="guardian_religion" class="border rounded px-2 py-1.5 w-full" >
                                                <option value="">Select Religion</option>
                                                <option value="Islam" {{ old('guardian_religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                <option value="Christian" {{ old('guardian_religion') == 'Christian' ? 'selected' : '' }}>Christian</option>
                                                <option value="Hindu" {{ old('guardian_religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                <option value="Buddha" {{ old('guardian_religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                <option value="Others" {{ old('guardian_religion') == 'Others' ? 'selected' : '' }}>Others</option>
                                            </select>
                                            @error('guardian_religion')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        </div>

                                        <div>
                                            <label class="block mb-1">Occupation<span class="text-red-500">*</span></label>
                                            <input type="text" name="guardian_occupation" value="{{ old('guardian_occupation') }}"
                                                class="border rounded px-2 py-1.5 w-full" required>
                                            @error('guardian_occupation')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">Monthly Income<span class="text-red-500">*</span></label>
                                            <input type="number" name="guardian_monthly_income" value="{{ old('guardian_monthly_income') }}"
                                                class="border rounded px-2 py-1.5 w-full" min="0" step="0.01" required>
                                            @error('guardian_monthly_income')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block mb-2">UTHM Staff<span class="text-red-500">*</span></label>
                                                <div class="flex space-x-4">
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="guardian_uthm_staff" value="yes" class="mr-2" onclick="toggleStaffFields(true,'guardian')">
                                                        <span>Yes</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="guardian_uthm_staff" value="no" class="mr-2" onclick="toggleStaffFields(false,'guardian')">
                                                        <span>No</span>
                                                    </label>
                                                </div>
                                                @error('guardian_uthm_staff')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">Staff Number</label>
                                            <input type="text" name="guardian_staff_number" id="guardian_staff_number" value="{{ old('guardian_staff_number') }}"
                                                class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" >
                                            @error('guardian_staff_number')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">PTJ</label>
                                            <input type="text" name="guardian_ptj" id="guardian_ptj" value="{{ old('guardian_ptj') }}"
                                                class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" >
                                            @error('guardian_ptj')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1">Office Number</label>
                                            <input type="text" name="guardian_office_number" id="guardian_office_number" value="{{ old('guardian_office_number') }}"
                                                class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" >
                                            @error('guardian_office_number')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <!-- Child Information -->

                            <div class="container mx-auto p-6 bg-white shadow-lg border border-gray-300 rounded-lg">
                            <h3 class="text-xl font-semibold mb-4 text-sky-700 flex items-center" style="background-color: #FFD3B6; padding: 5px; border-radius: 5px;"> <svg class="w-5 h-5 mr-2" fill="black" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg> Child's Information
                            </h3>
                            <div class="grid grid-cols-2 gap-6 mb-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block mb-1">Full Name<span class="text-red-500">*</span></label>
                                        <input type="text" name="child_name" value="{{ old('child_name') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('child_name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Birth Date<span class="text-red-500">*</span></label>
                                        <input type="date" id="child_birth_date" name="child_birth_date" value="{{ old('child_birth_date') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('child_birth_date')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Child Gender<span class="text-red-500">*</span></label>
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
                                        <input type="text" id="child_age" name="child_age" value="{{ old('child_age') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('child_age')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Number of Siblings<span class="text-red-500">*</span></label>
                                        <input type="number" name="child_siblings_count" value="{{ old('child_siblings_count') }}"
                                            class="border rounded px-2 py-1.5 w-full" min="0">
                                        @error('child_siblings_count')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div>
                                        <label class="block mb-1">Child Position<span class="text-red-500">*</span></label>
                                        <input type="number" name="child_position" value="{{ old('child_position') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('child_position')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Address<span class="text-red-500">*</span></label>
                                        <input type="text" name="child_address" value="{{ old('child_address') }}"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('child_address')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Allergies (if any)</label>
                                        <input type="text" name="child_allergies" value="{{ old('child_allergies') }}"
                                            class="border rounded px-2 py-1.5 w-full" >
                                        @error('child_allergies')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Medical Conditions (if any)</label>
                                        <input type="text" name="child_medical_conditions" value="{{ old('child_medical_conditions') }}"
                                            class="border rounded px-2 py-1.5 w-full" >
                                        @error('child_medical_conditions')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block mb-1">Previous Childcare/School (if any)</label>
                                        <input type="text" name="child_previous_childcare" value="{{ old('child_previous_childcare') }}"
                                            class="border rounded px-2 py-1.5 w-full" >
                                        @error('child_previous_childcare')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Right Column -->
                                <div class="space-y-4">

                                    <div>
                                        <label class="block mb-1">Child Passport Photo<span class="text-red-500">*</span></label>
                                        <input type="file" name="child_photo" accept="image/*"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('child_photo')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Birth Certificate / MyKid<span class="text-red-500">*</span></label>
                                        <input type="file" name="birth_cert" accept="image/*"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('birth_cert')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1">Immunization Record<span class="text-red-500">*</span></label>
                                        <input type="file" name="immunization_record" accept="image/*"
                                            class="border rounded px-2 py-1.5 w-full" required>
                                        @error('immunization_record')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                                <div class="flex justify-end mt-6">
                                    <button type="submit" class="bg-blue-500 text-black px-6 py-2 rounded hover:bg-blue-600"> Submit </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
</div>


    <script>

        toggleRegistrationType('parents');
                function toggleRegistrationType(type) {
                    const parentsSection = document.getElementById('parents-section');
                    const guardianSection = document.getElementById('guardian-section');

                    if (type === 'parents') {
                        parentsSection.style.display = 'block';
                        guardianSection.style.display = 'none';

                        // Make parents fields required
                        document.querySelectorAll('#parents-section input').forEach(input => {
                            input.setAttribute('required', 'required');
                        });

                        // Remove required from guardian fields
                        document.querySelectorAll('#guardian-section input').forEach(input => {
                            input.removeAttribute('required');
                        });
                    } else {
                        parentsSection.style.display = 'none';
                        guardianSection.style.display = 'block';

                        // Remove required from parents fields
                        document.querySelectorAll('#parents-section input, #parents-section select, #parents-section textarea').forEach(input => {
                            input.removeAttribute('required');
                        });

                        // Make guardian fields required
                        document.querySelectorAll('#guardian-section input, #guardian-section select, #guardian-section textarea').forEach(input => {
                            input.setAttribute('required', 'required');
                        });
                    }
                }

                function toggleStaffFields(isEnabled, type) {
                    const staffNumber = document.getElementById(`${type}_staff_number`);
                    const ptj = document.getElementById(`${type}_ptj`);
                    const officeNumber = document.getElementById(`${type}_office_number`);

                    if (staffNumber) staffNumber.disabled = !isEnabled;
                    if (ptj) ptj.disabled = !isEnabled;
                    if (officeNumber) officeNumber.disabled = !isEnabled;
                }

              
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
    </div>
            
</x-guest-layout>
