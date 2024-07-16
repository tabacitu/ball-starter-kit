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

    <body class="d-flex flex-column">
        <div class="page page-center">

            <!-- Page body -->
            <div class="page-body">

                <div class="container-xl">
                    {{ $slot }}
                </div>

            </div>

        </div>

    </body>

@stack('modals')
@include('partials.scripts')

</html>
