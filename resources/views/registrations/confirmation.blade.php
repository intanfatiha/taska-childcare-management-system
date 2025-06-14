<x-guest-layout>
    <div class="relative flex flex-col items-center justify-center min-h-screen w-full bg-cover bg-center"
         style="background-image: url('{{ asset('assets/kid.png') }}');">

        <!-- Optional white overlay for readability -->
        <!-- <div class="absolute inset-0 bg-white/70 backdrop-blur-sm"></div> -->
<div class="flex flex-col items-center">
<h2 class="font-extrabold text-4xl text-purple-600 mb-5 z-10 -mt-14 drop-shadow-md">
    Registration Confirmation
</h2>
            </div>
        <!-- Main content card -->
<div class="relative w-full max-w-md p-8 rounded-3xl shadow-xl bg-white border-4 border-purple-200 z-10 -mt-15">
           

            <div class="flex flex-col items-center mt-4">
                <h3 class="text-lg font-semibold text-blue-700 mb-2">🎉 Your registration has been submitted! 🎉</h3>
                <p class="text-gray-700 text-center mb-4">
                    Thank you for joining our childcare family!<br>
                    Your registration is under review.<br>
                    We will notify you once it is approved.
                </p>

                <div class="mt-6">
                   @if(auth()->check() && auth()->user()->role === 'parents')
                        <a href="{{ route('adminHomepage') }}"
                        class="bg-gradient-to-r from-pink-400 to-purple-400 text-white px-8 py-2 rounded-full font-bold shadow hover:from-pink-500 hover:to-yellow-500 transition">
                            Back to Homepage
                        </a>
                    @else
                        <a href="{{ url('/') }}"
                        class="bg-gradient-to-r from-pink-400 to-purple-400 text-white px-8 py-2 rounded-full font-bold shadow hover:from-pink-500 hover:to-yellow-500 transition">
                            Back to Homepage
                        </a>
                    @endif
                </div>

                
            </div>
        </div>
    </div>
</x-guest-layout>
