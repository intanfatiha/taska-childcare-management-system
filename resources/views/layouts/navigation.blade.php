<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-lg">
  <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex justify-between items-center h-16">

      <!-- Left Section: Logo and Title -->
      <div class="flex items-center space-x-4">
        <a href="" class="flex items-center space-x-3">
          <div class="bg-orange-400 p-2 rounded-lg">
            <img src="{{ asset('assets/ppuk_logo.png') }}" alt="Logo" class="h-6 w-6">
          </div>
          <div class="text-gray-900 leading-tight text-left"> <!-- text-left explicitly here -->
            <h1 class="text-lg font-bold">LITTLECARE: CHILDCARE MANAGEMENT SYSTEM</h1>
            <!-- <p class="text-sm text-gray-600">Comprehensive care management solution</p> -->
          </div>
        </a>
      </div>

      <!-- Right Section: Admin Profile -->
<div class="hidden sm:flex items-center space-x-3">
  
  <!-- Oval-shaped Welcome + Dot -->
  <div class="flex items-center bg-gray-100 rounded-full px-4 py-1 space-x-2 shadow-sm">
    <span class="text-gray-900 text-sm">
      Welcome, <span class="font-medium">{{ Auth::user()->name }}</span>
    </span>
    <span class="w-3 h-3 bg-green-400 rounded-full"></span>
  </div>

  <!-- Dropdown Button with same height -->
  <x-dropdown align="right" width="48">
    <x-slot name="trigger">
      <button
        class="flex items-center text-gray-900 hover:text-purple-600 focus:outline-none transition duration-150
               bg-gray-100 rounded-full px-4 py-1 shadow-sm"
        title="User menu"
        style="min-height: 32px;" 
      >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
            clip-rule="evenodd" />
        </svg>
      </button>
    </x-slot>

    <x-slot name="content">
      <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
          {{ __('Log Out') }}
        </x-dropdown-link>
      </form>
    </x-slot>
  </x-dropdown>
</div>


    </div>
  </div>
</nav>
