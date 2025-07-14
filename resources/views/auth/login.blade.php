<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="max-w-md w-full mx-auto bg-transparent p-8 rounded-lg">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ __('Welcome Back') }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ __('Sign in to your account') }}</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" class="dark:text-gray-300" />
                <x-text-input 
                    id="email" 
                    class="block mt-1 w-full px-4 py-3 bg-white/80 dark:bg-gray-800/80 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition backdrop-blur-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="your@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between">
                    <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>
                
                <x-text-input 
                    id="password" 
                    class="block mt-1 w-full px-4 py-3 bg-white/80 dark:bg-gray-800/80 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition backdrop-blur-sm"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••" />
                
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded bg-white/80 dark:bg-gray-800/80"
                    name="remember">
                <label for="remember_me" class="ms-2 block text-sm text-gray-700 dark:text-gray-300">
                    {{ __('Remember me') }}
                </label>
            </div>

            <div>
                <button type="submit" class="w-full py-3 px-4 bg-[#15119c] hover:bg-[#191757] focus:ring-[#453fff] focus:ring-offset-2 transition ease-in-out duration-150 text-white rounded-lg flex justify-center items-center">
                    <span class="text-center">{{ __('Sign In') }}</span>
                </button>
            </div>

            @if (Route::has('register'))
                <div class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
                    {{ __("Don't have an account?") }}
                    <a class="font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" href="{{ route('register') }}">
                        {{ __('Create one') }}
                    </a>
                </div>
            @endif
        </form>
    </div>
</x-guest-layout>