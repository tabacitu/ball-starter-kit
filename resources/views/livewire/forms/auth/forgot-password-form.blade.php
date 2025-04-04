<div>
    @if (session('status'))
        <x-alert type="success" :title="session('status')" class="mb-3" />
    @endif

    <form wire:submit="save">
        @csrf

        <x-form-input wire:model="email" :label="__('Email Address')" name="email" type="email" placeholder="Enter email" required autofocus autocomplete="username" />

        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">{{ __('Email Password Reset Link') }}</button>
        </div>
    </form>
</div>
