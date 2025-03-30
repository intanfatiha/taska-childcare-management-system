<x-guest-layout>
<div class="mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registration Confirmation') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Your registration has been submitted!</h3>
        <p class="text-gray-600">Your registration is under review. We will notify you once it is approved.</p>

        <div class="mt-6">
            <a href="{{ route('login') }}" 
               class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Back to Login
            </a>
        </div>
    </div>
</div>
</x-guest-layout>
