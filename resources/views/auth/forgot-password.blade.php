<x-guest-layout>

    <div class="container container-tight py-4">

        @if (session('status'))
            <x-alert type="success" :title="session('status')" class="mb-3" />
        @endif

        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{  __('Forgot password?') }}</h2>

                <p class="text-secondary mb-4">{{ __('No problem. Just let us know your email address and we will email you a link to reset your password.') }}</p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <x-form-input :label="__('Email Address')" name="email" type="email" placeholder="Enter email" required autofocus autocomplete="username" />

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{ __('Email Password Reset Link') }}</button>
                    </div>
                </form>
            </div>
        </div>

        @if (Route::has('login'))
        <div class="text-center mt-3">
            <a href="{{ route('login') }}"> {{ __('Back to login') }}</a>
        </div>
        @endif
    </div>
</x-guest-layout>
