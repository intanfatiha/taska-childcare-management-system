<x-app-layout>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
                <div>
                    <h2 class="text-3xl font-bold text-indigo-800">
                        {{ __('Register New Staff') }}
                    </h2>
                    <p class="text-gray-600 mt-1">Fill in the staff information below</p>
                </div>
            </div>


            <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
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
                <form action="{{ route('staffs.store') }}" method="POST" class="p-6 space-y-3">
                    @csrf
                    
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
                                       value="{{ old('staff_name') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       placeholder="Enter full name"
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
                                       value="{{ old('staff_ic') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       placeholder="Ex: 123456121234"
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
                                       value="{{ old('staff_email') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       placeholder="example@email.com"
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
                                       value="{{ old('staff_phoneno') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       placeholder="Ex: 0123456789"
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
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                      placeholder="Enter full address"
                                      required>{{ old('staff_address') }}</textarea>
                        </div>
                    </div>

                    <!-- Account Information Note -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Account Information</h3>
                                <p class="mt-1 text-sm text-blue-700">
                                    Login credentials will be automatically generated and sent to the staff's email address after registration.
                                </p>
                            </div>
                        </div>
                    </div>

                     <!-- Form Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end items-center gap-4 pt-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-3 mt-6">
                        <a href="{{ route('staffs.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                            Register Staff
                        </button>
                    </div>


                    
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-format IC number
        // document.getElementById('staff_ic').addEventListener('input', function(e) {
        //     let value = e.target.value.replace(/\D/g, '');
        //     if (value.length >= 6) {
        //         value = value.substring(0, 6) + '-' + value.substring(6);
        //     }
        //     if (value.length >= 9) {
        //         value = value.substring(0, 9) + '-' + value.substring(9, 13);
        //     }
        //     e.target.value = value;
        // });

        // // Auto-format phone number
        // document.getElementById('staff_phoneno').addEventListener('input', function(e) {
        //     let value = e.target.value.replace(/\D/g, '');
        //     if (value.length >= 3) {
        //         value = value.substring(0, 3) + '-' + value.substring(3);
        //     }
        //     if (value.length >= 7) {
        //         value = value.substring(0, 7) + '-' + value.substring(7, 11);
        //     }
        //     e.target.value = value;
        // });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[class*="bg-red-50"], [class*="bg-green-50"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease-out';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</x-app-layout>