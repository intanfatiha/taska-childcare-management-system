<x-guest-layout>
    {{-- Override guest layout default styles --}}
    <style>
        body > div {
            min-height: unset !important;
            display: block !important;
            padding: 0 !important;
            background: transparent !important;
        }
        
        /* Custom styles for better organization */
        .login-container {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        
        .login-form-container {
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .form-input:focus {
            outline: none;
            ring: 2px;
            ring-color: rgb(147 51 234);
            border-color: rgb(147 51 234);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Bubble Animation Styles */
        .bubble-container {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }
        
        .bubble {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
            animation: float-bubble 8s infinite ease-in-out;
        }
        
        .bubble-1 {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, rgba(255, 107, 107, 0.7), rgba(255, 182, 193, 0.7));
            left: 10%;
            animation-delay: 0s;
            animation-duration: 8s;
        }
        
        .bubble-2 {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, rgba(135, 206, 235, 0.7), rgba(173, 216, 230, 0.7));
            right: 20%;
            animation-delay: 2s;
            animation-duration: 10s;
        }
        
        .bubble-3 {
            width: 45px;
            height: 45px;
            background: linear-gradient(45deg, rgba(255, 165, 0, 0.7), rgba(255, 218, 185, 0.7));
            left: 25%;
            animation-delay: 4s;
            animation-duration: 12s;
        }
        
        .bubble-4 {
            width: 70px;
            height: 70px;
            background: linear-gradient(45deg, rgba(147, 112, 219, 0.7), rgba(221, 160, 221, 0.7));
            right: 15%;
            animation-delay: 1s;
            animation-duration: 9s;
        }
        
        .bubble-5 {
            width: 35px;
            height: 35px;
            background: linear-gradient(45deg, rgba(50, 205, 50, 0.7), rgba(144, 238, 144, 0.7));
            left: 5%;
            animation-delay: 3s;
            animation-duration: 11s;
        }
        
        .bubble-6 {
            width: 90px;
            height: 90px;
            background: linear-gradient(45deg, rgba(255, 20, 147, 0.7), rgba(255, 182, 193, 0.7));
            right: 5%;
            animation-delay: 6s;
            animation-duration: 13s;
        }
        
        .bubble-7 {
            width: 55px;
            height: 55px;
            background: linear-gradient(45deg, rgba(255, 215, 0, 0.7), rgba(255, 248, 220, 0.7));
            left: 15%;
            animation-delay: 5s;
            animation-duration: 7s;
        }
        
        .bubble-8 {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, rgba(0, 191, 255, 0.7), rgba(176, 224, 230, 0.7));
            right: 30%;
            animation-delay: 7s;
            animation-duration: 14s;
        }
        
        @keyframes float-bubble {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
            }
            90% {
                opacity: 0.6;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Login form container enhanced styles */
        .form-section {
            position: relative;
            z-index: 2;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-container {
                padding: 1rem;
            }
            
            .bubble {
                width: 30px !important;
                height: 30px !important;
            }
        }
    </style>
    
    {{-- Bubble Animation Container --}}
    <div class="bubble-container">
        <div class="bubble bubble-1"></div>
        <div class="bubble bubble-2"></div>
        <div class="bubble bubble-3"></div>
        <div class="bubble bubble-4"></div>
        <div class="bubble bubble-5"></div>
        <div class="bubble bubble-6"></div>
        <div class="bubble bubble-7"></div>
        <div class="bubble bubble-8"></div>
    </div>

    {{-- Main Login Container --}}
    <div class="login-container flex items-center justify-center px-4 md:px-12"
         style="background-image: url('{{ asset('assets/kid.png') }}');">
        
        {{-- Centered Login Form Section --}}
        <div class="form-section flex flex-col items-center justify-center min-h-screen py-8">
            
            <!-- {{-- Login Header (Visible on all screens) --}}
            <div class="text-center mb-6">
                <h2 class="text-4xl font-bold text-purple-800 mb-2">LOGIN HERE</h2>
                <p class="text-purple-600">Please enter your details...</p>
            </div> -->
            
            {{-- Login Form Container --}}
            <div class="login-form-container  w-[500px] h-[600px] bg-white/95 p-8 rounded-2xl shadow-xl">
                
                {{-- Form Header --}}
                <div class="text-center mb-8">
                    <a href="{{ url('/') }}"> {{-- Change this to your desired URL --}}
                        <img src="{{ asset('assets/ppuk_logo_v2.png') }}" 
                            alt="Logo" 
                            class="w-20 h-20 mx-auto rounded-full mb-4 shadow-md hover:opacity-80 transition duration-200">
                    </a>
                    <h3 class="text-4xl font-semibold text-gray-800">Welcome Back!</h3>
                    <p class="text-sm text-gray-600 mt-2">Please enter your login details below!</p>
                </div>
                
                {{-- Session Status Messages --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />
                
                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    {{-- Email Field --}}
                    <div class="form-group">
                        <x-input-label for="email" 
                                     :value="__('Email Address')" 
                                     class="text-sm font-semibold text-gray-700 mb-2" />
                        <x-text-input 
                            id="email"
                            class="form-input block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                            type="email"
                            name="email"
                            :value="old('email')"
                            placeholder="Enter your email address"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                    </div>
                    
                    {{-- Password Field --}}
                    <div class="form-group">
                        <x-input-label for="password" 
                                     :value="__('Password')" 
                                     class="text-sm font-semibold text-gray-700 mb-2" />
                        <x-text-input 
                            id="password"
                            class="form-input block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                    </div>
                    
                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-600 font-medium">Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a class="text-sm text-purple-600 hover:text-purple-800 font-medium hover:underline transition duration-200" 
                               href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    
                    {{-- Submit Button --}}
                    <div class="pt-4">
                        <button type="submit" 
                                class="btn-login w-full py-3 px-4 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform transition duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            {{ __('LOGIN') }}
                        </button>
                    </div>
                </form>
                
                {{-- Additional Help --}}
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        Need help? Contact us at 
                        <a href="mailto:ppak@uthm.edu.my" class="text-purple-600 hover:underline">
                            ppak@uthm.edu.my
                        </a>
                    </p>
                </div>
            </div>
            
            {{-- Footer Note --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    &copy; {{ date('Y') }} Taska Hikmah. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>