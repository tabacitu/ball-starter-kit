<?php

namespace App\Livewire\Pages\Auth;

use Livewire\Component;

class AuthComponent extends Component
{
    /**
     * The path to your application's "home" route.
     */
    protected string $defaultRoute = '/dashboard';

    /**
     * The view to render.
     */
    protected string $view = '';

    /**
     * The render method for the component.
     * Uses a default layout for guest pages.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view($this->view)->layout('layouts.guest');
    }
}
