<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateGroup extends Component
{
    public string $name = '';
    public string $description = '';
    public int $maxMembers = 10;

    protected $rules = [
        'name' => 'required|string|min:3|max:50',
        'description' => 'nullable|string|max:255',
        'maxMembers' => 'required|integer|min:2|max:10',
    ];

    protected $messages = [
        'name.required' => 'Group name is required.',
        'name.min' => 'Group name must be at least 3 characters.',
        'name.max' => 'Group name cannot exceed 50 characters.',
        'maxMembers.min' => 'Groups must have at least 2 members.',
        'maxMembers.max' => 'Groups cannot exceed 10 members.',
    ];

    public function createGroup()
    {
        $this->validate();

        // Generate unique group code
        do {
            $code = strtoupper(Str::random(6));
        } while (Group::where('code', $code)->exists());

        // Create the group
        $group = Group::create([
            'name' => $this->name,
            'description' => $this->description,
            'code' => $code,
            'max_members' => $this->maxMembers,
            'created_by' => Auth::id(),
            'season' => 2025, // Current season
        ]);

        // Add creator as first member (admin)
        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => Auth::id(),
            'is_admin' => true,
        ]);

        session()->flash('success', "Group '{$this->name}' created successfully! Invite code: {$code}");

        // Reset form
        $this->reset(['name', 'description']);
        $this->maxMembers = 10;

        // Redirect to group dashboard or groups list
        return redirect()->route('groups.show', $group);
    }

    public function render()
    {
        return view('livewire.create-group')
            ->layout('components.layouts.app');
    }
}
