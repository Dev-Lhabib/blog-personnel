<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Blog Tech')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-10">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600 hover:text-indigo-700">
                Mon Blog Tech
            </a>
            <nav class="flex items-center gap-4">
                <a href="{{ route('articles.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">
                    Articles
                </a>
                @auth
                    <a href="{{ route('dashboard.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">
                        Tableau de bord
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm bg-indigo-600 text-white px-4 py-1.5 rounded hover:bg-indigo-700 transition">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm bg-indigo-600 text-white px-4 py-1.5 rounded hover:bg-indigo-700 transition">
                        Connexion
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-grow max-w-5xl mx-auto px-4 py-8 w-full">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-5xl mx-auto px-4 py-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Mon Blog Tech &mdash; Tous droits réservés.
        </div>
    </footer>

</body>
</html>
