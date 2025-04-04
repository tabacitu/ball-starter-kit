@php
    $type = $type ?? 'success';
    $icon = $icon ?? true;
    $dismissible = $dismissible ?? true;
    $important = $important ?? false;
@endphp

<div class="alert {{ $important ? 'alert-important' : '' }} alert-{{ $type }} {{ $dismissible ? 'alert-dismissible' : '' }} {{ $class ?? '' }}" role="alert">
    <div class="d-flex">
      @if ($icon)
        <div>
            @switch($type)
                @case('success')
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                    @break
                @case('warning')
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
                    @break
                @case('danger')
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
                    @break
                @default
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg>
            @endswitch
        </div>
      @endif
      <div>
        @if (isset($title))
            <h4 class="alert-title {{ $important ? 'text-white' : '' }}">{{ $title }}</h4>
        @endif
        @if (isset($text))
            <div class="text-secondary">{!! $text !!}</div>
        @endif

        {{ $slot }}
      </div>
    </div>

    @if ($dismissible)
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    @endif
</div>
