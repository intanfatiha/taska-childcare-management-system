
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
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Parent(s)</label>
                        <input type="text" id="parent_display" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                        <input type="hidden" id="parent_id" name="parent_id">
                    </div>

                    <!-- Payment Amount -->
                    <div class="mb-5">
                        <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-1">Amount (RM)</label>
                        <input type="number" id="payment_amount" name="payment_amount" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter amount" step="0.01" required>
                        @error('payment_amount')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div class="mb-5">
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date (Pay By or Before)</label>
                        <input type="date" id="due_date" name="due_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        @error('due_date')
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

    document.getElementById('child_id').addEventListener('change', function() {
        const childId = this.value;
        const parentDisplay = document.getElementById('parent_display');
        parentDisplay.value = parentsByChild[childId] || '';
        // If you need to set a hidden parent_id for form submission, you can add logic here
    });
</script>
</x-app-layout>