<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-primary mb-1">{{ __('Name') }}</label>
                <input 
                    wire:model="name" 
                    type="text" 
                    id="name"
                    required 
                    autofocus 
                    autocomplete="name"
                    class="border-primary/20 focus:ring-highlight focus:border-highlight @error('name') border-tomato @enderror"
                />
                @error('name')
                    <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-primary mb-1">{{ __('Email') }}</label>
                <input 
                    wire:model="email" 
                    type="email" 
                    id="email"
                    required 
                    autocomplete="email"
                    class="border-primary/20 focus:ring-highlight focus:border-highlight @error('email') border-tomato @enderror"
                />
                @error('email')
                    <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                @enderror

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div class="mt-4">
                        <p class="text-sm text-primary/70">
                            {{ __('Your email address is unverified.') }}
                            <button 
                                type="button"
                                wire:click.prevent="resendVerificationNotification"
                                class="text-highlight hover:text-highlight/80 underline cursor-pointer"
                            >
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm font-medium text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <button 
                    type="submit" 
                    class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90 transition-colors font-medium"
                >
                    {{ __('Save') }}
                </button>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
