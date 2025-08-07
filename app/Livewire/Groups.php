<?php

namespace App\Livewire;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Groups extends Component
{
    public $myGroups = [];

    public function mount()
    {
        $this->loadUserGroups();

        if (session()->has('success')) {
            $this->dispatch('$refresh');
        }
    }

    public function loadUserGroups()
    {
        // Get groups where user is a member
        $this->myGroups = Group::whereHas('members', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->with(['members.user', 'creator'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($group) {
                return [
                    'id' => $group->id,
                    'name' => $group->name,
                    'description' => $group->description,
                    'code' => $group->code,
                    'member_count' => $group->members()->count(),
                    'max_members' => $group->max_members,
                    'is_admin' => $group->isUserAdmin(Auth::id()),
                    'created_by_me' => $group->created_by === Auth::id(),
                    'creator_name' => $group->creator->name,
                    'season' => $group->season,
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.groups')
            ->layout('components.layouts.app');
    }
}
