<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('TASKA HIKMAH') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Configure Greetings Time-->
                @php
                    $currentHour = \Carbon\Carbon::now()->format('H'); // Current hour in 24-hour format
                    if ($currentHour >= 5 && $currentHour < 12) {
                        $greeting = 'Good Morning!'; // 5am to before 12pm
                    } elseif ($currentHour >= 12 && $currentHour < 19) {
                        $greeting = 'Good Afternoon!'; // 12pm to before 7pm
                    } else {
                        $greeting = 'Good Evening!'; // 7pm to before 5am
                    }
                @endphp
                
                <!-- Display Greeting -->
                <h1 class="text-5xl font-bold mb-10">{{ $greeting }}</h1>
                
                @if(auth()->user()->role==='admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Children Registration Request Card -->
                    <a href="{{ route('childrenRegisterRequest') }}">
                    <div class="border-2 border-gray-300 p-5 rounded-lg">
                        <p class="text-center font-medium">Children Registration<br/>Request</p>
                        <p class="text-center text-3xl font-bold mt-2">2</p>
                    </div>
                    </a>

                    <!-- Total Staff Card -->
                     <a href="{{ route('staffs.index') }}">
                    <div class="border-2 border-gray-300 p-8 rounded-lg">
                        <p class="text-center font-medium">Total Staff</p>
                        <p class="text-center text-3xl font-bold mt-2">6</p>
                    </div>
                    </a>
                    @endif

                    @if(auth()->user()->role==='admin')
                    <!-- Total Children Card -->
                    <div class="border-2 border-gray-300 p-4 rounded-lg">
                        <p class="text-center font-medium">Total Children</p>
                        <p class="text-center text-3xl font-bold mt-2">6</p>
                    </div>
                    @endif

                    @if(auth()->user()->role==='staff')
                    <div class="border-2 border-gray-300 p-4 rounded-lg w-40 h-40 flex flex-col justify-center items-center">
                    <p class="text-center font-medium">Total Children</p>
                        <p class="text-center text-3xl font-bold mt-2">6</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
