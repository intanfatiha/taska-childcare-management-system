<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Register New Staff</h2>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('staffs.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="staff_name" class="block text-sm font-medium text-gray-700">Staff Name</label>
                        <input type="text" name="staff_name" id="staff_name" value="{{ old('staff_name') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="staff_ic" class="block text-sm font-medium text-gray-700">IC</label>
                        <input type="text" name="staff_ic" id="staff_ic" value="{{ old('staff_ic') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="staff_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="staff_email" id="staff_email" value="{{ old('staff_email') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="staff_phoneno" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="staff_phoneno" id="staff_phoneno" value="{{ old('staff_phoneno') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div> 

                    <div>
                        <label for="staff_address" class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea name="staff_address" id="staff_address" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>{{ old('staff_address') }}</textarea>
                    </div>

                    <!-- <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" value="{{ old('password') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div> -->

                

                <div class="flex justify-between mt-4">
                        <a href="{{ route('staffs.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500 inline-block text-center">
                            Go Back
                        </a>
                        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                            Submit
                        </button>
                    </div>
                      
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
