<div>
    <form wire:submit="save">
        @csrf

        <input wire:model="token" type="hidden" name="token">
        <x-form-input wire:model="email" :label="__('Email Address')" name="email" type="email" placeholder="Enter email" required autofocus autocomplete="username" />
        <x-form-input wire:model="password" :label="__('Password')" name="password" type="password" placeholder="Enter password" required autocomplete="new-password" />
        <x-form-input wire:model="password_confirmation" :label="__('Confirm Password')" name="password_confirmation" type="password" placeholder="Confirm password" required autocomplete="new-password" />

        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">{{ __('Set new password') }}</button>
        </div>
    </form>
</div>
