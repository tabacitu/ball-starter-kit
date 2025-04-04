<x-layouts.guest>
    <x-slot name="title">{{ __('Forgot Password') }}</x-slot>

    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{ __('Forgot password?') }}</h2>

                <p class="text-secondary mb-4">{{ __('No problem. Just let us know your email address and we will email you a link to reset your password.') }}</p>

                <livewire:forms.auth.forgot-password-form />
            </div>
        </div>

        @if (Route::has('login'))
        <div class="text-center mt-3">
            <a href="{{ route('login') }}"> {{ __('Back to login') }}</a>
        </div>
        @endif
    </div>
</x-layouts.guest>
