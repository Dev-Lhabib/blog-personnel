@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('articles.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 mb-6 inline-block">
            &larr; Retour aux articles
        </a>

        <article>
            <header class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <a
                        href="{{ route('articles.index', ['category' => $article->category->slug]) }}"
                        class="text-sm bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-medium hover:bg-indigo-200 transition"
                    >
                        {{ $article->category->name }}
                    </a>
                    <span class="text-sm text-gray-400">{{ $article->reading_time }} min de lecture</span>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">
                    {{ $article->title }}
                </h1>

                <p class="text-sm text-gray-500">
                    Publié le {{ $article->published_at->format('d/m/Y') }}
                    par <span class="font-medium text-gray-700">{{ $article->user->name }}</span>
                </p>
            </header>

            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-8 text-gray-700 leading-relaxed whitespace-pre-line text-[15px]">
                {{ $article->content }}
            </div>
        </article>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('articles.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">
                &larr; Retour aux articles
            </a>
        </div>
    </div>
@endsection
