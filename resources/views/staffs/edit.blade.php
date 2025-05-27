<x-app-layout>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
                <div>
                    <h2 class="text-3xl font-bold text-indigo-800">
                        {{ __('Edit Staff') }}
                    </h2>
                    <p class="text-gray-600 mt-1">Update the staff's information below</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                <!-- Success Message -->
                @if(session('message'))
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <p class="text-green-700 text-sm">{{ session('message') }}</p>
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('staffs.update', $staff->id) }}" method="POST" class="p-6 space-y-3">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information Section -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                            Personal Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Staff Name -->
                            <div>
                                <label for="staff_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="staff_name" 
                                       id="staff_name" 
                                       value="{{ old('staff_name', $staff->staff_name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                       required>
                            </div>

                            <!-- IC Number -->
                            <div>
                                <label for="staff_ic" class="block text-sm font-medium text-gray-700 mb-1">
                                    IC Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="staff_ic" 
                                       id="staff_ic" 
                                       value="{{ old('staff_ic', $staff->staff_ic) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                            Contact Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div>
                                <label for="staff_email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="staff_email" 
                                       id="staff_email" 
                                       value="{{ old('staff_email', $staff->staff_email) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                       required>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="staff_phoneno" class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       name="staff_phoneno" 
                                       id="staff_phoneno" 
                                       value="{{ old('staff_phoneno', $staff->staff_phoneno) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                       required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="staff_address" class="block text-sm font-medium text-gray-700 mb-1">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <textarea name="staff_address" 
                                      id="staff_address" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                      required>{{ old('staff_address', $staff->staff_address) }}</textarea>
                        </div>
                    </div>

                    <!-- Form Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end items-center gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('staffs.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                            Update Staff
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
