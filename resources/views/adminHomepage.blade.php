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
                    $totalStaffs = \App\Models\Staff::count();
                    $totalChildren = \App\Models\Child::count();

                    //get total child for parents  
                    $parentChildrenCount = auth()->user()->role === 'parents' 
                        ? \App\Models\Child::whereHas('enrollment', function ($query) {
                            $query->where('enrollment_id', auth()->user()->id);
                        })->count()
                        : 0;

                @endphp

                <!-- Display Greeting -->
                <h1 id="greeting" class="text-5xl font-bold mb-10">{{ $greeting }}</h1>
                
                

                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if(auth()->user()->role==='admin')
                    <!-- Children Registration Request Card -->
                    <a href="{{ route('childrenRegisterRequest') }}">
                    <div class="border-2 border-gray-300 p-5 rounded-lg bg-white-100 hover:bg-blue-200 transition duration-300">
                        <p class="text-center font-medium">Children Registration<br/>Request</p>
                        <p class="text-center text-3xl font-bold mt-2">{{$totalEnrollments}}</p>
                    </div>
                    </a>

                    <!-- Total Staff Card -->
                     <a href="{{ route('staffs.index') }}">
                    <div class="border-2 border-gray-300 p-8 rounded-lg bg-white-100 hover:bg-purple-200 transition duration-300">
                        <p class="text-center font-medium">Total Staff</p>
                        <p class="text-center text-3xl font-bold mt-2">{{$totalStaffs}}</p>
                    </div>
                    </a>

                    <!-- Total Children Card -->
                     
                    <a href="{{ route('listChildEnrollment') }}">
                    <div class="border-2 border-gray-300 p-5 rounded-lg bg-white-100 hover:bg-orange-200 transition duration-300">
                    <p class="text-center font-medium">Total Registered<br/>Children</p>
                    <p class="text-center text-3xl font-bold mt-2">{{$totalChildren}}</p>
                    </div>
                    </a>
                    @endif




                    @if(auth()->user()->role === 'staff')
                        @php
                            $userId = auth()->id();
                            $staff = App\Models\Staff::where('user_id', $userId)->first();
                            $totalAssignedChildren = $staff ? App\Models\StaffAssignment::where('primary_staff_id', $staff->id)->count() : 0;
                            $assignedChildren = $staff ? App\Models\StaffAssignment::where('primary_staff_id', $staff->id)->with('child')->get() : [];
                        @endphp
                        
                            
                            <!-- Total Children Assigned to Staff -->
                        <div class="border-2 border-gray-300 p-4 rounded-lg w-30 h-20 flex flex-col justify-center items-center">
                            <p class="text-center font-medium">Total Children</p>
                            <p class="text-center text-4xl font-bold mt-2 text-blue-600">{{ $totalChildren }}</p>

                        </div>

                        <!-- Total Children Assigned to Staff -->
                        <div class="border-2 border-gray-300 p-4 rounded-lg w-30 h-20 flex flex-col justify-center items-center">
                            <p class="text-center font-medium">Total Children Assigned</p>
                            <p class="text-center text-4xl font-bold mt-2 text-green-600">{{ $totalAssignedChildren }}</p>

                        </div>

                        <br>

                        <!-- Assigned Children Table -->
                        <div class="w-full bg-white border border-gray-300 rounded-lg shadow overflow-x-auto ">
                            <table class="w-full table-auto">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-9 text-left font-semibold text-gray-700">Picture</th>
                                        <th class="py-3 px-9 text-left font-semibold text-gray-700">Name</th>
                                        <th class="py-3 px-9 text-left font-semibold text-gray-700">Age</th>
                                        <th class="py-3 px-9 text-left font-semibold text-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($assignedChildren as $assignment)
                                        @php $child = $assignment->child; @endphp
                                        <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if($assignment->child->child_photo)
                                                <div class="flex justify-center">
                                                    <img src="{{ asset('storage/' . $assignment->child->child_photo) }}" 
                                                        alt="Child Photo" 
                                                        class="w-16 h-16 object-cover rounded-full border"
                                                        onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                                </div>
                                            @else
                                                <div class="flex justify-center">
                                                    <img src="{{ asset('images/no-image.png') }}" 
                                                        alt="No Image" 
                                                        class="w-16 h-16 object-cover rounded-full border">
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-t">{{ $assignment->child->child_name }}</td>
                                        <td class="py-2 px-4 border-t">{{ $assignment->child->child_age }} y/o</td>
                                        <td class="py-2 px-4 border-t">
                                            <span class="inline-block px-3 py-1 text-sm rounded-full 
                                                {{ $child->status === 'Active' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                {{ $assignment->status}}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 px-4 text-center text-gray-500">No children assigned.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    @endif

           
                 


                    @if(auth()->user()->role === 'parents')
                    <!-- Total Children for Parents -->
                    <div class="border-2 border-gray-300 p-4 rounded-lg w-30 h-20 flex flex-col justify-center items-center">
                            <p class="text-center font-medium">Total Children</p>
                            <p class="text-center text-4xl font-bold mt-2 text-green-600">0</p>

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
