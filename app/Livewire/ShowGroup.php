<?php

namespace App\Livewire;

use App\Models\Group;
use Livewire\Component;

class ShowGroup extends Component
{
    public Group $group;

    public function mount(Group $group)
    {
        $this->group = $group;
    }

    public function render()
    {
        return view('livewire.show-group')
            ->layout('components.layouts.app');
    }
}
