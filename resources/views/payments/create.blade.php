<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
                <h2 class="text-2xl font-bold text-indigo-800">
                    {{ __('Create New Payment') }}
                </h2>
                <p class="text-gray-600 mt-1">Fill in the details to create a new payment record</p>
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

            <!-- Form Card -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf

                    <!-- Child Dropdown -->
                    <div class="mb-5">
                        <label for="child_id" class="block text-sm font-medium text-gray-700 mb-1">Child Name</label>
                        <select id="child_id" name="child_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            <option value="">Select a Child</option>
                            @foreach($formattedChildren as $child)
                                <option value="{{ $child['id'] }}">{{ $child['name'] }}</option>
                            @endforeach
                        </select>
                        @error('child_id')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parent Dropdown (auto-filled, read-only) -->
                    <div class="mb-5">
                        <label for="parent_display" class="block text-sm font-medium text-gray-700 mb-1">Parent(s)</label>
                        <input type="text" id="parent_display" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                        <input type="hidden" id="parent_id" name="parent_id">
                        @error('parent_id')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Payment Amount -->
                    <div class="mb-5">
                        <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-1">Amount (RM)</label>
                        <input type="number" id="payment_amount" name="payment_amount" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter amount" step="0.01" required>
                        @error('payment_amount')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Overtime Amount and Minutes -->
                    <div class="mb-5 flex items-center space-x-4">
                        <div class="flex-1">
                            <label for="overtime_amount" class="block text-sm font-medium text-gray-700 mb-1">Overtime Charges (RM)</label>
                            <input type="number" id="overtime_amount" name="overtime_amount" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Overtime Charges" step="0.01" required readonly>
                        </div>
                        <div>
                            <label for="total_overtime_minutes" class="block text-sm font-medium text-gray-700 mb-1">Total Overtime (min)</label>
                            <input type="number" id="total_overtime_minutes" name="total_overtime_minutes" class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>

                    <!-- Due Date -->
                    <div class="mb-5">
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date (Pay By or Before)</label>
                        <input type="date" id="due_date" name="due_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        @error('due_date')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                     <!-- Total Amount -->
                    <div class="mb-5">
                    <label for="total_payment_amount" class="block text-sm font-bold text-gray-700 mb-1">Total Payment (RM)</label>
                        <input type="number" id="total_payment_amount" name="total_payment_amount" class="w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" readonly>
                        @error('total_payment_amount')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Form Buttons -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                            Create Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
const parentsByChild = @json($parentsByChild);
const parentRecordIdByChild = @json($parentRecordIdByChild);
const enrollmentDatesByChild = @json($enrollmentStartDates);
const overtimeMinutesByChild = @json($totalOvertimeMinutesByChild);

const today = "{{ \Carbon\Carbon::now()->format('Y-m-d') }}";
const monthlyFee = 300.00;
const ratePerMinute = 0.50;

/**
 * Calculate prorated fee based on enrollment date
 */
function calculateProratedFee(enrollmentDate, billingMonth = null) {
    if (!enrollmentDate) return monthlyFee;
    
    const enrollment = new Date(enrollmentDate);
    const currentDate = new Date();
    
    // Use provided billing month or current month
    const billingYear = billingMonth ? new Date(billingMonth).getFullYear() : currentDate.getFullYear();
    const billingMonthNum = billingMonth ? new Date(billingMonth).getMonth() : currentDate.getMonth();
    
    // Get total days in the billing month
    const totalDaysInMonth = new Date(billingYear, billingMonthNum + 1, 0).getDate();
    
    // Check if enrollment is in the billing month
    if (enrollment.getFullYear() === billingYear && enrollment.getMonth() === billingMonthNum) {
        // Calculate remaining days from enrollment date to end of month
        const enrollmentDay = enrollment.getDate();
        const remainingDays = totalDaysInMonth - enrollmentDay + 1;
        
        // Calculate prorated amount
        const dailyRate = monthlyFee / totalDaysInMonth;
        return remainingDays * dailyRate;
    }
    
    // If enrolled in previous months, charge full amount
    if (enrollment < new Date(billingYear, billingMonthNum, 1)) {
        return monthlyFee;
    }
    
    // If enrollment is in future months, no charge
    return 0;
}

/**
 * Calculate and update all payment fields
 */
function updatePaymentCalculations() {
    const childId = document.getElementById('child_id').value;
    if (!childId) return;
    
    // Get enrollment date for this child
    const enrollmentDate = enrollmentDatesByChild[childId] || null;
    
    // Calculate base fee
    const baseFee = calculateProratedFee(enrollmentDate);
    
    // Get overtime minutes (from input field)
    const overtimeMinutes = parseInt(document.getElementById('total_overtime_minutes').value) || 0;
    const positiveOvertimeMinutes = Math.abs(overtimeMinutes);
    
    // Calculate overtime charges
    const overtimeAmount = positiveOvertimeMinutes * ratePerMinute;
    
    // Calculate total
    const totalPaymentAmount = baseFee + overtimeAmount;
    
    // Update form fields
    document.getElementById('overtime_amount').value = overtimeAmount.toFixed(2);
    document.getElementById('payment_amount').value = baseFee.toFixed(2);
    document.getElementById('total_payment_amount').value = totalPaymentAmount.toFixed(2);
}

/**
 * Initialize payment fields when child is selected
 */
function initializePaymentFields(enrollmentDate, overtimeMinutes) {
    // Calculate base fee
    const baseFee = calculateProratedFee(enrollmentDate);
    
    // Set initial overtime minutes (from database)
    const positiveOvertimeMinutes = Math.abs(overtimeMinutes || 0);
    
    // Calculate overtime charges
    const overtimeAmount = positiveOvertimeMinutes * ratePerMinute;
    
    // Calculate total
    const totalPaymentAmount = baseFee + overtimeAmount;
    
    // Update form fields
    document.getElementById('total_overtime_minutes').value = positiveOvertimeMinutes;
    document.getElementById('overtime_amount').value = overtimeAmount.toFixed(2);
    document.getElementById('payment_amount').value = baseFee.toFixed(2);
    document.getElementById('total_payment_amount').value = totalPaymentAmount.toFixed(2);
}

// Event listeners
document.getElementById('child_id').addEventListener('change', function () {
    const childId = this.value;
    
    if (!childId) {
        // Clear all fields if no child selected
        document.getElementById('parent_display').value = '';
        document.getElementById('parent_id').value = '';
        document.getElementById('total_overtime_minutes').value = '';
        document.getElementById('overtime_amount').value = '';
        document.getElementById('payment_amount').value = '';
        document.getElementById('total_payment_amount').value = '';
        return;
    }

    // Update parent fields
    document.getElementById('parent_display').value = parentsByChild[childId] || '';
    document.getElementById('parent_id').value = parentRecordIdByChild[childId] || '';

    // Initialize payment fields with database values
    const enrollmentDate = enrollmentDatesByChild[childId] || null;
    const overtimeMinutes = overtimeMinutesByChild[childId] || 0;

    initializePaymentFields(enrollmentDate, overtimeMinutes);
});

// Add event listener for manual overtime input
document.getElementById('total_overtime_minutes').addEventListener('input', function() {
    updatePaymentCalculations();
});

// Also listen for change event (when user leaves the field)
document.getElementById('total_overtime_minutes').addEventListener('change', function() {
    updatePaymentCalculations();
});

// Auto-trigger for preselected child
document.addEventListener('DOMContentLoaded', () => {
    const initialChildId = document.getElementById('child_id').value;
    if (initialChildId) {
        document.getElementById('child_id').dispatchEvent(new Event('change'));
    }
});
</script>
</x-app-layout>