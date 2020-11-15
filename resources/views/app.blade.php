<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link href="/vendor/fontawesome/css/all.css" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">

                @if (Route::has('login'))
                        @auth

                        @else
                            <header>
                                <div class="container-fluid">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Logga in</a>
                                    </div>
                                </div>
                            </header>
                        @endif
                @endif
        @inertia
    </body>
</html>
