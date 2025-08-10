<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <div>
                <label for="current_password" class="block text-sm font-medium text-primary mb-1">{{ __('Current password') }}</label>
                <input 
                    wire:model="current_password"
                    type="password" 
                    id="current_password"
                    required
                    autocomplete="current-password"
                    class="border-primary/20 focus:ring-highlight focus:border-highlight @error('current_password') border-tomato @enderror"
                />
                @error('current_password')
                    <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-primary mb-1">{{ __('New password') }}</label>
                <input 
                    wire:model="password"
                    type="password" 
                    id="password"
                    required
                    autocomplete="new-password"
                    class="border-primary/20 focus:ring-highlight focus:border-highlight @error('password') border-tomato @enderror"
                />
                @error('password')
                    <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-primary mb-1">{{ __('Confirm Password') }}</label>
                <input 
                    wire:model="password_confirmation"
                    type="password" 
                    id="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="border-primary/20 focus:ring-highlight focus:border-highlight @error('password_confirmation') border-tomato @enderror""
                />
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <button 
                    type="submit" 
                    class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90 transition-colors font-medium"
                >
                    {{ __('Save') }}
                </button>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
