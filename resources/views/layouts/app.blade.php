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
        @vite('resources/sass/app.scss')

        <!-- Scripts -->
        @vite('resources/js/app.js')
    </head>
    <body class="font-sans antialiased bg-light">
        @auth()
            @include('layouts.navigation')
        @endauth

        <!-- Page Content -->
        <main class="container my-5">
            <x-alert-message />
            {{ $slot }}
        </main>

        <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container" style="z-index: 11">
            <template id="toast-template">
                <div id="toasty" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                    </div>
                    <div class="toast-body"></div>
                </div>
            </template>
        </div>

    </body>
</html>
