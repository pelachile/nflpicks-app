{{-- resources/views/livewire/create-group.blade.php --}}
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-card rounded-lg shadow-md p-6">
        <x-breadcrumb :items="[
            ['title' => 'My Groups', 'url' => route('groups.index')],
            ['title' => 'Create New Group'],
        ]"/>
        <h1 class="text-3xl font-bold text-primary mb-6">Create New Group</h1>

        <form wire:submit.prevent="createGroup" class="space-y-6">
            {{-- Group Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-primary mb-2">
                    Group Name *
                </label>
                <input
                    type="text"
                    id="name"
                    wire:model.live="name"
                    class="w-full px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight @error('name') border-tomato @enderror"
                    placeholder="Enter group name (e.g., 'Office League', 'College Friends')"
                    maxlength="50"
                >
                @error('name')
                <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-primary/50">{{ strlen($name) }}/50 characters</p>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-primary mb-2">
                    Description (Optional)
                </label>
                <textarea
                    id="description"
                    wire:model.live="description"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                    placeholder="Describe your group (e.g., 'Weekly NFL predictions with the team')"
                    maxlength="255"
                ></textarea>
                @error('description')
                <p class="mt-1 text-sm text-tomato">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-primary/50">{{ strlen($description) }}/255 characters</p>
            </div>

            {{-- Max Members --}}
            <div>
                <label for="maxMembers" class="block text-sm font-medium text-primary mb-2">
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
                <p class="mt-1 text-sm text-primary/50">You can have up to 10 members in your group.</p>
            </div>

            {{-- Info Box --}}
            <div class="bg-highlight/10 border border-highlight/30 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-highlight mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                              clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-primary">How it works:</h3>
                        <ul class="mt-2 text-sm text-primary/80 space-y-1">
                            <li>• You'll receive a unique 6-character invite code</li>
                            <li>• Share this code with friends to join your group</li>
                            <li>• Compete weekly to see who picks the most winners</li>
                            <li>• Season-long leaderboards track overall performance</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end space-x-3">
                <a
                    href="{{ route('dashboard') }}"
                    class="px-4 py-2 border border-primary/20 rounded-md shadow-sm text-sm font-medium text-primary bg-card hover:bg-soft/20"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-highlight hover:bg-highlight/90 focus:ring-2 focus:ring-highlight disabled:opacity-50"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>Create Group</span>
                    <span wire:loading>Creating...</span>
                </button>
            </div>
        </form>
    </div>
</div>
