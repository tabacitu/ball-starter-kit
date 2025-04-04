<div>
    @if (session('status') == 'verification-link-sent')
        <x-alert type="success" :title="__('A new verification link has been sent to the email address you provided during registration.')" class="mb-3" />
    @endif

    @if (session('error'))
        <x-alert type="danger" :title="session('error')" class="mb-3" />
    @endif

    <form wire:submit="sendVerificationEmail">
        @csrf

        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">{{ __('Resend Verification Email') }}</button>
        </div>
    </form>
</div>
