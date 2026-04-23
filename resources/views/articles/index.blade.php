@extends('layouts.app')

@section('title', 'Articles')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-1">Articles</h1>
        <p class="text-gray-500">Découvrez mes articles techniques</p>
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
            class="flex-grow border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
        >
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
            Rechercher
        </button>
        @if(request('search'))
            <a
                href="{{ route('articles.index', $activeCategory ? ['category' => $activeCategory] : []) }}"
                class="border border-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-100 transition"
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
                    : 'bg-white text-gray-600 border-gray-300 hover:border-indigo-400 hover:text-indigo-600' }}"
        >
            Toutes
        </a>
        @foreach($categories as $category)
            <a
                href="{{ route('articles.index', array_filter(['category' => $category->slug, 'search' => request('search')])) }}"
                class="px-3 py-1.5 rounded-full text-sm border transition
                    {{ $activeCategory === $category->slug
                        ? 'bg-indigo-600 text-white border-indigo-600'
                        : 'bg-white text-gray-600 border-gray-300 hover:border-indigo-400 hover:text-indigo-600' }}"
            >
                {{ $category->name }}
                <span class="ml-1 opacity-60">({{ $category->articles_count }})</span>
            </a>
        @endforeach
    </div>

    {{-- Liste --}}
    @if($articles->isEmpty())
        <div class="text-center py-20 text-gray-400">
            <p class="text-lg">Aucun article trouvé.</p>
            @if(request('search') || $activeCategory)
                <a href="{{ route('articles.index') }}" class="mt-2 inline-block text-indigo-500 hover:text-indigo-700 text-sm">
                    Voir tous les articles
                </a>
            @endif
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2">
            @foreach($articles as $article)
                <article class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full font-medium">
                            {{ $article->category->name }}
                        </span>
                        <span class="text-xs text-gray-400">{{ $article->reading_time }} min de lecture</span>
                    </div>

                    <h2 class="text-lg font-semibold text-gray-900 mb-2">
                        <a href="{{ route('articles.show', $article) }}" class="hover:text-indigo-600">
                            {{ $article->title }}
                        </a>
                    </h2>

                    <p class="text-sm text-gray-600 mb-4 leading-relaxed flex-grow">
                        {{ $article->excerpt }}
                    </p>

                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-100">
                        <span class="text-xs text-gray-400">
                            {{ $article->published_at->format('d/m/Y') }}
                        </span>
                        <a href="{{ route('articles.show', $article) }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
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
