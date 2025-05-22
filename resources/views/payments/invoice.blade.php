<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Invoice') }} - INV-{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}-{{ \Carbon\Carbon::parse($payment->created_at)->format('Y') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Action Buttons -->
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Payments
                </a>
                
                <div class="flex space-x-3">
                    <a href="{{ route('payments.invoice', $payment) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download PDF
                    </a>
                    
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print
                    </button>
                </div>
            </div>

            <!-- Invoice Container -->
            <div class="invoice-container max-w-4xl mx-auto bg-white shadow-lg">
                <!-- Invoice Header -->
                <div class="invoice-header bg-gradient-to-r from-indigo-600 to-purple-700 text-white p-10 text-center">
                    <h1 class="text-4xl font-light mb-2">PAYMENT INVOICE</h1>
                    <p class="text-lg opacity-90">Childcare Payment Receipt</p>
                </div>
                
                <!-- Invoice Content -->
                <div class="invoice-content p-10">
                    <!-- Company Information -->
                    <div class="company-info text-center mb-8 p-5 bg-gray-50 rounded-lg">
                        <h2 class="text-xl font-semibold text-indigo-600 mb-2">Little Stars Childcare Center</h2>
                        <p class="text-gray-600 mb-1">123 Childcare Avenue, Puchong, Selangor</p>
                        <p class="text-gray-600 mb-1">Phone: +60 3-1234 5678 | Email: info@littlestars.com</p>
                        <p class="text-gray-600">Registration No: 12345678-A</p>
                    </div>
                    
                    <!-- Invoice Number -->
                    <div class="invoice-number border-2 border-indigo-600 rounded-lg p-4 mb-8 text-center">
                        <strong class="text-indigo-600 text-lg">Invoice #: INV-{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}-{{ \Carbon\Carbon::parse($payment->created_at)->format('Y') }}</strong>
                    </div>
                    
                    <!-- Invoice Details Grid -->
                    <div class="invoice-details grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <!-- Bill To Section -->
                        <div class="detail-section">
                            <h3 class="text-lg font-semibold text-indigo-600 mb-4 pb-2 border-b-2 border-gray-200">Bill To</h3>
                            <div class="detail-item flex justify-between mb-3">
                                <span class="detail-label font-semibold text-gray-700">Parent(s):</span>
                                <span class="detail-value text-gray-900 text-right">
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
                                </span>
                            </div>
                            <div class="detail-item flex justify-between mb-3">
                                <span class="detail-label font-semibold text-gray-700">Child:</span>
                                <span class="detail-value text-gray-900">{{ $payment->child->child_name ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item flex justify-between mb-3">
                                <span class="detail-label font-semibold text-gray-700">Email:</span>
                                <span class="detail-value text-gray-900 text-right">
                                    @php
                                        $email = 'N/A';
                                        if ($parentRecord) {
                                            if ($parentRecord->father && $parentRecord->father->father_email) {
                                                $email = $parentRecord->father->father_email;
                                            } elseif ($parentRecord->mother && $parentRecord->mother->mother_email) {
                                                $email = $parentRecord->mother->mother_email;
                                            } elseif ($parentRecord->guardian && $parentRecord->guardian->guardian_email) {
                                                $email = $parentRecord->guardian->guardian_email;
                                            }
                                        }
                                        echo $email;
                                    @endphp
                                </span>
                            </div>
                        </div>
                        
                        <!-- Payment Details Section -->
                        <div class="detail-section">
                            <h3 class="text-lg font-semibold text-indigo-600 mb-4 pb-2 border-b-2 border-gray-200">Payment Details</h3>
                            <div class="detail-item flex justify-between mb-3">
                                <span class="detail-label font-semibold text-gray-700">Invoice Date:</span>
                                <span class="detail-value text-gray-900">{{ \Carbon\Carbon::parse($payment->bill_date ?? $payment->created_at)->format('d M Y') }}</span>
                            </div>
                            <div class="detail-item flex justify-between mb-3">
                                <span class="detail-label font-semibold text-gray-700">Due Date:</span>
                                <span class="detail-value text-gray-900">{{ \Carbon\Carbon::parse($payment->payment_duedate)->format('d M Y') }}</span>
                            </div>
                            <div class="detail-item flex justify-between mb-3">
                                <span class="detail-label font-semibold text-gray-700">Payment Date:</span>
                                <span class="detail-value text-gray-900">{{ $payment->paymentByParents_date ? \Carbon\Carbon::parse($payment->paymentByParents_date)->format('d M Y') : 'Pending' }}</span>
                            </div>
                            <div class="detail-item flex justify-between mb-3">
                                <span class="detail-label font-semibold text-gray-700">Status:</span>
                                <span class="detail-value">
                                    <span class="status-badge inline-block px-4 py-2 rounded-full text-sm font-semibold uppercase tracking-wide bg-green-100 text-green-800 border border-green-200">
                                        {{ ucfirst($payment->payment_status) }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Summary -->
                    <div class="payment-summary bg-gray-50 rounded-lg p-8 mb-8 border-l-4 border-indigo-600">
                        <h3 class="text-xl font-semibold text-indigo-600 mb-5">Payment Summary</h3>
                        <div class="summary-row flex justify-between py-3 mb-3">
                            <span class="text-gray-700">Childcare Services</span>
                            <span class="text-gray-900">RM {{ number_format($payment->payment_amount, 2) }}</span>
                        </div>
                        <div class="summary-row flex justify-between py-3 mb-3">
                            <span class="text-gray-700">Service Tax (0%)</span>
                            <span class="text-gray-900">RM 0.00</span>
                        </div>
                        <div class="summary-row total flex justify-between py-3 border-t-2 border-gray-300 text-lg font-bold text-indigo-600">
                            <span>Total Amount</span>
                            <span>RM {{ number_format($payment->payment_amount, 2) }}</span>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="additional-info">
                        <h3 class="text-lg font-semibold text-indigo-600 mb-4 pb-2 border-b-2 border-gray-200">Additional Information</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            This invoice represents payment for childcare services provided to {{ $payment->child->child_name ?? 'your child' }}. 
                            Payment has been successfully processed and confirmed. For any questions regarding this invoice, 
                            please contact our administration office at info@littlestars.com or call +60 3-1234 5678.
                        </p>
                        
                        @if($payment->payment_method ?? false)
                        <p class="text-gray-600 mb-2">
                            <strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}
                        </p>
                        @endif
                        
                        @if($payment->transaction_id ?? false)
                        <p class="text-gray-600">
                            <strong>Transaction ID:</strong> {{ $payment->transaction_id }}
                        </p>
                        @endif
                    </div>
                </div>
                
                <!-- Invoice Footer -->
                <div class="invoice-footer bg-gray-50 p-8 text-center border-t border-gray-200">
                    <p class="text-gray-600 mb-3"><strong>Thank you for your payment!</strong></p>
                    <p class="text-gray-600 mb-3">This is a computer-generated invoice and does not require a signature.</p>
                    <p class="text-gray-500 text-sm">
                        Generated on {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            .invoice-container {
                box-shadow: none !important;
                margin: 0 !important;
            }
            
            .invoice-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            
            .bg-gray-50 {
                background-color: #f9fafb !important;
                -webkit-print-color-adjust: exact !important;
            }
            
            .border-indigo-600 {
                border-color: #4f46e5 !important;
                -webkit-print-color-adjust: exact !important;
            }
        }
    </style>
    @endpush
</x-app-layout>