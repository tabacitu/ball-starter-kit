<div>
    <form wire:submit="save">
        @csrf

        <x-form-input wire:model="password" :label="__('Password')" name="password" type="password" placeholder="Enter password" required autocomplete="current-password" />

        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">{{ __('Confirm') }}</button>
        </div>
    </form>
</div>
