<?php

namespace App\Livewire;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManageGroup extends Component
{
    public Group $group;
    public string $name = '';
    public string $description = '';
    public int $maxMembers = 10;
    public bool $editMode = false;

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

    public function mount(Group $group)
    {
        // Check if user is admin of this group
        if (!$group->isUserAdmin(Auth::id())) {
            abort(403, 'You are not authorized to manage this group.');
        }

        $this->group = $group;
        $this->name = $group->name;
        $this->description = $group->description ?? '';
        $this->maxMembers = $group->max_members;
    }

    public function enableEditMode()
    {
        $this->editMode = true;
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        // Reset to original values
        $this->name = $this->group->name;
        $this->description = $this->group->description ?? '';
        $this->maxMembers = $this->group->max_members;
    }

    public function updateGroup()
    {
        $this->validate();

        // Check if new max_members is less than current member count
        $currentMemberCount = $this->group->members()->count();
        if ($this->maxMembers < $currentMemberCount) {
            $this->addError('maxMembers', "Cannot reduce max members below current member count ({$currentMemberCount}).");
            return;
        }

        $this->group->update([
            'name' => $this->name,
            'description' => $this->description,
            'max_members' => $this->maxMembers,
        ]);

        $this->editMode = false;
        session()->flash('success', 'Group updated successfully!');
    }

    // app/Livewire/ManageGroup.php - Add these methods to the existing class

    public function deleteGroup()
    {
        // Double-check authorization
        if (!$this->group->isUserAdmin(Auth::id())) {
            abort(403, 'You are not authorized to delete this group.');
        }

        $groupName = $this->group->name;

        // Delete the group (cascade will handle members and other related data)
        $this->group->delete();

        session()->flash('success', "Group '{$groupName}' has been deleted successfully.");

        return redirect()->route('groups.index');
    }

    public function confirmDelete()
    {
        $this->dispatch('confirm-delete');
    }

    public function render()
    {
        $members = $this->group->members()
            ->with('user')
            ->orderBy('is_admin', 'desc')
            ->orderBy('joined_at')
            ->get();

        return view('livewire.manage-group', compact('members'))
            ->layout('components.layouts.app');
    }
}
