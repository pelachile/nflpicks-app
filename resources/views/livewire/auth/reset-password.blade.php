<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-primary mb-2">
                {{ __('Email') }}
            </label>
            <input
                wire:model="email"
                id="email"
                type="email"
                required
                autocomplete="email"
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
                {{ __('Reset password') }}
            </button>
        </div>
    </form>
</div>
