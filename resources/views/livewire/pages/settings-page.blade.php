<settings-page>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">
              {{ __('Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="card">
      <div class="row g-0">
        <div class="col-12 col-md-3 border-end">
          <div class="card-body">
            <h4 class="subheader">Account Settings</h4>
            <div class="list-group list-group-transparent">
                @foreach ($sections as $sectionKey => $section)
                    <a href="{{ url('settings/'.$sectionKey) }}" class="list-group-item list-group-item-action d-flex align-items-center {{ $currentSectionKey == $sectionKey ? 'active' : '' }}">{{ $section['title'] }}</a>
                @endforeach
            </div>
          </div>
        </div>
        <div class="col-12 col-md-9 d-flex flex-column">
            @livewire($currentSectionLivewireComponent)
        </div>
      </div>
    </div>

</settings-page>
