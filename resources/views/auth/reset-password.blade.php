<x-layouts.guest>
    <x-slot name="title">{{ __('Reset Password') }}</x-slot>

    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">{{ __('Set new password') }}</h2>

            <livewire:forms.auth.reset-password-form :token="$token" />
        </div>
    </div>
</x-layouts.guest>
