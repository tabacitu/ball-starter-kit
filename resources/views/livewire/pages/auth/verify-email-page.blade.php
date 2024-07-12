<verify-email-page>

    <div class="container container-tight py-4">

        @if (session('status') == 'verification-link-sent')
            <x-alert type="success" :title="__('A new verification link has been sent to the email address you provided during registration.')" class="mb-3" />
        @endif

        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{  __('Verify email address') }}</h2>

                <p class="text-secondary mb-4">{{ __('Please verify your email address, by clicking on the link we just emailed to you. If you didn\'t receive the email, we will gladly send you another.') }}</p>

                <form wire:submit="send">
                    @csrf

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{ __('Resend Verification Email') }}</button>
                    </div>
                </form>
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
</verify-email-page>
