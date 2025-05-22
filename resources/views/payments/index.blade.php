<x-app-layout>
   
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-indigo-800">
                            {{ __('Payments') }}
                        </h2>
                        <p class="text-gray-600 mt-1">Manage payment records for children</p>
                    </div>
                    
                    @if(auth()->user()->role === 'admin')
                    <div>
                        <a href="{{ route('payments.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm transition">
                            Create New Payment
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Success Message Alert -->
            @if(session('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p>{{ session('message') }}</p>
                    </div>
                </div>
            @endif

             @if(auth()->user()->role === 'admin')
            <!-- Payments Table Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($payments->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No payments found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new payment.</p>
                            <div class="mt-6">
                                <a href="{{ route('payments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    New Payment
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Child</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent(s)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount (RM)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $payment->child->child_name ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @php
                                                        $parentRecord = $payment->parentRecord;
                                                        $names = [];
                                                        if ($parentRecord) {
                                                            if ($parentRecord->father) $names[] = $parentRecord->father->father_name;
                                                            if ($parentRecord->mother) $names[] = $parentRecord->mother->mother_name;
                                                            if ($parentRecord->guardian) $names[] = $parentRecord->guardian->guardian_name;
                                                        }
                                                        echo !empty($names) ? implode(' & ', $names) : 'N/A';
                                                    @endphp
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ number_format($payment->payment_amount, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($payment->payment_duedate)->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $isOverdue = $payment->payment_status == 'pending' && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($payment->payment_duedate));
                                                    $status = $isOverdue ? 'overdue' : $payment->payment_status;
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($status == 'Complete')
                                                        bg-green-100 text-green-800
                                                    @elseif($status == 'Pending')
                                                        bg-yellow-100 text-yellow-800
                                                    @elseif($status == 'Overdue')
                                                        bg-red-100 text-red-800
                                                    @else
                                                        bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $payment->paymentByParents_date ? \Carbon\Carbon::parse($payment->paymentByParents_date)->format('d M Y') : 'Not paid yet' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    @if($payment->payment_status !== 'Complete')
                                                        <form action="{{ route('payment.checkout') }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                            <button type="submit" class="btn btn-primary">Pay with Card</button>
                                                        </form>
                                                    @else
                                                        <button type="button" disabled class="px-3 py-1 bg-gray-300 text-gray-500 rounded cursor-not-allowed text-sm">
                                                            Paid
                                                        </button>
                                                        <a href="{{ route('payments.invoice', $payment) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm transition">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                            Invoice
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('payments.edit', $payment) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(auth()->user()->role === 'parents')
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-indigo-800 mb-6">My Payment Records</h2>
        <div class="space-y-6">
            @forelse($payments as $payment)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition duration-200">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="flex-1">
                            <!-- Child Name -->
                            <h3 class="text-xl font-bold text-gray-800 mb-2">
                                {{ $payment->child->child_name ?? 'N/A' }}
                            </h3>
                            <!-- Payment Info Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <span class="font-semibold text-gray-700">Amount:</span>
                                    <span class="text-indigo-700 font-bold">RM {{ number_format($payment->payment_amount, 2) }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700">Due Date:</span>
                                    <span>{{ \Carbon\Carbon::parse($payment->payment_duedate)->format('d M Y') }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700">Status:</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($payment->payment_status == 'Complete')
                                            bg-green-100 text-green-800
                                        @elseif($payment->payment_status == 'Pending')
                                            bg-yellow-100 text-yellow-800
                                        @else
                                            bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($payment->payment_status) }}
                                    </span>
                                </div>
                            </div>
                            <!-- Payment Date -->
                            <div class="text-sm text-gray-600 mb-2">
                                <span class="font-semibold">Payment Date:</span>
                                {{ $payment->paymentByParents_date ? \Carbon\Carbon::parse($payment->paymentByParents_date)->format('d M Y') : 'Not paid yet' }}
                            </div>
                            <!-- Parent(s) Name
                            <div class="text-sm text-gray-600">
                                <span class="font-semibold">Parent(s):</span>
                                @php
                                    $parentRecord = $payment->parentRecord;
                                    $names = [];
                                    if ($parentRecord) {
                                        if ($parentRecord->father) $names[] = $parentRecord->father->father_name;
                                        if ($parentRecord->mother) $names[] = $parentRecord->mother->mother_name;
                                        if ($parentRecord->guardian) $names[] = $parentRecord->guardian->guardian_name;
                                    }
                                    echo !empty($names) ? implode(' & ', $names) : 'N/A';
                                @endphp
                            </div> -->
                        </div>
                        <!-- Action Button -->
                        <div class="flex flex-col justify-center mt-4 md:mt-0 md:ml-6 space-y-2">
                            @if($payment->payment_status !== 'Complete')
                                <form action="{{ route('payment.checkout') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition w-full">
                                        Pay with Card
                                    </button>
                                </form>
                            @else
                                <button type="button" disabled class="px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-not-allowed w-full">
                                    Payment Complete
                                </button>
                                <a href="{{ route('payments.invoice', $payment) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition w-full">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Invoice
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012 2h2a2 2 0 012 2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-4 text-xl text-gray-500">No payment records available</p>
                </div>
            @endforelse
        </div>
    </div>
@endif

</x-app-layout>