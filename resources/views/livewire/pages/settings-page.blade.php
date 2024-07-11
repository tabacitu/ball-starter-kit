<div>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">
              {{ __('Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="row row-cards">
        <div class="col-12">
            @livewire('widgets.user-profile-form')
        </div>
        <div class="col-12">
            @livewire('widgets.user-change-password-form')
        </div>
        <div class="col-12">
            {{-- Nice little widget that provides a button for the user to open the "Delete account" modal --}}
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
                      @livewire('widgets.user-delete-form')
                  </div>
                </div>
            @endpush
        </div>
    </div>
</div>
