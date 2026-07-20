<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class MemberCount extends Component
{
    public $count = 0;

    public function mount()
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
            $this->count = User::where('is_active', true)->count();
        }
    }

    public function render()
    {
        return view('livewire.member-count');
    }
}
