<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Configure Greetings Time-->
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
                    </div>

                <!-- Display Greeting -->
                <div class="flex items-center mb-8">
                    <h1 id="greeting" class="text-4xl font-bold text-black-700">{{ $greeting }} <span id="greeting-icon"></span></h1>
                </div>
                
                <!-- Admin Dashboard -->
                @if(auth()->user()->role === 'admin')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        <!-- Children Registration Request Card -->
                        <a href="{{ route('childrenRegisterRequest') }}" class="transform transition duration-300 hover:scale-105">
                            <div class="border-2 border-indigo-200 p-6 rounded-lg bg-gradient-to-br from-white to-indigo-50 shadow-md hover:shadow-lg">
                                <div class="flex items-center justify-center mb-3">
                                    <span class="text-3xl">👶</span>
                                </div>
                                <p class="text-center font-medium text-gray-700">Children Registration Request</p>
                                <p class="text-center text-3xl font-bold mt-2 text-indigo-600">{{$totalEnrollments}}</p>
                            </div>
                        </a>

                        <!-- Total Staff Card -->
                        <a href="{{ route('staffs.index') }}" class="transform transition duration-300 hover:scale-105">
                            <div class="border-2 border-purple-200 p-6 rounded-lg bg-gradient-to-br from-white to-purple-50 shadow-md hover:shadow-lg">
                                <div class="flex items-center justify-center mb-3">
                                    <span class="text-3xl">👩‍🏫</span>
                                </div>
                                <p class="text-center font-medium text-gray-700">Total Staff</p>
                                <p class="text-center text-3xl font-bold mt-2 text-purple-600">{{$totalStaffs}}</p>
                            </div>
                        </a>

                        <!-- Total Children Card -->
                        <a href="{{ route('listChildEnrollment') }}" class="transform transition duration-300 hover:scale-105">
                            <div class="border-2 border-pink-200 p-6 rounded-lg bg-gradient-to-br from-white to-pink-50 shadow-md hover:shadow-lg">
                                <div class="flex items-center justify-center mb-3">
                                    <span class="text-3xl">🧒</span>
                                </div>
                                <p class="text-center font-medium text-gray-700">Total Registered Children</p>
                                <p class="text-center text-3xl font-bold mt-2 text-pink-600">{{$totalChildren}}</p>
                            </div>
                        </a>
                    </div>

                        
                <!-- Login History -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden mt-6">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-1">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <span class="mr-2">📜</span> Login History
                        </h2>
                    </div>
                    <div class="overflow-x-auto" style="max-height: 200px; overflow-y: auto;">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-6 text-left font-semibold text-gray-700 border-b">User</th>
                                    <th class="py-3 px-6 text-left font-semibold text-gray-700 border-b">Role</th>
                                    <th class="py-3 px-6 text-left font-semibold text-gray-700 border-b">IP Address</th>
                                    <th class="py-3 px-6 text-left font-semibold text-gray-700 border-b">User Agent</th>
                                    <th class="py-3 px-6 text-left font-semibold text-gray-700 border-b">Login Time</th>
                                    <th class="py-3 px-6 text-left font-semibold text-gray-700 border-b">Logout Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $loginHistories = \App\Models\LoginHistory::with('user')->orderBy('login_time', 'desc')->take(10)->get();
                                @endphp
                                @forelse($loginHistories as $history)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 border-b">{{ $history->user->name }}</td>
                                        <td class="px-6 py-4 border-b">{{ $history->user->role }}</td>
                                        <td class="px-6 py-4 border-b">{{ $history->ip_address }}</td>
                                        <td class="px-6 py-4 border-b">{{ $history->user_agent }}</td>
                                        <td class="px-6 py-4 border-b">{{ $history->login_time }}</td>
                                        <td class="px-6 py-4 border-b">{{ $history->logout_time ?? 'Still Logged In' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 px-6 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <span class="text-2xl mb-2">🔍</span>
                                                <p>No login history found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Staff Dashboard -->
                @if(auth()->user()->role === 'staff')
                    @php
                        $userId = auth()->id();
                        $staff = App\Models\Staff::where('user_id', $userId)->first();
                        $totalAssignedChildren = $staff ? App\Models\StaffAssignment::where('primary_staff_id', $staff->id)->count() : 0;
                        $assignedChildren = $staff ? App\Models\StaffAssignment::where('primary_staff_id', $staff->id)->with('child')->get() : [];
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        <!-- Total Children Card -->
                        <div class="border-2 border-blue-200 p-6 rounded-lg bg-gradient-to-br from-white to-blue-50 shadow-md">
                            <div class="flex items-center justify-center mb-2">
                                <span class="text-3xl">🧒</span>
                            </div>
                            <p class="text-center font-medium text-gray-700">Total Children</p>
                            <p class="text-center text-4xl font-bold mt-2 text-blue-600">{{ $totalChildren }}</p>
                        </div>

                        <!-- Total Children Assigned Card -->
                        <div class="border-2 border-green-200 p-6 rounded-lg bg-gradient-to-br from-white to-green-50 shadow-md">
                            <div class="flex items-center justify-center mb-2">
                                <span class="text-3xl">👩‍👦</span>
                            </div>
                            <p class="text-center font-medium text-gray-700">Total Children Assigned</p>
                            <p class="text-center text-4xl font-bold mt-2 text-green-600">{{ $totalAssignedChildren }}</p>
                        </div>
                    </div>

                    <!-- Assigned Children Table -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden mt-6">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <span class="mr-2">👨‍👩‍👧‍👦</span> Assigned Children
                            </h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="py-3 px-6 text-left font-semibold text-gray-700 border-b">Picture</th>
                                        <th class="py-3 px-6 text-left font-semibold text-gray-700 border-b">Name</th>
                                        <th class="py-3 px-6 text-left font-semibold text-gray-700 border-b">Age</th>
                                        <th class="py-3 px-6 text-left font-semibold text-gray-700 border-b">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($assignedChildren as $assignment)
                                        @php $child = $assignment->child; @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 border-b">
                                                @if($assignment->child->child_photo)
                                                    <div class="flex justify-center">
                                                        <img src="{{ asset('storage/' . $assignment->child->child_photo) }}" 
                                                            alt="Child Photo" 
                                                            class="w-16 h-16 object-cover rounded-full border-2 border-indigo-200"
                                                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                                    </div>
                                                @else
                                                    <div class="flex justify-center">
                                                        <img src="{{ asset('images/no-image.png') }}" 
                                                            alt="No Image" 
                                                            class="w-16 h-16 object-cover rounded-full border-2 border-gray-200">
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 border-b font-medium">{{ $assignment->child->child_name }}</td>
                                            <td class="px-6 py-4 border-b">{{ $assignment->child->child_age }} y/o</td>
                                            <td class="px-6 py-4 border-b">
                                                <span class="inline-block px-3 py-1 text-sm rounded-full 
                                                    {{ $assignment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $assignment->status}}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-6 px-6 text-center text-gray-500">
                                                <div class="flex flex-col items-center">
                                                    <span class="text-2xl mb-2">🔍</span>
                                                    <p>No children assigned yet.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Parent Dashboard -->
                @if(auth()->user()->role === 'parents')
                    
                    @php
                        $userId = auth()->id();

                        $totalChildren = \App\Models\ParentRecord::where(function ($query) use ($userId) {
                            $query->where('father_id', $userId)
                                ->orWhere('mother_id', $userId)
                                ->orWhere('guardian_id', $userId);
                        })->count();

                        $children = \App\Models\ParentRecord::where(function ($query) use ($userId) {
                            $query->where('father_id', $userId)
                                ->orWhere('mother_id', $userId)
                                ->orWhere('guardian_id', $userId);
                        })->with('child')->get();
                    @endphp

                    <div class="bg-white rounded-lg overflow-hidden">
                        <!-- Header with button -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <span class="text-3xl mr-3">👨‍👩‍👧‍👦</span>
                                <h2 class="text-2xl font-bold text-black-700">My Children</h2>
                            </div>
                           
                            <a href="#" 
                                class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition duration-300 flex items-center">
                                    <span class="mr-1">➕</span> Register New Child
                                

                            </a>
                        </div>
                        
                        <!-- Total Children Card -->
                        <div class="mb-8 border-2 border-pink-200 p-6 rounded-lg bg-gradient-to-br from-white to-pink-50 shadow-md w-48">
                            <div class="flex items-center justify-center mb-2">
                                <span class="text-3xl">👶</span>
                            </div>
                            <p class="text-center font-medium text-gray-700">Your Children</p>
                            <p class="text-center text-4xl font-bold mt-2 text-pink-600">{{ $totalChildren }}</p>
                        </div>

                        <!-- Children Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @forelse($children as $record)
                                @php $child = $record->child; @endphp
                                <div class="border-2 border-indigo-100 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:border-indigo-300 bg-white">
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                                        @if($child && $child->child_photo)
                                            <img src="{{ asset('storage/' . $child->child_photo) }}"
                                                alt="Child Photo"
                                                class="w-full h-full object-cover"
                                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}"
                                                alt="No Image"
                                                class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <p class="font-bold text-center text-lg text-indigo-700 mb-2">{{ $child->child_name ?? 'No Name' }}</p>
                                        <div class="space-y-1 text-sm">
                                            <p class="flex items-center"><span class="mr-2">🎂</span> Age: {{ $child->child_age ?? 'N/A' }} years old</p>
                                            <p class="flex items-center"><span class="mr-2">📅</span> Birthday: {{ $child->birthdate ?? '-' }}</p>
                                            <p class="flex items-center">
                                                <span class="mr-2">
                                                    @if($child->gender == 'Male')
                                                        👦
                                                    @elseif($child->gender == 'Female')
                                                        👧
                                                    @else
                                                        👶
                                                    @endif
                                                </span>
                                                Gender: {{ $child->gender ?? '-' }}
                                            </p>
                                            <p class="flex items-center"><span class="mr-2">⚠️</span> Allergic: {{ $child->allergy ?? 'No allergies' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-8 flex flex-col items-center justify-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                    <span class="text-4xl mb-4">🔍</span>
                                    <p class="text-gray-500 text-center">No children found. Register your child to see them here.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
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