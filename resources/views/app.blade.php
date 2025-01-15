<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" type="text/css" href="{{ URL::to('bulma/css/bulma-rtl.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::to('bulma/css/bulma-rtl.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::to('bulma/css/bulma.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::to('bulma/css/bulma.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::to('bulma/css/additional.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::to('css/animations.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::to('css/custel.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::to('css/style.css') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- <link rel="stylesheet" type="text/css" href="{{ URL::to('css/carousel.css') }}"> --}}

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

        @routes
        @viteReactRefresh
        @vite(['resources/js/app.tsx', "resources/js/Pages/{$page['component']}.tsx"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </body>
</html>
