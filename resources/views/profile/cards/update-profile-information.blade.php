<div class="card">
{{--    <div class="card-status-start bg-primary"></div>--}}

  <div class="card-body">
      <h3 class="card-title">{{ __('Profile Information') }}</h3>

      <p class="text-secondary">{{ __("Update your account's profile information and email address.") }}</p>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <x-form-input :label="__('Name')" name="name" :value="old('name', $user->name)" type="text" placeholder="Enter name" required autocomplete="name"  />
            <x-form-input :label="__('Email Address')" name="email" :value="old('email', $user->email)" type="email" placeholder="Enter email" required autocomplete="username" />

            <div>
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <x-alert type="warning" :title="__('Your email address is unverified.')">
                            <div class="text-secondary">To send a verification email <button form="send-verification" class="btn-link m-0 p-0 text-warning">{{ __('click here') }}</button>.</div>
                        </x-alert>

                        @if (session('status') === 'verification-link-sent')
                            <x-alert type="success" :title="__('A new verification link has been sent to your email address.')" />
                        @endif
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
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
