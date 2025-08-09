<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-primary mb-2">
                {{ __('Email Address') }}
            </label>
            <input
                wire:model="email"
                id="email"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
                class="w-full px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight @error('email') border-tomato @enderror"
            />
            @error('email')
                <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-highlight text-white px-4 py-2 rounded-md hover:bg-highlight/90 transition-colors disabled:opacity-50">
            {{ __('Email password reset link') }}
        </button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-primary/60">
        <span>{{ __('Or, return to') }}</span>
        <a href="{{ route('login') }}" wire:navigate class="text-highlight hover:text-highlight/80 font-medium">
            {{ __('log in') }}
        </a>
    </div>
</div>
