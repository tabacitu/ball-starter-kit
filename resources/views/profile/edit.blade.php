<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">
                {{ __('Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="row row-cards">
        <div class="col-12">
            @include('profile.cards.update-profile-information')
        </div>

        <div class="col-12">
            @include('profile.cards.update-password')
        </div>


        <div class="col-12">
            @include('profile.cards.delete-user')
        </div>

    </div>

</x-app-layout>
