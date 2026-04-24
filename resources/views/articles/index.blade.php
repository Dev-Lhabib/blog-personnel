@extends('layouts.app')

@section('title', 'Articles')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Articles</h1>
        <p class="text-gray-500 dark:text-gray-400">Découvrez mes articles techniques</p>
    </div>

    {{-- Recherche --}}
    <form method="GET" action="{{ route('articles.index') }}" class="mb-6 flex gap-2">
        @if($activeCategory)
            <input type="hidden" name="category" value="{{ $activeCategory }}">
        @endif
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Rechercher un article..."
            class="flex-grow border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-600"
        >
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
            Rechercher
        </button>
        @if(request('search'))
            <a
                href="{{ route('articles.index', $activeCategory ? ['category' => $activeCategory] : []) }}"
                class="border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition"
            >
                Effacer
            </a>
        @endif
    </form>

    {{-- Filtre catégories --}}
    <div class="flex flex-wrap gap-2 mb-8">
        <a
            href="{{ route('articles.index', request('search') ? ['search' => request('search')] : []) }}"
            class="px-3 py-1.5 rounded-full text-sm border transition
                {{ !$activeCategory
                    ? 'bg-indigo-600 text-white border-indigo-600'
                    : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-400' }}"
        >
            Toutes
        </a>
        @foreach($categories as $category)
            <a
                href="{{ route('articles.index', array_filter(['category' => $category->slug, 'search' => request('search')])) }}"
                class="px-3 py-1.5 rounded-full text-sm border transition
                    {{ $activeCategory === $category->slug
                        ? 'bg-indigo-600 text-white border-indigo-600'
                        : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-400' }}"
            >
                {{ $category->name }}
                <span class="ml-1 opacity-60">({{ $category->articles_count }})</span>
            </a>
        @endforeach
    </div>

    {{-- Liste --}}
    @if($articles->isEmpty())
        <div class="text-center py-20 text-gray-400 dark:text-gray-500">
            <p class="text-lg">Aucun article trouvé.</p>
            @if(request('search') || $activeCategory)
                <a href="{{ route('articles.index') }}" class="mt-2 inline-block text-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-400 text-sm">
                    Voir tous les articles
                </a>
            @endif
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2">
            @foreach($articles as $article)
                <article class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-md dark:hover:shadow-gray-900 transition flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300">
                            {{ $article->category->name }}
                        </span>
                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ $article->reading_time }} min de lecture</span>
                    </div>

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        <a href="{{ route('articles.show', $article) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                            {{ $article->title }}
                        </a>
                    </h2>

                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed flex-grow">
                        {{ $article->excerpt }}
                    </p>

                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-100 dark:border-gray-700">
                        <div class="text-xs text-gray-400 dark:text-gray-500">
                            <span class="font-medium text-gray-600 dark:text-gray-300">{{ $article->user->name }}</span>
                            <span class="mx-1">•</span>
                            {{ $article->published_at->format('d/m/Y') }}
                        </div>
                        <a href="{{ route('articles.show', $article) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                            Lire l'article &rarr;
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $articles->links() }}
        </div>
    @endif
@endsection
