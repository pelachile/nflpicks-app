<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class JoinGroup extends Component
{
    public string $code = '';
    public ?Group $foundGroup = null;
    public bool $showGroupDetails = false;

    protected $rules = [
        'code' => 'required|string|size:6',
    ];

    protected $messages = [
        'code.required' => 'Please enter a group code.',
        'code.size' => 'Group codes are exactly 6 characters.',
    ];

    public function updatedCode()
    {
        $this->code = strtoupper($this->code);
        $this->foundGroup = null;
        $this->showGroupDetails = false;
    }

    public function searchGroup()
    {
        $this->validate();

        $this->foundGroup = Group::where('code', $this->code)
            ->where('is_active', true)
            ->with(['creator', 'members.user'])
            ->first();

        if (!$this->foundGroup) {
            $this->addError('code', 'No group found with this code.');
            return;
        }

        // Check if user is already a member
        if ($this->foundGroup->isUserMember(Auth::id())) {
            $this->addError('code', 'You are already a member of this group.');
            return;
        }

        // Check if group is full
        if ($this->foundGroup->isFull()) {
            $this->addError('code', 'This group is full and cannot accept new members.');
            return;
        }

        $this->showGroupDetails = true;
    }

    public function joinGroup()
    {
        if (!$this->foundGroup || $this->foundGroup->isUserMember(Auth::id())) {
            session()->flash('error', 'Unable to join group.');
            return;
        }

        GroupMember::create([
            'group_id' => $this->foundGroup->id,
            'user_id' => Auth::id(),
            'is_admin' => false,
        ]);

        session()->flash('success', "Successfully joined '{$this->foundGroup->name}'!");

        return redirect()->route('groups.show', $this->foundGroup);
    }

    public function render()
    {
        return view('livewire.join-group')
            ->layout('components.layouts.app');
    }
}
