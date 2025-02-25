<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4 text-center border-b pb-2">CHILDREN REGISTRATION</h2>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form action="{{ route('childrens.index') }}" method="POST" >
                    @csrf
                    <p class="mb-4 text-gray-600">Fill in the register form below</p>
                    <h3 class="text-lg font-medium mb-4">Guardian's details:</h3>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-1">Name</label>
                                <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" 
                                    class="border rounded px-2 py-1.5 w-full" >
                                @error('guardian_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1">Email</label>
                                <input type="email" name="guardian_email" value="{{ old('guardian_email') }}" 
                                    class="border rounded px-2 py-1.5 w-full" >
                                @error('guardian_email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1">Phone Number</label>
                                <input type="text" name="guardian_phoneNo" value="{{ old('guardian_phoneNo') }}" 
                                    class="border rounded px-2 py-1.5 w-full" >
                                @error('guardian_phoneno')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1">IC</label>
                                <input type="text" name="guardian_ic" value="{{ old('guardian_ic') }}" 
                                    class="border rounded px-2 py-1.5 w-full" >
                                @error('guardian_ic')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1">Address</label>
                                <input type="text" name="guardian_address" value="{{ old('guardian_address') }}" 
                                    class="border rounded px-2 py-1.5 w-full" >
                                @error('guardian_address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1">Nationality</label>
                                <input type="text" name="guardian_nationality" value="{{ old('guardian_nationality') }}" 
                                    class="border rounded px-2 py-1.5 w-full" >
                                @error('guardian_nationality')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-1">Race</label>
                                    <input type="text" name="guardian_race" value="{{ old('guardian_race') }}" 
                                        class="border rounded px-2 py-1.5 w-full" >
                                    @error('guardian_race')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1">Religion</label>
                                    <input type="text" name="guardian_religion" value="{{ old('guardian_religion') }}" 
                                        class="border rounded px-2 py-1.5 w-full" >
                                    @error('guardian_religion')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block mb-1">Occupation</label>
                                <input type="text" name="guardian_occupation" value="{{ old('guardian_occupation') }}" 
                                    class="border rounded px-2 py-1.5 w-full" >
                                @error('guardian_occupation')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-2">Monthly Income</label>
                                <select name="guardian_income" class="border rounded-lg px-2 py-1.5 w-full" >
                                    <option value="" disabled selected>Select income range</option>
                                    <option value="below_2000" {{ old('guardian_income') == 'below_2000' ? 'selected' : '' }}>Below RM2,000</option>
                                    <option value="2000_3999" {{ old('guardian_income') == '2000_3999' ? 'selected' : '' }}>RM2,000 - RM3,999</option>
                                    <option value="4000_5999" {{ old('guardian_income') == '4000_5999' ? 'selected' : '' }}>RM4,000 - RM5,999</option>
                                    <option value="6000_7999" {{ old('guardian_income') == '6000_7999' ? 'selected' : '' }}>RM6,000 - RM7,999</option>
                                    <option value="8000_9999" {{ old('guardian_income') == '8000_9999' ? 'selected' : '' }}>RM8,000 - RM9,999</option>
                                    <option value="10000_above" {{ old('guardian_income') == '10000_above' ? 'selected' : '' }}>RM10,000 and above</option>
                                </select>
                                @error('guardian_income')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2">UTHM Staff</label>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="uthm_staff" value="yes" class="mr-2" onchange="toggleStaffFields(true)">
                                        <span>Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="uthm_staff" value="no" class="mr-2" onchange="toggleStaffFields(false)">
                                        <span>No</span>
                                    </label>
                                </div>
                                @error('uthm_staff')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1">Staff Number</label>
                                <input type="text" name="staff_number" id="staff_number" value="{{ old('staff_number') }}" 
                                    class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" disabled>
                                @error('staff_number')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1">PTJ</label>
                                <input type="text" name="ptj" id="ptj" value="{{ old('ptj') }}" 
                                    class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" disabled>
                                @error('ptj')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1">Office Number</label>
                                <input type="text" name="office_number" id="office_number" value="{{ old('office_number') }}" 
                                    class="border rounded px-2 py-1.5 w-full disabled:bg-gray-200" disabled>
                                @error('office_number')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <script>
                                function toggleStaffFields(isEnabled) {
                                    document.getElementById('staff_number').disabled = !isEnabled;
                                    document.getElementById('ptj').disabled = !isEnabled;
                                    document.getElementById('office_number').disabled = !isEnabled;
                                }
                            </script>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                                Next
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
