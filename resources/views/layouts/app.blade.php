<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>

    <!-- Sidebar -->
    @include('partials.sidebar')


    <main class="main-content">

        <!-- Topbar -->
        @include('partials.topbar')

        <!-- Dynamic Content -->
        @yield('content')

    </main>

    <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>