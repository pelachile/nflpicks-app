{{-- resources/views/livewire/groups.blade.php --}}
<div class="max-w-6xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-primary mb-4">My Groups</h1>
        <div class="flex flex-col sm:flex-row gap-3">
            <a
                href="{{ route('groups.join') }}"
                wire:navigate
                class="inline-flex items-center justify-center bg-highlight text-primary px-4 py-2 rounded-lg hover:bg-highlight/90 transition-colors font-medium text-sm sm:text-base"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Join Group
            </a>
            <a
                href="{{ route('groups.create') }}"
                wire:navigate
                class="inline-flex items-center justify-center bg-primary text-soft px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors font-medium text-sm sm:text-base"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create New Group
            </a>
        </div>
    </div>

    @if(count($myGroups) > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($myGroups as $group)
                <div class="bg-card rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-primary">{{ $group['name'] }}</h3>
                        @if($group['is_admin'])
                            <span class="px-2 py-1 bg-highlight/10 text-highlight text-xs rounded font-medium">
                                Admin
                            </span>
                        @endif
                    </div>

                    @if($group['description'])
                        <p class="text-primary/60 text-sm mb-4">{{ $group['description'] }}</p>
                    @endif

                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-primary/60">Members:</span>
                            <span class="font-medium">{{ $group['member_count'] }}/{{ $group['max_members'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-primary/60">Invite Code:</span>
                            <span class="font-mono font-bold">{{ $group['code'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-primary/60">Created by:</span>
                            <span class="font-medium">{{ $group['created_by_me'] ? 'You' : $group['creator_name'] }}</span>
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <a
                            href="{{ route('groups.show', $group['id']) }}"
                            wire:navigate
                            class="flex-1 bg-primary text-soft text-center py-2 rounded hover:bg-primary/90 transition-colors text-sm"
                        >
                            View Group
                        </a>
                        @if($group['is_admin'])
                            <a
                                href="{{ route('groups.manage', $group['id']) }}"
                                wire:navigate
                                class="flex-1 bg-primary text-soft text-center py-2 rounded hover:bg-primary/90 transition-colors text-sm"
                            >
                            Manage
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 px-6 sm:px-12 bg-card rounded-lg shadow-md">
            <svg class="w-16 h-16 text-primary/40 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="text-lg font-medium text-primary mb-2">No Groups Yet</h3>
            <p class="text-primary/60 mb-6 px-4">Create a group or join an existing one to start competing with friends!</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a
                    href="{{ route('groups.join') }}"
                    wire:navigate
                    class="inline-flex items-center justify-center bg-highlight text-primary px-6 py-3 rounded-lg hover:bg-highlight/90 transition-colors font-medium"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Join Group
                </a>
                <a
                    href="{{ route('groups.create') }}"
                    wire:navigate
                    class="inline-flex items-center justify-center bg-primary text-soft px-6 py-3 rounded-lg hover:bg-primary/90 transition-colors font-medium"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Your First Group
                </a>
            </div>
        </div>
    @endif
</div>
