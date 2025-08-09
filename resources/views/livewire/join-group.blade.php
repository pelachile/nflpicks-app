{{-- resources/views/livewire/join-group.blade.php --}}
<div class="max-w-2xl mx-auto p-6">
    <x-breadcrumb :items="[
        ['title' => 'My Groups', 'url' => route('groups.index')],
        ['title' => 'Join Group']
    ]" />

    <div class="bg-card rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-primary mb-6">Join a Group</h1>

        {{-- Search Form --}}
        @if(!$showGroupDetails)
            <form wire:submit.prevent="searchGroup" class="space-y-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-primary mb-2">
                        Group Invite Code
                    </label>
                    <div class="flex space-x-3">
                        <input
                            type="text"
                            id="code"
                            wire:model.live="code"
                            placeholder="Enter 6-character code (e.g., ABC123)"
                            class="flex-1 px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight @error('code') border-tomato @enderror font-mono text-lg text-center uppercase"
                            maxlength="6"
                        >
                        <button
                            type="submit"
                            class="bg-highlight text-white px-6 py-2 rounded-md hover:bg-highlight/90 transition-colors disabled:opacity-50"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>Search</span>
                            <span wire:loading>Searching...</span>
                        </button>
                    </div>
                    @error('code')
                    <p class="mt-2 text-sm text-tomato">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info Box --}}
                <div class="bg-highlight/10 border border-highlight/30 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-highlight mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-primary">How to join:</h3>
                            <ul class="mt-2 text-sm text-primary/80 space-y-1">
                                <li>• Ask a group member for their 6-character invite code</li>
                                <li>• Enter the code above to find the group</li>
                                <li>• Review the group details and join if it's the right one</li>
                                <li>• Start making predictions and competing with friends!</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        @endif

        {{-- Group Details --}}
        @if($showGroupDetails && $foundGroup)
            <div class="space-y-6">
                <div class="bg-highlight/10 border border-highlight/30 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-primary mb-2">Group Found!</h3>
                    <p class="text-primary/80">Review the details below and click "Join Group" to become a member.</p>
                </div>

                <div class="bg-soft/20 rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-primary mb-4">{{ $foundGroup->name }}</h2>

                    @if($foundGroup->description)
                        <p class="text-primary/60 mb-4">{{ $foundGroup->description }}</p>
                    @endif

                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="font-semibold text-primary mb-2">Group Info</h4>
                            <div class="space-y-1 text-sm">
                                <div>
                                    <span class="text-primary/60">Created by:</span>
                                    <span class="ml-2">{{ $foundGroup->creator->name }}</span>
                                </div>
                                <div>
                                    <span class="text-primary/60">Members:</span>
                                    <span class="ml-2">{{ $foundGroup->members->count() }}/{{ $foundGroup->max_members }}</span>
                                </div>
                                <div>
                                    <span class="text-primary/60">Season:</span>
                                    <span class="ml-2">{{ $foundGroup->season }}</span>
                                </div>
                                <div>
                                    <span class="text-primary/60">Created:</span>
                                    <span class="ml-2">{{ $foundGroup->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-primary mb-2">Current Members</h4>
                            <div class="space-y-1 text-sm max-h-32 overflow-y-auto">
                                @foreach($foundGroup->members->take(5) as $member)
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center">
                                            <span class="text-soft text-xs font-bold">
                                                {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <span>{{ $member->user->name }}</span>
                                        @if($member->is_admin)
                                            <span class="px-1 py-0.5 bg-highlight/10 text-highlight text-xs rounded">Admin</span>
                                        @endif
                                    </div>
                                @endforeach
                                @if($foundGroup->members->count() > 5)
                                    <p class="text-primary/50 text-xs">...and {{ $foundGroup->members->count() - 5 }} more</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button
                        wire:click="$set('showGroupDetails', false)"
                        class="px-4 py-2 border border-primary/20 rounded-md shadow-sm text-sm font-medium text-primary bg-card hover:bg-soft/20"
                    >
                        Search Again
                    </button>
                    <button
                        wire:click="joinGroup"
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-highlight hover:bg-highlight/90 disabled:opacity-50"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Join Group</span>
                        <span wire:loading>Joining...</span>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
