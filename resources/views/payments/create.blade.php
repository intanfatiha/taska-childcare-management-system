<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf

                        <!-- Parent Dropdown -->
                        <div class="mb-4">
                            <label for="parent_name" class="block text-sm font-medium text-gray-700">Parent Name</label>
                            <select id="parent_name" name="parent_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Select a Parent</option>
                                <!-- Example options, dynamically generated -->
                                <option value="1">John Doe</option>
                                <option value="2">Alice Smith</option>
                                <option value="3">Michael Brown</option>
                            </select>
                        </div>

                        <!-- Child Dropdown -->
                        <div class="mb-4">
                            <label for="child_name" class="block text-sm font-medium text-gray-700">Child Name</label>
                            <select id="child_name" name="child_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Select a Child</option>
                                <!-- Example options, dynamically generated -->
                                <option value="1">Anis</option>
                                <option value="2">Irfan</option>
                                <option value="3">Zahra</option>
                            </select>
                        </div>

                        <!-- Payment Title -->
                        <div class="mb-4">
                            <label for="payment_title" class="block text-sm font-medium text-gray-700">Payment Title</label>
                            <input type="text" id="payment_title" name="payment_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter payment title" required>
                        </div>

                        <!-- Payment Amount -->
                        <div class="mb-4">
                            <label for="payment_amount" class="block text-sm font-medium text-gray-700">Amount (RM)</label>
                            <input type="number" id="payment_amount" name="payment_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter amount" step="0.01" required>
                        </div>

                        <!-- Due Date -->
                        <div class="mb-4">
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                            <input type="date" id="due_date" name="due_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <!-- Buttons -->
                        <div class="mb-6 flex items-center gap-4">
                            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                                Create Payment
                            </button>
                            <a href="{{ route('payments.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-700">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
