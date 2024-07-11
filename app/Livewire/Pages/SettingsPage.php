<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Settings')]
class SettingsPage extends Component
{
    public function render()
    {
        return view('livewire.pages.settings-page');
    }
}
