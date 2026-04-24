@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tableau de bord</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                Bienvenue, {{ auth()->user()->name }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a
                href="{{ route('articles.index') }}"
                class="border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm"
            >
                Voir le blog
            </a>
            <a
                href="{{ route('dashboard.articles.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition text-sm"
            >
                + Nouvel article
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg text-sm border border-green-200 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($articles->isEmpty())
        <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <p class="text-gray-400 dark:text-gray-500 text-lg mb-4">Vous n'avez pas encore d'articles.</p>
            <a href="{{ route('dashboard.articles.create') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 font-medium text-sm">
                Créer votre premier article &rarr;
            </a>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 text-left">
                    <tr>
                        <th class="px-6 py-3 font-medium text-gray-600 dark:text-gray-300">Titre</th>
                        <th class="px-6 py-3 font-medium text-gray-600 dark:text-gray-300">Catégorie</th>
                        <th class="px-6 py-3 font-medium text-gray-600 dark:text-gray-300">Statut</th>
                        <th class="px-6 py-3 font-medium text-gray-600 dark:text-gray-300">Créé le</th>
                        <th class="px-6 py-3 font-medium text-gray-600 dark:text-gray-300 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($articles as $article)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white max-w-xs">
                                <span class="block truncate">{{ $article->title }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300">
                                    {{ $article->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($article->status === 'published')
                                    <span class="inline-flex items-center gap-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-2.5 py-0.5 rounded-full text-xs font-medium">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                        Publié
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300 px-2.5 py-0.5 rounded-full text-xs font-medium">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                                        Brouillon
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $article->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    @if($article->status === 'published')
                                        <a
                                            href="{{ route('articles.show', $article) }}"
                                            class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 text-xs"
                                            target="_blank"
                                        >
                                            Voir
                                        </a>
                                    @endif
                                    <a
                                        href="{{ route('dashboard.articles.edit', $article) }}"
                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-xs font-medium"
                                    >
                                        Modifier
                                    </a>
                                    <form
                                        method="POST"
                                        action="{{ route('dashboard.articles.destroy', $article) }}"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs font-medium"
                                        >
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="mt-3 text-xs text-gray-400 dark:text-gray-500 text-right">
            {{ $articles->count() }} article(s) au total
        </p>
    @endif
@endsection
