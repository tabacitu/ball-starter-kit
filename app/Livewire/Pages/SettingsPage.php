<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Settings')]
class SettingsPage extends Component
{
    public string $currentSectionKey;
    public string $currentSectionTitle;
    public string $currentSectionLivewireComponent;

    public array $sections = [
        'personal-information' => [
            'title' => 'Personal Information',
            'livewireComponent' => 'widgets.account-information-form',
        ],
        'change-password' => [
            'title' => 'Change Password',
            'livewireComponent' => 'widgets.account-change-password-form',
        ],
        'delete-account' => [
            'title' => 'Delete Account',
            'livewireComponent' => 'widgets.account-delete-section',
        ],
    ];

    public function mount(string $section = 'personal-information'): void
    {
        $this->currentSectionKey = $section;
        $this->currentSectionTitle = $this->sections[$section]['title'];
        $this->currentSectionLivewireComponent = $this->sections[$section]['livewireComponent'];
    }

    public function render()
    {
        return view('livewire.pages.settings-page');
    }
}
