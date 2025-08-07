{{-- resources/views/livewire/groups.blade.php --}}
<div class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Groups</h1>
        <a
            href="{{ route('groups.join') }}"
            wire:navigate
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
        >
            Join Group
        <a
            href="{{ route('groups.create') }}"
            wire:navigate
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
        >
            Create New Group
        </a>
    </div>

    @if(count($myGroups) > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($myGroups as $group)
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-800">{{ $group['name'] }}</h3>
                        @if($group['is_admin'])
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded font-medium">
                                Admin
                            </span>
                        @endif
                    </div>

                    @if($group['description'])
                        <p class="text-gray-600 text-sm mb-4">{{ $group['description'] }}</p>
                    @endif

                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Members:</span>
                            <span class="font-medium">{{ $group['member_count'] }}/{{ $group['max_members'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Invite Code:</span>
                            <span class="font-mono font-bold">{{ $group['code'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Created by:</span>
                            <span class="font-medium">{{ $group['created_by_me'] ? 'You' : $group['creator_name'] }}</span>
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <a
                            href="{{ route('groups.show', $group['id']) }}"
                            wire:navigate
                            class="flex-1 bg-gray-600 text-white text-center py-2 rounded hover:bg-gray-700 transition-colors text-sm"
                        >
                            View Group
                        </a>
                        <a
                            href="{{ route('groups.show', $group['id']) }}"
                            wire:navigate
                            class="flex-1 bg-gray-600 text-white text-center py-2 rounded hover:bg-gray-700 transition-colors text-sm"
                        >
                            View Group
                        </a>
                        @if($group['is_admin'])
                            <a
                                href="{{ route('groups.manage', $group['id']) }}"
                                wire:navigate
                                class="flex-1 bg-gray-600 text-white text-center py-2 rounded hover:bg-gray-700 transition-colors text-sm"
                            >
                            Manage
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow-md">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.121M9 20h8v-2a3 3 0 00-2.59-2.674m-3.73-1.39a3 3 0 004.632 0M9 8a3 3 0 106 0v1M6 20v-2a3 3 0 011.07-2.311m0 0a3 3 0 012.86 0M6 20v-2a3 3 0 011.07-2.311m0 0a3 3 0 012.86 0"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Groups Yet</h3>
            <p class="text-gray-600 mb-4">Create a group or join and existing one to start competing with friends!</p>
            <a
                href="{{ route('groups.join') }}"
                wire:navigate
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors"
            >
                Join Group
            </a>
            <a
                href="{{ route('groups.create') }}"
                wire:navigate
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors"
            >
                Create Your First Group
            </a>
        </div>
    @endif
</div>
