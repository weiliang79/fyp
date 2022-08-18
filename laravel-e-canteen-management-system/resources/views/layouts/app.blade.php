<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <main>
            <div class="d-flex" id="wrapper">
                @if(!Route::is('login'))
                @include('layouts.sidenavbar')
                @endif
                <div id="page-content-wrapper">
                    @include('layouts.topnavbar')
                    <div id="content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    @if(Session::get('swal-success'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: 'Success',
                html: '{{ Session::get("swal-success") }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 1000,
            });
        })
    </script>
    @endif
</body>

</html>