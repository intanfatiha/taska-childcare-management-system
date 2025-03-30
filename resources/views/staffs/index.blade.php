<!-- index.blade -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Staff List</h2>
                <!-- Register New Staff Button -->
                    
                <div class="d-flex gap-2">
                    <a href="{{ route('staffs.create') }}" class="btn btn-sm" style="background-color:rgb(221, 130, 221); color: white;">
                        Register New Staff
                    </a>

                    <a href="{{ route('staffs.staffAssignment') }}" class="btn btn-sm" style="background-color:rgb(221, 130, 221); color: white;">
                        Staff Assignment
                    </a>

                </div>
               

                </div>
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
                 @endif

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-[#8A4FFF] text-white">
                                <th class="border px-4 py-2 text-left">Staff Name</th>
                                <th class="border px-4 py-2 text-left">IC</th>
                                <th class="border px-4 py-2 text-left">Email</th>
                                <th class="border px-4 py-2 text-left">Phone Number</th>
                                <th class="border px-4 py-2 text-left">Address</th>
                                <th class="border px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staffList as $staff)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $staff->staff_name }}</td>
                                    <td class="border px-4 py-2">{{ $staff->staff_ic }}</td>
                                    <td class="border px-4 py-2">{{ $staff->staff_email }}</td>
                                    <td class="border px-4 py-2">{{ $staff->staff_phoneno }}</td>
                                    <td class="border px-4 py-2">{{ $staff->staff_address }}</td>
                                    <td class="border px-4 py-2">
                                    <div class="mt-4 flex justify-end gap-4">
                                          <!-- Edit Button -->
                                        <a href="{{ route('staffs.edit', $staff->id) }}" class="text-blue-500 hover:text-blue-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>

                                         <form method="POST" action="{{ route('staffs.destroy', $staff->id) }}" onsubmit="return confirm('Are you sure you want to delete this?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 7l16 0" />
                                                <path d="M10 11l0 6" />
                                                <path d="M14 11l0 6" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>
                                    </form>
                                    </div>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


