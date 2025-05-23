<x-app-layout>
    
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payment') }}
            </h2>
            <button onclick="alert('Add Payment clicked!')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md text-sm">
                Add Payment
            </button>
        </div>
   

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <!-- Month Filter -->
                <label for="month-filter" class="block text-sm font-medium text-gray-700">Filter by Month:</label>
                <select id="month-filter" onchange="filterByMonth()" class="mt-1 block w-1/3 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">All</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>

            <div id="payment-list" class="space-y-4">
                <!-- Dummy Data -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200" data-month="01">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium">Payment 1</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">
                                    Parent: John Doe, Children: Jane Doe
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                Paid
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Due date: 15/01/2025
                        </div>
                        <div class="font-semibold">
                            RM100.00
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end gap-3">
                        <button onclick="alert('Send email clicked!')" class="text-gray-600 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </button>

                        <button onclick="alert('Edit payment clicked!')" class="text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>

                        <button onclick="if(confirm('Are you sure you want to delete this payment?')) alert('Delete clicked!')" class="text-red-600 hover:text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200" data-month="02">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium">Payment 2</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">
                                    Parent: Alice Smith, Children: Bob Smith
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Due date: 10/02/2025
                        </div>
                        <div class="font-semibold">
                            RM200.00
                        </div>
                    </div>

                    @if(auth()->user()->role==='admin')

                    <div class="mt-4 flex justify-end gap-3">
                        <button onclick="alert('Send email clicked!')" class="text-gray-600 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </button>

                        <button onclick="alert('Edit payment clicked!')" class="text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>

                        <button onclick="if(confirm('Are you sure you want to delete this payment?')) alert('Delete clicked!')" class="text-red-600 hover:text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterByMonth() {
            const selectedMonth = document.getElementById('month-filter').value;
            const payments = document.querySelectorAll('[data-month]');

            payments.forEach(payment => {
                if (!selectedMonth || payment.getAttribute('data-month') === selectedMonth) {
                    payment.style.display = '';
                } else {
                    payment.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>
