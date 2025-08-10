<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <h3 class="text-lg font-bold text-primary">{{ __('Delete account') }}</h3>
        <p class="text-sm text-primary/60 mt-1">{{ __('Delete your account and all of its resources') }}</p>
    </div>

    <button 
        x-data="" 
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-tomato text-white px-4 py-2 rounded-md hover:bg-tomato/90 transition-colors font-medium"
    >
        {{ __('Delete account') }}
    </button>

    <div x-data="{ show: false }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         @open-modal.window="if ($event.detail === 'confirm-user-deletion') show = true"
         @close-modal.window="if ($event.detail === 'confirm-user-deletion') show = false"
         @click.away="show = false">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        
        <!-- Modal Content -->
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="show" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-lg bg-card text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                 @click.stop>
                
                <form wire:submit="deleteUser" class="space-y-6 p-6">
                    <div>
                        <h3 class="text-lg font-bold text-primary">{{ __('Are you sure you want to delete your account?') }}</h3>
                        <p class="text-sm text-primary/70 mt-2">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-primary mb-1">{{ __('Password') }}</label>
                        <input 
                            wire:model="password" 
                            type="password" 
                            id="password"
                            class="border-primary/20 focus:ring-highlight focus:border-highlight @error('password') border-tomato @enderror"
                        />
                        @error('password')
                            <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button 
                            type="button"
                            @click="show = false"
                            class="bg-primary/10 text-primary px-4 py-2 rounded-md hover:bg-primary/20 transition-colors font-medium"
                        >
                            {{ __('Cancel') }}
                        </button>

                        <button 
                            type="submit"
                            class="bg-tomato text-white px-4 py-2 rounded-md hover:bg-tomato/90 transition-colors font-medium"
                        >
                            {{ __('Delete account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
