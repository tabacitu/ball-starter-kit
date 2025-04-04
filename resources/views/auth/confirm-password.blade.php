<x-layouts.guest>
    <x-slot name="title">{{ __('Confirm Password') }}</x-slot>

    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">{{ __('Confirm password') }}</h2>

            <p class="text-secondary mb-4">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>

            <livewire:forms.auth.confirm-password-form />
        </div>
    </div>
</x-layouts.guest>
