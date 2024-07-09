<x-guest-layout>

    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{  __('Register') }}</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <x-form-input :label="__('Name')" name="name" type="text" placeholder="Enter name" required autofocus autocomplete="name"  />
                    <x-form-input :label="__('Email Address')" name="email" type="email" placeholder="Enter email" required autocomplete="username" />
                    <x-form-input :label="__('Password')" name="password" type="password" placeholder="Enter password" required autocomplete="new-password" />
                    <x-form-input :label="__('Confirm Password')" name="password_confirmation" type="password" placeholder="Confirm password" required autocomplete="new-password" />

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{ __('Register') }}</button>
                    </div>
                </form>
            </div>
        </div>

        @if (Route::has('login'))
        <div class="text-center mt-3">
            <a href="{{ route('login') }}"> {{ __('Already have an account?') }}</a>
        </div>
        @endif
    </div>

</x-guest-layout>
