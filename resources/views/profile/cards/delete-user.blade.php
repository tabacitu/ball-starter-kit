<div class="card">
    <div class="card-status-start bg-danger"></div>

    <div class="card-body">
        <h3 class="card-title">{{ __('Delete Account') }}</h3>

        <p class="text-secondary">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>

        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">{{ __('Delete Account') }}</button>
    </div>
</div>

@push('modals')

    <div class="modal" id="confirm-user-deletion" tabindex="-1">
      <div class="modal-dialog modal-sm" role="document">
      <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
          @csrf
          @method('delete')
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status bg-danger"></div>
          <div class="modal-body text-center py-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M12 9v2m0 4v.01" />
              <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
            </svg>
            <h3>{{ __('Are you sure?') }}</h3>

            <div class="text-secondary">{{ __('Please enter your password to confirm you would like to permanently delete your account:') }}</div>

            <x-form-input label="" class="mt-4" name="password" id="password-delete-confirmation" type="password" placeholder="Enter current password" required :errors="$errors->userDeletion->get('password')" />

          </div>
          <div class="modal-footer">
            <div class="w-100">
              <div class="row">
                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                    {{ __('Cancel') }}
                  </a></div>
                <div class="col"><button type="submit" class="btn btn-danger w-100">
                    {{ __('Delete account') }}
                  </button></div>
              </div>
            </div>
          </div>
        </div>
      </form>
      </div>
    </div>

    {{-- show model on pageload if there are errors--}}
    @if ($errors->userDeletion->isNotEmpty())
        <script>
            new bootstrap.Modal(document.getElementById('confirm-user-deletion'), {}).toggle();
        </script>
    @endif
@endpush
