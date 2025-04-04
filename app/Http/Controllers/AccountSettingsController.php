<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountSettingsController extends Controller
{
    /**
     * The sections available in the account settings page.
     */
    protected array $sections = [
        'personal-information' => [
            'title' => 'Personal Information',
            'livewireComponent' => 'forms.account.account-information-form',
        ],
        'change-password' => [
            'title' => 'Change Password',
            'livewireComponent' => 'forms.account.account-change-password-form',
        ],
        'delete-account' => [
            'title' => 'Delete Account',
            'livewireComponent' => 'forms.account.account-delete-section',
        ],
    ];

    /**
     * Show the account settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('account-settings', [
            'sections' => $this->sections,
        ]);
    }
}
