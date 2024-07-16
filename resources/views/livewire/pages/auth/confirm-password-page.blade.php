<confirm-password-page>

    <div class="container container-tight py-4">

        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{  __('Confirm password') }}</h2>

                <p class="text-secondary mb-4">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>

                <form wire:submit="save">
                    @csrf

                    <x-form-input wire:model="password" :label="__('Password')" name="password" type="password" placeholder="Enter password" required autocomplete="current-password" />

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{ __('Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</confirm-password-page>

