<div class="flex flex-col gap-6">
    <div class="flex w-full flex-col text-center">
        <h1 class="text-3xl font-bold text-primary">{{ __('Create an account') }}</h1>
        <p class="mt-2 text-primary/60">{{ __('Enter your details below to create your account') }}</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-primary mb-2">
                {{ __('Name') }}
            </label>
            <input
                wire:model="name"
                id="name"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="{{ __('Full name') }}"
                class="w-full px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight @error('name') border-tomato @enderror"
            />
            @error('name')
                <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
            @enderror
        </div>

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
            <label for="password" class="block text-sm font-medium text-primary mb-2">
                {{ __('Password') }}
            </label>
            <input
                wire:model="password"
                id="password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="{{ __('Password') }}"
                class="w-full px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight @error('password') border-tomato @enderror"
            />
            @error('password')
                <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-primary mb-2">
                {{ __('Confirm password') }}
            </label>
            <input
                wire:model="password_confirmation"
                id="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                placeholder="{{ __('Confirm password') }}"
                class="w-full px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight @error('password_confirmation') border-tomato @enderror"
            />
            @error('password_confirmation')
                <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="w-full bg-highlight text-white px-4 py-2 rounded-md hover:bg-highlight/90 transition-colors disabled:opacity-50">
                {{ __('Create account') }}
            </button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-primary/60">
        <span>{{ __('Already have an account?') }}</span>
        <a href="{{ route('login') }}" wire:navigate class="text-highlight hover:text-highlight/80 font-medium">
            {{ __('Log in') }}
        </a>
    </div>
</div>
