<x-guest-layout>
    <div class="min-h-screen flex bg-gradient-to-r from-indigo-100 via-purple-100 to-pink-100">
        <!-- Left Side - Image & Welcome Text -->
        <div class="hidden lg:flex lg:w-1/2 relative">
            <div class="w-full h-full relative overflow">
                <img 
                    src="{{ asset('assets/Taska-Hikmah-login.jpg') }}" 
                    alt="Taska Hikmah Background"
                    class="w-full h-full object-cover brightness-100"
                />
                <div class="absolute inset-0 bg-gradient-to-br from-blue-900/30 to-purple-900/30"></div>

                <!-- Welcome Message -->
                <div class="absolute inset-0 flex flex-col justify-center items-center text-white p-12">
                    <div class="text-center space-y-4">
                        <h1 class="text-4xl font-extrabold tracking-wide">Welcome to</h1>
                        <h2 class="text-3xl font-bold">TASKA HIKMAH</h2>
                        <p class="text-lg opacity-90 max-w-md">Your trusted partner in nurturing happy, healthy, and bright little minds.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 sm:px-10 py-12 bg-white">
            <div class="w-full max-w-md space-y-8">
                
                <!-- Logo and Heading -->
                <div class="text-center space-y-4">
                    <a href="/">
                        <img src="{{ asset('assets/ppuk_logo.png') }}" alt="Taska Hikmah Logo" class="w-20 h-20 mx-auto rounded-full shadow-md border">
                    </a>
                    <h2 class="text-2xl font-semibold text-gray-800">Parent/Guardian Login</h2>
                    <p class="text-sm text-gray-600">Please sign in to manage your child's enrollment.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Login Form Card -->
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" class="text-sm font-medium text-gray-700 mb-2" />
                            <x-text-input 
                                id="email" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="e.g. parent@example.com" 
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700 mb-2" />
                            <x-text-input 
                                id="password" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password"
                                placeholder="Enter your password" 
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center text-sm">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2" 
                                    name="remember"
                                >
                                <span class="ml-2 text-gray-600">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors" href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <x-primary-button class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 shadow-md hover:shadow-xl transform hover:-translate-y-0.5 focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                                Sign In
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- Mobile Image -->
                <div class="lg:hidden text-center mt-6">
                    <img 
                        src="{{ asset('assets/Taska-Hikmah-login.jpg') }}" 
                        alt="Taska Hikmah"
                        class="w-24 h-24 rounded-full mx-auto object-cover shadow-lg border"
                    />
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
