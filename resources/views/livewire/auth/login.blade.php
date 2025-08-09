<div class="flex flex-col gap-6">
    <div class="flex w-full flex-col text-center">
        <h1 class="text-3xl font-bold text-primary">{{ __('Log in to your account') }}</h1>
        <p class="mt-2 text-primary/60">{{ __('Enter your email and password below to log in') }}</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-primary mb-2">
                {{ __('Email address') }}
            </label>
            <input
                wire:model="email"
                id="email"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
                class="w-full px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight @error('email') border-tomato @enderror"
            />
            @error('email')
                <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-sm font-medium text-primary">
                    {{ __('Password') }}
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" wire:navigate class="text-sm text-highlight hover:text-highlight/80">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
            <input
                wire:model="password"
                id="password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="{{ __('Password') }}"
                class="w-full px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight @error('password') border-tomato @enderror"
            />
            @error('password')
                <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input
                wire:model="remember"
                id="remember"
                type="checkbox"
                class="h-4 w-4 text-highlight border-primary/20 rounded focus:ring-highlight focus:ring-offset-0"
            />
            <label for="remember" class="ml-2 block text-sm text-primary">
                {{ __('Remember me') }}
            </label>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="w-full bg-highlight text-white px-4 py-2 rounded-md hover:bg-highlight/90 transition-colors disabled:opacity-50">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-primary/60">
            <span>{{ __('Don\'t have an account?') }}</span>
            <a href="{{ route('register') }}" wire:navigate class="text-highlight hover:text-highlight/80 font-medium">
                {{ __('Sign up') }}
            </a>
        </div>
    @endif
</div>
