{{-- resources/views/livewire/show-group.blade.php --}}
<div class="max-w-4xl mx-auto p-6">
<x-breadcrumb :items="[
    ['title' => 'My Groups', 'url' => route('groups.index')],
    ['title' => $group->name]
]" />
    <div class="bg-card rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-primary mb-4">{{ $group->name }}</h1>

        <div class="bg-highlight/10 border border-highlight/30 text-primary px-4 py-3 rounded mb-4">
            <strong>Group Created Successfully!</strong><br>
            Invite Code: <span class="font-mono text-lg font-bold text-highlight">{{ $group->code }}</span><br>
            Share this code with friends to join your group.
        </div>

        @if($group->description)
            <p class="text-primary/60 mb-4">{{ $group->description }}</p>
        @endif

        <div class="grid md:grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-2xl font-bold text-highlight">{{ $group->members()->count() }}</p>
                <p class="text-sm text-primary/60">Members</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-primary">{{ $group->max_members }}</p>
                <p class="text-sm text-primary/60">Max Members</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-tomato">2025</p>
                <p class="text-sm text-primary/60">Season</p>
            </div>
        </div>
    </div>
</div>
