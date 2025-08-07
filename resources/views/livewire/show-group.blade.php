{{-- resources/views/livewire/show-group.blade.php --}}
<div class="max-w-4xl mx-auto p-6">
<x-breadcrumb :items="[
    ['title' => 'My Groups', 'url' => route('groups.index')],
    ['title' => $group->name]
]" />
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $group->name }}</h1>

        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <strong>Group Created Successfully!</strong><br>
            Invite Code: <span class="font-mono text-lg font-bold">{{ $group->code }}</span><br>
            Share this code with friends to join your group.
        </div>

        @if($group->description)
            <p class="text-gray-600 mb-4">{{ $group->description }}</p>
        @endif

        <div class="grid md:grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-2xl font-bold text-blue-600">{{ $group->members()->count() }}</p>
                <p class="text-sm text-gray-600">Members</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-green-600">{{ $group->max_members }}</p>
                <p class="text-sm text-gray-600">Max Members</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-purple-600">2025</p>
                <p class="text-sm text-gray-600">Season</p>
            </div>
        </div>
    </div>
</div>
