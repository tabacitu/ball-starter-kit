<div>
    @if (session('status'))
        <x-alert type="success" :title="session('status')" class="mb-3" />
    @endif

    <form wire:submit="save">
        @csrf

        <x-form-input wire:model="email" :label="__('Email Address')" name="email" type="email" placeholder="your@email.com" required autofocus autocomplete="username" />
        <x-form-input wire:model="password" :label="__('Password')" name="password" type="password" placeholder="Your password" required autocomplete="current-password" />

        <div class="mb-1">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-check mb-0">
                    <input wire:model="remember" type="checkbox" class="form-check-input" name="remember">
                    <span class="form-check-label">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                <span class="form-label-description">
                    <a href="{{ route('password.request') }}"> {{ __('Forgot your password?') }}</a>
                </span>
                @endif
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">{{ __('Log in') }}</button>
        </div>
    </form>
</div>
