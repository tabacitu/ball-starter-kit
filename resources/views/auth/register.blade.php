<x-layouts.guest>
    <x-slot name="title">{{ __('Register') }}</x-slot>

    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">{{ __('Register') }}</h2>

            <livewire:forms.auth.register-form />
        </div>
    </div>

    @if (Route::has('login'))
    <div class="text-center mt-3">
        <a href="{{ route('login') }}"> {{ __('Already have an account?') }}</a>
    </div>
    @endif
</x-layouts.guest>
