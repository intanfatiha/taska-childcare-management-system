<x-app-layout>
    <div class="min-h-screen ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> 
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
                <div>
                    <h2 class="text-3xl font-bold text-indigo-800">
                        {{ __('Payment Management') }}
                    </h2>
                    <p class="text-gray-600 mt-1">Manage and track childcare payment records</p>
                </div>

                @if(auth()->user()->role === 'admin')
                        <div class="flex space-x-3">
                            <a href="{{ route('payments.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create New Payment
                            </a>
                        </div>
                        @endif
            </div>
            

            <!-- Success Message Alert -->
            @if(session('message'))
                <div class="mb-6">
                    <div class="bg-green-50 border-l-4 border-green-400 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700 font-medium">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(auth()->user()->role === 'admin')
             <h3 class="text-lg font-semibold text-gray-800"></h3>
                    


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-105 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-teal-400 to-teal-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl mb-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-1">
                            RM {{ number_format($payments->where('payment_status', 'Complete')->sum('payment_amount'), 2) }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">Total Revenue</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Payments Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-105 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-green-400 to-green-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl mb-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-1">
                            {{ $payments->where('payment_status', 'Complete')->count() }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">Completed Payments</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Payments Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-105 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-orange-400 to-orange-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl mb-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-1">
                           

                              {{ $payments->where('payment_status', 'Pending')->count() }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">Pending Payments</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overdue Payments Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-105 transition-all duration-300">
            <div class="h-2 bg-gradient-to-r from-red-400 to-red-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl mb-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-1">
                            @php
                                $overdueCount = $payments->filter(function($payment) {
                                    return $payment->payment_status == 'Pending' && 
                                           \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($payment->payment_duedate));
                                })->count();
                            @endphp
                            {{ $overdueCount }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">Overdue Payments</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

            <!-- Admin Payments Table -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                
                
                <div class="p-6">
                    @if($payments->isEmpty())
                        <div class="text-center py-12">
                            <div class="bg-gray-100 rounded-full p-6 w-24 h-24 mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No payments found</h3>
                            <p class="text-gray-500 mb-6">Get started by creating your first payment record.</p>
                            <a href="{{ route('payments.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create First Payment
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Child Information</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Parent(s)</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payment Details</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($payments as $payment)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <!-- Child Information -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    
                                                    <div class="ml-4">
                                                        <div class="text-sm font-semibold text-gray-900">
                                                            {{ $payment->child->child_name ?? 'N/A' }}
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Parent(s) -->
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 font-medium">
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

                                            <!-- Payment Details -->
                                            <td class="px-6 py-4">
                                                <div class="space-y-1">
                                                    <div class="text-lg font-bold text-blue-600">
                                                        RM {{ number_format($payment->payment_amount, 2) }}

                                                        
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        Due: {{ \Carbon\Carbon::parse($payment->payment_duedate)->format('d M Y') }}
                                                    </div>
                                                    @if($payment->paymentByParents_date)
                                                    <div class="text-xs text-green-600">
                                                        Paid: {{ \Carbon\Carbon::parse($payment->paymentByParents_date)->format('d M Y') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Status -->
                                            <td class="px-6 py-4">
                                                @php
                                                    $isOverdue = $payment->payment_status == 'pending' && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($payment->payment_duedate));
                                                    $status = $isOverdue ? 'overdue' : $payment->payment_status;
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($status == 'Complete')
                                                        bg-green-100 text-green-800
                                                    @elseif($status == 'Pending')
                                                        bg-yellow-100 text-yellow-800
                                                    @elseif($status == 'Overdue')
                                                        bg-red-100 text-red-800
                                                    @else
                                                        bg-gray-100 text-gray-800
                                                    @endif">
                                                    @if($status == 'Complete')
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @elseif($status == 'Overdue')
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                        </svg>

                                                    @endif
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col space-y-2 items-center">
                                                    <!-- Management Actions (Edit/Delete) -->
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('payments.edit', $payment) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium rounded-lg transition-colors">
                                                            <svg class="w-4 h-4 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                           
                                                        </a>
                                                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition-colors">
                                                                <svg class="w-4 h-4 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                            
                                                            </button>
                                                        </form>

                                                        @if($payment->payment_status == 'Complete')
                                                           
                                                            <a href="{{ route('payments.invoice', $payment) }}" class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 text-xs font-medium rounded-lg transition-colors">
                                                                <svg class="w-4 h-4 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                            
                                                            </a>
                                                         @elseif($payment->payment_status == 'Overdue')
                                                         <!-- @php
                                                            $parentRecord = $payment->parentRecord;
                                                            // Try to get the first available parent/guardian email
                                                            $email = $parentRecord?->father?->father_email
                                                                ?? $parentRecord?->mother?->mother_email
                                                                ?? $parentRecord?->guardian?->guardian_email
                                                                ?? null;
                                                            $mailto = $email ? 'mailto:' . $email . '?subject=Overdue Payment Reminder&body=Dear Parent,%0D%0A%0D%0AThis is a reminder that your payment for ' . ($payment->child->child_name ?? 'your child') . ' is overdue. Please make the payment as soon as possible.%0D%0A%0D%0AThank you.' : '#';
                                                        @endphp  -->

                                                         <form action="{{ route('payments.sendOverdueEmail') }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                            <button type="submit" title="Send Overdue Email"
                                                                class="inline-flex items-center px-2 py-1 bg-red-50 hover:bg-red-100 rounded transition"
                                                               >
                                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm-8 0v4a4 4 0 008 0v-4"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-5 9 5"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        @else
                                                            <span class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-lg">
                                                                <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                
                                                            </span>
                                                        @endif


                                                    </div> 
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
            @endif

            @if(auth()->user()->role === 'staff')

            <h3 class="text-lg font-semibold text-gray-800">All Payment Records</h3>
                    <p class="text-sm text-gray-600 mt-1">Overview of all childcare payments</p>
            <!-- Admin Payments Table -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                
                
                <div class="p-6">
                    @if($payments->isEmpty())
                        <div class="text-center py-12">
                            <div class="bg-gray-100 rounded-full p-6 w-24 h-24 mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No payments found</h3>
                            <p class="text-gray-500 mb-6">Get started by creating your first payment record.</p>
                            <a href="{{ route('payments.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create First Payment
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Child Information</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Parent(s)</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payment Details</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($payments as $payment)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <!-- Child Information -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    
                                                    <div class="ml-4">
                                                        <div class="text-sm font-semibold text-gray-900">
                                                            {{ $payment->child->child_name ?? 'N/A' }}
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Parent(s) -->
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 font-medium">
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

                                            <!-- Payment Details -->
                                            <td class="px-6 py-4">
                                                <div class="space-y-1">
                                                    <div class="text-lg font-bold text-blue-600">
                                                        RM {{ number_format($payment->payment_amount, 2) }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        Due: {{ \Carbon\Carbon::parse($payment->payment_duedate)->format('d M Y') }}
                                                    </div>
                                                    @if($payment->paymentByParents_date)
                                                    <div class="text-xs text-green-600">
                                                        Paid: {{ \Carbon\Carbon::parse($payment->paymentByParents_date)->format('d M Y') }}

                                                         <form action="{{ route('payment.checkout') }}" method="POST" class="w-full">
                                            
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Status -->
                                            <td class="px-6 py-4">
                                                @php
                                                    $isOverdue = $payment->payment_status == 'pending' && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($payment->payment_duedate));
                                                    $status = $isOverdue ? 'overdue' : $payment->payment_status;
                                                @endphp
                                              
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($status == 'Complete')
                                                        bg-green-100 text-green-800
                                                    @elseif($status == 'Pending')
                                                        bg-yellow-100 text-yellow-800
                                                    @elseif($status == 'Overdue')
                                                        bg-red-100 text-red-800
                                                    @else
                                                        bg-gray-100 text-gray-800
                                                    @endif">
                                                    @if($status == 'Complete')
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @elseif($status == 'Overdue')
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @endif
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col space-y-2 items-center">
                                                    <!-- Management Actions (Edit/Delete) -->
                                                    <div class="flex space-x-2">
                                                        
                                                        

                                                        @if($payment->payment_status == 'Complete')
                                                           
                                                            <a href="{{ route('payments.invoice', $payment) }}" class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 text-xs font-medium rounded-lg transition-colors">
                                                                <svg class="w-4 h-4 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                            
                                                            </a>
                                                        @elseif($payment->payment_status == 'Overdue')
                                                         @php
                                                            $parentRecord = $payment->parentRecord;
                                                            // Try to get the first available parent/guardian email
                                                            $email = $parentRecord?->father?->father_email
                                                                ?? $parentRecord?->mother?->mother_email
                                                                ?? $parentRecord?->guardian?->guardian_email
                                                                ?? null;
                                                            $mailto = $email ? 'mailto:' . $email . '?subject=Overdue Payment Reminder&body=Dear Parent,%0D%0A%0D%0AThis is a reminder that your payment for ' . ($payment->child->child_name ?? 'your child') . ' is overdue. Please make the payment as soon as possible.%0D%0A%0D%0AThank you.' : '#';
                                                        @endphp 

                                                        <a href="{{ $mailto }}" title="Send Overdue Email" class="inline-flex items-center px-2 py-1 bg-red-50 hover:bg-red-100 rounded transition">
                                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm-8 0v4a4 4 0 008 0v-4"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-5 9 5"></path>
                                                            </svg>
                                                        </a>
                                                            <span class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-lg">
                                                                <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                
                                                            </span>
                                                        @else
                                                         <span class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-lg">
                                                                <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                
                                                            </span>


                                                        @endif


                                                    </div> 
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

            @endif


            @if(auth()->user()->role === 'parents')
            <!-- Parent View -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">My Payment Records</h2>
                            <p class="text-gray-600">Track your childcare payment history</p>
                        </div>
                    </div>

                    @forelse($payments as $payment)
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100 hover:shadow-lg transition-all duration-200 mb-6">
                            <div class="flex flex-col lg:flex-row justify-between items-start space-y-4 lg:space-y-0">
                                <!-- Payment Information -->
                                <div class="flex-1 space-y-4">
                                    <!-- Child Header -->
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-gradient-to-r from-pink-400 to-purple-500 p-2 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-800">
                                            {{ $payment->child->child_name ?? 'N/A' }}
                                        </h3>
                                    </div>

                                    <!-- Payment Details Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                        <div class="bg-white p-4 rounded-lg shadow-sm">
                                            <div class="text-sm font-medium text-gray-500 mb-1">Amount</div>
                                            <div class="text-xl font-bold text-blue-600">RM {{ number_format($payment->payment_amount, 2) }}</div>
                                        </div>
                                        <div class="bg-white p-4 rounded-lg shadow-sm">
                                            <div class="text-sm font-medium text-gray-500 mb-1">Due Date</div>
                                            <div class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($payment->payment_duedate)->format('d M Y') }}</div>
                                        </div>
                                        <div class="bg-white p-4 rounded-lg shadow-sm">
                                            <div class="text-sm font-medium text-gray-500 mb-1">Status</div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
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
                                        <div class="bg-white p-4 rounded-lg shadow-sm">
                                            <div class="text-sm font-medium text-gray-500 mb-1">Payment Date</div>
                                            <div class="text-sm font-semibold text-gray-800">
                                                {{ $payment->paymentByParents_date ? \Carbon\Carbon::parse($payment->paymentByParents_date)->format('d M Y') : 'Not paid yet' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col space-y-3 lg:ml-6 min-w-0 lg:min-w-[200px]">
                                    @if($payment->payment_status !== 'Complete')
                                        <form action="{{ route('payment.checkout') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                </svg>
                                                Pay with Card
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" disabled class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-500 font-semibold rounded-lg cursor-not-allowed">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Payment Complete
                                        </button>
                                        <a href="{{ route('payments.invoice', $payment) }}" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download Invoice
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="bg-gray-100 rounded-full p-6 w-24 h-24 mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012 2h2a2 2 0 012 2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No payment records found</h3>
                            <p class="text-gray-500">Your payment history will appear here once payments are created.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>