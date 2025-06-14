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
                   
                    $totalStaffs = \App\Models\Staff::count();
                    $totalChildren = \App\Models\Child::count();

                    $totalRegisteredChildren = \App\Models\Child::whereHas('enrollment', function($query) {
                        $query->where('status', 'approved');
                    })->count();

                  
                    $totalEnrollments = \App\Models\Enrollment::where('status', 'pending')->count();

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

         // Get children records with approved enrollment only
        $childrenRecords = \App\Models\ParentRecord::with(['child' => function($q) {
            $q->whereHas('enrollment', function($query) {
                $query->where('status', 'approved');
            });
        }])
        ->where(function ($query) use ($father, $mother, $guardian) {
            if ($father) $query->orWhere('father_id', $father->id);
            if ($mother) $query->orWhere('mother_id', $mother->id);
            if ($guardian) $query->orWhere('guardian_id', $guardian->id);
        })
        ->get();

        $childrenTot = $childrenRecords->filter(function($record) {
            return $record->child !== null;
        })->count();
        
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

        // Get payment data with statistics
        $payments = $parentRecord
            ? \App\Models\Payment::with('child')
                ->where('parent_id', $parentRecord->id)
                ->orderBy('payment_duedate', 'desc')
                ->take(5)
                ->get()
            : collect();

        // Calculate payment statistics
        $totalUnpaid = $payments->where('payment_status', '!=', 'Complete')->where('payment_status', '!=', 'Paid')->sum('payment_amount');
        $overdueCount = $payments->where('payment_status', 'overdue')->count();
        $upcomingDue = $payments->where('payment_status', '!=', 'Complete')
            ->where('payment_status', '!=', 'Paid')
            ->where('payment_duedate', '>=', now())
            ->where('payment_duedate', '<=', now()->addDays(7))
            ->count();

        // Calculate attendance statistics
        $presentToday = collect($attendanceSummary)->where('status', 'attend')->count();
        $absentToday = collect($attendanceSummary)->where('status', 'absent')->count();
        $notMarkedToday = collect($attendanceSummary)->where('status', 'Not Marked')->count();
    @endphp

    <div class="bg-white rounded-lg overflow-hidden">
        
        {{-- MAIN CONTENT WRAPPER --}}
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- LEFT SECTION - MY CHILDREN --}}
            <div class="lg:w-2/3">
                <div class="mb-8">
                    <!-- Header with Register Button -->
                    <div class="flex items-center justify-between mb-6 w-full">
    <div class="flex items-center">
        <span class="text-3xl mr-3">👨‍👩‍👧‍👦</span>
        <h2 class="text-2xl font-bold text-black-700">My Children</h2>
   
    
    <a href="{{ route('enrollment.createNewChild') }}"
        class="ml-10 bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition duration-300 flex items-center">
        <span class="mr-1">➕</span> Register New Child
    </a>
     </div>
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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
                                                 class="w-full h-full object-cover">
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
            </div>

            {{-- RIGHT SECTION - SUMMARIES --}}
            <div class="lg:w-1/3 space-y-6">
                
                {{-- QUICK STATS OVERVIEW --}}
                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 border-2 border-indigo-200 rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center">
                        <span class="mr-2">📊</span> Today's Overview
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Attendance Stats -->
                        <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                            <div class="text-2xl mb-1">👥</div>
                            <div class="text-2xl font-bold text-green-600">{{ $presentToday }}</div>
                            <div class="text-xs text-gray-600">Present</div>
                        </div>
                        
                        <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                            <div class="text-2xl mb-1">❌</div>
                            <div class="text-2xl font-bold text-red-600">{{ $absentToday }}</div>
                            <div class="text-xs text-gray-600">Absent</div>
                        </div>
                        
                        <!-- Payment Stats -->
                        <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                            <div class="text-2xl mb-1">💰</div>
                            <div class="text-lg font-bold text-yellow-600">RM{{ number_format($totalUnpaid, 0) }}</div>
                            <div class="text-xs text-gray-600">Unpaid</div>
                        </div>
                        
                        <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                            <div class="text-2xl mb-1">⚠️</div>
                            <div class="text-2xl font-bold text-orange-600">{{ $upcomingDue }}</div>
                            <div class="text-xs text-gray-600">Due Soon</div>
                        </div>
                    </div>
                </div>

                {{-- LATEST ANNOUNCEMENT --}}
                <div class="bg-white border-2 border-blue-200 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <span class="mr-2">📢</span> Latest News
                        </h3>
                    </div>
                    
                    <div class="p-4">
                        @if($latestAnnouncement)
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-medium">
                                        {{ ucfirst($latestAnnouncement->announcement_type) }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($latestAnnouncement->announcement_date)->format('M d') }}
                                    </span>
                                </div>
                                
                                <h4 class="font-bold text-gray-800 leading-tight">{{ $latestAnnouncement->announcement_title }}</h4>
                                
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $latestAnnouncement->activity_description }}</p>
                                
                                @if($latestAnnouncement->announcement_location)
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span class="mr-1">📍</span> {{ $latestAnnouncement->announcement_location }}
                                    </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('announcements.index') }}"
                               class="inline-block mt-4 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View all announcements →
                            </a>
                        @else
                            <div class="text-center text-gray-500 py-6">
                                <span class="text-3xl mb-2 block">📢</span>
                                <p class="text-sm">No announcements yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- DAILY BOARD --}}
                <div class="bg-white border-2 border-purple-200 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <span class="mr-2">📝</span> Daily Activity
                        </h3>
                    </div>
                    
                    <div class="p-4">
                        @if($latestDaily)
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full font-medium">
                                        Daily Update
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($latestDaily->post_date)->format('M d') }}
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $latestDaily->post_desc }}</p>
                                
                                @if($latestDaily->post_time)
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span class="mr-1">🕐</span> {{ $latestDaily->post_time }}
                                    </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('daily_activities.index') }}"
                               class="inline-block mt-4 text-purple-600 hover:text-purple-800 text-sm font-medium">
                                View all activities →
                            </a>
                        @else
                            <div class="text-center text-gray-500 py-6">
                                <span class="text-3xl mb-2 block">📝</span>
                                <p class="text-sm">No activities posted yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ATTENDANCE SUMMARY --}}
                <div class="bg-white border-2 border-green-200 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <span class="mr-2">✅</span> Today's Attendance
                        </h3>
                    </div>
                    
                    <div class="p-4">
                        @if(count($attendanceSummary) > 0)
                            <div class="space-y-3">
                                @foreach($attendanceSummary as $row)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            @if($row['status'] === 'attend')
                                                <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                                            @elseif($row['status'] === 'absent')
                                                <span class="w-3 h-3 bg-red-500 rounded-full mr-3"></span>
                                            @else
                                                <span class="w-3 h-3 bg-gray-400 rounded-full mr-3"></span>
                                            @endif
                                            <div>
                                                <p class="font-medium text-sm text-gray-800">{{ $row['name'] }}</p>
                                                @if($row['time_in'])
                                                    <p class="text-xs text-gray-500">In: {{ \Carbon\Carbon::parse($row['time_in'])->format('g:i A') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            @if($row['status'] === 'attend')
                                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Present</span>
                                            @elseif($row['status'] === 'absent')
                                                <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Absent</span>
                                            @else
                                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <a href="{{ route('attendances.parentsIndex') }}"
                               class="inline-block mt-4 text-green-600 hover:text-green-800 text-sm font-medium">
                                View full attendance →
                            </a>
                        @else
                            <div class="text-center text-gray-500 py-6">
                                <span class="text-3xl mb-2 block">📋</span>
                                <p class="text-sm">No attendance data today</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- PAYMENT SUMMARY --}}
                <div class="bg-white border-2 border-yellow-200 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <span class="mr-2">💳</span> Payment Status
                        </h3>
                    </div>
                    
                    <div class="p-4">
                        @if($payments->count() > 0)
                            <!-- Payment Summary Stats -->
                            @if($totalUnpaid > 0 || $overdueCount > 0)
                                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    @if($overdueCount > 0)
                                        <div class="flex items-center text-red-600 mb-2">
                                            <span class="mr-2">⚠️</span>
                                            <span class="text-sm font-medium">{{ $overdueCount }} overdue payment(s)</span>
                                        </div>
                                    @endif
                                    @if($totalUnpaid > 0)
                                        <div class="flex items-center text-yellow-700">
                                            <span class="mr-2">💰</span>
                                            <span class="text-sm">Total outstanding: <strong>RM{{ number_format($totalUnpaid, 2) }}</strong></span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Recent Payments -->
                            <div class="space-y-3">
                                @foreach($payments->take(3) as $payment)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-sm text-gray-800">{{ $payment->child->child_name ?? 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500">Due: {{ \Carbon\Carbon::parse($payment->payment_duedate)->format('M d, Y') }}</p>
                                        </div>
                                        
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-gray-800">RM{{ number_format($payment->payment_amount, 2) }}</p>
                                            @if($payment->payment_status === 'Complete' || $payment->payment_status === 'Paid')
                                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Paid</span>
                                            @elseif($payment->payment_status === 'overdue' || $payment->payment_status === 'Overdue')
                                                <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Overdue</span>
                                            @else
                                                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <a href="{{ route('payments.index') }}"
                               class="inline-block mt-4 text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                View all payments →
                            </a>
                        @else
                            <div class="text-center text-gray-500 py-6">
                                <span class="text-3xl mb-2 block">💳</span>
                                <p class="text-sm">No payment records found</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
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