<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            {{-- Header Section --}}
            <div class="bg-blue-600 text-white p-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-4xl font-bold flex items-center">
                        <span class="material-icons mr-4 text-5xl">Payment Management</span>
                        
                    </h1>
                    <div class="flex items-center space-x-4">
                        @if(auth()->check())
                            <div class="bg-blue-500 rounded-full p-2">
                                <span class="material-icons text-white">notifications</span>
                            </div>
                            <div class="bg-blue-500 rounded-full p-2">
                                <span class="material-icons text-white">account_circle</span>
                            </div>
                        @endif
                    </div>
                </div>
                <h2 class="text-2xl mt-4 flex items-center">
                    <span class="material-icons mr-3"></span>
                    Payment Dashboard
                </h2>
            </div>

            <div class="p-6">
                <div class="mb-6 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <label for="month-filter" class="text-gray-700 font-semibold flex items-center">
                            <span class="material-icons mr-2"></span>
                            Filter by Month
                        </label>
                        <select 
                            id="month-filter" 
                            onchange="filterByMonth()" 
                            class="bg-blue-50 border border-blue-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5"
                        >
                            <option value="">All Months</option>
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

                    @if(auth()->user()->role === 'admin')
                        <button 
                            onclick="openAddPaymentModal()"
                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg flex items-center"
                        >
                            <span class="material-icons mr-2">add_circle</span>
                            Add Payment
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead class="bg-blue-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Parents</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Children</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Payment (RM)</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Status</th>
                                @if(auth()->user()->role === 'admin')
                                    <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="payment-list">
                            @foreach($payments as $payment)
                                <tr 
                                    data-month="{{ date('m', strtotime($payment->due_date)) }}" 
                                    class="border-b hover:bg-blue-50 transition-colors"
                                >
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <div class="flex items-center">
                                            <span class="material-icons mr-2 text-blue-500">family_restroom</span>
                                            {{ $payment->parent_names }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <div class="flex items-center">
                                            <span class="material-icons mr-2 text-green-500">child_care</span>
                                            {{ $payment->child_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ number_format($payment->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ date('d/m/Y', strtotime($payment->due_date)) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @switch($payment->status)
                                            @case('paid')
                                                <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-800 flex items-center">
                                                    <span class="material-icons mr-1 text-sm">check_circle</span>
                                                    Paid
                                                </span>
                                                @break
                                            @case('pending')
                                                <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800 flex items-center">
                                                    <span class="material-icons mr-1 text-sm">pending</span>
                                                    Pending
                                                </span>
                                                @break
                                            @case('overdue')
                                                <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-800 flex items-center">
                                                    <span class="material-icons mr-1 text-sm">warning</span>
                                                    Overdue
                                                </span>
                                                @break
                                        @endswitch
                                    </td>
                                    @if(auth()->user()->role === 'admin')
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-2">
                                                <button 
                                                    onclick="sendReminderEmail({{ $payment->id }})"
                                                    class="text-blue-500 hover:text-blue-700 transition-colors"
                                                >
                                                    <span class="material-icons">email</span>
                                                </button>
                                                <button 
                                                    onclick="editPayment({{ $payment->id }})"
                                                    class="text-green-500 hover:text-green-700 transition-colors"
                                                >
                                                    <span class="material-icons">edit</span>
                                                </button>
                                                <button 
                                                    onclick="deletePayment({{ $payment->id }})"
                                                    class="text-red-500 hover:text-red-700 transition-colors"
                                                >
                                                    <span class="material-icons">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div 
        id="add-payment-modal" 
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50"
    >
        <div class="bg-white rounded-2xl shadow-xl p-8 w-96">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-blue-700">Add New Payment</h3>
                <button onclick="closeAddPaymentModal()" class="text-gray-500 hover:text-gray-700">
                    <span class="material-icons">close</span>
                </button>
            </div>
            <form id="add-payment-form" class="space-y-4">
                @csrf
                <div>
                    <label for="parent-names" class="block text-sm font-medium text-gray-700">Parent Names</label>
                    <input 
                        type="text" 
                        id="parent-names" 
                        name="parent_names" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" 
                        required
                    >
                </div>
                <div>
                    <label for="child-name" class="block text-sm font-medium text-gray-700">Child Name</label>
                    <input 
                        type="text" 
                        id="child-name" 
                        name="child_name" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" 
                        required
                    >
                </div>
                <div>
                    <label for="payment-amount" class="block text-sm font-medium text-gray-700">Payment Amount (RM)</label>
                    <input 
                        type="number" 
                        id="payment-amount" 
                        name="amount" 
                        step="0.01" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" 
                        required
                    >
                </div>
                <div>
                    <label for="due-date" class="block text-sm font-medium text-gray-700">Due Date</label>
                    <input 
                        type="date" 
                        id="due-date" 
                        name="due_date" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" 
                        required
                    >
                </div>
                <div class="flex justify-end space-x-4 pt-4">
                    <button 
                        type="button" 
                        onclick="closeAddPaymentModal()" 
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
                    >
                        Add Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
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

        function openAddPaymentModal() {
            document.getElementById('add-payment-modal').classList.remove('hidden');
            document.getElementById('add-payment-modal').classList.add('flex');
        }

        function closeAddPaymentModal() {
            document.getElementById('add-payment-modal').classList.remove('flex');
            document.getElementById('add-payment-modal').classList.add('hidden');
        }

        function sendReminderEmail(paymentId) {
            // AJAX call to send reminder email
            fetch(`/payments/${paymentId}/remind`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert('Reminder email sent successfully!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to send reminder email.');
            });
        }

        function editPayment(paymentId) {
            // Redirect to edit payment page or open edit modal
            window.location.href = `/payments/${paymentId}/edit`;
        }

        function deletePayment(paymentId) {
            if (confirm('Are you sure you want to delete this payment?')) {
                fetch(`/payments/${paymentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Remove the payment row from the table
                    document.querySelector(`tr[data-payment-id="${paymentId}"]`).remove();
                    alert('Payment deleted successfully!');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to delete payment.');
                });
            }
        }

        // Handle form submission
        document.getElementById('add-payment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);

            fetch('/payments', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Close modal
                closeAddPaymentModal();
                
                // Optionally refresh the payments table or add the new payment row
                alert('Payment added successfully!');
                
                // Optionally reload the page or update the table dynamically
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add payment.');
            });
        });
    </script>
    @endpush
</x-app-layout>