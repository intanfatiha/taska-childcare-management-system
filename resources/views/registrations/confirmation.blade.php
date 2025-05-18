
<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen w-full bg-gradient-to-br from-yellow-100 via-pink-100 to-blue-100">
        <div class="w-full max-w-md p-8 rounded-3xl shadow-xl bg-white border-4 border-yellow-200">
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/childcare-happy.svg') }}" alt="Happy Kids" class="w-24 h-24 mb-4">
                <h2 class="font-extrabold text-2xl text-pink-600 mb-2">Registration Confirmation</h2>
            </div>
            <div class="flex flex-col items-center mt-4">
                <h3 class="text-lg font-semibold text-blue-700 mb-2">🎉 Your registration has been submitted! 🎉</h3>
                <p class="text-gray-700 text-center mb-4">
                    Thank you for joining our childcare family!<br>
                    Your registration is under review.<br>
                    We will notify you once it is approved.
                </p>
                <div class="mt-6">
                    <a href="{{ url('/') }}"
                       class="bg-gradient-to-r from-pink-400 to-yellow-400 text-white px-8 py-2 rounded-full font-bold shadow hover:from-pink-500 hover:to-yellow-500 transition">
                        Back to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>