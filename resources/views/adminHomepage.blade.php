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

                    $totalRegisteredChildren = \App\Models\Child::whereHas('enrollment', function($query) {
                        $query->where('status', 'approved');
                    })->count();

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
                                <p class="text-center text-3xl font-bold mt-2 text-pink-600">{{$totalRegisteredChildren}}</p>
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
                            <p class="text-center text-4xl font-bold mt-2 text-blue-600">{{ $totalRegisteredChildren }}</p>
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

                    <!-- Assigned Children Section -->
<div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden mt-6">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
        <h2 class="text-xl font-semibold text-white flex items-center">
            <span class="mr-2">👨‍👩‍👧‍👦</span> Assigned Children
        </h2>
    </div>
    
   <!-- Scrollable Container -->
<div class="max-h-96 overflow-y-auto p-6 scrollbar-thin">
    <!-- Children Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($assignedChildren as $assignment)
            @php
                $child = $assignment->child;
                $parentRecord = $child
                    ? \App\Models\ParentRecord::with(['father', 'mother', 'guardian'])
                        ->where('child_id', $child->id)
                        ->first()
                    : null;

                $parentsName = '';
                if ($parentRecord) {
                    if ($parentRecord->father && $parentRecord->mother) {
                        $parentsName = $parentRecord->father->father_name . ' & ' . $parentRecord->mother->mother_name;
                    } elseif ($parentRecord->father) {
                        $parentsName = $parentRecord->father->father_name;
                    } elseif ($parentRecord->mother) {
                        $parentsName = $parentRecord->mother->mother_name;
                    } elseif ($parentRecord->guardian) {
                        $parentsName = $parentRecord->guardian->guardian_name;
                    }
                }
            @endphp

            @if($child)
                <!-- Child Card -->
                <div class="border-2 border-indigo-100 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:border-indigo-300 bg-white flex flex-col justify-between">
                    <!-- Child Photo -->
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                        @if($child->child_photo)
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

                    <!-- Child Info -->
                    <div class="p-4 flex-grow">
                        <p class="font-bold text-center text-lg text-indigo-700 mb-3">{{ $child->child_name ?? 'No Name' }}</p>
                        
                        <div class="space-y-2 text-sm">
                            <p class="flex items-center">
                                <span class="mr-2">👨‍👩‍👧‍👦</span> 
                                <span class="font-medium">Parents:</span>
                                <span class="ml-1 truncate">{{ $parentsName ?: 'N/A' }}</span>
                            </p>
                            <p class="flex items-center">
                                <span class="mr-2">🎂</span> 
                                <span class="font-medium">Age:</span>
                                <span class="ml-1">{{ $child->child_age ?? 'N/A' }} years old</span>
                            </p>
                            <p class="flex items-center">
                                <span class="mr-2">📅</span> 
                                <span class="font-medium">Birthday:</span>
                                <span class="ml-1">{{ $child->child_birthdate ?? '-' }}</span>
                            </p>
                            <p class="flex items-center">
                                <span class="mr-2">
                                    @if($child->child_gender == 'Male')
                                        👦
                                    @elseif($child->child_gender == 'Female')
                                        👧
                                    @else
                                        👶
                                    @endif
                                </span>
                                <span class="font-medium">Gender:</span>
                                <span class="ml-1">{{ $child->child_gender ?? '-' }}</span>
                            </p>
                            <p class="flex items-center">
                                <span class="mr-2">⚠️</span> 
                                <span class="font-medium">Allergic:</span>
                                <span class="ml-1 truncate">{{ $child->child_allergies ?? 'No allergies' }}</span>
                            </p>

                            <!-- Status Badge -->
                            <!-- <div class="flex justify-center mt-3">
                                <span class="inline-block px-3 py-1 text-sm rounded-full font-medium
                                    {{ $assignment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($assignment->status) }}
                                </span>
                            </div> -->
                        </div>
                    </div>

                    <!-- View Record Button -->
                    <div class="p-4 pt-0 flex justify-center">
                        @if($child->enrollment)
                            <a href="{{ route('adminActivity.show', ['adminActivity' => $child->enrollment->id]) }}"
                               class="inline-block px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md transition">
                                View Record
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        @empty
            <!-- Empty State -->
            <div class="col-span-full py-12 text-center text-gray-500">
                <div class="flex flex-col items-center">
                    <span class="text-4xl mb-4">🔍</span>
                    <p class="text-lg font-medium">No children assigned yet.</p>
                    <p class="text-sm mt-1">Children will appear here once they are assigned to you.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

                @endif

               @if(auth()->user()->role === 'parents')
    @php
        // Initialize parent data
        $userId = auth()->id();
        $father = \App\Models\Father::where('user_id', $userId)->first();
        $mother = \App\Models\Mother::where('user_id', $userId)->first();
        $guardian = \App\Models\Guardian::where('user_id', $userId)->first();

        // Get children records
        $childrenRecords = \App\Models\ParentRecord::with('child')
            ->where(function ($query) use ($father, $mother, $guardian) {
                if ($father) $query->orWhere('father_id', $father->id);
                if ($mother) $query->orWhere('mother_id', $mother->id);
                if ($guardian) $query->orWhere('guardian_id', $guardian->id);
            })
            ->get();

        $childrenTot = $childrenRecords->count();

        // Get parent record for payments
        $parentRecord = null;
        if ($father) $parentRecord = \App\Models\ParentRecord::where('father_id', $father->id)->first();
        if (!$parentRecord && $mother) $parentRecord = \App\Models\ParentRecord::where('mother_id', $mother->id)->first();
        if (!$parentRecord && $guardian) $parentRecord = \App\Models\ParentRecord::where('guardian_id', $guardian->id)->first();

        // Get latest announcement and daily activity
        $latestAnnouncement = \App\Models\Announcements::orderBy('announcement_date', 'desc')->first();
        $latestDaily = \App\Models\daily_activities::orderBy('post_date', 'desc')->first();

        // Get attendance data for today
        $parentChildIds = $childrenRecords->pluck('child.id')->filter()->all();
        $attendanceSummary = [];
        $today = now()->format('Y-m-d');
        
        foreach ($parentChildIds as $childId) {
            $attendance = \App\Models\Attendance::where('children_id', $childId)
                ->where('attendance_date', $today)
                ->first();
            $attendanceSummary[] = [
                'name' => \App\Models\Child::find($childId)?->child_name ?? '-',
                'status' => $attendance?->attendance_status ?? 'Not Marked',
                'time_in' => $attendance?->time_in,
                'time_out' => $attendance?->time_out,
                'overtime' => $attendance?->attendance_overtime,
            ];
        }

        // Get payment data
        $payments = $parentRecord
            ? \App\Models\Payment::with('child')
                ->where('parent_id', $parentRecord->id)
                ->orderBy('payment_duedate', 'desc')
                ->take(5)
                ->get()
            : collect();
    @endphp

    <div class="bg-white rounded-lg overflow-hidden">
        
        {{-- MY CHILDREN SECTION --}}
        <div class="mb-8">
            <!-- Header with Register Button -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <span class="text-3xl mr-3">👨‍👩‍👧‍👦</span>
                    <h2 class="text-2xl font-bold text-black-700">My Children</h2>
                </div>
                
                <a href="{{ route('enrollment.createNewChild') }}"
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
                <p class="text-center text-4xl font-bold mt-2 text-pink-600">{{ $childrenTot }}</p>
            </div>

            <!-- Children Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($childrenRecords as $record)
                    @php $child = $record->child; @endphp
                    @if($child)
                        <!-- Child Card -->
                        <div class="border-2 border-indigo-100 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:border-indigo-300 bg-white">
                            <!-- Child Photo -->
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                                @if($child->child_photo)
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

                            <!-- Child Information -->
                            <div class="p-4">
                                <p class="font-bold text-center text-lg text-indigo-700 mb-2">{{ $child->child_name ?? 'No Name' }}</p>
                                
                                <div class="space-y-1 text-sm">
                                    <p class="flex items-center">
                                        <span class="mr-2">🎂</span> Age: {{ $child->child_age ?? 'N/A' }} years old
                                    </p>
                                    <p class="flex items-center">
                                        <span class="mr-2">📅</span> Birthday: {{ $child->child_birthdate ?? '-' }}
                                    </p>
                                    <p class="flex items-center">
                                        <span class="mr-2">
                                            @if($child->child_gender == 'Male')
                                                👦
                                            @elseif($child->child_gender == 'Female')
                                                👧
                                            @else
                                                👶
                                            @endif
                                        </span>
                                        Gender: {{ $child->child_gender ?? '-' }}
                                    </p>
                                    <p class="flex items-center">
                                        <span class="mr-2">⚠️</span> Allergic: {{ $child->child_allergies ?? 'No allergies' }}
                                    </p>
                                </div>

                                <!-- Staff Assignment -->
                                @php
                                    $staffAssignment = \App\Models\StaffAssignment::where('child_id', $child->id)
                                        ->whereIn('status', ['active', 'offday'])
                                        ->with('staff')
                                        ->first();
                                @endphp
                                
                               <div class="mt-4">
                                <h3 class="font-semibold text-gray-700 mb-2">Caretaker:</h3>
                                @if($staffAssignment && $staffAssignment->staff)
                                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-3 space-y-1">
                                        <p class="text-indigo-800 font-medium flex items-center">
                                            👩‍🏫 <span class="ml-2">{{ $staffAssignment->staff->staff_name }}</span>
                                        </p>
                                        <p class="text-indigo-700 text-sm flex items-center">
                                            📞 <span class="ml-2">{{ $staffAssignment->staff->staff_phoneno }}</span>
                                        </p>
                                    <div class="flex justify-end mt-2">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold 
                                    {{ $staffAssignment->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($staffAssignment->status) }}
                                </span>
                            </div>

                                </div>
                            @else
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                    <p class="text-red-500 text-sm font-medium">No staff assigned</p>
                                </div>
                            @endif
                        </div>

                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-span-full py-8 flex flex-col items-center justify-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <span class="text-4xl mb-4">🔍</span>
                        <p class="text-gray-500 text-center">No children found. Register your child to see them here.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ANNOUNCEMENTS & DAILY BOARD SECTION --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <!-- Announcements Section -->
            <div class="bg-white border-2 border-indigo-200 rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-indigo-700 mb-4 flex items-center">
                    <span class="mr-2">🔔</span> Latest Announcement
                </h3>

                @if($latestAnnouncement)
                    <div class="mb-4">
                        <!-- Date and Time -->
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($latestAnnouncement->announcement_date)->format('d M Y') }}
                            </span>
                            @if($latestAnnouncement->announcement_time)
                                <span class="text-xs text-gray-500">{{ $latestAnnouncement->announcement_time }}</span>
                            @endif
                        </div>

                        <!-- Title and Description -->
                        <h4 class="font-bold text-lg text-indigo-800 mb-1">{{ $latestAnnouncement->announcement_title }}</h4>
                        <p class="text-gray-700 mb-2">{{ $latestAnnouncement->activity_description }}</p>

                        <!-- Location -->
                        @if($latestAnnouncement->announcement_location)
                            <p class="text-sm text-gray-500 mb-1">
                                <span class="font-semibold">Location:</span> {{ $latestAnnouncement->announcement_location }}
                            </p>
                        @endif

                        <!-- Type -->
                        <p class="text-sm text-indigo-600 mt-1 font-semibold italic">
                            Type: {{ ucfirst($latestAnnouncement->announcement_type) }}
                        </p>
                    </div>

                    <a href="{{ route('announcements.index') }}"
                       class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        View All Announcements
                    </a>
                @else
                    <div class="text-center text-gray-500 py-8">
                        <span class="text-2xl mb-2 block">🔔</span>
                        <p>No announcements found.</p>
                    </div>
                @endif
            </div>

            <!-- Daily Board Section -->
            <div class="bg-white border-2 border-indigo-200 rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-indigo-700 mb-4 flex items-center">
                    <span class="mr-2">📅</span> Daily Board
                </h3>

                @if($latestDaily)
                    <div class="mb-4">
                        <!-- Date and Time -->
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($latestDaily->post_date)->format('d M Y') }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $latestDaily->post_time }}</span>
                        </div>

                        <!-- Title and Description -->
                        <h4 class="font-bold text-lg text-indigo-800 mb-1">Daily Activity</h4>
                        <p class="text-gray-700 mb-2">{{ $latestDaily->post_desc }}</p>
                    </div>

                    <a href="{{ route('daily_activities.index') }}"
                       class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        View All Daily Board
                    </a>
                @else
                    <div class="text-center text-gray-500 py-8">
                        <span class="text-2xl mb-2 block">📅</span>
                        <p>No daily board posts found.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ATTENDANCE SECTION --}}
        <div class="bg-white border-2 border-green-200 rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-bold text-green-700 mb-4 flex items-center">
                <span class="mr-2">🗓️</span> Attendance Summary
            </h3>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Child Name</th>
                            <th class="border px-4 py-2 text-left">Status</th>
                            <th class="border px-4 py-2 text-left">Time In</th>
                            <th class="border px-4 py-2 text-left">Time Out</th>
                            <th class="border px-4 py-2 text-left">Overtime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendanceSummary as $row)
                            <tr>
                                <td class="border px-4 py-2">{{ $row['name'] }}</td>
                                <td class="border px-4 py-2">
                                    @if($row['status'] === 'attend')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded">Present</span>
                                    @elseif($row['status'] === 'absent')
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded">Absent</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $row['status'] }}</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $row['time_in'] ? \Carbon\Carbon::parse($row['time_in'])->format('g:i A') : '-' }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $row['time_out'] ? \Carbon\Carbon::parse($row['time_out'])->format('g:i A') : '-' }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $row['overtime'] && $row['overtime'] > 0 ? $row['overtime'].' min' : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No attendance data for today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('attendances.parentsIndex') }}"
               class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                View Full Attendance
            </a>
        </div>

        {{-- PAYMENT SECTION --}}
        <div class="bg-white border-2 border-yellow-200 rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-bold text-yellow-700 mb-4 flex items-center">
                <span class="mr-2">💳</span> Payment Summary
            </h3>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Child Name</th>
                            <th class="border px-4 py-2 text-left">Amount</th>
                            <th class="border px-4 py-2 text-left">Due Date</th>
                            <th class="border px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="border px-4 py-2">{{ $payment->child->child_name ?? '-' }}</td>
                                <td class="border px-4 py-2">RM {{ number_format($payment->payment_amount, 2) }}</td>
                                <td class="border px-4 py-2">
                                    {{ $payment->payment_duedate ? \Carbon\Carbon::parse($payment->payment_duedate)->format('Y-m-d') : '-' }}
                                </td>
                                <td class="border px-4 py-2">
                                    @if($payment->payment_status === 'Complete' || $payment->payment_status === 'Paid')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded">Paid</span>
                                    @elseif($payment->payment_status === 'overdue' || $payment->payment_status === 'Overdue')
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded">Overdue</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Unpaid</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">No payment records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('payments.index') }}"
               class="inline-block mt-4 px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">
                View All Payments
            </a>
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