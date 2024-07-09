<x-guest-layout>

    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{  __('Set new password') }}</h2>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <x-form-input :label="__('Email Address')" name="email" type="email" placeholder="Enter email" required autofocus autocomplete="username" :value="old('email', $request->email)" />
                    <x-form-input :label="__('Password')" name="password" type="password" placeholder="Enter password" required autocomplete="new-password" />
                    <x-form-input :label="__('Confirm Password')" name="password_confirmation" type="password" placeholder="Confirm password" required autocomplete="new-password" />

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{ __('Set new password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-guest-layout>
