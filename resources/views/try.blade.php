<x-guest-layout>
        <div class="text-center mb-6">
            <p class="mt-2 text-lg text-gray-600">TASKA HIKMAH CHILDCARE MANAGEMENT</p>
        </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('processRelationType') }}">
        @csrf

        <div class="mb-6">
                        <label class="block text-lg font-medium text-gray-700 mb-2">Choose Relation Type:</label>
                        <div class="flex items-center mb-4">
                            <input type="radio" id="parents" name="relation" value="parents" 
                                   class="mr-2 text-blue-500 focus:ring-blue-400">
                            <label for="parents" class="text-gray-700">Parents</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="guardian" name="relation" value="guardian" 
                                   class="mr-2 text-blue-500 focus:ring-blue-400">
                            <label for="guardian" class="text-gray-700">Guardian</label>
                        </div>
                        @error('relation')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-right">
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Next
                        </button>
                      
                    </div>
                </form>
      
    
</x-guest-layout>
