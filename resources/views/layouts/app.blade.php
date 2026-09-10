<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Mon Blog — articles techniques sur Laravel, PHP, JavaScript, DevOps et Freelance. Guides détaillés, retours d'expérience et bonnes pratiques.">

        <title>{{ config('app.name', 'Mon Blog') }} — @yield('title', 'Articles techniques')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=newsreader:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Apply dark mode before paint -->
        <script>
            (function () {
                try {
                    if (localStorage.getItem('theme') === 'dark' ||
                        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark');
                    }
                } catch (e) {}
            })();
        </script>
        @stack('head')
    </head>
    <body class="font-sans min-h-screen flex flex-col">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="border-b border-slate-200/70 bg-white/70 backdrop-blur dark:border-white/10 dark:bg-white/[0.02]">
                <div class="container-blog py-5">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-1 w-full">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        @include('layouts.footer')

        <script>
            function toggleDarkMode() {
                const html = document.documentElement;
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    try { localStorage.setItem('theme', 'light'); } catch (e) {}
                } else {
                    html.classList.add('dark');
                    try { localStorage.setItem('theme', 'dark'); } catch (e) {}
                }
            }
        </script>
        @stack('scripts')
    </body>
</html>
