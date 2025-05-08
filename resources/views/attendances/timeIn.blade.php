<!-- <x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-6">Attendance Check In</h2>

        <form method="POST" action="{{ route('attendances.checkin') }}">
            @csrf
            <div class="flex items-center gap-4">
                <select name="children_id" required class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="" disabled selected>Select Child</option>
                    @foreach ($children as $child)
                        <option value="{{ $child->id }}">{{ $child->child_name }}</option>
                    @endforeach
                </select>
                <input type="date" name="attendance_date" value="{{ now()->format('Y-m-d') }}" required
                       class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded shadow">
                    Check In
                </button>
            </div>
        </form>
    </div>
</x-app-layout> -->

<form method="POST" action="">
    @csrf
    <div class="flex items-center gap-4">
        <select name="children_id" required class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="" disabled selected>Select Child</option>
            @foreach ($children as $child)
                <option value="{{ $child->id }}">{{ $child->child_name }}</option>
            @endforeach
        </select>
        <input type="date" name="attendance_date" value="{{ now()->format('Y-m-d') }}" required
               class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded shadow">
            Check In
        </button>
    </div>
</form>