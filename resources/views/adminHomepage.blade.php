<x-app-layout>
 

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Configure Greetings Time-->
                @php
                    $currentHour = \Carbon\Carbon::now()->format('H'); // Current hour in 24-hour format
                    $fullName = trim(auth()->user()->name); // Get full name and trim spaces

                    // Check if fullName is not empty before splitting
                    $firstName = !empty($fullName) ? explode(' ', $fullName)[0] : 'User';

                    if ($currentHour >= 5 && $currentHour < 12) {
                        $greeting = "Good Morning, $firstName!";
                    } elseif ($currentHour >= 12 && $currentHour < 18) {
                        $greeting = "Good Afternoon, $firstName!";
                    } else {
                        $greeting = "Good Evening, $firstName!";
                    }
                @endphp

                @php
                    $totalEnrollments = \App\Models\Enrollment::count(); 
                @endphp

                <!-- Display Greeting -->
                <h1 id="greeting" class="text-5xl font-bold mb-10">{{ $greeting }}</h1>
                
                

                @if(auth()->user()->role==='admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Children Registration Request Card -->
                    <a href="{{ route('childrenRegisterRequest') }}">
                    <div class="border-2 border-gray-300 p-5 rounded-lg">
                        <p class="text-center font-medium">Children Registration<br/>Request</p>
                        <p class="text-center text-3xl font-bold mt-2">{{$totalEnrollments}}</p>
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

    <!-- real-time updates without refreshing -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let timeNow = new Date().getHours();
            let fullName = @json(auth()->user()->name); //pass php variable here
           // Trim and check if name exists before splitting
            fullName = fullName.trim();
            let firstName = fullName.length > 0 ? fullName.split(" ")[0] : "User";

            let greeting = timeNow >= 5 && timeNow < 12 ? `Good Morning, ${firstName}!☀️` :
                   timeNow >= 12 && timeNow < 18 ? `Good Afternoon, ${firstName}!🌤️ ` :
                   `Good Evening, ${firstName}!🌙`;

            document.getElementById("greeting").innerText = greeting;

        });
    </script>
</x-app-layout>
