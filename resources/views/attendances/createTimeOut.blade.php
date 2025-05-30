<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-6 text-center text-purple-600">
            <i class="fas fa-sign-out-alt mr-2"></i>Children's Time Out
        </h1>

        <!-- Date Filter Form (GET) -->
        <form method="GET" action="{{ route('attendances.createTimeOut') }}">
            <div class="mb-6 bg-yellow-100 p-4 rounded-lg shadow-md border-2 border-yellow-300">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="flex flex-col">
                        <label for="date" class="text-sm font-medium text-gray-700 mb-1">Filter by Date</label>
                        <input type="date" name="date" id="date"
                            value="{{ request('date', now()->format('Y-m-d')) }}"
                            class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md transition">
                            <i class="fas fa-search mr-1"></i> Filter Date
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Time Out Submission Form -->
        <form method="POST" action="{{ route('attendances.updateTimeOut') }}">
            @csrf

            <!-- Summary Card -->
            <div class="mt-2 bg-white p-4 rounded-lg shadow-md border-2 border-gray-200 mb-6">
                <h3 class="text-lg font-bold text-gray-700 mb-2">Today's Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div class="bg-green-100 p-3 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $presentChildren->count() }}</div>
                        <div class="text-sm text-green-700">Present Today</div>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">
                            {{ $presentChildren->filter(fn($child) => $child->attendances->first()?->time_out)->count() }}
                        </div>
                        <div class="text-sm text-purple-700">Timed Out</div>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">
                            {{ $presentChildren->filter(fn($child) => $child->attendances->first() && !$child->attendances->first()->time_out)->count() }}
                        </div>
                        <div class="text-sm text-blue-700">Still Here</div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-blue-50 p-4 rounded-lg shadow-md mb-6 border-2 border-blue-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-blue-700">Time Out Sheet</h2>
                    <div class="text-sm text-blue-600">
                        <i class="fas fa-info-circle mr-1"></i>Only children who are present today will be shown
                    </div>
                </div>
            </div>

            <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-purple-500 to-blue-500 text-white">
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-center">Picture</th>
                        <th class="px-4 py-3 text-center">Name</th>
                        <th class="px-4 py-3 text-center">Time In</th>
                        <th class="px-4 py-3 text-center">Time Out</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presentChildren as $index => $child)
                    @php $attendance = $child->attendances->first(); @endphp
                    <tr class="hover:bg-blue-50 border-b border-gray-200 transition-colors">
                        <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-center">
                            <img src="{{ $child->child_photo ? asset('storage/' . $child->child_photo) : asset('images/no-image.png') }}"
                                alt="{{ $child->child_name }}" class="w-16 h-16 object-cover rounded-full border-4 border-blue-300 shadow-md"
                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                        </td>
                        <td class="px-4 py-3 text-center font-medium text-blue-800">{{ $child->child_name }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($attendance && $attendance->time_in)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-md text-sm font-medium">
                                    {{ date('g:i A', strtotime($attendance->time_in)) }}
                                </span>
                            @else
                                <span class="text-gray-400">No time in</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="time" class="border-2 border-blue-300 rounded-md p-1 bg-blue-50 time-out"
                                name="time_out[{{ $child->id }}]"
                                value="{{ optional($attendance)->time_out ? date('H:i', strtotime($attendance->time_out)) : '' }}"
                                data-child-id="{{ $child->id }}">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button type="button" class="set-current-time bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded-md text-sm transition"
                                data-child-id="{{ $child->id }}">
                                <i class="fas fa-clock mr-1"></i>Now
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10">
                            <div class="text-gray-500">
                                <i class="fas fa-info-circle text-2xl mb-2"></i>
                                <p>No children are present today to time out.</p>
                                <p class="text-sm mt-1">Children must be marked present first before they can be timed out.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-right mt-6">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-save mr-1"></i>Save All Time Out
                </button>
            </div>
        </form>

        <!-- Legend -->
        <div class="mt-6 flex justify-center space-x-6">
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-green-500 mr-2"></div>
                <span>Time In Recorded</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-purple-500 mr-2"></div>
                <span>Time Out</span>
            </div>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function getCurrentTime() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                return `${hours}:${minutes}`;
            }

            document.querySelectorAll('.set-current-time').forEach(button => {
                button.addEventListener('click', function () {
                    const childId = this.dataset.childId;
                    const timeOutField = document.querySelector(`.time-out[data-child-id="${childId}"]`);
                    timeOutField.value = getCurrentTime();

                    this.innerHTML = '<i class="fas fa-check mr-1"></i>Set';
                    this.classList.remove('bg-purple-500', 'hover:bg-purple-600');
                    this.classList.add('bg-green-500', 'hover:bg-green-600');

                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-clock mr-1"></i>Now';
                        this.classList.remove('bg-green-500', 'hover:bg-green-600');
                        this.classList.add('bg-purple-500', 'hover:bg-purple-600');
                    }, 2000);
                });
            });
        });
    </script>
</x-app-layout>
