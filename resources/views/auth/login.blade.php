@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="max-w-md mx-auto mt-12">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8 text-center">Connexion</h1>

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Adresse e-mail
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300
                            {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Mot de passe
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                        required
                    >
                </div>

                <div class="mb-6 flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember" class="rounded border-gray-300 text-indigo-600">
                    <label for="remember" class="text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                <button
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition"
                >
                    Se connecter
                </button>
            </form>
        </div>
    </div>
@endsection
