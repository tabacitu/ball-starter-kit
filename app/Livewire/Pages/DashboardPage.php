<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class DashboardPage extends Component
{
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.pages.dashboard-page');
    }
}
