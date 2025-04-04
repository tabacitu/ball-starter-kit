<account-change-password-form class="">
   <form wire:submit="save" class="mt-6 space-y-6">
      @csrf
      <div class="card-body">
        <h3 class="card-title">{{ __('Update Password') }}</h3>

        <p class="text-secondary">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

        <x-form-input wire:model="current_password" :label="__('Current Password')" name="current_password" type="password" placeholder="Enter current password" autocomplete="current-password" required />
        <x-form-input wire:model="password" :label="__('New Password')" name="password" type="password" placeholder="Enter new password"  autocomplete="new-password" required />
        <x-form-input wire:model="password_confirmation" :label="__('Confirm Password')" name="password_confirmation" type="password" placeholder="Confirm new password" autocomplete="new-password" required />
      </div>

      <div class="card-footer bg-transparent mt-auto">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            {{-- TODO: replace this with a global notification or something better --}}
            @if (session('status') === 'password-updated')
                <span
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success"
                >
                    <span class="d-inline-block ml-4 mr-0"><svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg></span>
                    {{ __('Saved') }}</span>
            @endif
      </div>
   </form>
</account-change-password-form>
