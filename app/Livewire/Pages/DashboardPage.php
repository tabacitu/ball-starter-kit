<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class DashboardPage extends Component
{
    public function render()
    {
        return view('livewire.pages.dashboard-page');
    }
}
