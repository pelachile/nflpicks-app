{{-- resources/views/livewire/manage-group.blade.php --}}
<div class="max-w-4xl mx-auto p-6">
    <x-breadcrumb :items="[
        ['title' => 'My Groups', 'url' => route('groups.index')],
        ['title' => $group->name, 'url' => route('groups.show', $group)],
        ['title' => 'Manage']
    ]" />

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="bg-highlight/10 border border-highlight/30 text-primary px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Group Information --}}
    <div class="bg-card rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-primary">Manage Group</h1>
            @if(!$editMode)
                <button
                    wire:click="enableEditMode"
                    class="bg-highlight text-white px-4 py-2 rounded-lg hover:bg-highlight/90 transition-colors"
                >
                    Edit Group
                </button>
            @endif
        </div>

        @if($editMode)
            {{-- Edit Form --}}
            <form wire:submit.prevent="updateGroup" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-primary mb-1">
                        Group Name *
                    </label>
                    <input
                        type="text"
                        id="name"
                        wire:model.live="name"
                        class="w-full px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight @error('name') border-tomato @enderror"
                        maxlength="50"
                    >
                    @error('name')
                    <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-primary mb-1">
                        Description
                    </label>
                    <textarea
                        id="description"
                        wire:model.live="description"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                        maxlength="255"
                    ></textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="maxMembers" class="block text-sm font-medium text-primary mb-1">
                        Maximum Members *
                    </label>
                    <select
                        id="maxMembers"
                        wire:model="maxMembers"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('maxMembers') border-red-500 @enderror"
                    >
                        @for($i = 2; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} members</option>
                        @endfor
                    </select>
                    @error('maxMembers')
                    <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-3">
                    <button
                        type="submit"
                        class="bg-highlight text-white px-4 py-2 rounded-lg hover:bg-highlight/90 transition-colors"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Save Changes</span>
                        <span wire:loading>Saving...</span>
                    </button>
                    <button
                        type="button"
                        wire:click="cancelEdit"
                        class="bg-primary text-soft px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        @else
            {{-- Display Information --}}
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Group Details</h3>
                    <div class="space-y-2">
                        <div>
                            <span class="text-primary/60">Name:</span>
                            <span class="font-medium ml-2">{{ $group->name }}</span>
                        </div>
                        <div>
                            <span class="text-primary/60">Description:</span>
                            <span class="ml-2">{{ $group->description ?: 'No description' }}</span>
                        </div>
                        <div>
                            <span class="text-primary/60">Invite Code:</span>
                            <span class="font-mono font-bold ml-2">{{ $group->code }}</span>
                        </div>
                        <div>
                            <span class="text-primary/60">Members:</span>
                            <span class="ml-2">{{ $members->count() }}/{{ $group->max_members }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Settings</h3>
                    <div class="space-y-2">
                        <div>
                            <span class="text-primary/60">Season:</span>
                            <span class="ml-2">{{ $group->season }}</span>
                        </div>
                        <div>
                            <span class="text-primary/60">Created:</span>
                            <span class="ml-2">{{ $group->created_at->format('M j, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Group Members --}}
    <div class="bg-card rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-primary mb-4">Group Members ({{ $members->count() }})</h2>

        <div class="space-y-3">
            @foreach($members as $member)
                <div class="flex items-center justify-between p-3 bg-soft/20 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                            <span class="text-soft font-bold">
                                {{ strtoupper(substr($member->user->name, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-medium">{{ $member->user->name }}</p>
                            <p class="text-sm text-primary/60">
                                Joined {{ $member->joined_at->format('M j, Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($member->is_admin)
                            <span class="px-2 py-1 bg-highlight/10 text-highlight text-xs rounded font-medium">
                                Admin
                            </span>
                        @endif
                        @if($member->user_id !== Auth::id() && !$member->is_admin)
                            <button class="text-tomato hover:text-tomato/80 text-sm">
                                Remove
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- Add this section after the Group Members section in resources/views/livewire/manage-group.blade.php --}}

    {{-- Danger Zone --}}
    <div class="bg-card rounded-lg shadow-md p-6 border-l-4 border-tomato">
        <h2 class="text-2xl font-bold text-tomato mb-4">Danger Zone</h2>

        <div class="bg-tomato/10 border border-tomato/30 rounded-lg p-4 mb-4">
            <div class="flex">
                <svg class="w-5 h-5 text-tomato mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-primary">Delete Group</h3>
                    <div class="mt-2 text-sm text-primary/80">
                        <p>Once you delete this group, there is no going back. This action:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Permanently removes the group and all its data</li>
                            <li>Removes all members from the group</li>
                            <li>Deletes all predictions made within this group</li>
                            <li>Cannot be undone</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <div>
                <h4 class="text-lg font-semibold text-primary">Delete "{{ $group->name }}"</h4>
                <p class="text-sm text-primary/60">This will permanently delete the group and all associated data.</p>
            </div>
            <button
                wire:click="confirmDelete"
                class="bg-tomato text-white px-4 py-2 rounded-lg hover:bg-tomato/90 transition-colors"
            >
                Delete Group
            </button>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div x-data="{ showModal: false }"
         @confirm-delete.window="showModal = true">

        {{-- Modal Backdrop and Content --}}
        <div x-show="showModal"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             @click.away="showModal = false">

            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black bg-opacity-50"></div>

            {{-- Modal Content --}}
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                     @click.stop>

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-tomato/10 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-tomato" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-primary">Delete Group</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-primary/60">
                                        Are you sure you want to delete "{{ $group->name }}"? This action cannot be undone and will permanently remove:
                                    </p>
                                    <ul class="mt-2 text-sm text-primary/60 list-disc list-inside space-y-1">
                                        <li>The group and all its settings</li>
                                        <li>{{ $members->count() }} group members</li>
                                        <li>All predictions made within this group</li>
                                        <li>All weekly scores and leaderboards</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-soft/20 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button"
                                wire:click="deleteGroup"
                                @click="showModal = false"
                                class="inline-flex w-full justify-center rounded-md bg-tomato px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-tomato/90 sm:ml-3 sm:w-auto">
                            Delete Forever
                        </button>
                        <button type="button"
                                @click="showModal = false"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-card px-3 py-2 text-sm font-semibold text-primary shadow-sm ring-1 ring-inset ring-primary/20 hover:bg-soft/20 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
