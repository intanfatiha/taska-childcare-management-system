<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('attendances.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                        <label for="child_name" class="block text-sm font-medium text-gray-700">Child</label>
                        <select id="child_name" name="child_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Select a Child</option>
                            <option value="1">Anis</option>
                            <option value="2">Irfan</option>
                            <option value="3">Zahra</option>
                        </select>
                    </div>

                        <div class="mb-4">
                            <label for="time_in" class="block text-sm font-medium text-gray-700">Time In</label>
                            <input type="time" id="time_in" name="time_in" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="time_out" class="block text-sm font-medium text-gray-700">Time Out</label>
                            <input type="time" id="time_out" name="time_out" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" id="date" name="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div class="mb-6">
                            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                                Save Attendance
                            </button>
                            <a href="{{ route('attendances.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-700">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
