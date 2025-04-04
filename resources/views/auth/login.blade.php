<x-layouts.guest>
    <x-slot name="title">{{ __('Login') }}</x-slot>

    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">{{ __('Login') }}</h2>

            <livewire:forms.auth.login-form />
        </div>
    </div>

    @if (Route::has('register'))
    <div class="text-center mt-3">
        <a href="{{ route('register') }}"> {{ __('Don\'t have an account?') }}</a>
    </div>
    @endif
</x-layouts.guest>
