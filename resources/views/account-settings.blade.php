<x-layouts.app>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">
              {{ __('Account Settings') }}
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
                    <a href="#{{ $sectionKey }}" class="list-group-item list-group-item-action d-flex align-items-center settings-nav-item">{{ $section['title'] }}</a>
                @endforeach
            </div>
          </div>
        </div>
        <div class="col-12 col-md-9 d-flex flex-column">
            @foreach ($sections as $sectionKey => $section)
                <div id="section-{{ $sectionKey }}" class="settings-section" style="display: none;">
                    @livewire($section['livewireComponent'])
                </div>
            @endforeach
        </div>
      </div>
    </div>

    @push('scripts')
    <script>
        // On page load and hash change
        function handleHashChange() {
            const hash = window.location.hash.substring(1) || 'personal-information';

            // Hide all sections
            document.querySelectorAll('.settings-section').forEach(section => {
                section.style.display = 'none';
            });

            // Show the selected section
            const selectedSection = document.getElementById(`section-${hash}`);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }

            // Update active state in navigation
            document.querySelectorAll('.settings-nav-item').forEach(item => {
                item.classList.remove('active');
            });

            const activeNavItem = document.querySelector(`.settings-nav-item[href="#${hash}"]`);
            if (activeNavItem) {
                activeNavItem.classList.add('active');
            }
        }

        // Listen for hash changes
        window.addEventListener('hashchange', handleHashChange);

        // Initial setup
        document.addEventListener('DOMContentLoaded', handleHashChange);
    </script>
    @endpush
</x-layouts.app>
