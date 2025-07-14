<x-guest-layout>
    <div class="max-w-md w-full mx-auto bg-transparent p-8 rounded-lg">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ __('Create Account') }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ __('Join us today') }}</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" class="dark:text-gray-300" />
                <x-text-input 
                    id="name" 
                    class="block mt-1 w-full px-4 py-3 bg-white/80 dark:bg-gray-800/80 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition backdrop-blur-sm" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    required 
                    autofocus 
                    autocomplete="name"
                    placeholder="John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

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
                    autocomplete="email"
                    placeholder="your@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
                <x-text-input 
                    id="password" 
                    class="block mt-1 w-full px-4 py-3 bg-white/80 dark:bg-gray-800/80 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition backdrop-blur-sm"
                    type="password"
                    name="password"
                    required 
                    autocomplete="new-password"
                    placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="dark:text-gray-300" />
                <x-text-input 
                    id="password_confirmation" 
                    class="block mt-1 w-full px-4 py-3 bg-white/80 dark:bg-gray-800/80 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition backdrop-blur-sm"
                    type="password"
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" class="px-6 py-3  bg-[#15119c] hover:bg-[#191757] focus:ring-[#453fff] focus:ring-offset-2 transition ease-in-out duration-150 text-white rounded-lg flex justify-center items-center">
                    <span class="text-center">{{ __('Register') }}</span>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>