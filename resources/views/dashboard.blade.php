<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">
              {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">
                    <div>{{ __("You're logged in!") }}</div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
