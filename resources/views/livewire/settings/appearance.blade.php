<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
        <div x-data="{ 
            appearance: localStorage.getItem('theme') || 'system',
            updateTheme(value) {
                this.appearance = value;
                localStorage.setItem('theme', value);
                this.applyTheme();
            },
            applyTheme() {
                if (this.appearance === 'dark' || (this.appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        }" x-init="applyTheme()" class="space-y-4">
            <p class="text-sm text-primary/70 mb-4">Choose how the interface looks to you. Select a single theme, or sync with your system and automatically switch between day and night themes.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <!-- Light Theme -->
                <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all duration-200"
                       :class="appearance === 'light' ? 'border-primary bg-primary/5' : 'border-primary/20 hover:border-primary/40'">
                    <input type="radio" 
                           name="appearance" 
                           value="light"
                           class="sr-only"
                           x-model="appearance"
                           @change="updateTheme('light')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="font-medium text-primary">{{ __('Light') }}</span>
                    </div>
                    <div x-show="appearance === 'light'" class="absolute top-2 right-2">
                        <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </label>

                <!-- Dark Theme -->
                <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all duration-200"
                       :class="appearance === 'dark' ? 'border-primary bg-primary/5' : 'border-primary/20 hover:border-primary/40'">
                    <input type="radio" 
                           name="appearance" 
                           value="dark"
                           class="sr-only"
                           x-model="appearance"
                           @change="updateTheme('dark')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <span class="font-medium text-primary">{{ __('Dark') }}</span>
                    </div>
                    <div x-show="appearance === 'dark'" class="absolute top-2 right-2">
                        <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </label>

                <!-- System Theme -->
                <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all duration-200"
                       :class="appearance === 'system' ? 'border-primary bg-primary/5' : 'border-primary/20 hover:border-primary/40'">
                    <input type="radio" 
                           name="appearance" 
                           value="system"
                           class="sr-only"
                           x-model="appearance"
                           @change="updateTheme('system')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium text-primary">{{ __('System') }}</span>
                    </div>
                    <div x-show="appearance === 'system'" class="absolute top-2 right-2">
                        <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </label>
            </div>
        </div>
    </x-settings.layout>
</section>
