<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Assign Staff to Children</h2>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('staff.updateAssignments') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Search Bar -->
                    <div class="mb-4">
                        <label for="search" class="block text-sm font-medium text-gray-700">Search Children</label>
                        <input type="text" id="search" onkeyup="filterTable()" placeholder="Enter children name..." class="mt-1 p-2 w-1/3 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    </div>

                    <!-- Student List Table -->
                    <div class="overflow-x-auto">
                        <table id="childrensTable" class="min-w-full bg-white border border-gray-300 rounded-lg">
                            <thead class="bg-[#8A4FFF] text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left">Children Name</th>
                                    <th class="px-4 py-2 text-left">Primary Staff</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($childrens as $child)
                                <tr class="border-t">
                                    <td class="px-4 py-2 child-name">{{ $child->child_name }}</td>
                                    <td class="px-4 py-2">
                                        <select name="primary_staff[{{ $child->id }}]" class="block w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="">Choose Staff</option>
                                            @foreach($staffs as $staff)
                                            <option value="{{ $staff->id }}" 
                                                {{ optional($child->staffAssignment)->primary_staff_id == $staff->id ? 'selected' : '' }}>
                                                {{ $staff->staff_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-4 py-2">
                                        <select name="status[{{ $child->id }}]" class="block w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="no status" {{ $child->status == 'no status' ? 'selected' : '' }}>
                                                No Status
                                            </option>
                                            <option value="active" {{ $child->status == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="offday" {{ $child->status == 'offday' ? 'selected' : '' }}>
                                                Off Day
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-between mt-4">
                        <a href="{{ route('staffs.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500 inline-block text-center">
                            Go Back
                        </a>
                        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function filterTable() {
            let input = document.getElementById("search");
            let filter = input.value.toLowerCase();
            let table = document.getElementById("childrensTable");
            let tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByClassName("child-name")[0];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                } 
            }
        }
    </script>
</x-app-layout>