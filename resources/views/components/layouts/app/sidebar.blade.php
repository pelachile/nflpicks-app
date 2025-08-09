<!-- Mobile sidebar overlay -->
<div x-data="{ sidebarOpen: false }" class="lg:hidden">
    <!-- Off-canvas menu overlay -->
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-primary/80 backdrop-blur-sm"
        @click="sidebarOpen = false"
    ></div>

    <!-- Mobile sidebar -->
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-soft dark:bg-primary border-r border-primary/20 dark:border-soft/20"
    >
        <!-- Mobile sidebar content -->
        <div class="flex h-full flex-col">
            <!-- Close button and logo -->
            <div class="flex h-16 shrink-0 items-center justify-between px-6 border-b border-primary/20 dark:border-soft/20">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2" wire:navigate>
                    <x-app-logo />
                </a>
                <button
                    @click="sidebarOpen = false"
                    class="text-primary dark:text-soft hover:text-accent dark:hover:text-highlight transition-colors"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <nav class="flex flex-1 flex-col px-6 py-6">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <!-- Platform Section -->
                    <li>
                        <div class="text-xs font-semibold leading-6 text-primary/70 dark:text-soft/70 uppercase tracking-wider mb-3">
                            Platform
                        </div>
                        <ul role="list" class="-mx-2 space-y-1">
                            <li>
                                <a href="{{ route('dashboard') }}"
                                   wire:navigate
                                   class="@if(request()->route()->getName() === 'dashboard') bg-accent text-white @else text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-all duration-200">
                                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('predictions') }}"
                                   wire:navigate
                                   class="@if(request()->route()->getName() === 'predictions') bg-accent text-white @else text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-all duration-200">
                                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.398.815 1.027 1.398 1.8 1.398h.174c.08 0 .157-.031.22-.067.075-.043.158-.097.234-.157.1-.075.206-.15.309-.224.296-.216.514-.467.691-.748a3.468 3.468 0 0 0 .422-.92c.17-.548.267-1.126.267-1.726v-.51H5.904Z" />
                                    </svg>
                                    Picks
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('leaderboard') }}"
                                   wire:navigate
                                   class="@if(request()->route()->getName() === 'leaderboard') bg-accent text-white @else text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-all duration-200">
                                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.228a25.628 25.628 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                                    </svg>
                                    Leaderboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('groups.index') }}"
                                   wire:navigate
                                   class="@if(str_starts_with(request()->route()->getName(), 'groups.')) bg-accent text-white @else text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-all duration-200">
                                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>
                                    My Groups
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Spacer -->
                    <li class="flex-1"></li>
                </ul>
            </nav>

            <!-- Mobile User Profile -->
            <div class="border-t border-primary/20 dark:border-soft/20 px-6 py-4">
                <div x-data="{ mobileUserMenuOpen: false }" class="relative">
                    <button @click="mobileUserMenuOpen = !mobileUserMenuOpen"
                            class="flex w-full items-center gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 transition-colors">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary dark:bg-soft text-soft dark:text-primary font-semibold">
                            {{ auth()->user()->initials() }}
                        </span>
                        <span class="flex-1 text-left">{{ auth()->user()->name }}</span>
                        <svg class="h-5 w-5 text-primary/70 dark:text-soft/70" :class="{'rotate-180': mobileUserMenuOpen}"
                             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Mobile User Dropdown -->
                    <div x-show="mobileUserMenuOpen"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         @click.away="mobileUserMenuOpen = false"
                         class="absolute bottom-full left-0 right-0 mb-2 rounded-md bg-white dark:bg-zinc-800 shadow-lg ring-1 ring-black ring-opacity-5">
                        <div class="p-1">
                            <a href="{{ route('settings.profile') }}"
                               wire:navigate
                               class="@if(str_starts_with(request()->route()->getName(), 'settings.')) bg-soft dark:bg-card/30 text-accent @else text-primary dark:text-soft hover:bg-soft dark:hover:bg-card/20 @endif flex items-center gap-x-3 rounded-md px-3 py-2 text-sm transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a6.759 6.759 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="flex w-full items-center gap-x-3 rounded-md px-3 py-2 text-sm text-accent hover:bg-accent/10 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile header with toggle -->
    <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-primary/20 dark:border-soft/20 bg-soft/80 dark:bg-primary/80 px-4 backdrop-blur-md sm:gap-x-6 sm:px-6">
        <button @click="sidebarOpen = true" class="-m-2.5 p-2.5 text-primary dark:text-soft hover:text-accent dark:hover:text-highlight transition-colors">
            <span class="sr-only">Open sidebar</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <!-- Mobile breadcrumb or title -->
        <div class="flex-1 text-sm font-semibold leading-6 text-primary dark:text-soft">
            NFL Picks
        </div>

        <!-- Mobile user menu -->
        <div x-data="{ mobileHeaderUserMenuOpen: false }" class="relative">
            <button @click="mobileHeaderUserMenuOpen = !mobileHeaderUserMenuOpen"
                    class="-m-2 flex items-center rounded-full p-1.5 text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 transition-colors">
                <span class="sr-only">Open user menu</span>
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary dark:bg-soft text-soft dark:text-primary text-sm font-semibold">
                    {{ auth()->user()->initials() }}
                </span>
                <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <!-- Mobile header user dropdown -->
            <div x-show="mobileHeaderUserMenuOpen"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 @click.away="mobileHeaderUserMenuOpen = false"
                 class="absolute right-0 top-full mt-2 w-48 rounded-md bg-white dark:bg-zinc-800 shadow-lg ring-1 ring-black ring-opacity-5">
                <div class="p-1">
                    <div class="px-3 py-2 border-b border-primary/20 dark:border-soft/20">
                        <p class="text-sm font-medium text-primary dark:text-soft">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-primary/70 dark:text-soft/70">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('settings.profile') }}"
                       wire:navigate
                       class="@if(str_starts_with(request()->route()->getName(), 'settings.')) bg-soft dark:bg-card/30 text-accent @else text-primary dark:text-soft hover:bg-soft dark:hover:bg-card/20 @endif flex items-center gap-x-3 rounded-md px-3 py-2 text-sm transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a6.759 6.759 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-x-3 rounded-md px-3 py-2 text-sm text-accent hover:bg-accent/10 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Desktop sidebar -->
