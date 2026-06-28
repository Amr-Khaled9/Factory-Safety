<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Factory Safety</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Design System -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @livewireStyles
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    <script>
        window.authUserId = @json(auth()->id() ?? null);
        window.alarmSoundUrl = "{{ asset('sounds/alarm.mp3') }}";
    </script>

    <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>
    @livewireScripts

    <!-- Hidden Audio element for notifications -->
    <audio id="alarm-audio" src="{{ asset('sounds/alarm.mp3') }}" preload="auto"></audio>

    <script>
        window.addEventListener('play-sound', () => {
            const audio = document.getElementById('alarm-audio');
            if (audio) {
                audio.currentTime = 0;
                audio.play().catch(e => console.error('Sound Blocked:', e));
                setTimeout(() => { audio.pause(); audio.currentTime = 0; }, 5000);
            }
        });
    </script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>