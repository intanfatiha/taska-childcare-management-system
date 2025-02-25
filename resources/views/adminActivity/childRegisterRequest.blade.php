<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Parent Children Registration</h2>
                </div>
               
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">Request</th>
                                <th class="border px-4 py-2 text-left">Details</th>
                                <th class="border px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="border px-4 py-2">Parent: Aiman & Nuraidah, Children: Adam</td>
                                    <td class="border px-4 py-2">
                                    <a href="#" class="text-blue-500 hover:text-blue-700 underline">
                                        View Details
                                    </a>
                                    </td>                                    <td class="border px-4 py-2">
                                    <div class="mt-1 flex justify-center gap-4">
                                    <!-- Approve Button -->
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-1 px-4 rounded text-sm">
                                        Approve
                                    </button>
                                    <!-- Reject Button -->
                                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-4 rounded text-sm">
                                        Reject
                                    </button>
                                    </div>


                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


