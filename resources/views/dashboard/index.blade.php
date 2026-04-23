@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tableau de bord</h1>
            <p class="text-gray-500 text-sm mt-1">
                Bienvenue, {{ auth()->user()->name }}
            </p>
        </div>
        <a
            href="{{ route('dashboard.articles.create') }}"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition text-sm"
        >
            + Nouvel article
        </a>
    </div>

    @if($articles->isEmpty())
        <div class="text-center py-20 bg-white rounded-lg border border-gray-200">
            <p class="text-gray-400 text-lg mb-4">Vous n'avez pas encore d'articles.</p>
            <a href="{{ route('dashboard.articles.create') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                Créer votre premier article &rarr;
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-left">
                    <tr>
                        <th class="px-6 py-3 font-medium text-gray-600">Titre</th>
                        <th class="px-6 py-3 font-medium text-gray-600">Catégorie</th>
                        <th class="px-6 py-3 font-medium text-gray-600">Statut</th>
                        <th class="px-6 py-3 font-medium text-gray-600">Créé le</th>
                        <th class="px-6 py-3 font-medium text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($articles as $article)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900 max-w-xs">
                                <span class="block truncate">{{ $article->title }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $article->category->name }}
                            </td>
                            <td class="px-6 py-4">
                                @if($article->status === 'published')
                                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-medium">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                        Publié
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 px-2.5 py-0.5 rounded-full text-xs font-medium">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                                        Brouillon
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $article->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    @if($article->status === 'published')
                                        <a
                                            href="{{ route('articles.show', $article) }}"
                                            class="text-gray-400 hover:text-gray-600 text-xs"
                                            target="_blank"
                                        >
                                            Voir
                                        </a>
                                    @endif
                                    <a
                                        href="{{ route('dashboard.articles.edit', $article) }}"
                                        class="text-indigo-600 hover:text-indigo-800 text-xs font-medium"
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
                                            class="text-red-500 hover:text-red-700 text-xs font-medium"
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

        <p class="mt-3 text-xs text-gray-400 text-right">
            {{ $articles->count() }} article(s) au total
        </p>
    @endif
@endsection
