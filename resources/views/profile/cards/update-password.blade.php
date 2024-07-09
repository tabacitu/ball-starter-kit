<div class="card">
{{--    <div class="card-status-start bg-warning"></div>--}}

  <div class="card-body">
      <h3 class="card-title">{{ __('Update Password') }}</h3>

      <p class="text-secondary">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <x-form-input :label="__('Current Password')" name="current_password" type="password" placeholder="Enter current password"  autocomplete="current-password" :errors="$errors->updatePassword->get('current_password')" />
            <x-form-input :label="__('New Password')" name="password" type="password" placeholder="Enter new password"  autocomplete="new-password" :errors="$errors->updatePassword->get('password')" />
            <x-form-input :label="__('Confirm Password')" name="password_confirmation" type="password" placeholder="Confirm new password"  autocomplete="new-password" :errors="$errors->updatePassword->get('password_confirmation')" />

            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

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
        </form>

  </div>
</div>
