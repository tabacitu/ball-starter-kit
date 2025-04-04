<div>
    <form wire:submit="save">
        @csrf

        <x-form-input wire:model="name" :label="__('Name')" name="name" type="text" placeholder="Enter name" required autofocus autocomplete="name"  />
        <x-form-input wire:model="email" :label="__('Email Address')" name="email" type="email" placeholder="Enter email" required autocomplete="username" />
        <x-form-input wire:model="password" :label="__('Password')" name="password" type="password" placeholder="Enter password" required autocomplete="new-password" />
        <x-form-input wire:model="password_confirmation" :label="__('Confirm Password')" name="password_confirmation" type="password" placeholder="Confirm password" required autocomplete="new-password" />

        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">{{ __('Register') }}</button>
        </div>
    </form>
</div>
