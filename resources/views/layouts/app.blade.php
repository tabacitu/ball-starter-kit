<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

        @include('partials.styles')
        @stack('styles')
    </head>

    <body>
        <div class="page">
            @include('partials.menu')

            <div class="page-wrapper">

                <!-- Page header -->
                @if (isset($header))
                <div class="page-header d-print-none">
                  <div class="container-xl">
                    <div class="row g-2 align-items-center">
                      {{ $header }}
                    </div>
                  </div>
                </div>
                @endif

                <!-- Page body -->
                <div class="page-body">

                    <div class="container-xl">
                        {{ $slot }}
                    </div>

                </div>

                @include('partials.footer')

            </div>
        </div>

    </body>

@stack('modals')
@include('partials.scripts')
@stack('scripts')

</html>
