<x-guest-layout>

    <div class="container container-tight py-4">

        <x-form-success-message class="mb-3" :message="session('status')" />

        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{  __('Confirm password') }}</h2>

                <p class="text-secondary mb-4">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <x-form-input :label="__('Password')" name="password" type="password" placeholder="Enter password" required autocomplete="current-password" />

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{ __('Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-guest-layout>

