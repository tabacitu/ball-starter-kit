<account-delete-section class="">
{{--    <div class="card-status-start bg-danger"></div>--}}
    <div class="card-body">
        <h3 class="card-title">{{ __('Delete Account') }}</h3>
        <p class="text-secondary">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">{{ __('Delete Account') }}</button>
    </div>

    @push('modals')
        <div class="modal" id="confirm-user-deletion" tabindex="-1">
          <div class="modal-dialog modal-sm" role="document">
              @livewire('forms.account.account-delete-form')
          </div>
        </div>
    @endpush
</account-delete-section>
