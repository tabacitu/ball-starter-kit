<x-layouts.guest>
    <x-slot name="title">{{ __('Verify Email') }}</x-slot>

    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{ __('Verify email address') }}</h2>

                <p class="text-secondary mb-4">{{ __('Please verify your email address, by clicking on the link we just emailed to you. If you didn\'t receive the email, we will gladly send you another.') }}</p>

                <livewire:forms.auth.verify-email-form />
            </div>
        </div>

        @if (Route::has('logout'))
        <div class="text-center mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-link">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
        @endif
    </div>
</x-layouts.guest>
