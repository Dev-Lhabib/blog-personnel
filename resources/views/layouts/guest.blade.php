<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mon Blog') }} — Connexion</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

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
    </head>
    <body class="font-sans min-h-screen bg-[#f7f7fb] text-slate-900 dark:bg-[#0b0e1a] dark:text-slate-100">
        <div class="grid min-h-screen lg:grid-cols-2">
            <!-- Brand panel -->
            <div class="relative hidden overflow-hidden bg-[#0d1030] lg:block">
                <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1400&q=80" alt="" class="absolute inset-0 h-full w-full object-cover opacity-40">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d1030] via-[#0d1030]/60 to-indigo-900/30"></div>
                <div class="relative flex h-full flex-col justify-between p-12">
                    <a href="{{ route('articles.index') }}" class="flex items-center gap-3">
                        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-white text-xl font-black text-indigo-700">M</span>
                        <span class="leading-tight">
                            <span class="font-display block text-xl font-bold text-white">Mon Blog</span>
                            <span class="block text-[11px] font-semibold uppercase tracking-[0.2em] text-indigo-300">Tech &amp; Code</span>
                        </span>
                    </a>
                    <div>
                        <p class="eyebrow !border-white/20 !bg-white/10 !text-indigo-200">Espace membre</p>
                        <h1 class="font-display mt-5 max-w-md text-4xl font-bold leading-[1.1] tracking-tight text-white">
                            Écrivez, publiez, inspirez.
                        </h1>
                        <p class="mt-4 max-w-md leading-relaxed text-indigo-200/90">
                            Rejoignez le tableau de bord pour rédiger des articles longs et illustrés,
                            suivre vos brouillons et publier en un clic.
                        </p>
                        <div class="mt-8 flex items-center gap-3">
                            <div class="flex -space-x-3">
                                <img class="h-10 w-10 rounded-full border-2 border-[#0d1030] object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" alt="">
                                <img class="h-10 w-10 rounded-full border-2 border-[#0d1030] object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="">
                                <img class="h-10 w-10 rounded-full border-2 border-[#0d1030] object-cover" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80" alt="">
                            </div>
                            <p class="text-sm text-indigo-200">+1 200 lecteurs chaque mois</p>
                        </div>
                    </div>
                    <p class="text-xs text-indigo-300/70">© {{ date('Y') }} Mon Blog — Laravel &amp; Tailwind CSS</p>
                </div>
            </div>

            <!-- Form panel -->
            <div class="flex flex-col">
                <div class="flex items-center justify-between px-6 py-5 sm:px-10">
                    <a href="{{ route('articles.index') }}" class="flex items-center gap-2.5 lg:hidden">
                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-indigo-600 to-violet-500 text-base font-black text-white">M</span>
                        <span class="font-display text-[16px] font-bold">Mon Blog</span>
                    </a>
                    <a href="{{ route('articles.index') }}" class="hidden text-sm font-semibold text-slate-500 transition hover:text-indigo-600 lg:inline dark:text-slate-400">&larr; Retour au blog</a>
                    <button onclick="toggleDarkMode()" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 text-slate-500 transition hover:text-indigo-600 lg:hidden dark:border-white/10 dark:text-slate-300" aria-label="Thème">
                        <svg class="h-5 w-5 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                        <svg class="h-5 w-5 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                    </button>
                </div>

                <div class="flex flex-1 items-center justify-center px-6 py-10 sm:px-10">
                    <div class="card-blog w-full max-w-md p-8 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

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
    </body>
</html>
