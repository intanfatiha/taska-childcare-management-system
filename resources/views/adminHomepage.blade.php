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
                        $role = auth()->user()->role;

                        $father = \App\Models\Father::where('user_id', $userId)->first();
                        $mother = \App\Models\Mother::where('user_id', $userId)->first();
                        $guardian = \App\Models\Guardian::where('user_id', $userId)->first();

                        $childrenRecords = \App\Models\ParentRecord::with('child')
                            ->where(function ($query) use ($father, $mother, $guardian) {
                                if ($father) $query->orWhere('father_id', $father->id);
                                if ($mother) $query->orWhere('mother_id', $mother->id);
                                if ($guardian) $query->orWhere('guardian_id', $guardian->id);
                            })
                            ->get();

                        $childrenTot = $childrenRecords->count();


                         //get total child for parents  
                        $parentChildrenCount = auth()->user()->role === 'parents' 
                            ? \App\Models\Child::whereHas('enrollment', function ($query) {
                                $query->where('enrollment_id', auth()->user()->id);
                            })->count() : 0;

                        
                        $latestAnnouncements = \App\Models\Announcements::orderBy('announcement_date', 'desc')->take(5)->get();



                    @endphp

                    <div class="bg-white rounded-lg overflow-hidden">
                        <!-- Header with button -->
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

                      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @forelse($childrenRecords as $record)
                            @php $child = $record->child; @endphp
                            @if($child)
                            <div class="border-2 border-indigo-100 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:border-indigo-300 bg-white">
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
                                <div class="p-4">
                                    <p class="font-bold text-center text-lg text-indigo-700 mb-2">{{ $child->child_name ?? 'No Name' }}</p>
                                    <div class="space-y-1 text-sm">
                                        <p class="flex items-center"><span class="mr-2">🎂</span> Age: {{ $child->child_age ?? 'N/A' }} years old</p>
                                        <p class="flex items-center"><span class="mr-2">📅</span> Birthday: {{ $child->child_birthdate ?? '-' }}</p>
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
                                        <p class="flex items-center"><span class="mr-2">⚠️</span> Allergic: {{ $child->allergy ?? 'No allergies' }}</p>
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

                   <!-- Announcements & Daily Board Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Announcements Section -->
                    <!-- Announcements Section -->
                    <div class="bg-white border-2 border-indigo-200 rounded-lg shadow-md p-6 mt-6">
                        <h3 class="text-xl font-bold text-indigo-700 mb-4 flex items-center">
                            <span class="mr-2">🔔</span> Latest Announcement
                        </h3>

                        @php
                            $latestAnnouncement = \App\Models\Announcements::orderBy('announcement_date', 'desc')->first();
                        @endphp

                        @if($latestAnnouncement)
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($latestAnnouncement->announcement_date)->format('d M Y') }}</span>
                                    @if($latestAnnouncement->announcement_time)
                                        <span class="text-xs text-gray-500">{{ $latestAnnouncement->announcement_time }}</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-lg text-indigo-800 mb-1">{{ $latestAnnouncement->announcement_title }}</h4>
                                <p class="text-gray-700 mb-2">{{ $latestAnnouncement->activity_description }}</p>

                                @if($latestAnnouncement->announcement_location)
                                    <p class="text-sm text-gray-500 mb-1"><span class="font-semibold">Location:</span> {{ $latestAnnouncement->announcement_location }}</p>
                                @endif
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
                                <span class="text-2xl mb-2">🔔</span>
                                <p>No announcements found.</p>
                            </div>
                        @endif
                    </div>


                    <!-- Daily Board Section -->
                    <div class="bg-white border-2 border-indigo-200 rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-indigo-700 mb-4 flex items-center">
                            <span class="mr-2">📅</span> Daily Board
                        </h3>
                        @php
                            $latestDaily = \App\Models\daily_activities::orderBy('post_date', 'desc')->first();
                        @endphp
                        @if($latestDaily)
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($latestDaily->post_date)->format('d M Y') }}</span>
                                    <span class="text-xs text-gray-500">{{ $latestDaily->post_time }}</span>
                                </div>
                                <h4 class="font-bold text-lg text-indigo-800 mb-1">Daily Activity</h4>
                                <p class="text-gray-700 mb-2">{{ $latestDaily->post_desc }}</p>
                            </div>
                            <a href="{{ route('daily_activities.index') }}"
                            class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                                View All Daily Board
                            </a>
                        @else
                            <div class="text-center text-gray-500 py-8">
                                <span class="text-2xl mb-2">📅</span>
                                <p>No daily board posts found.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Attendance Section -->
                    <div class="bg-white border-2 border-green-200 rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-xl font-bold text-green-700 mb-4 flex items-center">
                            <span class="mr-2">🗓️</span> Attendance Summary
                        </h3>
                        @php
                            // Get all children for this parent
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
                        @endphp
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
                        <a href="{{ route('attendances.index') }}"
                        class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            View Full Attendance
                        </a>
                    </div>

                    <!-- Payment Section -->
                    <div class="bg-white border-2 border-yellow-200 rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-xl font-bold text-yellow-700 mb-4 flex items-center">
                            <span class="mr-2">💳</span> Payment Summary
                        </h3>
                        @php
                            $parentRecord = null;
                            if ($father) $parentRecord = \App\Models\ParentRecord::where('father_id', $father->id)->first();
                            if (!$parentRecord && $mother) $parentRecord = \App\Models\ParentRecord::where('mother_id', $mother->id)->first();
                            if (!$parentRecord && $guardian) $parentRecord = \App\Models\ParentRecord::where('guardian_id', $guardian->id)->first();
                            $payments = $parentRecord
                                ? \App\Models\Payment::with('child')->where('parent_id', $parentRecord->id)->orderBy('payment_duedate', 'desc')->take(5)->get()
                                : collect();
                        @endphp
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
                                            <td class="border px-4 py-2">{{ $payment->payment_duedate ? \Carbon\Carbon::parse($payment->payment_duedate)->format('Y-m-d') : '-' }}</td>
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