<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-soft dark:bg-primary border-r border-primary/20 dark:border-soft/20 px-6 py-6">
        <!-- Logo -->
        <div class="flex h-16 shrink-0 items-center">
            <a href="{{ route('dashboard') }}" wire:navigate>
                <x-app-logo />
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <!-- Platform Section -->
                <li>
                    <div class="text-xs font-semibold leading-6 text-primary/70 dark:text-soft/70 uppercase tracking-wider mb-3">
                        Platform
                    </div>
                    <ul role="list" class="-mx-2 space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}"
                               wire:navigate
                               class="@if(request()->route()->getName() === 'dashboard') bg-accent text-white shadow-sm @else text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-all duration-200">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('predictions') }}"
                               wire:navigate
                               class="@if(request()->route()->getName() === 'predictions') bg-accent text-white shadow-sm @else text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-all duration-200">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.398.815 1.027 1.398 1.8 1.398h.174c.08 0 .157-.031.22-.067.075-.043.158-.097.234-.157.1-.075.206-.15.309-.224.296-.216.514-.467.691-.748a3.468 3.468 0 0 0 .422-.92c.17-.548.267-1.126.267-1.726v-.51H5.904Z" />
                                </svg>
                                Picks
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('leaderboard') }}"
                               wire:navigate
                               class="@if(request()->route()->getName() === 'leaderboard') bg-accent text-white shadow-sm @else text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-all duration-200">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.228a25.628 25.628 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                                </svg>
                                Leaderboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('groups.index') }}"
                               wire:navigate
                               class="@if(str_starts_with(request()->route()->getName(), 'groups.')) bg-accent text-white shadow-sm @else text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-all duration-200">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                                My Groups
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Spacer -->
                <li class="flex-1"></li>
            </ul>
        </nav>

        <!-- Desktop User Profile -->
        <div class="mt-auto border-t border-primary/20 dark:border-soft/20 pt-6">
            <div x-data="{ userMenuOpen: false }" class="relative">
                <button @click="userMenuOpen = !userMenuOpen"
                        class="flex w-full items-center gap-x-3 rounded-md p-3 text-left text-sm font-semibold leading-6 text-primary dark:text-soft hover:bg-highlight/20 dark:hover:bg-card/20 transition-all duration-200 group">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary dark:bg-soft text-soft dark:text-primary font-semibold text-sm">
                        {{ auth()->user()->initials() }}
                    </span>
                    <div class="flex-1">
                        <div class="font-semibold">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-primary/70 dark:text-soft/70">{{ auth()->user()->email }}</div>
                    </div>
                    <svg class="h-5 w-5 text-primary/70 dark:text-soft/70 group-hover:text-accent dark:group-hover:text-highlight transition-colors"
                         :class="{'rotate-180': userMenuOpen}"
                         fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                    </svg>
                </button>

                <!-- Desktop User Dropdown -->
                <div x-show="userMenuOpen"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     @click.away="userMenuOpen = false"
                     class="absolute bottom-full left-0 right-0 mb-2 rounded-lg bg-white dark:bg-zinc-800 shadow-lg ring-1 ring-black/5 dark:ring-white/10">
                    <div class="p-1">
                        <a href="{{ route('settings.profile') }}"
                           wire:navigate
                           class="@if(str_starts_with(request()->route()->getName(), 'settings.')) bg-soft dark:bg-card/30 text-accent @else text-primary dark:text-soft hover:bg-soft dark:hover:bg-card/20 @endif flex items-center gap-x-3 rounded-md px-3 py-2 text-sm transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a6.759 6.759 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Settings
                        </a>
                        <div class="my-1 h-px bg-primary/20 dark:bg-soft/20"></div>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                    class="flex w-full items-center gap-x-3 rounded-md px-3 py-2 text-sm text-accent hover:bg-accent/10 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
